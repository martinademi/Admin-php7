<?PHP //
//error_reporting(false);
//
//$enable = 'disabled';
//if ($Admin == '1') {
//    $enable = 'required';
//}
?>
<style>
     .form-horizontal .form-group 
    {
        margin-left: 13px;
    }    


    .pac-container {
        background-color: #FFF;
        z-index: 2000;
        position: fixed;
        display: inline-block;
    }
    .tab-content hr.col-xs-12 {
        margin: 0% 0% 1% 0%;
    }
    .tab-content h5.col-xs-12 {
        padding-left: 1.8%;
    }
    div#ForImageCroping .img-container {
        min-height: 470px !important;
    }
    div#ForImageCroping .modal-body .cropper-container.cropper-bg {
         width: auto !important; 
        height: 470px !important;
    }
</style>



<script>
    $("#MyProfile").addClass("active");
    $(document).ready(function () {

        $('.MyProfile').addClass('active');
//        $('.icon-thumbnail').attr('<?php echo base_url(); ?>assets/dash_board_on.png"');
        $('.profile_thumb').attr('src', "<?php echo base_url(); ?>assets/restaurant_on.png");
        
        $('#BusinessCat').on('change',function(){
            var catID = $(this).val();
//            alert(catID);
           $('#subCatList').load("<?php echo base_url('index.php/Admin') ?>/getsubcat", {catID: catID});
        
       });


        $('#callM').click(function () {

            $('#NewCat').modal('show');
        });

        $('.error-box-class').keypress(function () {
            $('.error_box').text("");
        });


        $(".errEmpty1, .errEmpty2, .errEmpty3, .errEmpty4").on('keyup change', function () {
            var err1 = $("#entityname").val();
            var err2 = $("#BusinessCat").val();
            var err3 = $("#entityemail").val();
            var err4 = $("#entityOwner").val();
            // console.log(err1.length);
            if (err1.length == 0 || err2 == 0 || err3.length == 0 || err4.length == 0) {
                $("#tb1").removeAttr('data-toggle');
                $("#mtab2").removeAttr('data-toggle');
                $("#mtab3").removeAttr('data-toggle');
                $("#tb1").removeAttr('href');
                $("#mtab2").removeAttr('href');
                $("#mtab3").removeAttr('href');
            }
        });

//        $('#CountryList').change(function () {
//
//            $('#CityList').load('http://54.174.164.30/Tebse/Business/application/views/superadmin/get_cities.php', {country: $('#CountryList').val()});
//            $('#countryname').val($('#CountryList option:selected').text());
////            alert($('#CountryList option:selected').text());
//        });
//        $('#cityLists').change(function () {
//            alert();
//            alert($('#cityLists option:selected').text());
//            $('#cityname').val($('#cityLists option:selected').text());
//        });

//        if ($('#SelectedCity').val() != '') {
////            alert($('#SelectedCity').val());
//            var enable = '<?PHP echo $enable; ?>';
////            alert(enable);
//            $('#CityList').load('http://54.174.164.30/Tebse/Business/application/views/superadmin/get_cities.php', {country: $('#CountryList').val(), CityId: $('#SelectedCity').val(), enable: enable});
//        }

    });
    //submit form data from forth tab
    function submitform()
    {
        if (signatorytab('fourthlitab', 'tab4'))
        {
             var monday = $("#Monday1").val();
                if(monday == '' || monday == null){
                    $("#err20").text("Working hours are Missing ");
                }else{
                    $("#addentity").submit();
                }
        }
    }

    //load mobile prefix as country code

    function fillcountrycode()
    {
        var country = $("#entitycountry").val();
        if (country !== "null")
        {
            var n = country.indexOf(",");
            $("#mobileprefix").val(country.substring((n + 1), country.length));
            $("#countrycode").val(country.substring((n + 1), country.length));
        }
    }

    //validations for each previous tab before proceeding to the next tab
    function managebuttonstate()
    {
        $("#prevbutton").addClass("hidden");
        $("#tb1").attr('data-toggle', 'tab');
        $("#tb1").attr('href', '#tab1');
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
        $('.error_box').text("");
        var pstatus = true;
        if ($("#entityname").val() == '' || $("#entityname").val() == null)
        {
            $("#entityname_err").text("Please enter the franchise name");
            pstatus = false;
        } else if ($("#BusinessCat").val() == '0')
        {
            $("#BusinessCat_err").text("Please select a category");
            pstatus = false;
        } else if ($("#entityOwner").val() == '' || $("#entityOwner").val() == null)
        {
            $("#entityOwner_err").text("Please enter the owner's name");
            pstatus = false;
        } else if ($("#entityemail").val() == '' || $("#entityemail").val() == null)
        {
            $("#entityemail_err").text("Please enter the email-id");
            pstatus = false;
        }
//        else if ($("#entitypostalcode").val()== '' || $("#entitypostalcode").val()== null)
//        {
//            $("#entityemail_err").text("Please enter the postal code");
//            pstatus = false;
//        }
//        if (isBlank($("#entiryLongitude").val()))
//        {
//            pstatus = false;
//        }
//        if (isBlank($("#entiryLatitude").val()))
//        {
//            pstatus = false;
//        }

        if (pstatus === false)
        {
            setTimeout(function ()
            {
                proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
            }, 300);

//            alert("Mandatory Fields Missing")
            $("#tab1icon").removeClass("fs-14 fa fa-check");
            return false;
        } else {
            $("#mtab2").attr('data-toggle', 'tab');
            $("#mtab2").attr('href', '#tab2');
            $("#mtab3").attr('data-toggle', 'tab');
            $("#mtab3").attr('href', '#tab3');
        }
//        alert();
        $("#tab1icon").addClass("fs-14 fa fa-check");
        $("#prevbutton").removeClass("hidden");
        $("#nextbutton").removeClass("hidden");
        $("#finishbutton").addClass("hidden");
        return true;
    }

    function addresstab(litabtoremove, divtabtoremove)
    {
        var astatus = true;
        //alert(profiletab());
        if (profiletab(litabtoremove, divtabtoremove))
        {
//            if ($("#entitytown").val() === "null")
//            {
//                astatus = false;
//            }
//
//            if (isBlank($("#entitypobox").val()) || isBlank($("#entityzipcode").val()))
//            {
//                astatus = false;
//            }

            if (astatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'secondlitab', 'tab2');

                }, 100);

                alert("Mandatory Fields Missing")
                $("#tab2icon").removeClass("fs-14 fa fa-check");
                return false;
            }
            $("#tab2icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");

            return astatus;
        }
    }

    function bonafidetab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (addresstab(litabtoremove, divtabtoremove))
        {
//            if (isBlank($("#entitydocname").val()) || isBlank($("#entitydocfile").val()) || isBlank($("#entityexpirydate").val()))
//            {
//                bstatus = false;
//            }

            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'thirdlitab', 'tab3');

                }, 100);

                alert("Mandatory Fields Missing");
                $("#tab3icon").removeClass("fs-14 fa fa-check");
                return false;
            }

            $("#tab3icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");

            return bstatus;

        }
    }

    function signatorytab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (bonafidetab(litabtoremove, divtabtoremove))
        {
//            if (isBlank($("#entitypersonname").val()) || isBlank($("#entitysignatorymobileno").val()) || isBlank($("#entitysignatoryfile").val()) || $("#entitydegination").val() === "null")
//            {
//                bstatus = false;
//            }
//
//            if (validateEmail($("#entitysignatoryemail").val()) !== 2)
//            {
//                bstatus = false;
//            }

            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'fourthlitab', 'tab4');

                }, 100);

                alert("Mandatory Fields Missing");
                $("#tab4icon").removeClass("fs-14 fa fa-check");
                return false;
            }

            $("#tab4icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");

            return bstatus;
        }

    }


    function proceed(litabtoremove, divtabtoremove, litabtoadd, divtabtoadd)
    {
        $("#" + litabtoremove).removeClass("active");
        $("#" + divtabtoremove).removeClass("active");

        $("#" + litabtoadd).addClass("active");
        $("#" + divtabtoadd).addClass("active");
    }

    /*-----managing direct click on tab is over -----*/

    //manage next next and finish button
    function movetonext()
    {
        if ($("#firstlitab").attr('class') === "active")
        {
            var entityname = $("#entityname").val();
            var BusinessCat = $("#BusinessCat").val();
            var entityemail = $("#entityemail").val();
            var entityOwner = $("#entityOwner").val();
            profiletab('secondlitab', 'tab2');

            if (entityname && BusinessCat != '0' && entityemail && entityOwner) {
                proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
            }
        } else if ($("#secondlitab").attr('class') === "active")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');
            $("#finishbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");
        }


    }
    function movetoprevious()
    {
        var currenttabstatus = $("li.active").attr('id');
        if ($("#secondlitab").attr('class') === "active")
        {
            profiletab('secondlitab', 'tab2');
            proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
            $("#prevbutton").addClass("hidden");
        } else if ($("#thirdlitab").attr('class') === "active")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('thirdlitab', 'tab3', 'secondlitab', 'tab2');
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");
        }

    }

</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyA2OMyhNrvUxHa7ijT2FJuen-h6GfuGiEc"></script>
<script>
    function callMap() {
//        alert();
        $('#ForMaps').modal('show');

//       alert('1');
        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
//           alert('2');
            initialize($('#entiryLatitude').val(), $('#entiryLongitude').val());
            $('#address').val($('#entityAddress').val());
        } else {
//            alert('3');
            initialize(24.7136, 46.6753);
        }
    }

    var map;
    var marker;
    var myLatlng = new google.maps.LatLng(24.7136, 46.6753);

    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();
    function getAddLatLong(text) {
        var addr = text.value;
//        alert(text.value);
        $.ajax({
            url: "http://54.174.164.30/Tebse/Business/application/views/superadmin/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                // alert(data);
                 $('#latitude').val(Arr.Lat);
                $('#longitude').val(Arr.Long);

                initialize(Arr.Lat, Arr.Long, '0');
            }
        });
    }
    function getAddLatLong1(text) {

        var addr = text.value;
//        alert(addr)
//        alert(text.value);
        $.ajax({
            url: "http://54.174.164.30/Tebse/Business/application/views/superadmin/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                // alert(data);
                $('#entiryLatitude').val(Arr.Lat);
                $('#entiryLongitude').val(Arr.Long);

                initialize(Arr.Lat, Arr.Long, '1');
            }
        });
    }
    function initialize(lat, long, from) {

        if (lat != '' || long != '')
        {
            myLatlng = new google.maps.LatLng(lat, long);
        } else {
            myLatlng = new google.maps.LatLng(24.7136, 46.6753);
        }



        var mapOptions = {
            zoom: 15,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: true,
            zoomControl: true,
            scaleControl: true,
            mapTypeControl: true,
            streetViewControl: true,
            overviewMapControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
        };
//        alert('1');
        map = new google.maps.Map(document.getElementById("myMap"), mapOptions);
//        alert('1');
        marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            draggable: true
        });
//        alert('1');
        geocoder.geocode({'latLng': myLatlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    if (from == '1') {
                        $('#entiryLongitude').val(marker.getPosition().lat());
                        $('#entiryLatitude').val(marker.getPosition().lng());
                    } else {
                        //$('#address').val(results[0].formatted_address);
                        $('#latitude').val(marker.getPosition().lat());
                        $('#longitude').val(marker.getPosition().lng());
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    }
                }
            }
        });
//        alert('1');
        google.maps.event.addListener(marker, 'dragend', function () {

            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
//                        if (results[0].address_components.length > 4) {
//                            $('#address').val(results[0].address_components[0].long_name + ', ' + results[0].address_components[1].long_name);
//                            $('#address2').val(results[0].address_components[2].long_name + ', ' + results[0].address_components[3].long_name);
//                        } else if (results[0].address_components.length = 3) {
//                            $('#address').val(results[0].address_components[0].long_name + ', ' + results[0].address_components[1].long_name);
//                            $('#address2').val(results[0].address_components[2].long_name);
//                        }
                        $('#address').val(results[0].formatted_address);

                        $('#latitude').val(marker.getPosition().lat());
                        $('#longitude').val(marker.getPosition().lng());
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    }
                }
            });
        });
        google.maps.event.addListenerOnce(map, 'idle', function () {
            google.maps.event.trigger(map, 'resize');
        });
    }
    function Cancel() {
        $('#ForMaps').modal('hide');
    }
    function Cancel1() {
        $('#getCroppedCanvasModal').modal('hide');
        $('#ForImageCroping').modal('show');
    }
    function Take() {
//        alert();
        $('#entiryLongitude').val($('#longitude').val());
        $('#entiryLatitude').val($('#latitude').val());
        $('#entityAddress').val($('#address').val());

//        $('#entityAddress2').val($('#address2').val());
        $('#ForMaps').modal('hide');
    }
    function test() {
//alert();
    }


</script>

<script type="text/javascript">
    function initialize1() {
        var input = document.getElementById('entityAddress');
        var options = {componentRestrictions: {country: 'us'}};

        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
//            document.getElementById('city2').value = place.name;
            document.getElementById('entiryLatitude').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude').value = place.geometry.location.lng();
            //alert("This function is working!");
            //alert(place.name);
            // alert(place.address_components[0].long_name);

        });
    }

    google.maps.event.addDomListener(window, 'load', initialize1);
</script>


<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="">
                    <!--                    <li>
                                            <a href="<?php echo base_url() ?>index.php/superadmin/loadDashbord">DASHBOARD</a>
                                        </li>-->


                    <li style="width: 200px"><a href="#" class="active">FRANCHISE PROFILE</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                <li class="active" id="firstlitab" onclick="managebuttonstate()">
                    <a id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
                </li>
                <li class="" id="secondlitab">
                    <a onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>Social Settings</span></a>
                </li>
                <li class="" id="thirdlitab">
                    <a href="#tab3" onclick="addresstab('thirdlitab', 'tab3')" id="mtab3"><i id="tab3icon" class=""></i> <span>Working Hours</span></a>
                </li>


            </ul>



            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs
                    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <li class="active" id="firstlitab" onclick="managebuttonstate()">
                            <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
                        </li>
                        <li class="" id="secondlitab">
                            <a data-toggle="tab" href="#tab2" onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>Social Settings</span></a>
                        </li>
                        <li class="" id="thirdlitab">
                            <a data-toggle="tab" href="#tab3" onclick="addresstab('thirdlitab', 'tab3')"><i id="tab3icon" class=""></i> <span>Working Hours</span></a>
                        </li>


                    </ul>  -->
                    <!-- Tab panes -->
                    <form id="BannerImage" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                        <input id="uploadBanner" type="file" name="myMainfile"  style="visibility: hidden;" accept="image/*" />

                    </form>
                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php/superadmin/UpdateProfile" method="post" enctype="multipart/form-data">
                        <input type='hidden' name='BusinessId' value='<?PHP echo $BizId; ?>'> 
                        <div class="tab-content">
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">


                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label for="fname" class="control-label">Upload Logo</label>
                                            <div class="" style="
                                                 width: 31%;
                                                 ">
                                                <a onclick="openFileUpload(this)" id='1' style="cursor: pointer;">
                                                    <div class="portfolio-group">
                                                        <?PHP
                                                        if ($ProfileData['ImageUrl'] == '') {
                                                            echo '  <img src="https://tebse.com/Tebse/Business/addnew.png" id="MainImageUrl" style="width: 100%;height: 160px;">';
                                                        } else {
                                                            // <div style="position:absolute;top:0;right:0px;">
//                                                            echo '<img src="' . $ProfileData['ImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'http://52.59.109.132/JIBLEY/Business/addnew.png\';" id="MainImageUrl" style="width: 100%;height: 160px;">
//                                                                    
//                                                                     <div style="top:0;right:0px;">
//                                                                        <a onclick="delete1(this)" id="' . $ProfileData['ImageUrl'] . '"  value="" ><img  class="thumb_image" src="https://tebse.com/Tebse/dialog_close_button.png" height="20px" width="20px" /></a>
//                                                                    </div>';
                                                            echo '<div class="col-md-12" id="pImg' . $ProfileData['ImageUrl'] . '">
                                                                    <img src="' . $ProfileData['ImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'https://tebse.com/Tebse/Business/addnew.png\';" id="MainImageUrl" style="width: 100%;height: 160px;">
                                                                     <div style="position:absolute;top:0;right:0px;">
                                                                         <a onclick="deletepimg(this)" id="' . $ProfileData['ImageUrl'] . '"  value="" ><img  class="thumb_image" src="https://tebse.com/Tebse/dialog_close_button.png" height="20px" width="20px" /></a>
                                                                     </div>
                                                                 </div>';
                                                        }
                                                        ?>

                                                    </div>
                                                </a>                                                                    
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <label for="fname" class="control-label">Upload Banner Image</label>
                                            <div class="" style="
                                                 width: 31%;
                                                 ">
                                                <a onclick="openFileUpload(this)" id='3' style="cursor: pointer;">
                                                    <div class="portfolio-group">
                                                        <?PHP
                                                        if ($ProfileData['BannerImageUrl'] == '') {
                                                            echo '  <img src="https://tebse.com/Tebse/Business/addnew.png" onerror="if (this.src != \'error.jpg\') this.src = \'https://tebse.com/Tebse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">';
                                                        } else {
//                                                            echo '  <img src="' . $ProfileData['BannerImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'https://tebse.com/Tebse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">';
                                                            echo '<div class="col-md-12" id="bImg' . $ProfileData['BannerImageUrl'] . '">
                                                                    <img src="' . $ProfileData['BannerImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'https://tebse.com/Tebse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">
                                                                     <div style="position:absolute;top:0;right:0px;">
                                                                         <a onclick="deletebimg(this)" id="' . $ProfileData['BannerImageUrl'] . '"  value="' . $ProfileData['BannerImageUrl'] . '" >
                                                                             <img  class="thumb_image" src="https://tebse.com/Tebse/dialog_close_button.png" height="20px" width="20px" /></a>
                                                                     </div>
                                                                 </div>';
                                                        }
                                                        ?>

                                                    </div>
                                                </a>                                                                    
                                            </div>

                                        </div>

                                    </div>




                                    <div class="form-group" style="margin-bottom:0px;">
                                        <label for="fname" class="col-sm-3 control-label">Franchise Name<span style="color: red; font-size: 20px">*</span></label>
                                        <div class="col-sm-6" style="margin-top: 10px;">
                                            <input type="text" class="errEmpty1 form-control error-box-class" id="entityname" value='<?PHP echo $ProfileData['MasterName']; ?>' placeholder="Francaise Name" name="FData[MasterName]"  aria-required="true" <?PHP echo $enable; ?>>
                                            <!--<input id="searchTextField" type="text" size="50">-->
                                        </div> 
                                        <!--<div class="col-sm-3 error_box" id="entityname_err"></div>-->
                                    </div>
                                    <div class="form-group">
                                        <span class="col-sm-3"></span>
                                        <span class="col-sm-6 error_box" id="entityname_err" style="color: tomato;"></span>
                                    </div>

                                    <div class="form-group" style="margin-bottom:0px;">
                                        <label for="fname" class="col-sm-3 control-label">Category <span style="color: red; font-size: 20px">*</span></label>
                                        <div class="col-sm-6" style="margin-top: 10px;">
                                            <div id='CatList'>
                                                <select id='BusinessCat' class="errEmpty2 form-control error-box-class" name='FData[BusinessCategory]' <?PHP echo $enable; ?> >
                                                    <option value='0'>Select Category</option>
                                                    <?PHP
                                                    foreach ($ProCats as $procat) {
                                                        if ($ProfileData['BusinessCategory'] == (string) $procat['_id']['$oid']) {
                                                            echo ' <option value="' . (string) $procat['_id']['$oid'] . '" selected>' . implode($procat['Category'],',') . '</option>';
                                                        } else {
                                                            echo ' <option value="' . (string) $procat['_id']['$oid'] . '">' . implode($procat['Category'],',') . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!--<div class="col-sm-3 error_box" id="BusinessCat_err"></div>-->
                                    </div>
                                    <div class="form-group">
                                        <span class="col-sm-3"></span>
                                        <span class="col-sm-6 error_box" id="BusinessCat_err" style="color: tomato;"></span>
                                    </div>
                                    
                                    <div class="form-group" style="margin-bottom:0px;">
                                        <label for="fname" class="col-sm-3 control-label">Sub-category <em>*</em></label>
                                        <div class="col-sm-6">
                                          <?php //  foreach ($ProfileData['subCategory'] as $buscat){
//                                          print_r($buscat); } ?>
                                            <div id='subCatList'>
                                                <select id="subCatId" multiple name="FData[subCategory][]"  class="errr4 form-control error-box-class" required <?PHP echo $enable; ?>>
                                                <!--<select multiple id='BusinesssubCat' class="form-control" name="subCategory[]" required <?PHP echo $enable; ?> >-->
                                                    <option value='0'>Select Sub-category</option>
                                                    
                                                    <?PHP
//                                                    $subcat = [];
                                                    foreach ($ProsubCats as $procat) {
                                                    foreach ($ProfileData['subCategory'] as $buscat){
//                                                        print_r($buscat);
                                                        if ($buscat == (string) $procat['_id']['$oid']) {
//                                                            $subcat[] =  $procat['Subcategory'];
//                                                            echo 'if';
                                                            echo ' <option value="' . (string) $procat['_id']['$oid'] . '" selected>' . implode($procat['Subcategory'],',') . '</option>';
                                                            
                                                    }else {
//                                                           echo ' <option value="' . (string) $procat['_id']['$oid'] . '">' . $procat['Subcategory'] . '</option>';
                                                        
                                                        }
                                                   }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err4" style=""></div>
                                        <input type='hidden' id='SelectedCity' value='<?PHP echo $ProfileData['City']; ?>'>
                                        
                                    </div>

                                    <div class="form-group" style="margin-bottom:0px;">
                                        <label for="fname" class="col-sm-3 control-label">Email-id <span style="color: red; font-size: 20px">*</span></label>
                                        <div class="col-sm-6" style="margin-top: 10px;">
                                            <input type="text" class="errEmpty3 form-control error-box-class" id="entityemail" value='<?PHP echo $ProfileData['Email']; ?>' placeholder="Email" name="FData[Email]" <?PHP echo $enable; ?>  aria-required="true" style="color: black;">
                                        </div>

                                        <!--<div class="col-sm-3 error_box" id="entityemail_err"></div>-->
                                    </div>
                                    <div class="form-group">
                                        <span class="col-sm-3"></span>
                                        <span class="col-sm-6 error_box" id="entityemail_err" style="color: tomato;"></span>
                                    </div>
                                    <div class="form-group" style="margin-bottom:0px;">
                                        <label for="fname" class="col-sm-3 control-label">Owner Name <span style="color: red; font-size: 20px">*</span></label>
                                        <div class="col-sm-6" style="margin-top: 10px;">
                                            <input type="text" class="errEmpty4 form-control error-box-class" id="entityOwner" value='<?PHP echo $ProfileData['OwnerName']; ?>' placeholder="Owner Name" name="FData[OwnerName]" <?PHP echo $enable; ?>  aria-required="true">
                                        </div>
                                        <!--<div class="col-sm-3 error_box" id="entityOwner_err"></div>-->
                                    </div>
                                    <div class="form-group">
                                        <span class="col-sm-3"></span>
                                        <span class="col-sm-6 error_box" id="entityOwner_err" style="color:tomato;"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Web-Site</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entitywebsite" value='<?PHP echo $ProfileData['Website']; ?>' placeholder="Web-Site" name="FData[Website]"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Images Allowed</label>
                                        <div class="col-sm-6">
                                            <?PHP
                                            if ($ProfileData['ImageFlag'] == '1') {
                                                echo ' <input type="checkbox" name="FData[ImageFlag]" value="1" checked>';
                                            } else {
                                                echo ' <input type="checkbox" name="FData[ImageFlag]" value="1">';
                                            }
                                            ?>


                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label" style="font-size: 20px;   color: black;">Social Media Links</label>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Google+ link</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['GoogleLink']; ?>' placeholder="Google+ Link" name="FData[GoogleLink]"  aria-required="true">
                                        </div>
                                        <!--                                        <div class="col-sm-1">
                                                                                    <span style="color: red; font-size: 20px">*</span>
                                                                                </div>-->
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Facebook Link</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['FacebookLink']; ?>' placeholder="Facebook Link" name="FData[FacebookLink]"  aria-required="true">
                                        </div>
                                        <!--                                        <div class="col-sm-1">
                                                                                    <span style="color: red; font-size: 20px">*</span>
                                                                                </div>-->
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Twitter Link</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['TwitterLink']; ?>' placeholder="Twitter Link" name="FData[TwitterLink]"  aria-required="true">
                                        </div>
                                        <!--                                        <div class="col-sm-1">
                                                                                    <span style="color: red; font-size: 20px">*</span>
                                                                                </div>-->
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Instagram</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['Instagram']; ?>' placeholder="Instagram" name="FData[Instagram]"  aria-required="true">
                                        </div>
                                        <!--                                        <div class="col-sm-1">
                                                                                    <span style="color: red; font-size: 20px">*</span>
                                                                                </div>-->
                                    </div>


                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label" style="font-size: 20px;   color: black;">Working Hours</label>
                                    
                                                                        </div>-->
                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab3">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Send Order Email To </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="OrderEmails" value='<?PHP echo $ProfileData['OrderEmail']; ?>' placeholder="Order Email" name="FData[OrderEmail]"  aria-required="true">
                                        </div>
                                        <!--                                        <div class="col-sm-1">
                                                                                    <span style="color: red; font-size: 20px">*</span>
                                                                                </div>-->
                                    </div>


                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label" style="font-size: 20px;   color: black;">Working Hours</label>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err20" style=""></div>

                                    </div>
                                    <?PHP
                                    $times = '<option value="">Time</option>
                                        <option value="12:30 AM">12:30 AM</option>
                                                    <option value="1:00 AM">1:00 AM</option>
                                                     <option value="1:30 AM">1:30 AM</option>
                                                    <option value="2:00 AM">2:00 AM</option>
                                                     <option value="2:30 AM">2:30 AM</option>
                                                    <option value="3:00 AM">3:00 AM</option>
                                                    <option value="3:30 AM">3:30 AM</option>
                                                    <option value="4:00 AM">4:00 AM</option>
                                                    <option value="4:30 AM">4:30 AM</option>
                                                    <option value="5:00 AM">5:00 AM</option>
                                                     <option value="5:30 AM">5:30 AM</option>
                                                    <option value="6:00 AM">6:00 AM</option>
                                                    <option value="6:30 AM">6:30 AM</option>
                                                    <option value="7:00 AM">7:00 AM</option>
                                                    <option value="7:30 AM">7:30 AM</option>
                                                    <option value="8:00 AM">8:00 AM</option>
                                                    <option value="8:30 AM">8:30 AM</option>
                                                    <option value="9:00 AM">9:00 AM</option>
                                                    <option value="9:30 AM">9:30 AM</option>
                                                    <option value="10:00 AM">10:00 AM</option>
                                                    <option value="10:30 AM">10:30 AM</option>
                                                    <option value="11:00 AM">11:00 AM</option>
                                                    <option value="11:30 AM">11:30 AM</option>
                                                    <option value="12:00 PM">12:00 PM</option>
                                                    <option value="12:30 PM">12:30 PM</option>
                                                    <option value="1:00 PM">1:00 PM</option>
                                                    <option value="1:30 PM">1:30 PM</option>
                                                    <option value="2:00 PM">2:00 PM</option>
                                                    <option value="2:30 PM">2:30 PM</option>
                                                    <option value="3:00 PM">3:00 PM</option>
                                                    <option value="3:30 PM">3:30 PM</option>
                                                    <option value="4:00 PM">4:00 PM</option>
                                                    <option value="4:30 PM">4:30 PM</option>
                                                    <option value="5:00 PM">5:00 PM</option>
                                                    <option value="5:30 PM">5:30 PM</option>
                                                    <option value="6:00 PM">6:00 PM</option>
                                                    <option value="6:30 PM">6:30 PM</option>
                                                    <option value="7:00 PM">7:00 PM</option>
                                                    <option value="7:30 PM">7:30 PM</option>
                                                    <option value="8:00 PM">8:00 PM</option>
                                                    <option value="8:30 PM">8:30 PM</option>
                                                    <option value="9:00 PM">9:00 PM</option>
                                                    <option value="9:30 PM">9:30 PM</option>
                                                    <option value="10:00 PM">10:00 PM</option>
                                                    <option value="10:30 PM">10:30 PM</option>
                                                    <option value="11:00 PM">11:00 PM</option>
                                                    <option value="11:30 PM">11:30 PM</option>
                                                    <option value="12:00 AM">12:00 AM</option>
                                                    ';
                                    ?>
                                    <div class="form-group">
                                       <label for="fname" class="col-sm-1 control-label">Monday<span style="color:red;font-size: 18px">*</span></label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-2 text-center">
                                                <select  class="Monday1 form-control col-sm-2" id="Monday1" name="FData[WorkingHours][Monday][From]" >
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Monday2 form-control col-sm-2" id="Monday2" name="FData[WorkingHours][Monday][To]"  >
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">And</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Monday3 form-control col-sm-2" id="Monday3" name="FData[WorkingHours][Monday][From1]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Monday4 form-control col-sm-2" id="Monday4" name="FData[WorkingHours][Monday][To1]"  >
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-1 control-label">Tuesday</label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-2 text-center">
                                                <select  class="Tuesday1 form-control col-sm-2"id="Tuesday1" name="FData[WorkingHours][Tuesday][From]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>

                                            <div class="col-sm-2 text-center">
                                                <select  class="Tuesday2 form-control col-sm-2" id="Tuesday2" name="FData[WorkingHours][Tuesday][To]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">And</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Tuesday3 form-control col-sm-2" id="Tuesday3" name="FData[WorkingHours][Tuesday][From1]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Tuesday4 form-control col-sm-2" id="Tuesday4" name="FData[WorkingHours][Tuesday][To1]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-1 control-label">Wednesday</label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-2 text-center">
                                                <select  class="Wednesday1 form-control col-sm-2" id="Wednesday1" name="FData[WorkingHours][Wednesday][From]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>

                                            <div class="col-sm-2 text-center">
                                                <select  class="Wednesday2 form-control col-sm-2" id="Wednesday2" name="FData[WorkingHours][Wednesday][To]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">And</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Wednesday3 form-control col-sm-2" id="Wednesday3" name="FData[WorkingHours][Wednesday][From1]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Wednesday4 form-control col-sm-2" id="Wednesday4" name="FData[WorkingHours][Wednesday][To1]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-1 control-label">Thursday</label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-2 text-center">
                                                <select  class="Thursday1 form-control col-sm-2" id="Thursday1" name="FData[WorkingHours][Thursday][From]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>

                                            <div class="col-sm-2 text-center">
                                                <select  class="Thursday2 form-control col-sm-2" id="Thursday2" name="FData[WorkingHours][Thursday][To]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">And</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Thursday3 form-control col-sm-2" id="Thursday3" name="FData[WorkingHours][Thursday][From1]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Thursday4 form-control col-sm-2" id="Thursday4" name="FData[WorkingHours][Thursday][To1]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-1 control-label">Friday</label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-2 text-center">
                                                <select  class="Friday1 form-control col-sm-2" id="Friday1" name="FData[WorkingHours][Friday][From]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>

                                            <div class="col-sm-2 text-center">
                                                <select  class="Friday2 form-control col-sm-2" id="Friday2" name="FData[WorkingHours][Friday][To]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">And</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Friday3 form-control col-sm-2" id="Friday3" name="FData[WorkingHours][Friday][From1]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Friday4 form-control col-sm-2" id="Friday4" name="FData[WorkingHours][Friday][To1]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-1 control-label">Saturday</label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-2 text-center">
                                                <select  class="Saturday1 form-control col-sm-2" id="Saturday1" name="FData[WorkingHours][Saturday][From]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>

                                            <div class="col-sm-2 text-center">
                                                <select  class="Saturday2 form-control col-sm-2"id="Saturday2" name="FData[WorkingHours][Saturday][To]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">And</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Saturday3 form-control col-sm-2" id="Saturday3" name="FData[WorkingHours][Saturday][From1]">
                                                    <?PHP echo $times; ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Saturday4 form-control col-sm-2" id="Saturday4" name="FData[WorkingHours][Saturday][To1]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-1 control-label">Sunday</label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-2 text-center">
                                                <select  class="Sunday1 form-control col-sm-2" id="Sunday1" name="FData[WorkingHours][Sunday][From]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>

                                            <div class="col-sm-2 text-center">
                                                <select  class="Sunday2 form-control col-sm-2" id="Sunday2" name="FData[WorkingHours][Sunday][To]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">And</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Sunday3 form-control col-sm-2" id="Sunday3" name="FData[WorkingHours][Sunday][From1]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 text-center">To</div>
                                            <div class="col-sm-2 text-center">
                                                <select  class="Sunday4 form-control col-sm-2" id="Sunday4" name="FData[WorkingHours][Sunday][To1]">
                                                    <?PHP echo $times; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    </div>
                                </div>
                            </div>
                            <script>
                                $('.Monday1').on('change', function() {
                                    console.log( this.value );
                                    var val =  this.value;
                                   
                                    $('.Tuesday1').val(val);
                                    $('.Wednesday1').val(val);
                                    $('.Thursday1').val(val);
                                    $('.Friday1').val(val);
                                    $('.Saturday1').val(val);
                                    $('.Sunday1').val(val);
                                  });
                                $('.Monday2').on('change', function() {
                                    console.log( this.value );
                                    var val =  this.value;
                                     $('.Tuesday2').val(val);
                                    $('.Wednesday2').val(val);
                                    $('.Thursday2').val(val);
                                    $('.Friday2').val(val);
                                    $('.Saturday2').val(val);
                                    $('.Sunday2').val(val);
                                  });
                                $('.Monday3').on('change', function() {
                                    console.log( this.value );
                                    var val =  this.value;
                                    $('.Tuesday3').val(val);
                                    $('.Wednesday3').val(val);
                                    $('.Thursday3').val(val);
                                    $('.Friday3').val(val);
                                    $('.Saturday3').val(val);
                                    $('.Sunday3').val(val);
                                  });
                                $('.Monday4').on('change', function() {
                                    console.log( this.value );
                                    var val =  this.value;
                                     $('.Tuesday4').val(val);
                                    $('.Wednesday4').val(val);
                                    $('.Thursday4').val(val);
                                    $('.Friday4').val(val);
                                    $('.Saturday4').val(val);
                                    $('.Sunday4').val(val);
                                  });

                           function openFileUpload(check)
                                {
                                    if (check.id == '1') {
                                        $('#FileUpload1').trigger('click');
                                        //                                        $('#uploadMain').trigger('click');
                                    } else if (check.id == '3') {
                                        //                                        $('#uploadBanner').trigger('click');
                                        $('#FileUpload2').trigger('click');
                                    } else {
                                        //                                        $('#uploadFile').trigger('click');
                                        $('#FileUpload3').trigger('click');
                                    }
                                    //                                                                $('#iimg').hide();


                                }

                               function deletepimg(val) {
                                    $(val).hide();
                                      var img = val.id;
                                    $('#MainImageUrl').attr('src','');
                                    $('input[name="FData[ImageUrl]"]').val("");
//                                  ('input[name="FData[ImageUrl]"]').val(sort2);
//                                      $("#pImg"+ img).attr('src','');
                                    
//                                    $("#pImg"+ img).remove();
                                    //                                    $('#SaveImages').load('<?PHP echo AjaxUrl; ?>DeleteImage.php', {ImageId: ii});
                                }
                                
                                function deletebimg(val) {
                                    $(val).hide();
                                      var img = val.id;
                                    $('#BannerImageUrl').attr('src','');
                                    $('input[name="FData[BannerImageUrl]"]').val("");
//                                                                    $('#SaveImages').load('<?PHP echo AjaxUrl; ?>DeleteImage.php', {ImageId: ii});
                                }
                                function delete1(val) {
                                    var ii = val.id;
                                    //                                    alert(ii);
                                    $('#Img' + ii).remove();
                                    //                                    $('#SaveImages').load('<?PHP echo AjaxUrl; ?>DeleteImage.php', {ImageId: ii});
                                }

                            </script>


                            <input type='hidden' class='Masterimageurl' name='FData[ImageUrl]' value="<?PHP echo $ProfileData['ImageUrl']; ?>">
                            <input type='hidden' class='Bnnerimageurl' name='FData[BannerImageUrl]' value="<?PHP echo $ProfileData['BannerImageUrl']; ?>">
                            <input id="FileUpload1" type="file" name="myMainfile"  style="visibility: hidden;"/>
                            <input id="FileUpload2" type="file" name="myMainfile"  style="visibility: hidden;"/>
                            <input id="FileUpload3" type="file" name="myMainfile"  style="visibility: hidden;"/>




                            <div class="padding-20 bg-white">
                                <ul class="pager wizard">
                                    <li class="next" id="nextbutton">
                                        <button class="btn btn-primary btn-cons btn-animated from-left  pull-right" type="button" onclick="movetonext()">
                                            <span style="
                                                  height: 24px;
                                                  ">Next</span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-primary btn-cons btn-animated from-left pull-right" type="button" onclick="submitform()">
                                            <span style="
                                                  height: 24px;
                                                  ">Finish</span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-default btn-cons pull-right" type="button" onclick="movetoprevious()">
                                            <span style="
                                                  height: 24px;
                                                  ">Previous</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>               
                    </form>

                </div>


            </div>
            <!-- END PANEL -->
        </div>

    </div>
    <!-- END JUMBOTRON -->

    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->

        <!-- END PLACE PAGE CONTENT HERE -->
    </div>
    <!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
    <?PHP include 'FooterPage.php' ?>
</div>



<?PHP
$i = 0;
if (is_array($ProfileData['WorkingHours'])) {
    foreach ($ProfileData['WorkingHours'] as $wh) {

        if ($i == 0) {
            ?>
            <script>

                $('#Monday1').val('<?PHP echo $wh['From']; ?>');
                $('#Monday2').val('<?PHP echo $wh['To']; ?>');
                $('#Monday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Monday4').val('<?PHP echo $wh['To1']; ?>');</script>
            <?PHP
        }
        if ($i == 1) {
            ?>
            <script>
                $('#Tuesday1').val('<?PHP echo $wh['From']; ?>');
                $('#Tuesday2').val('<?PHP echo $wh['To']; ?>');
                $('#Tuesday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Tuesday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 2) {
            ?>
            <script>
                $('#Wednesday1').val('<?PHP echo $wh['From']; ?>');
                $('#Wednesday2').val('<?PHP echo $wh['To']; ?>');
                $('#Wednesday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Wednesday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 3) {
            ?>
            <script>
                $('#Thursday1').val('<?PHP echo $wh['From']; ?>');
                $('#Thursday2').val('<?PHP echo $wh['To']; ?>');
                $('#Thursday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Thursday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 4) {
            ?>
            <script>
                $('#Friday1').val('<?PHP echo $wh['From']; ?>');
                $('#Friday2').val('<?PHP echo $wh['To']; ?>');
                $('#Friday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Friday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 5) {
            ?>
            <script>
                $('#Saturday1').val('<?PHP echo $wh['From']; ?>');
                $('#Saturday2').val('<?PHP echo $wh['To']; ?>');
                $('#Saturday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Saturday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 6) {
            ?>
            <script>
                $('#Sunday1').val('<?PHP echo $wh['From']; ?>');
                $('#Sunday2').val('<?PHP echo $wh['To']; ?>');
                $('#Sunday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Sunday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        $i++;
    }
}
?>
<div class="modal fade in" id="ForMaps" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog">

        <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCenter" method= "post" onsubmit="return validateForm();">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Drag Marker To See Address</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group" >
                        <div id="myMap" style="width: 544px; height: 250px;"></div><br/>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" value="" placeholder="Address ..." name="address" id="address" onkeyup="getAddLatLong(this);">
                        </div> 
                        <div class="col-md-6">
                            <label>Latitude</label>
                            <input type="text" readonly class="form-control" value="" placeholder="Latitude ..." name="latitude" id="latitude">
                        </div> 
                        <div class="col-md-6">
                            <label>Longitude</label>
                            <input type="text" readonly class="form-control" value="" placeholder="Longitude ..." name="longitude" id="longitude">
                        </div> 

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick='Cancel();'>Close</button>
                    <input type="button" id="TakeMapAddress"  data-dismiss="modal" class="btn btn-primary" onclick='Take();' value="Take Address" >

                </div>
            </div>
        </form>


    </div>

</div>

<div class="modal fade in" id="ForImageCroping" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog" style="
         width: 750px;
         ">


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Crop Image</h4>
            </div>

            <div class="modal-body">
                <div class="form-group" >
                    <!--<div class="container">-->
                    <div class="row"  style="height:423px;">
                        <div class="col-md-12" style="
                             height: 106%;
                             ">
                            <!-- <h3 class="page-header">Demo:</h3> -->
                            <div class="img-container" style="
                                 margin-top: 29px;
                                 ">
                                <div id="toUpload1" style="display: block; width: 825px; margin-top:-30px; overflow: hidden;">
                                    <label class="btn-upload" for="FileUpload1" title="Upload image file">
                                        <!--<input type="file"  id="FileUpload1" name="file" accept="image/*">-->
                                        <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                                            <span><a><img id="img" src="img/images(6).jpg" style= margin-top:150px; ></a></span>
                                        </span>
                                    </label>
                                </div>
                                <img id="image" src=" " style="width:500px !important;height:400px !important;">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="
                         margin-top: -114px;
                         ">
                        <div class="col-md-12 docs-buttons" style="margin-top:-2px; ">
                            <div class="btn-group btn-group-crop">
                                <button type="button" class="btn btn-primary btn block" data-method="getCroppedCanvas">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Custom Crop Image" style="width:130px">
                                        Crop Image
                                    </span>
                                </button>
                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 60, &quot;height&quot;: 60 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 60x60">
                                        60&times;60
                                    </span>
                                </button>
                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 120, &quot;height&quot;: 120 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 120x120">
                                        120&times;120
                                    </span>
                                </button>

                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 150, &quot;height&quot;: 150 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 150x150">
                                        150&times;150
                                    </span>
                                </button>
                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 500, &quot;height&quot;: 500 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 500x500">
                                        500&times;500
                                    </span>
                                </button>
                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 400, &quot;height&quot;: 300 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 400X300">
                                        400&times;300
                                    </span>
                                </button>

                            </div>

                            <!-- Show the cropped image in modal -->

                        </div>
                    </div>
                    <!--</div>-->
                </div>
            </div>

        </div>


    </div>

</div>
<div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
    <div id="dialog" class="modal-dialog">
        <div class="modal-content">
            <div id="header" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
            </div>
            <div id="prop1" class="modal-body"></div>
            <div id="prop" class="modal-footer">
                <button type="button" class="btn btn-default"  onclick='Cancel1();'>Close</button>
                <input type='hidden' id='ImageData' name='ImageData'>
                <a class="btn btn-primary" id="download" href="javascript:void(0);">Save</a>
            </div>
        </div>
    </div>
</div>