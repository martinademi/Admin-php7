<?php
$this->load->database();
$activetab1 = $activetab2 = '';
?>
<style>
    .form-horizontal .form-group
    {
        margin-left: 13px;
    }
</style>

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
  input[type='file'] {
  color: transparent;
}

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>

<script>

    function isNumberKey(evt)
    {
        $("#mobify").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 45 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#mobify").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }

    function isNumberKeyedit(evt)
    {
        $("#mobile_s").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 45 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#mobile_s").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }



    function isNumberKey1(evt)
    {
        $("#pcode").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 45 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#pcode").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }

    function isNumberKey2(evt)
    {
        $("#pcode_s").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 45 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#pcode_s").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }
    var geocoder;
        var map;  
      var city;
      var state;
      var pcode;

    $(document).ready(function (e) {
    
     $('#addr_s').blur(function ()
        {
             $("#city_s").val('');
             $("#state_s").val('');
             $("#pcode_s").val('');
             var address = document.getElementById('addr_s').value;
            $.ajax({
              url:"http://maps.googleapis.com/maps/api/geocode/json?address="+address+"&sensor=false",
              type: "POST",
              success:function(res){
                  
                        address = res.results[0].geometry.location.lat+','+res.results[0].geometry.location.lng;
                        geocoder = new google.maps.Geocoder();

                        geocoder.geocode({ 'address': address }, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {                       

                                for (var component in results[0]['address_components']) {
//                                           console.log(results[0]['address_components']);
                                    for (var i in results[0]['address_components'][component]['types']) {


                                            if (results[0]['address_components'][component]['types'][i] == "locality") {
                                                    city = results[0]['address_components'][component]['long_name'];
                                                   
                                                     
                                                    $("#city_s").find("option").each(function(){
                                                        if( $(this).text() == city) {
                                                           $(this).attr("selected","selected");
                                                        }
                                                    });

                                            }


                                            if (results[0]['address_components'][component]['types'][i] == "administrative_area_level_1") {
                                                state = results[0]['address_components'][component]['long_name'];

                                               $('#state_s').val(state);

                                            }
                                            
                                            if (results[0]['address_components'][component]['types'][i] == "postal_code") {
                                               pcode = results[0]['address_components'][component]['long_name'];

                                               $('#pcode_s').val(pcode);

                                            }
                                    }
                                }                                           
                            } else {
                                alert('Invalid Zipcode');
                            }
                        });
            
             }
            });
        });
    
      $(":file").on("change", function(e) {
            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                $(this).val('');
                alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
            }
       });
       
         <?php
         $registered ;
            foreach ($get_company_data as $value) {
                $registered = $value->registered;
            }
                ?>

        var companyRegistered = '<?php echo $registered;?>'; 
        if(companyRegistered == 1)
            $('#Registered').prop('checked',true);
        else
            $('#unregistered').prop('checked',true);

        $("#define_page").html("Company's");

        $('.company_s').addClass('active');
        $('.company_sthumb').addClass("bg-success");

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });

        $("#fname").keypress(function (event) {
            var inputValue = event.which;
            //if digits or not a space then don't let keypress work.
            if ((inputValue > 64 && inputValue < 91) // uppercase
                    || (inputValue > 96 && inputValue < 123) // lowercase
                    || inputValue == 32) { // space
                return;
            }
            event.preventDefault();
        });

        $("#lname").keypress(function (event) {
            var inputValue = event.which;
            //if digits or not a space then don't let keypress work.
            if ((inputValue > 64 && inputValue < 91) // uppercase
                    || (inputValue > 96 && inputValue < 123) // lowercase
                    || inputValue == 32) { // space
                return;
            }
            event.preventDefault();
        });

        $("#fname_s").keypress(function (event) {
            var inputValue = event.which;
            //if digits or not a space then don't let keypress work.
            if ((inputValue > 64 && inputValue < 91) // uppercase
                    || (inputValue > 96 && inputValue < 123) // lowercase
                    || inputValue == 32) { // space
                return;
            }
            event.preventDefault();
        });

        $("#lname_S").keypress(function (event) {
            var inputValue = event.which;
            //if digits or not a space then don't let keypress work.
            if ((inputValue > 64 && inputValue < 91) // uppercase
                    || (inputValue > 96 && inputValue < 123) // lowercase
                    || inputValue == 32) { // space
                return;
            }
            event.preventDefault();
        });


        $("#state").on("input", function () {
            var regexp = /[^a-zA-Z/ ]/g;
            if ($(this).val().match(regexp)) {
                $(this).val($(this).val().replace(regexp, ''));
            }
        });

        $("#state_s ").on("input", function () {
            var regexp = /[^a-zA-Z/ ]/g;
            if ($(this).val().match(regexp)) {
                $(this).val($(this).val().replace(regexp, ''));
            }
        });


//          $('.company_s').addClass('active');
//        $('.company_sthumb').addClass("bg-success");

        $("#define_page").html("Company's");


        $("#cancel").click(function () {

            //if (confirm("Cancel the data you have entered?")) {

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
            $("#errorboxdata").text(<?php echo json_encode(POPUP_CANCEL); ?>);

            $("#confirmed").click(function () {

                $(".close").trigger("click");

                $("#cname").val('');
                $("#fname").val('');
                $("#lname").val('');
                $("#uname").val('');
                $("#pass").val('');
                $("#email").val('');
                $("#addr").val('');
                $("#mobile").val('');
                $("#city").val('');
                $("#state").val('');
                $("#pcode").val('');
                $("#vnumber").val('');
            });
        });




        $("#cancel_s").click(function () {

            window.location = "<?php echo base_url('index.php?/superadmin') ?>/company_s/1";
        });



        $("#back").click(function () {
            window.location = "<?php echo base_url('index.php?/superadmin') ?>/company_s/1";
        });




        $("#exx").click(function () {
            
          

            $("#companyname_s").text("");
            $("#password_s").text("");
            $("#email_ss").text("");
            $("#address_s").text("");
            $("#cities_s").text("");
            $("#vatnumber_s").text("");

            $("#pass").text("");
            $("#email").text("");

//             var status = '<?php echo $status; ?>';


            var cname = $("#cname_S").val();

            var pass = $("#pass_s").val();
            var uemail = $("#email_s").val();
            var addr = $("#addr_s").val();

            var city = $("#city_s").val();
            var state = $("#state_s").val();
            var pcode = $("#pcode_s").val();
            var vnumber = $("#vnumber_s").val();

            var fname = $("#fname_s").val();
            var lname = $("#lname_S").val();
            var uname = $("#uname_s").val();
            var mobile = $("#mobile_s").val();
          

            var password = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{6,}$/g;

            var number = /^[0-9-+]+$/;
            var post_code = /^[0-9]+$/;

            var phone = /^[0-9]{10,14}$/;
            var company = /^[-\w\s]+$/;
            var re = /[a-zA-Z0-9\-\_]$/;

            var email = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            var text = /^[a-zA-Z ]*$/;
            var alphabit = /^[a-zA-Z]+$/;


            if (cname == "" || cname == null)
            {
//                alert("please enter  the company name");
                $("#companyname_s").text(<?php echo json_encode(POPUP_COMPANY_NAME); ?>);
              
                e.preventDefault();

            }
            else if (!re.test(cname))
            {
//                alert("enter the  company name as  text");
                $("#companyname_s").text(<?php echo json_encode(POPUP_COMPANY_NAMEVALID); ?>);
                e.preventDefault();
            }


            else if (uemail == "" || uemail == null)
            {
//                alert("enter  your email number");
                $("#email_ss").text(<?php echo json_encode(POPUP_COMPANY_EMAIL); ?>);
                e.preventDefault();
            }

            else if (pass == "" || pass == null)
            {
//                alert("enter the password");
                $("#password_s").text(<?php echo json_encode(POPUP_PASSENGERS_PASSENTER); ?>);
                e.preventDefault();
            }
            else if (!password.test(pass))
            {
//                alert("enetr a password atleast one capital letter and one number");
                $("#password_s").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
                e.preventDefault();

            }

            else if (addr == "" || addr == null)
            {
//                alert("enter the address");
                $("#address_s").text(<?php echo json_encode(POPUP_COMPANY_ADDRESS); ?>);
                e.preventDefault();
            }
              if (fname == "" || fname == null)
            {
                $('#fnamefirst').text(<?php echo json_encode(POPUP_COMPANY_SELECT_FIRSTNAME); ?>);
                e.preventDefault();
            }
//            else if (lname == "" || lname == null)
//            {
//                $('#lnamefirst').text(<?php echo json_encode(POPUP_COMPANY_SELECT_LASTNAME); ?>);
//            }
            else if (mobile == "" || mobile == null)
            {
                $('#mobilefirst').text(<?php echo json_encode(POPUP_COMPANY_SELECT_MOBILE); ?>);
                e.preventDefault();
            }
            else if (!phone.test(mobile))
            {
                $('#mobilefirst').text(<?php echo json_encode(POPUP_MOBILE_VALIDATION_ERROR); ?>);
                 e.preventDefault();
            }

            else if (city == "0")
            {
//                alert("select the city");
                $("#cities_s").text(<?php echo json_encode(POPUP_DISPATCHERS_CITY); ?>);
                e.preventDefault();
            }

//             else if (pcode == "" || pcode == null)
//            {
////                alert("enter the vnumber");
//                $("#pcode_sErr").text(<?php echo json_encode(POPUP_COMPANY_PPCODE); ?>);
//                e.preventDefault();
//            }
//            else if (!post_code.test(pcode))
//            {
//                $("#pcode_sErr").text(<?php echo json_encode(POPUP_COMPANY_PPCODE); ?>);
//               e.preventDefault();
//            }   
//            else if (vnumber == "" || vnumber == null)
//            {
////                alert("enter the vnumber");
//                $("#vatnumber_s").text(<?php echo json_encode(POPUP_COMPANY_VATNUMBER); ?>);
//                e.preventDefault();
//            }
//            else if (!re.test(vnumber))
//            {
////                alert("enter vat as numbers only");
//                $("#vatnumber_s").text(<?php echo json_encode(POPUP_COMPANY_VATNUMBERNUM); ?>);
//                e.preventDefault();
//            }
            else
            {
                $('#addentity').submit();  

            }
        });

    });


    function okadded() {
        window.location = "<?php echo base_url('index.php?/superadmin') ?>/company_s/1";

    }


    function ok() {

        var cname = $("#cname_S").val();

        var pass = $("#pass_s").val();
        var uemail = $("#email_s").val();
        var addr = $("#addr_s").val();

        var city = $("#city_s").val();
        var state = $("#state_s").val();
        var pcode = $("#pcode_s").val();
        var vnumber = $("#vnumber_s").val();

        var fname = $("#fname_s").val();
        var lname = $("#lname_S").val();
        var uname = $("#uname_s").val();
        var mobile = $("#mobile_s").val();
        
      }


                function no() {

                    $('.close').trigger('click');
                }


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

                    alert();

                    $("#companyname").text("");
                    $("#password").text("");
                    $("#cemail").text("");

                    $("#address").text("");
                    $("#ccity").text("");
                    $("#vatnumber").text("");
                    var cname = $("#cname").val();
                    var fname = $("#fname").val();
                    var lname = $("#lname").val();
                    var uname = $("#uname").val();
                    var pass = $("#pass").val();
                    var uemail = $("#email").val();
                    var addr = $("#addr").val();
                    var mobile = $("#mobile").val();
                    var city = $("#city").val();
                    var state = $("#state").val();
                    var pcode = $("#pcode").val();
                    var vnumber = $("#vnumber").val();


                    var password = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{6,}$/g

                    var number = /^[0-9-+]+$/;

                    var phone = /^[0-9]{10,14}$/;
                    var company = /^[-\w\s]+$/;
                    var re = /[a-zA-Z0-9\-\_]$/;

                    var email = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                    var text = /^[a-zA-Z ]*$/;
                    var alphabit = /^[a-zA-Z]+$/;


                    if (cname == "" || cname == null)
                    {
                        $("#companyname").text(<?php echo json_encode(POPUP_COMPANY_NAME); ?>);
                        pstatus = false;
                    }
                    else if (!re.test(cname))
                    {
                        $("#companyname").text(<?php echo json_encode(POPUP_COMPANY_NAMEVALID); ?>);
                        pstatus = false;
                    }

                    else if (uemail == "" || uemail == null)
                    {

                        $("#cemail").text(<?php echo json_encode(POPUP_COMPANY_EMAIL); ?>);
                        pstatus = false;
                    }
                    else if (!email.test(uemail))
                    {
                        $("#cemail").text(<?php echo json_encode(POPUP_COMPANY_EMAILVALID); ?>);
                        pstatus = false;
                    }

                    else if ($("#email").attr('data') == 1)
                    {
                        $("#cemail").text(<?php echo json_encode(POPUP_DRIVER_DRIVER_ALLOCATED); ?>);
                        pstatus = false;


                    }

                    else if (pass == "" || pass == null)
                    {
                        $("#cemail").text("");
                        $("#password").text(<?php echo json_encode(POPUP_PASSENGERS_PASSENTER); ?>);
                        pstatus = false;
                    }
                    else if (!password.test(pass))
                    {
                        $("#password").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
                        pstatus = false;
                    }

                    else if (addr == "" || addr == null)
                    {
                        $("#address").text(<?php echo json_encode(POPUP_COMPANY_ADDRESS); ?>);
                        pstatus = false;
                    }
                    else if (city == "0")
                    {
                        $("#ccity").text(<?php echo json_encode(POPUP_DISPATCHERS_CITY); ?>);
                        pstatus = false;
                    }
//                       
                    else if (vnumber == "" || vnumber == null)
                    {
                        $("#vatnumber").text(<?php echo json_encode(POPUP_COMPANY_VATNUMBER); ?>);
                        pstatus = false;
                    }
                    else if (!re.test(vnumber))
                    {
                        $("#vatnumber").text(<?php echo json_encode(POPUP_COMPANY_VATNUMBERNUM); ?>);
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




                function ValidateFromDb() {

                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php?/superadmin/validateEditCompanyEmail",
                        type: "POST",
                        data: {email: $('#email_s').val(),company_id:<?php echo $param?>},
                        dataType: "JSON",
                        success: function (result) {

                            $('#email').attr('data', result.msg);

                            if (result.msg == 1) {

                                $("#email_ss").html("Email is already allocated !");
                                $('#email').focus();
                                return false;
                            } else if (result.msg == 0) {
                                $("#email_ss").html("");
                                return true;

                            }
                        }
                    });

                }
                function validateForm()
                {
                    if (!isBlank($("#Firstname").val()))
                    {
                        if (!isAlphabet($("#Firstname").val()))
                        {
                            $("#errorbox").html("Enter only character in First name");
                            return false;
                        }
                    }
                    else
                    {
                        $("#errorbox").html("First name is blank");
                        return false;
                    }

                    if (!isBlank($("#Lastname").val()))
                    {
                        if (!isAlphabet($("#Lastname").val()))
                        {
                            $("#errorbox").html("Enter only character in Last name");
                            return false;
                        }
                    }
                    else
                    {
                        $("#errorbox").html("Last name is blank");
                        return false;
                    }

                    if (validateEmail($("#Email").val()) == 1)
                    {

                        $("#errorbox").html("Enter valid email");
                        return false;
                    }

                    if (isBlank($("#Password").val()))
                    {
                        $("#errorbox").html("Password is Blank");
                        return false;
                    }

                    if (!MatchPassword($("#Password").val(), $("#Cpassword").val()))
                    {
                        $("#errorbox").html("Password not matching");
                        return false;
                    }
                    // return true;
                }

                function signatorytab(litabtoremove, divtabtoremove)
                {
                    var bstatus = true;
                    if (bonafidetab(litabtoremove, divtabtoremove))
                    {
                        if (isBlank($("#entitypersonname").val()) || isBlank($("#entitysignatorymobileno").val()) || isBlank($("#entitysignatoryimagefile").val()) || $("#entitydegination").val() === "null")
                        {
                            bstatus = false;
                        }

                        if (validateEmail($("#entityemail").val()) !== 2)
                        {
                            bstatus = false;
                        }

                        if (bstatus === false)
                        {
                            setTimeout(function ()
                            {
                                proceed(litabtoremove, divtabtoremove, 'fourthlitab', 'tab4');

                            }, 100);

                            alert("complete Other Document tab properly");
                            $("#tab4icon").removeClass("fs-14 fa fa-check");
                            return false;
                        }

                        $("#tab4icon").addClass("fs-14 fa fa-check");
                        $("#nextbutton").addClass("hidden");
                        $("#finishbutton").removeClass("hidden");

                        return bstatus;
                    }

                }


</script>
<style>
    .col-sm-4 {
        width: 67px; 
    }
</style>



<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url('index.php?/superadmin') ?>/company_s/1" class=""><?php echo LIST_COMPANY; ?></a>
                    </li>
                    <li ><a href="#" class="active">EDIT COMPANY</a>
                    </li>

                </ul>
                <!-- END BREADCRUMB -->
            </div>



              <div class="col-md-12 col-sm-12 col-xs-12">

                <div id="rootwizard" class="m-t-50">
               

                        <div class="tab-content">
                            
                            <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/superadmin/updatecompany/<?php echo $param;?>"  method="post" enctype="multipart/form-data">
                            <div class="tab-pane slide-left padding-20 <?php echo $activetab2 ?>" id="tab3">
                                <div class="row row-same-height">



                                    <?php
                                    foreach ($get_company_data as $value) {
                                        ?>
                                   
                                    
                                       <div class="form-group" class="formexx">
                                        <label for="address" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-5">
                                                <input type="radio" class="radio-success" name="registered" id="Registered" value="0">
                                                    <label>Registered</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="radio" class="radio-success" name="registered" id="Unregistered" value="1">
                                                    <label>Unregistered</label>
                                                </div>
                                        </div>

                                        <div class="col-sm-3 error-box" id="companyname"></div>
                                    </div>

                                        <div class="form-group" class="formexx">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_COMPANYNAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="cname_S" name="companyname" class="form-control error-box-class" value="<?php echo $value->companyname; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="companyname_s"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_EMAIL; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="email_s" name="email" class="form-control error-box-class" onblur="ValidateFromDb()" value="<?php echo $value->email; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="email_ss"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_PASSWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="password" id="pass_s" name="password" class="form-control error-box-class" value="<?php echo $value->password; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="password_s"></div>

                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_ADDRESS; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="addr_s" name="address" class="form-control error-box-class" value="<?php echo $value->addressline1; ?>" autocomplete="on">

                                            </div>
                                            <div class="col-sm-3 error-box" id="address_s"></div>

                                        </div>
                                    
                                    
                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_STATE; ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="state_s" name="state" class="form-control error-box-class" value="<?php echo $value->state; ?>">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_CITY; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <select id="city_s" name="cityname"  class="form-control error-box-class col-sm-6" >
    <!--                                                        <option value="0"><?php echo $value->city_id; ?></option>-->

                                                    <?php
                                                    foreach ($city_ram as $result) {

                                                        $selected = "";
                                                        if ($result->City_Id == $value->city)
                                                            $selected = "selected";

                                                        echo "<option value='" . $result->City_Id . "'" . $selected . ">" . ucfirst(strtolower($result->City_Name)) . "</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-3 error-box" id="cities_s"></div>

                                        </div>

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_POSTCODE; ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="pcode_s" name="pincode" class="form-control error-box-class" onkeypress="return isNumberKey(event)" value="<?php echo $value->postcode; ?>">

                                            </div>
                                                 <div class="col-sm-3 error-box" id="pcode_sErr"></div>
                                        </div>



<!--                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_VATNUMBER; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="vnumber_s" name="vatnumber" class="form-control error-box-class" value="<?php echo $value->vat_number; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="vatnumber_s"></div>

                                        </div>-->


                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_FIRSTNAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="fname_s" name="firstname" class="form-control error-box-class" value="<?php echo $value->firstname; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="fnamefirst"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_LASTNAME; ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="lname_S" name="lastname" class="form-control error-box-class" value="<?php echo $value->lastname; ?>">

                                            </div>
                                              <div class="col-sm-3 error-box" id="lnamefirst"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_MOBILE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="mobile_s" name="mobilenumber" class="form-control error-box-class" onkeypress="return isNumberKeyedit(event)" value="<?php echo $value->mobile; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="mobilefirst"></div>
                                        </div>
                                    
                                     <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_COMPANYLOGO; ?></label>
                                        <div class="col-sm-6">

                                            <input type="file" class="form-control" style="height: 37px;" name="e_companylog" id="e_companylogo">
                                        </div>
                                        
                                        <div class="col-sm-4 error-box" id="logo"></div><br>
                                         <?php
                                                if ($value->logo != '') {
                                                    ?>
                                                    <a style="color:dodgerblue" target="_blank" href="<?php echo base_url()?>../../pics/<?php echo $value->logo; ?>">view</a> 

                                                <?php }
                                                ?>
                                    </div>



                                    <div class="pull-right m-t-10" style="margin-right:18.5%;"> <button class="btn btn-success btn-cons" id="exx" type="button"><?php echo BUTTON_CHANGES_COMPANY; ?></button></div>
                                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-default btn-cons" id="cancel_s"><?php echo BUTTON_CANCEL; ?></button></div>

                                    <?php }
                                    ?>

                                </div>
                            </div>
 </form>



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
                    <div class="col-sm-12" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" ><?php echo BUTTON_YES; ?></button>
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
                    <div class="col-sm-4 pull-right"> <button type="button" class="btn btn-primary pull-right" onclick="no()"><?php echo BUTTON_NO; ?></button></div>
                    <div class="col-sm-4 pull-right">
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" onclick="ok()" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="confirmmodelss" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxdatass" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmedss"  onclick="okadded()"><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

   <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE&sensor=false&libraries=places&language=en-AU"></script>
     <script>
                                            var autocomplete = new google.maps.places.Autocomplete($("#addr_s")[0], {});

                                            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                                                var place = autocomplete.getPlace();
                                               
                                            });
                                        </script>