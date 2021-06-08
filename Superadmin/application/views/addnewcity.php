<?php
$this->load->database();
?>
<style>
    .form-horizontal .form-group
    {
        margin-left: 13px;
    }
    #selectedcity,#companyid{
        display: none;
    }

</style>




<script>


    $(document).ready(function () {


        $('.cities').addClass('active');
        $('.cities_thumb').addClass("bg-success");

        $("#ex").click(function () {

            $("#field_countries").text("");
            var data2 = $("#two").val();

            if (data2 == "" || data2 == null)
            {
                //       alert("please enter the country name");
                $("#field_countries").text(<?php echo json_encode(POPUP_CITIES_ENTER_COUNTRY_NAME); ?>);
            }
            else {



                $.ajax({
                    type: 'post',
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addingcountry",
                    data: {
                        data2: data2
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#two").val('');



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

                        if (response.flag == 0)
                            $("#errorboxdatas").text(response.msg);
                        else
                            $("#errorboxdatas").text(<?php echo json_encode(POPUP_COUNTRY_ADDED); ?>);

                        $("#confirmeds").hide();

                        $('#countryid').append("<option value='" + response.id + "'>" + data2.toUpperCase() + "</option>");
                    },
                });

            }

        });


        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });



        $("#two").on("input", function () {
            var regexp = /[^a-zA-Z/ ]/g;
            if ($(this).val().match(regexp)) {
                $(this).val($(this).val().replace(regexp, ''));
            }
        });



        $("#three").on("input", function () {
            var regexp = /[^a-zA-Z/ ]/g;
            if ($(this).val().match(regexp)) {
                $(this).val($(this).val().replace(regexp, ''));
            }
        });


        $("#one").on("input", function () {
            var regexp = /[^a-zA-Z/ ]/g;
            if ($(this).val().match(regexp)) {
                $(this).val($(this).val().replace(regexp, ''));
            }
        });


        $("#exx").click(function () {

            $("#field_countries").text("");
            $("#field_cities").text("");
            $("#field_currency").text("");

            var data3 = $("#three").val();
            var data = $("#one").val();
            var filter = /^[a-zA-Z ]/g;
            var countryid = $("#countryid").val();

            if (countryid == "0")
            {
          
                $("#field_countries_second").text(<?php echo json_encode(POPUP_CITIES_CITY_ENTER_COUNTRY); ?>);
            }
             else if (data3 == "" || data3 == null)
            {
                $("#field_countries_second").text("");
                $("#field_cities").text(<?php echo json_encode(POPUP_CITIES_CITY_ENTER); ?>);

            }
            else if (!filter.test(data3)) {
                $("#field_cities").text("");
                $("#field_cities").text(<?php echo json_encode(POPUP_CITIES_CITY_ENTERALPHA); ?>);
            }

            else if (data == "" || data == null || data.length > 3)

            {

                $("#field_currency").text(<?php echo json_encode(POPUP_CITIES_CITY_CURENCY); ?>);
            }

            else
            {


                $.ajax({
                    type: 'post',
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addingcity",
                    dataType: 'JSON',
                    data: {
                        countryid: countryid,
                        data3: data3,
                        data: data


                    },
                    success: function (response) {

                        $("#three").val('');
                        $("#one").val('');
                        $("#countryid").val('0');

                        var size = $('input[name=stickup_toggler]:checked').val()
                        var modalElem = $('#addcitymodal');
                        if (size == "mini")
                        {
                            $('#modalStickUpSmall').modal('show')
                        }
                        else
                        {
                            $('#addcitymodal').modal('show')
                            if (size == "default") {
                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                            }
                            else if (size == "full") {
                                modalElem.children('.modal-dialog').addClass('modal-lg');
                            }
                        }

                        if (response.flag == 1)
                            $("#cityerror").text(response.msg);
                        else
                            $("#cityerror").text('city added successfully');

                        $("#cityok").hide();
//                         

                        //      alert("city aded successfully");
//                           

                    }


                });
            }


        });

    });



</script>

<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
   
</div>



<div class="modal fade stick-up" id="addcitymodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                 <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="cityerror" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="cityok" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
     
</div>



<div class="container" style="margin-top: 5%;">
  
         <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="cities" class=""><b>CITIES</b></a>
                    </li>

                    <li ><a href="#" class="active"><b>ADD</small></b></a>
                    </li>
                </ul>
             

                <!-- END BREADCRUMB -->
            </div>
    
  
  <ul class="nav nav-tabs  bg-white">
    <li class="tabs_active active"><a data-toggle="pill" href="#home"><?php echo LIST_ADD_COUNTRY_DETAILS; ?></a></li>
 
    <li class="tabs_active"><a data-toggle="pill" href="#menu2"><?php echo LIST_ADD_CITY_DETAILS; ?></a></li>
  </ul>
  
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     <div class="x_content">
                    <br>
                    <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name"><?php echo FIELD_ENTER_COUNTRY_NAME; ?><span style="" class="MandatoryMarker"> *</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="two" name="countryname" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                       <div class="col-sm-3 error-box" id="field_countries"></div>
                      </div>
                   
                        <div class="form-group pull-right" style="margin-right: 26%;">
                       
                       
                          <button id="ex" type="button" class="btn btn-success">Submit</button>
                       
                      </div>

                    </form>
                  </div>
    </div>
   
    <div id="menu2" class="tab-pane fade">
     <div class="x_content">
                    <br>
                    <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

                      <div class="form-group" class="formex">
                                        <label for="address" class="col-sm-2 control-label"><?php echo FIELD_CITIES_COUNTRY; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">

                                            <select id="countryid" name="country_select"  class="form-control error-box-class">
                                                <option value="0">Select Country</option>
                                                <?php
                                                foreach ($country as $result) {

                                                    echo '<option value="' . $result->Country_Id . '">' . ucwords(strtolower($result->Country_Name)) . '  </option>';
                                                }
                                                ?>

                                            </select>
                                        </div>
                                   
                                        <div class="col-sm-3 error-box" id="field_countries_second">
                                            
                                        </div>
                                </div>

                                <div class="form-group" class="formex">
                                    <label for="address" class="col-sm-2 control-label"><?php echo FIELD_CITIES_CITYNAME_NAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="three" name="cityname" class="form-control error-box-class">

                                    </div>
                                    <div class="col-sm-3 error-box" id="field_cities">
                                        
                                    </div>
                                        
                                </div>



                                <div class="form-group" class="formexx">
                                    <label for="address" class="col-sm-2 control-label"><?php echo FIELD_CITIES_CURRENCY_NAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="one" name="currency" class="form-control error-box-class">

                                    </div><div class="col-sm-3 error-box" id="field_currency"></div></div>

                      
                    
                       <div class="form-group pull-right" style="margin-right: 26%;">
                        
                        
                          <button id="exx" type="button" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
    </div>
   
  </div>
</div>


