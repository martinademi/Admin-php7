<?PHP
error_reporting(false);

$enable = 'disabled';
if ($Admin == '1') {
    $enable = 'required';
}
?>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link href="http://104.131.66.74/Menuse/Business/application/views/admin/js/jquery.multiselect.css"
    rel="stylesheet" type="text/css" />
<script src="http://104.131.66.74/Menuse/Business/application/views/admin/js/jquery.multiselect.js"
    type="text/javascript"></script>-->

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
            
          

         <?php if($ProfileData['pricing_status'] == 2 && $ProfileData['Driver_exist'] == 1 ){ ?>
                $('.basefare').show();  
         <?php }else { ?>
                $('.basefare').hide();
         <?php    } ?>
        
        $('.MyProfile').addClass('active');
//        $('.icon-thumbnail').attr('<?php // echo base_url(); ?>assets/dash_board_on.png"');
        $('.profile_thumb').attr('src', "<?php echo base_url(); ?>assets/restaurant_on.png");
       
        $('#callM').click(function () {

            $('#NewCat').modal('show');
        });
        $('#CountryList').change(function () {

            $('#CityList').load('http://104.131.66.74/Menuse/sadmin/index.php/superadmin/get_cities', {country: $('#CountryList').val()});
            $('#countryname').val($('#CountryList option:selected').text());
//            alert($('#CountryList option:selected').text());
        });
        $('#cityLists').change(function () {
//            alert();
            alert($('#cityLists option:selected').text());
            $('#cityname').val($('#cityLists option:selected').text());
        });

        if ($('#SelectedCity').val() != '') {
//            alert($('#SelectedCity').val());
            var enable = '<?PHP echo $enable; ?>';
//            alert(enable);
            $('#CityList').load('http://104.131.66.74/Menuse/Business/index.php/Admin/get_city', {country: $('#CountryList').val(), CityId: $('#SelectedCity').val(), enable: enable});
        }
        
         $('#BusinessCat').on('change',function(){
            
            var catID = $(this).val();
//            alert(catID);
           $('#subCatList').load("<?php echo base_url('index.php/Admin') ?>/getsubcat", {catID: catID});
          
    
       });
       
    });
  
    function submitform()
    {

//        var BusinessCat = $("#BusinessCat").val();
        var monday = $("#Monday1").val();
        if(monday == '' || monday == null){
            $("#err20").text("Working hours are Missing ");
        }else{
            $("#addentity").submit();
        }
    }
    function validatecat(){
         $.ajax({
            url: "<?php echo base_url() ?>index.php/Admin/validate_catname",
            type: "POST",
            data: {catname: $('#catname_0').val()},
            dataType: "JSON",
            success: function (result) {

                // alert();
//                alert(result.count);
                console.log(result.count);
                $('#catname_0').attr('data', result.msg);

                if (result.count == true) {

                    $("#clearerror").html("Category name already exists.");
                    $('#catname_0').focus();
                    return false;
                } else if (result.count != true) {
                    $("#clearerror").html("");

                }
            }
        });
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
        $("#tb1").attr('data-toggle','tab');
        $("#tb1").attr('href','#tab1');
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
        console.log('profiletab-start');
        var pstatus = true;
        var reason = '';
        $(".text_err").text("");
        
         var businessname = new Array();
                    $(".businessname").each(function (){
                        businessname.push($(this).val());
                    });
        if($(".errr1").val() == '' || $(".errr1").val() == null){
             pstatus = false;
             $("#err1").text("Name is Missing");
        }
//        else if($(".errr2").val() == '' || $(".errr2").val() == null){
//             pstatus = false;
//             $("#err2").text("Name is Missing");
//        }
        else if($(".errr3").val() == '0'){
             pstatus = false;
             $("#err3").text("category is Missing");
        }
//        else if($(".errr4").val() == '0'){
//             pstatus = false;
//             $("#err4").text("sub-category is Missing");
//        }
        else if($(".errr5").val() == '' || $(".errr5").val() == null){
             pstatus = false;
             $("#err5").text("Email is Missing");
        }else if($(".errr6").val() == '' || $(".errr6").val() == null){
             pstatus = false;
             $("#err6").text("Owner name is Missing");
        }else if($(".errr7").val() == '' || $(".errr7").val() == null){
             pstatus = false;
             $("#err7").text("Description is Missing");
        }
//        else if($(".errr8").val() == '' || $(".errr8").val() == null){
//             pstatus = false;
//             $("#err8").text("Description is Missing");
//        }
        else if($(".errr9").val() == '' || $(".errr9").val() == null){
             pstatus = false;
             $("#err9").text("Address is Missing");
        }
//        else if($(".errr10").val() == '' || $(".errr10").val() == null){
//             pstatus = false;
//             $("#err10").text("Address is Missing");
//        }
        else if($(".errr11").val() == '0'){
             pstatus = false;
             $("#err11").text("Country is Missing");
        }
        else if($(".errr12").val() == '0'){
             pstatus = false;
             $("#err12").text("City is Missing");
        }else if($(".errr13").val() == '' || $(".errr13").val() == null){
             pstatus = false;
             $("#err13").text("Postal code is Missing");
        }else if($(".errr14").val() == '' || $(".errr14").val() == null){
             pstatus = false;
             $("#err14").text("Longtitude is Missing");
        }else if($(".errr15").val() == '' || $(".errr15").val() == null){
             pstatus = false;
             $("#err15").text("Latitude is Missing");
       }

        if (pstatus === false)
        {
            console.log('pstatus-false');
            $("#mtab2").removeAttr('data-toggle','tab');
            $("#mtab2").removeAttr('href','#tab2');
            $("#mtab3").removeAttr('data-toggle','tab');
            $("#mtab3").removeAttr('href','#tab3');           
           
            setTimeout(function ()
            {
                proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
            }, 300);
            if (reason != '') {
                alert(reason);
            } 
            $("#tab1icon").removeClass("fs-14 fa fa-check");
            return false;
        }else{  
            
            console.log('else');
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
//            $("#nextbutton").removeClass("hidden");
//            $("#finishbutton").addClass("hidden");
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

//    function signatorytab(litabtoremove, divtabtoremove)
//    {
//        var bstatus = true;
//        if (bonafidetab(litabtoremove, divtabtoremove))
//        {
////            if (isBlank($("#entitypersonname").val()) || isBlank($("#entitysignatorymobileno").val()) || isBlank($("#entitysignatoryfile").val()) || $("#entitydegination").val() === "null")
////            {
////                bstatus = false;
////            }
////
////            if (validateEmail($("#entitysignatoryemail").val()) !== 2)
////            {
////                bstatus = false;
////            }
//
//            if (bstatus === false)
//            {
//                setTimeout(function ()
//                {
//                    proceed(litabtoremove, divtabtoremove, 'fourthlitab', 'tab4');
//
//                }, 100);
//
//                alert("Mandatory Fields Missing");
//                $("#tab4icon").removeClass("fs-14 fa fa-check");
//                return false;
//            }
//
//            $("#tab4icon").addClass("fs-14 fa fa-check");
//            $("#nextbutton").addClass("hidden");
//            $("#finishbutton").removeClass("hidden");
//
//            return bstatus;
//        }
//
//    }


    function proceed(litabtoremove, divtabtoremove, litabtoadd, divtabtoadd)
    {
        console.log(litabtoremove);
        console.log(litabtoadd);
        $("#" + litabtoremove).removeClass("active");
        $("#" + divtabtoremove).removeClass("active");

        $("#" + litabtoadd).addClass("active");
        $("#" + divtabtoadd).addClass("active");
    }

    /*-----managing direct click on tab is over -----*/

    //manage next next and finish button
    function movetonext()
    {
                var currenttabstatus = $("li.active").attr('id');
                console.log(currenttabstatus);
        if (currenttabstatus === "firstlitab")
        {
             var entityname = new Array();
                    $(".businessname").each(function (){
                        entityname.push($(this).val());
                    });
//            var entityname = $("#entityname").val();
            var BusinessCat = $("#BusinessCat").val();
            var entityemail = $("#entityemail").val();
            var entityOwner = $("#entityOwnername").val();
            var entiryLatitude = $("#entiryLatitude").val();
            var entiryLongitude = $("#entiryLongitude").val();
            console.log(entiryLongitude);
            console.log(entiryLatitude);
            profiletab('secondlitab', 'tab2');
            // console.log(entityname, BusinessCat, entityemail, entityOwner);
            if(entityname && BusinessCat && entityemail && entityOwner && entiryLatitude && entiryLongitude){
//                alert();
                proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
            }
//        } else if ($("#secondlitab").attr('class') === "active")
        } else if (currenttabstatus === "secondlitab")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');
            $("#finishbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");
        }
//        else if ($("#thirdlitab").attr('class') === "active")
//        {
//            bonafidetab('fourthlitab', 'tab4');
//            proceed('thirdlitab', 'tab3', 'fourthlitab', 'tab4');
//            $("#finishbutton").removeClass("hidden");
//            $("#nextbutton").addClass("hidden");
//        }
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
//        else if ($("#fourthlitab").attr('class') === "active")
//        {
//            bonafidetab('fourthlitab', 'tab4');
//            proceed('fourthlitab', 'tab4', 'thirdlitab', 'tab3');
//            $("#nextbutton").removeClass("hidden");
//            $("#finishbutton").addClass("hidden");
//        }
    }

</script>
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyA1fCUi4aDiWfD7vvdJgznndKWF54KJRnw"></script>-->
<script>
    function callMap() {
//        alert();

        $('#ForMaps').modal('show');


        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
            initialize($('#entiryLatitude').val(), $('#entiryLongitude').val());
            $('.entityAddress').val($('.entityAddress').val());
        } else {
            initialize(20.268455824834792, 85.84099235520011);
        }
    }
    var map;
    var marker;
    var myLatlng = new google.maps.LatLng(20.268455824834792, 85.84099235520011);

    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();

    function getAddLatLong(text) {
        var addr = text.value;
//        alert(text.value);
        $.ajax({
            url: "http://104.131.66.74/Menuse/Business/application/views/superadmin/get_latlong.php",
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
            url: "http://104.131.66.74/Menuse/Business/application/views/superadmin/get_latlong.php",
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
            myLatlng = new google.maps.LatLng(20.268455824834792, 85.84099235520011);
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
        map = new google.maps.Map(document.getElementById("myMap"), mapOptions);
        marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            draggable: true
        });

        geocoder.geocode({'latLng': myLatlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    if (from == '1') {
                        $('#entiryLongitude').val(marker.getPosition().lng());
                        $('#entiryLatitude').val(marker.getPosition().lat());
                    } else {
//                        $('#entityAddress').val(results[0].formatted_address);
                        $('#latitude').val(marker.getPosition().lat());
                        $('#longitude').val(marker.getPosition().lng());
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    }
                }
            }
        });
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
                        $('#entityAddress1').val(results[0].formatted_address);
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
        console.log($('#entityAddress1').val());
        console.log($('#longitude').val());
        console.log($('#latitude').val());
        $('#entiryLongitude').val($('#longitude').val());
        $('#entiryLatitude').val($('#latitude').val());
//        $('#entityAddress1').val($('.entityAddress').val());
        $('.entityAddress').val($('#entityAddress1').val());

//        $('#entityAddress2').val($('#address2').val());

        $('#ForMaps').modal('hide');

    }
    function test() {
//alert();
    }


    function ResetPwd(v) {
        $('#CenterId').val(v.id);
        $('#resetPwd').modal('show');
    }
    
     function changeprice(){
      var SelectList = $('select#pricing');
       var pricing = $('option:selected', SelectList).val();
       
//          var pricing = $("#pricing").val();
          var drivers = $("#drivers").val();
//       alert(pricing);
//       alert(drivers);
        if (pricing == "2" && drivers == '1')
            {
//                if(drivers == '1'){
//                alert();
                $('.basefare').show();
               
//                $('.range').show();
//                $('.Priceperkm').show();
//                $("#clearerror").text(<?php // echo json_encode(POPUP_PASSENGERS_PRICING); ?>);
//                } 
            }
            else{
//                  alert();
              $('.basefare').hide();
                $('#Range').val('');
                $('#Pricepermile').val('');
                $('#Basefare').val('');
            }
    }
    
   function acceptselect(){
        
//        alert();
        var select = $('.accepts:checked').val();
             if(select == '1'){
                $('.Pickup').show(); 
                $('.Delivery').hide(); 
             }else if(select == '2'){
                $('.Pickup').hide();  
                $('.Delivery').show(); 
             }
             else if(select == '3'){
                $('.Pickup').show();
                $('.Delivery').show(); 
             }
    }
</script>

<script type="text/javascript">
    function initialize1() {
        var id = '';
         $('.entityAddress').each(function(){
//                console.log($(this).attr("id"));
                  id = $(this).attr("id");
                  
        var input = document.getElementById(id);
//        var input = document.getElementById('entityAddress');
        var input1 = document.getElementById('entityAddress1');
        var options = {componentRestrictions: {country: 'us'}};

        var autocomplete = new google.maps.places.Autocomplete(input);
        var autocomplete1 = new google.maps.places.Autocomplete(input1);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
//            document.getElementById('city2').value = place.name;
            document.getElementById('entiryLatitude').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude').value = place.geometry.location.lng();
            //alert("This function is working!");
            //alert(place.name);
            // alert(place.address_components[0].long_name);

        });
        google.maps.event.addListener(autocomplete1, 'place_changed', function () {
            var place = autocomplete1.getPlace();
//            console.log( place.name)
//            document.getElementById('entityAddress1').value = place.name;
            document.getElementById('entiryLatitude').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude').value = place.geometry.location.lng();
            //alert("This function is working!");
            //alert(place.name);
            // alert(place.address_components[0].long_name);

         });
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
                                            <a href="<?php echo base_url() ?>index.php/Admin/loadDashbord">DASHBOARD</a>
                                        </li>-->


                    <li style="width: 300px"><a href="#" class="active">STORE PROFILE</a>
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
                    <a onclick="addresstab('thirdlitab', 'tab3')" id="mtab3"><i id="tab3icon" class=""></i> <span>Working Hours</span></a>
                </li>
                <!--                        <li class="" id="fourthlitab">
                                            <a data-toggle="tab" href="#tab4" onclick="bonafidetab('fourthlitab', 'tab4')"><i id="tab4icon" class=""></i> <span>Images</span></a>
                                        </li>-->

            </ul>



            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs -->
                    
                    <!-- Tab panes -->
                    <form id="BannerImage" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                        <input id="uploadBanner" type="file" name="myMainfile"  style="visibility: hidden;"/>

                    </form>
                    <!--<form id="addentity" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">-->
                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php/Admin/UpdateProfile" method="post" enctype="multipart/form-data">
                        <input type='hidden' name='BusinessId' value='<?PHP echo $BizId; ?>'> 
                        <div class="tab-content">
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">
                                    <?php // print_r($ProfileData['ProviderName'][$val['lan_id']]); 
//                                            print_r($val['lan_id']);
                                    ?>
                                    
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
                                                            echo '  <img src="http://104.131.66.74/Menuse/Business/addnew.png" id="MainImageUrl" style="width: 100%;height: 160px;">';
                                                        } else {
                                                            
                                                            echo '<div class="col-md-12" id="pImg' . $ProfileData['ImageUrl'] . '">
                                                                    <img src="' . $ProfileData['ImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="MainImageUrl" style="width: 100%;height: 160px;">
                                                                     <div style="position:absolute;top:0;right:0px;">
                                                                         <a onclick="deletepimg(this)" id="' . $ProfileData['ImageUrl'] . '"  value="" ><img  class="thumb_image" src="http://104.131.66.74/Menuse/dialog_close_button.png" height="20px" width="20px" /></a>
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
                                                 width: 31%;">
                                                <a onclick="openFileUpload(this)" id='3' style="cursor: pointer;">
                                                    <div class="portfolio-group">
                                                        <?PHP
                                                        if ($ProfileData['BannerImageUrl'] == '') {
                                                            echo '  <img src="http://104.131.66.74/Menuse/Business/addnew.png" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">';
                                                        } else {
//                                                            echo '  <img src="' . $ProfileData['BannerImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">';
                                                            echo '<div class="col-md-12" id="bImg' . $ProfileData['BannerImageUrl'] . '">
                                                                    <img src="' . $ProfileData['BannerImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">
                                                                     <div style="position:absolute;top:0;right:0px;">
                                                                         <a onclick="deletebimg(this)" id="' . $ProfileData['BannerImageUrl'] . '"  value="' . $ProfileData['BannerImageUrl'] . '" >
                                                                             <img  class="thumb_image" src="http://104.131.66.74/Menuse/dialog_close_button.png" height="20px" width="20px" /></a>
                                                                     </div>
                                                                 </div>';
                                                        }
                                                        ?>

                                                    </div>
                                                </a>                                                                    
                                            </div>

                                        </div>

                                    </div>

<!--                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label for="fname" class="control-label">Upload Logo</label>
                                            <div class="" style="
                                                 width: 31%;
                                                 ">
                                                <a onclick="openFileUpload(this)" id='1' style="cursor: pointer;">
                                                    <div class="portfolio-group">
                                                        <?PHP
//                                                        if ($ProfileData['ImageUrl'] == '') {
//                                                            echo '  <img src="http://104.131.66.74/Menuse/Business/addnew.png" id="MainImageUrl" style="width: 100%;height: 160px;">';
//                                                        } else {
//                                                               echo '<div class="col-md-12" id="pImg' . $ProfileData['ImageUrl'] . '">
//                                                                    <img src="' . $ProfileData['ImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="MainImageUrl" style="width: 100%;height: 160px;">
//                                                                     <div style="position:absolute;top:0;right:0px;">
//                                                                         <a onclick="deletepimg(this)" id="' . $ProfileData['ImageUrl'] . '"  value="" ><img  class="thumb_image" src="http://104.131.66.74/Menuse/dialog_close_button.png" height="20px" width="20px" /></a>
//                                                                     </div>
//                                                                 </div>';
//                                                        }
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
//                                                        if ($ProfileData['BannerImageUrl'] == '') {
//                                                            echo '  <img src="http://104.131.66.74/Menuse/Business/addnew.png" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">';
//                                                        } else {
//                                                            echo '  <img src="' . $ProfileData['BannerImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">';
//                                                        }
//                                                         if ($ProfileData['BannerImageUrl'] == '') {
//                                                            echo '  <img src="http://104.131.66.74/Menuse/Business/addnew.png" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">';
//                                                        } else {
////                                                            echo '  <img src="' . $ProfileData['BannerImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">';
//                                                            echo '<div class="col-md-12" id="bImg' . $ProfileData['BannerImageUrl'] . '">
//                                                                    <img src="' . $ProfileData['BannerImageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" id="BannerImageUrl" style="width: 100%;height: 160px;">
//                                                                     <div style="position:absolute;top:0;right:0px;">
//                                                                         <a onclick="deletebimg(this)" id="' . $ProfileData['BannerImageUrl'] . '"  value="' . $ProfileData['BannerImageUrl'] . '" >
//                                                                             <img  class="thumb_image" src="http://104.131.66.74/Menuse/dialog_close_button.png" height="20px" width="20px" /></a>
//                                                                     </div>
//                                                                 </div>';
//                                                        }
                                                        ?>

                                                    </div>
                                                </a>                                                                    
                                            </div>

                                        </div>

                                    </div>-->
                                    <div id="bussiness_txt">
                                        <div class="form-group lan_append formex">
                                            <label for="fname" class="col-sm-3 control-label"> Business Name (English) <span style="color:red;font-size: 18px">*</span></label>
                                              <div class="col-sm-6">  
                                                  <input type="text" <?PHP echo $enable; ?> id="businessname_0" name="FData[ProviderName][0]"  onblur="validatecat()"value="<?PHP if(is_array($ProfileData['name'])) 
                                                                                                                                            echo $ProfileData['name'][0];
                                                                                                                                        else
                                                                                                                                            echo $ProfileData['name'];
                                                                                                                                    ?>" class=" businessname errr1 form-control error-box-class" >
                                              </div>
                                              <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err1" style=""></div>
                                         </div>

                                                <?php
                                                 foreach ($language as $val) {
//                                                    print_r($val['lan_id']);
                                                ?>
                                        <div class="form-group lan_append formex" >
                                               <label for="fname" class=" col-sm-3 control-label">Business Name  (<?php echo $val['lan_name'];?>) <span style="color:red;font-size: 18px">*</span></label>
                                               <div class="col-sm-6">
                                                 <input type="text" <?php echo $enable; ?> id="businessname_<?= $val['lan_id'] ?>" value="<?php echo $ProfileData['name'][$val['lan_id']]; ?>" name="FData[ProviderName][<?= $val['lan_id'] ?>]"  class="errr2 businessname form-control error-box-class" >
                                               </div>
                                               <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err2" style=""></div>
                                        </div>

                                                    <?php } ?>

                                    </div>

<!--                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Business Name <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input readonly type="text" class="form-control" id="entityname" value="<?PHP echo $ProfileData['name']; ?>" placeholder="Business Name" name="FData[ProviderName]"  aria-required="true" <?PHP echo $enable; ?>>
                                            <input id="searchTextField" type="text" size="50">
                                        </div>
                                        
                                    </div>-->
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Category <em>*</em></label>
                                        <div class="col-sm-6">
                                            <div id='CatList'>
                                                <select id='BusinessCat' readonly class="errr3 form-control" name='FData[BusinessCategory]' required <?PHP echo $enable; ?> >
                                                    <option value='0'>Select Category</option>
                                                    
                                                    <?PHP
                                                    foreach ($ProCats as $procat) {
//                                                    foreach ($ProfileData['BusinessCategory'] as $buscat){
                                                        
                                                        if ($ProfileData['BusinessCategory'] == (string) $procat['_id']['$oid']) {
//                                                            echo 'if';
                                                            echo ' <option value="' . (string) $procat['_id']['$oid'] . '" selected>' . implode($procat['name'],',') . '</option>';
                                                    }else {
                                                           echo ' <option value="' . (string) $procat['_id']['$oid'] . '">' . implode($procat['name'],',') . '</option>';
                                                        
                                                        }
                                                   }
                                                  
//                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Sub-category <em>*</em></label>
                                        <div class="col-sm-6">
                                          <?php //  foreach ($ProfileData['subCategory'] as $buscat){
//                                          print_r($buscat); } ?>
                                            <div id='subCatList'>
                                                <select id="subCatId" multiple readonly name="FData[subCategory][]"  class="errr4 form-control error-box-class" required <?PHP echo $enable; ?>>
                                                <!--<select multiple id='BusinesssubCat' class="form-control" name="subCategory[]" required <?PHP echo $enable; ?> >-->
                                                    <option value='0'>Select Sub-category</option>
                                                    
                                                    <?PHP
//                                                    $subcat = [];
                                                    foreach ($ProsubCats as $procat) {
                                                    foreach ($ProfileData['subCategory'] as $buscat){
//                                                        print_r($buscat);
                                                        if ($buscat == (string) $procat['_id']) {
//                                                            $subcat[] =  $procat['Subcategory'];
//                                                            echo 'if';
                                                            echo ' <option value="' . (string) $procat['_id'] . '" selected>' . implode($procat['Subcategory'],',') . '</option>';
                                                            
                                                    }else {
//                                                           echo ' <option value="' . (string) $procat['_id'] . '">' . $procat['Subcategory'] . '</option>';
                                                        
                                                        }
                                                   }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Email <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="errr5 form-control" id="entityemail" value='<?PHP echo $ProfileData['Email']; ?>' placeholder="Email" name="FData[Email]" <?PHP echo $enable; ?>  aria-required="true" style="color: black;">
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err5" style=""></div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Owner Name <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="errr6 form-control"  id="entityOwnername" value='<?PHP echo $ProfileData['OwnerName']; ?>' placeholder="Owner Name" name="FData[OwnerName]" <?PHP echo $enable; ?>  aria-required="true">
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err6" style=""></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Web-Site </label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control" id="entitywebsite" value='<?PHP echo $ProfileData['Website']; ?>' placeholder="Web-Site" name="FData[Website]"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Phone</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control" id="entityPhone" value='<?PHP echo $ProfileData['Phone']; ?>' placeholder="Phone" name="FData[Phone]"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>

                                    </div>

                                        
                                    <div id="bussiness_txt">
                                        <div class="form-group lan_append formex">
                                            <label for="fname" class="col-sm-3 control-label">Description (English) <span style="color:red;font-size: 18px">*</span></label>
                                              <div class="col-sm-6">  
                                            <textarea rows="4" cols="50"  class="errr7 form-control" id="entitydesc" placeholder="Description" name="FData[Description][0]"  aria-required="true" ><?PHP echo $ProfileData['Description'][0]; ?></textarea>
                                            <!--<input type="text" readonly  id="entitydesc_0" name="Description[0]"  value="<?PHP echo $ProfileData['ProviderName'][0]; ?>" class=" businessname form-control error-box-class" >-->
                                              </div>
                                              <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err7" style=""></div>
                                         </div>

                                                <?php
                                                 foreach ($language as $val) {
            //                                         print_r($val);
                                                ?>
                                        <div class="form-group lan_append formex" >
                                               <label for="fname"  class=" col-sm-3 control-label">Description (<?php echo $val['lan_name'];?>) <span style="color:red;font-size: 18px">*</span></label>
                                               <div class="col-sm-6">
                                                   <textarea rows="4" cols="50"  class="errr8 form-control" id="entitydesc" placeholder="Description" name="FData[Description][<?= $val['lan_id'] ?>]"  aria-required="true"><?PHP echo $ProfileData['Description'][$val['lan_id']]; ?></textarea>
                                                <!--<input type="text" readonly  id="businessname_<?= $val['lan_id'] ?>" value="<?PHP echo $ProfileData['ProviderName'][$val['lan_id']]; ?>" name="Businessname<?= $val['lan_id'] ?>"  class=" businessname form-control error-box-class" >-->
                                               </div>
                                               <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err8" style=""></div>
                                        </div>

                                                    <?php } ?>



                                    </div>

<!--                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Description</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityemail" placeholder="Description" name="FData[Description]"  aria-required="true">
                                            <textarea rows="4" cols="50" class="form-control" id="entitydesc" placeholder="Description" name="FData[Description]"  aria-required="true"><?PHP echo $ProfileData['Description']; ?></textarea>
                                        </div>

                                    </div>-->

                                     
                                    <!--<div class="form-group">-->
                                        <div id="Address_txt" >
                                            <div class="form-group">
                                                <label for="fname" class="col-sm-3 control-label ">Address (English)<span style="color:red;font-size: 18px">*</span></label>
                                                <div class="col-sm-6">
                                                    <textarea <?PHP echo $enable; ?> class="errr9 form-control entityAddress" id="entityAddress_0" placeholder="Address" name="FData[Address][0]"  aria-required="true"  onkeyup="getAddLatLong1(this)""><?php echo $ProfileData['Address'][0]; ?></textarea>
                                                </div>
                                                <div class="col-sm-offset-3 col-sm-7 error-box text_err" id="err9" style=""></div>
                                          <div class="col-md-1">
                                            <div id='map_lat_long'></div>

                                            <button  type="button" class="form-control btn btn-danger btn-sm" style="border-radius: 20px;"  name="action" onclick="callMap();" value="add">Map</button>
                                            <div id="latlong_error"></div>
                                        </div>
                                            </div>
                                              <?php
                                                     foreach ($language as $val) {
                //                                         print_r($val);
                                              ?>
                                            <div class="form-group lan_append " >
                                                   <label for="fname" class=" col-sm-3 control-label"> Address (<?php echo $val['lan_name']; ?>) <span style="color:red;font-size: 18px">*</span></label>
                                                   <div class="col-sm-6">
                                                     <textarea <?PHP echo $enable; ?> class="errr10 form-control entityAddress" id="entityAddress_<?= $val['lan_id'] ?>" placeholder="Address" name="FData[Address][<?= $val['lan_id'] ?>]"  aria-required="true"  onchange="getAddLatLong1(this)"><?php echo $ProfileData['Address'][$val['lan_id'] ]; ?></textarea>
                                                   </div>
                                                   <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err10" style=""></div>
<!--                                          <div class="col-md-1">
                                            <div id='map_lat_long'></div>

                                            <button  type="button" class="form-control btn btn-danger btn-sm" style="border-radius: 20px;"  name="action" onclick="callMap();" value="add">Map</button>
                                            <div id="latlong_error"></div>
                                          </div>-->
                                            </div>

                                             <?php } ?>
                   
                                       
                                        </div>
<!--                                        <label for="fname" class="col-sm-3 control-label">Address <em>*</em></label>
                                        <div class="col-sm-6">
                                            <textarea rows="4" cols="50"  class="form-control" id="entityAddress" placeholder="Address" name="FData[Address]"  aria-required="true"  <?PHP // echo $enable; ?>   onchange="getAddLatLong1(this)"><?PHP // if(is_array($ProfileData['Address'])) 
//                                                          echo implode($ProfileData['Address'],',');
//                                                      else
//                                                           echo $ProfileData['Address']; 
                                                ?>
                                            </textarea>
                                        </div>-->
                                        
<!--                                        <div class="col-md-1">
                                            <div id='map_lat_long'></div>

                                            <button  type="button" class="form-control btn btn-danger btn-sm" style="border-radius: 20px;"  name="action" onclick="callMap();" value="add">Map</button>
                                            <div id="latlong_error"></div>
                                        </div>
                                    </div>-->
                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label">Address Line2</label>
                                                                            <div class="col-sm-6">
                                                                                <input type="text" class="form-control" id="entityAddress" value='<?PHP // echo $ProfileData['Address'];                                                                                                                                                                                                          ?>' placeholder="Address" name="FData[Address]"  aria-required="true" disabled>
                                                                                <textarea class="form-control" id="entityAddress2" placeholder="Address2" name="FData[Address2]"  aria-required="true"  <?PHP // echo $enable;                                                                    ?>><?PHP // echo $ProfileData['Address2'];                                                                    ?></textarea>
                                    
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <span style="color: red; font-size: 20px">*</span>
                                                                            </div>
                                    
                                                                        </div>-->
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Country <em>*</em></label>
                                        <div class="col-sm-6">
                                            <select  id='CountryList' name='FData[Country]' class='errr11 form-control'  <?PHP echo $enable; ?>>
                                                <option val='0'>Select Country</option>
                                                <?PHP
                                                foreach ($CountryList as $Country) {
                                                    if ((string)$Country['_id'] == $ProfileData['Country']) {
                                                        echo "<option value='" . $Country['_id'] . "' selected>" . implode($Country['name'],',') . "</option>";
                                                    } else {
                                                        echo "<option value='" . $Country['_id'] . "'>" . implode($Country['name'],','). "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err11" style=""></div>                                       
                                    </div>
                                    <input type='hidden' name='FData[cityname]' id='cityname'>
                                    <input type='hidden' name='FData[countryname]' id='countryname'>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">City <em>*</em></label>
                                        <div class="col-sm-6">
                                            <div id='CityList' >
                                                <select  id='cityLists' class="errr12 form-control" name='FData[City]' <?PHP echo $enable; ?> >
                                                    <option value='0'>Select City</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err12" style=""></div>
                                        <input type='hidden' id='SelectedCity' value='<?PHP echo $ProfileData['City']; ?>'>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Postal Code <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input  type="text" class="errr13 form-control" id="entitypostalcode" value='<?PHP echo $ProfileData['PostalCode']; ?>' placeholder="0" name="FData[PostalCode]"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err13" style=""></div>                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Longitude <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input  type="text" readonly class="errr14 form-control" id="entiryLongitude" value='<?PHP echo $ProfileData['Location']['Longitude']; ?>' placeholder="0.00" name="FData[Location][Longitude]"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err14" style=""></div>                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Latitude <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input  type="text" readonly class="errr15 form-control" id="entiryLatitude" value='<?PHP echo $ProfileData['Location']['Latitude']; ?>' placeholder="0.00" name="FData[Location][Latitude]"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err15" style=""></div>
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
                                  
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Maximum Images Allowed Per Product</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="MaxImageForProducts" class="form-control" value='<?PHP echo $ProfileData['MaxImageForProducts']; ?>' placeholder="Maximum Images Allowed Per Product" name="FData[MaxImageForProducts]"  aria-required="true" >
                                        </div>
                              
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Avg cooking time</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="avgcooktime" class="form-control" value='<?PHP echo $ProfileData['avg_cook_time']; ?>' placeholder="hh:mm:ss" name="FData[avg_cook_time]"  aria-required="true" >
                                        </div>
                              
                                    </div>
                                    <div class="form-group" class="formex">
                                        <label for="fname" class="col-sm-3 control-label">Budget</label>
                                         <div class="col-sm-6">
                                        <select id="Budget" name="FData[Budget]"  class="form-control error-box-class" >
                                             <option value="">Select Drivers</option>
                                                <?PHP
//                                                foreach ($CountryList as $Country) {
                                                    if ($ProfileData['Budget'] == 1) {
                                                        echo "<option value='" .$ProfileData['Budget']. "' selected>1</option>";
                                                        echo "<option value='2' >2</option>";
                                                        echo "<option value='3' >3</option>";
                                                        echo "<option value='4' >4</option>";
                                                        echo "<option value='5' >5</option>";
                                                    }else if($ProfileData['Budget'] == 2){
                                                        echo "<option value='1' >1</option>";
                                                        echo "<option value='" .$ProfileData['Budget']. "' selected>2</option>";
                                                        echo "<option value='3' >3</option>";
                                                        echo "<option value='4' >4</option>";
                                                        echo "<option value='5' >5</option>";
                                                    }else if($ProfileData['Budget'] == 3){
                                                        echo "<option value='1' >1</option>";
                                                        echo "<option value='2' >2</option>";
                                                        echo "<option value='" .$ProfileData['Budget']. "' selected>3</option>";
                                                        echo "<option value='4' >4</option>";
                                                        echo "<option value='5' >5</option>";
                                                    }else if($ProfileData['Budget'] == 4){
                                                        echo "<option value='1' >1</option>";
                                                        echo "<option value='2' >4</option>";
                                                        echo "<option value='3' >3</option>";
                                                        echo "<option value='" .$ProfileData['Budget']. "' selected>4</option>";
                                                        echo "<option value='5' >5</option>";
                                                    }else {
                                                        echo "<option value='1' >1</option>";
                                                        echo "<option value='2' >4</option>";
                                                        echo "<option value='3' >3</option>"; 
                                                        echo "<option value='4' >5</option>";
                                                        echo "<option value='" .$ProfileData['Budget']. "' selected>5</option>";
                                                     }
//                                                }
                                                ?> 
                                            
<!--                                            <option value="0">Jaiecom Drivers</option>
                                            <option value="1">Store Drivers</option>-->
                                        </select>
                                         </div>

                                    </div>
                                      
                                     <br>
                                    <h5 class="col-xs-12"><b>Price Settings</b></h5>
                                     <hr class="col-xs-12">
                                    <br>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Minimum Order Value ($)</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entiryminorderVal" value='<?PHP echo $ProfileData['MinimumOrderValue']; ?>' placeholder="Minimum Order Value" name="FData[MinimumOrderValue]"  aria-required="true" >
                                        </div>
                                       
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Free Delivery Above ($)</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="freedelVal" value='<?PHP echo $ProfileData['FreeDeliveryAbove']; ?>' placeholder="Free Delivery Above" name="FData[FreeDeliveryAbove]"  aria-required="true" >
                                        </div>
                                       
                                    </div>
                                    
                                  

                                    <div class="form-group" class="formex">
                                        <label for="fname" class="col-sm-3 control-label">Pricing Model</label>
                                         <div class="col-sm-6">
                                                 
                                             <input type="radio" class="pricing_" name="FData[pricing_status]" value=0 <?php echo ($ProfileData['pricing_status'] == 0) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>ZONAL PRICING</label> 
                                             &nbsp;&nbsp;&nbsp;&nbsp;
                                             <input type="radio" class="pricing_" name="FData[pricing_status]"  value=1  <?php echo ($ProfileData['pricing_status'] == 1) ? "CHECKED" : " " ?>  >&nbsp;&nbsp;<label>MILEAGE PRICING</label>

                                             
                                             
<!--                                             <select id="pricing" name="FData[pricing_status]"  onchange="changeprice();" value="<?php $ProfileData['pricing_status'];?>" class="form-control error-box-class" aria-required="true" >
                                            <option value="0">Select Pricing</option>
                                             <?php // if ($ProfileData['pricing_status'] == 1) {
//                                                        echo "<option value='" .$ProfileData['pricing_status']. "' selected>ZONAL PRICING</option>";
//                                                        echo "<option value='2' >MILEAGE PRICING</option>";
//                                                    } else {
//                                                         echo "<option value='1' >ZONAL PRICING</option>";
//                                                        echo "<option value='" .$ProfileData['pricing_status']. "' selected>MILEAGE PRICING</option>";
//                                                    }
                                             ?>
                                            <option value="1">ZONAL PRICING</option>
                                            <option value="2">MILEAGE PRICING</option>
                                        </select>-->
                                         </div>

                                    </div>
                                    <br>
                                    
                                    <div class="basefare">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Base Fare ($)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="Basefare" value='<?PHP echo $ProfileData['Basefare']; ?>' placeholder="Base Fare" name="FData[Basefare]"  aria-required="true" >
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Range ($)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="Range" value='<?PHP echo $ProfileData['Range']; ?>' placeholder="Range" name="FData[Range]"  aria-required="true" >
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Price/Km ($)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="Pricepermile" value='<?PHP echo $ProfileData['Pricepermile']; ?>' placeholder="Price/Km" name="FData[Pricepermile]"  aria-required="true" >
                                            </div>

                                        </div>
                                    </div>
                                    
                                   
                                    <!--
                                    <div class="form-group" >
                                        <label for="fname" class="col-sm-3 control-label">Pricing</label>
                                        <div class="col-sm-6">                                            
                                                <input type="radio" class="radio-inline"  style="" name="FData[pricing_status]"  aria-required="true" id="yes1" value=1 <?php // echo ($ProfileData['pricing_status'] == 1) ? "CHECKED" : " " ?> /> Zonal Pricing
                                         
                                                <input type="radio" class="radio-inline" style="" name="FData[pricing_status]"  aria-required="true" id="yes1" value=2 <?php // echo ($ProfileData['pricing_status'] == 2) ? "CHECKED" : " " ?>  /> Mileage Pricing                                           
                                        </div>Ordertype_status
                                    </div>-->
                                        <br>
                                        <h5 class="col-xs-12"><b>Service Settings</b></h5>
                                        <hr>
                                        <br>
                                       <div class="form-group formex">

                                         <div class="frmSearch">
                                             <label for="fname" class="col-sm-3 control-label">Order Type<span style="color:red;font-size: 18px">*</span></label>
                                             <div class="col-sm-6" id="accepts" >
                                                 <input type="radio" name="FData[Ordertype_status]" onclick="acceptselect();" class="accepts" id="accepts_1" value=1 <?php echo ($ProfileData['Ordertype_status'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp; Pickup
                                                    <input type="radio" name="FData[Ordertype_status]" onclick="acceptselect();" class="accepts" id="accepts_2" value=2 <?php echo ($ProfileData['Ordertype_status'] == 2) ? "CHECKED" : " " ?>>&nbsp;&nbsp; Delivery
                                                    <input type="radio" name="FData[Ordertype_status]" onclick="acceptselect();" class="accepts" id="accepts_3" value=3 <?php echo ($ProfileData['Ordertype_status'] == 3) ? "CHECKED" : " " ?> >&nbsp;&nbsp; Both<br>
                                               </div>
                                         </div>
                                        </div>
                                    <br>
                                    <h5 class="col-xs-12"><b>Payment Settings</b></h5>
                                     <hr class="col-xs-12">
                                    
                                    <div class="form-group pickup" >
                                        <label for="fname" class="col-sm-3 control-label">Payment method for Pickup<span style="color:red;font-size: 18px">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="checkbox"  class="checkbox_ checkbox-inline" name="FData[P_cash]" id="Pcash" value=1 <?php echo ($ProfileData['P_cash'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>Cash</label> 
                                            <!--<br>-->
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox"  class="checkbox_ checkbox-inline" name="FData[P_card]" id="Pcredit_card" value=1 <?php echo ($ProfileData['P_card'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>Credit Card</label> 
                                            <!--<br>-->
<!--                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox"  class="checkbox_ checkbox-inline" name="FData[P_sadad]" id="PSADAD" value=1 <?php echo ($ProfileData['P_sadad'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>SADAD</label> -->
                                        </div>
                                    </div>
                                     

                                     <div class="form-group formex Delivery">
                                        <label for="fname" class="col-sm-3 control-label">Payment method for Delivery<span style="color:red;font-size: 18px">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="checkbox"  class="checkbox_ checkbox-inline" name="FData[D_cash]" id="Dcash" value=1 <?php echo ($ProfileData['D_cash'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>Cash</label> 
                                            <!--<br>-->
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox"  class="checkbox_ checkbox-inline" name="FData[D_card]" id="Dcredit_card" value=1 <?php echo ($ProfileData['D_card'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>Credit Card</label> 
                                            <!--<br>-->
<!--                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox"  class="checkbox_ checkbox-inline" name="FData[D_sadad]" id="DSADAD" value=1 <?php echo ($ProfileData['D_sadad'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>SADAD</label> -->
                                       </div>
                                    </div>
                                     <br>
                                    <h5 class="col-xs-12"><b>Driver Settings</b></h5>
                                     <hr class="col-xs-12">
                                    <br>
                                    <div class="form-group" class="formex">
                                        <label for="fname" class="col-sm-3 control-label">Drivers Type</label>
                                         <div class="col-sm-6">
                                           <input type="checkbox" class="drivers_" name="FData[Jaiecomdriver]" id="Jaiecomdriver0" value=1 <?php echo ($ProfileData['Jaiecomdriver'] == 1) ? "CHECKED" : " " ?>>&nbsp;&nbsp;<label>Menuze Pool</label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                           <input type="checkbox" class="drivers_" name="FData[Storedriver]" id="Storedriver1" value=1 <?php echo ($ProfileData['Storedriver'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>Store Pool</label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                           <input type="checkbox" class="drivers_" name="FData[Offlinedriver]" id="Offlinedrivers" value=1 <?php echo ($ProfileData['Offlinedriver'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>Offline Pool</label>

                                             
                                             
<!--                                        <select id="drivers" name="FData[Driver_exist]" onchange="changeprice();" class="form-control error-box-class" >
                                             <option value="">Select Drivers</option>
                                                <?PHP
//                                                foreach ($CountryList as $Country) {
//                                                    if ($ProfileData['Driver_exist'] == 0) {
//                                                        echo "<option value='" .$ProfileData['Driver_exist']. "' selected>Jaiecom Pool</option>";
//                                                        echo "<option value='1' >Store Drivers</option>";
//                                                        echo "<option value='2' >Offline Drivers</option>";
//                                                    } else if($ProfileData['Driver_exist'] == 1){
//                                                        echo "<option value='0' >Jaiecom Drivers</option>";
//                                                        echo "<option value='" .$ProfileData['Driver_exist']. "' selected>Store Drivers</option>";
//                                                        echo "<option value='2' >Offline Drivers</option>";
//                                                     
//                                                    } else {
//                                                         echo "<option value='0' >Jaiecom Drivers</option>";
//                                                         echo "<option value='1' >Store Drivers</option>";
//                                                         echo "<option value='" .$ProfileData['Driver_exist']. "' selected>Offline Drivers</option>";
//                                                        
//                                                     }
//                                                }
                                                ?> 
                                            
                                            <option value="0">Jaiecom Drivers</option>
                                            <option value="1">Store Drivers</option>
                                        </select>-->
                                         </div>

                                    </div>
                                    <br>
                               
                                    
                                    <br>
                                      <h5 class="col-xs-12"><b>Dispatch Settings</b></h5>
                                    <hr class="col-xs-12">
                                     <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Tier 1</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="tier1" value='<?PHP echo $ProfileData['tier1']; ?>' placeholder="tier1" name="FData[tier1]"  aria-required="true" >
                                        </div>
                                       
                                    </div>
                                     <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Tier 2</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="tier2" value='<?PHP echo $ProfileData['tier2']; ?>' placeholder="tier2" name="FData[tier2]"  aria-required="true" >
                                        </div>
                                       
                                    </div>
                                     <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Tier 3</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="tier3" value='<?PHP echo $ProfileData['tier3']; ?>' placeholder="tier3" name="FData[tier3]"  aria-required="true" >
                                        </div>
                                       
                                    </div>
                                    
                                     <br>
                                      <h5 class="col-xs-12"><b>Printer Settings</b></h5>
                                    <hr class="col-xs-12">
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Printer Setup Request Link</label>
                                        <div class="col-sm-6">
                                            <input readonly type="text" class="form-control" id="ReqLink" value='http://jaiecom.com/Tebse/printer/order_request.php?id=<?PHP echo (string) $ProfileData['_id']; ?>&'   aria-required="true">
                                        </div>

                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Printer Setup Callback URL</label>
                                        <div class="col-sm-6">
                                            <input readonly type="text" class="form-control" id="OrderEmails" value='http://jaiecom.com/Tebse/printer/order_response.php'   aria-required="true">
                                        </div>
                                        <!--                                        <div class="col-sm-1">
                                                                                    <span style="color: red; font-size: 20px">*</span>
                                                                                </div>-->
                                    </div>
                                    
<!--                                     <br>
                                        <h5 class="col-xs-12"><b>Notes</b></h5>
                                        <hr class="col-xs-12">
                                        <br>
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label"> Note </label>
                                            <div class="col-sm-6">
                                                <textarea type="text"  id="notes" name="FData[Notes]"   class="description form-control error-box-class" ><?PHP echo $ProfileData['Notes']; ?></textarea>
                                            </div>
                                        </div>-->
                                    
<!--                                     <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Payment Method</label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" class="checkbox_ checkbox-inline" name="FData[cash]" id="cash" value=1 <?php echo ($ProfileData['cash'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>Cash</label> 
                                            <br>
                                            <input type="checkbox" class="checkbox_ checkbox-inline" name="FData[card]" id="credit_card" value=1 <?php echo ($ProfileData['card'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>Credit Card</label> 
                                            <br>
                                            <input type="checkbox" class="checkbox_ checkbox-inline" name="FData[sadad]" id="SADAD" value=1 <?php echo ($ProfileData['sadad'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label>SADAD</label> 
                                        </div>
                                       
                                    </div>-->
                                    
                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label">Vat</label>
                                                                            <div class="col-sm-6">
                                                                                <input type="text" class="form-control" id="entiryvat" value='<?PHP echo $ProfileData['Vat']; ?>' placeholder="Vat" name="FData[Vat]"  aria-required="true" <?PHP echo $enable; ?> >
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <span style="color: red; font-size: 20px">*</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label">Service Tax</label>
                                                                            <div class="col-sm-6">
                                                                                <input type="text" class="form-control" id="entiryservicetax" value='<?PHP echo $ProfileData['ServiceTax']; ?>' placeholder="Service Tax" name="FData[ServiceTax]"  aria-required="true" <?PHP echo $enable; ?>>
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <span style="color: red; font-size: 20px">*</span>
                                                                            </div>
                                                                        </div>-->
                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label">Google Places Id</label>
                                                                            <div class="col-sm-6">
                                                                                <input type="text" class="form-control" id="entiryLatitude" value='<?PHP // echo $ProfileData['GooglePlaceId'];                                                                                                                  ?>' placeholder="Google Places Id" name="FData[GooglePlaceId]"  aria-required="true" <?PHP echo $enable; ?>>
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <span style="color: red; font-size: 20px">*</span>
                                                                            </div>
                                                                        </div>-->




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
                                    <div class="form-group ">
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
//                                $('.Monday').val(val);
//                                $('.Tuesday').val(val);
                             
                           
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

                                    var img = val.id;
                                    //                                    alert(img);
                                    $('#pImg' + img).remove();
                                    //                                    $('#SaveImages').load('<?PHP echo AjaxUrl; ?>DeleteImage.php', {ImageId: ii});
                                }

                                function delete1(val) {
                                    var ii = val.id;
                                    //                                    alert(ii);
                                    $('#Img' + ii).remove();
                                    //                                    $('#SaveImages').load('<?PHP echo AjaxUrl; ?>DeleteImage.php', {ImageId: ii});
                                }

                            </script>

                             <input id="FileUpload1" type="file" name="myMainfile"  style="visibility: hidden;"/>
                            <input id="FileUpload2" type="file" name="myMainfile"  style="visibility: hidden;"/>
                            <input id="FileUpload3" type="file" name="myMainfile"  style="visibility: hidden;"/>

                            <input type='hidden' class='Masterimageurl' name='FData[ImageUrl]' value="<?PHP echo $ProfileData['ImageUrl']; ?>">
                            <input type='hidden' class='Bnnerimageurl' name='FData[BannerImageUrl]' value="<?PHP echo $ProfileData['BannerImageUrl']; ?>">

                            <div class="tab-pane slide-left padding-20" id="tab4">

                                <div class="row row-same-height">
                                    <div id='MultipleImages'>
                                        <?PHP
                                        $ImgId = 0;
                                        foreach ($ProfileData['Images'] as $Imgs) {
                                            echo '<div class="col-md-2" id="Img' . $ImgId . '">
                                            <input type = "hidden" id = "image" name = "FData[Images][' . $ImgId . '][Url]" value = "' . $Imgs['Url'] . '"><img src="' . $Imgs['Url'] . '" alt="image 1" style="width: 100%;height: 160px;">
                                            <div style="position:absolute;top:0;right:0px;">
                                                <a onclick="delete1(this)" id="' . $ImgId . '"  value="" ><img  class="thumb_image" src="http://108.166.190.172:81/SteinGlass/assets/newui/dialog_close_button.png" height="20px" width="20px" /></a>
                                            </div>
                                        </div>';
                                            $ImgId++;
                                        }
                                        ?>
                                        <input type = "hidden" id = "imageId" value = "<?PHP echo $ImgId; ?>">
                                    </div>
                                    <div class="col-md-2" >
                                        <a onclick="openFileUpload(this)" id='2' onmouseover="" style="cursor: pointer;">
                                            <div class="portfolio-group">
                                                <img src="http://104.131.66.74/Menuse/Business/addnew.png" onerror="if (this.src != \'error.jpg\') this.src = \'http://104.131.66.74/Menuse/Business/addnew.png\';" style="width: 100%;height: 160px;">
                                            </div>
                                        </a>                                                                    
                                    </div>
                                </div>

                            </div>




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


<div class="modal fade in" id="ForMaps" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog">

        <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCenter" method= "post" onsubmit="return validateF
                orm();">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:initial;">&times;</button>
                    <h4 class="modal-title">Drag Marker To See Address</h4>
                </div>

                <div class="modal-body"><div class="form-group" >
                        <div id="myMap" style="width: 544px; height: 250px;"></div><br/>
                        <div class="form-group">
                            <label>Address</label>
                            <!--<input type="text" class="form-control" value="" placeholder="Address ..." name="address" id="address" onkeyup="getAddLatLong(this);">-->
                            <textarea rows="4" cols="50" class="form-control" id="entityAddress1" placeholder="Address.." name="FData[Address][0]"   onkeyup="getAddLatLong(this)"><?PHP echo $ProfileData['Address'][0]; ?></textarea>

                        </div> 
                        <!--                        <div class="form-group">
                                                    <label>Address Line 2</label>
                                                    <input type="text" class="form-control" value="" placeholder="Address ..." name="address2" id="address2" >
                                                </div> -->
                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" readonly class="form-control" value="" placeholder="Latitude ..." name="latitude" id="latitude">
                        </div> 
                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" readonly class="form-control" value="" placeholder="Longitude ..." name="longitude" id="longitude">
                        </div> 

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='Cancel();'>Close</button>
                    <input type="button" id="TakeMapAddress"  data-dismiss="modal" class="btn btn-primary" onclick='Take();' value="Take Address" >

                </div>
            </div>
        </form>
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
                                            <span><a><img id="img" src="img/images(6).jpg" style=" margin-top:150px; "></a></span>
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