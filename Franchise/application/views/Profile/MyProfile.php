<?php
$readonlymode= ($this->session->userdata["fadmin"]['Admin']=='0')?"readonly":"";
$disabledmode= ($this->session->userdata["fadmin"]['Admin']=='0')?"disabled":"";

?>
<link href="<?php echo ServiceLink; ?>theme/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<!-- <link rel="stylesheet" type="text/css" href="http://104.131.66.74/Grocer/sadmin/application/views/sweetalert/dist/sweetalert.css"> -->

<style>     
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
        width: 44px;
        height: 20px;
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
        border-radius: 50px;
        transition: background 0.4s;
    }
    input.cmn-toggle-round + label:after {
        width: 16px;
        background-color: #fff;
        border-radius: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        transition: margin 0.4s;
    }
    input.cmn-toggle-round:checked + label:before {
        background-color: #8ce196;
    }
    input.cmn-toggle-round:checked + label:after {
        margin-left:25px;
    }

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
    .row.row-same-height .tableTime .text-center:first-child {
        margin-top: 0px;
    }
    .zeroPadding{
        padding:0px;
    }
    .row.row-same-height tr th, .row.row-same-height tr td {
        border: 1px solid gray;
        padding: 5px;
        text-align: center; 
        width: 8%;
    }
    .row.row-same-height .buttonLeft {
        margin-left: 5%;
        display: inline-block;
    }
    .btn-prime {
        color: #fff;
        background-color: #4187C9   !important; 
        border-color:  #4187C9  !important;
        padding: 5px 28px;
        padding-left: 17px;
        width: 130px;

    }
    .col-md-12.inner .row {
        border: 1px solid gainsboro;
        padding: 10px;
        height: 167px;
    }
    .row.dayheading {
        height: 75px !important;
    }
    .phoneWidth{
        width: 216%;
    }
    .multiselect-container>li>a label.checkbox input[type="checkbox"] {
        margin-left: -20px !important;
    }
    .btn-group{
        width: 100% !important;
    }
    span.multiselect-selected-text {
        font-size: 12px;
    }
    span.abs_text1 {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
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
    span.abs_textLeft {
        position: absolute;
        left: 12px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
    }
    .bootstrap-timepicker-widget table td input{
        width: 60px;

    }
    .datepicker{z-index:1151 !important;}

     .error{
        color:red;
    }

    .intl-tel-input {
        position: relative;
        display: block;
        height: 40px;
    }
    .MandatoryMarker{
        color:red;
    }

</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?php echo GOOGLE_MAP_API_KEY; ?>"></script>

<script>
    var addressType = '';
    function callMap() {
        $('#mapentityAddress').val('');
        $('#mapBtnDataId').val($('#mapbtn1').attr("data-id"));
        $('#ForMaps').modal('show');
        addressType = 1;
        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
            initialize1($('#entiryLatitude').val(), $('#entiryLongitude').val(),"1");
            $('#mapentityAddress').val($('#entityAddress_0').val());
        } else {
            var loc = '';
            $('#mapentityAddress,#latitude,#longitude').val("");
            $.get("https://ipinfo.io/json", function (response) {
                loc = response.loc;
                var res = loc.split(",");
                initialize1(res[0], res[1]);
            }, "jsonp");
        }
    }
    function callMapB() {
        $('#mapentityAddress').val('');
        $('#mapBtnDataId').val($('#mapbtn2').attr("data-id"));
        $('#ForMaps').modal('show');
        addressType = 2;
        if ($('#entityBillingAddress_0').val() != "") {
            $('#mapentityAddress').val($('#entityBillingAddress_0').val());
            $.ajax({
                url: "<?php echo base_url(); ?>application/views/get_latlong.php",
                method: "POST",
                data: {Address: $('#mapentityAddress').val()},
                datatype: 'json', // fix: need to append your data to the call
                success: function (data) {
                    console.log(data);
                    var Arr = JSON.parse(data);
                    console.log(data);
                    if (Arr.flag == 1) {
                        $('#latitude').val(Arr.Lat);
                        $('#longitude').val(Arr.Long);
                        initialize1(Arr.Lat, Arr.Long, '0');
                    }
                }
            });
        } else {
            var loc = '';
            $.get("https://ipinfo.io/json", function (response) {
                loc = response.loc;
                var res = loc.split(",");
                initialize1(res[0], res[1]);
            }, "jsonp");
        }
    }
    function Cancel() {
        $('#mapBtnDataId').val('');
        $('#ForMaps').modal('hide');
    }

    function Take() {
        if (addressType == 1) {
            $('#entiryLongitude').val($('#longitude').val());
            $('#entiryLatitude').val($('#latitude').val());
            $('.entityAddress').val($('#mapentityAddress').val());
        } else if (addressType == 2) {
            $('#entityBillingAddress_0').val($('#mapentityAddress').val());
        }
        $('#mapBtnDataId').val('');
        $('#ForMaps').modal('hide');
    }

    function initialize1(lat, long, from) {
        console.log("my lat",lat,"my long",long,"from",from)
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
                        $('#longitude').val(marker.getPosition().lng());
                        $('#latitude').val(marker.getPosition().lat());
                        infowindow.open(map, marker);
                    } else {
                        $('#entityAddress').val(results[0].formatted_address);
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

                        $('#mapentityAddress').val(results[0].formatted_address);

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

    var map;
    var marker;
    var myLatlng = new google.maps.LatLng(20.268455824834792, 85.84099235520011);

    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();

    function getAddLatLong1(text) {

        var addr = $('#entityAddress_0').val();
        if (!addr) {
            var addr = text;
        }
        console.log(addr);
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                console.log(data);
                if (Arr.flag == 1) {
                    $('#entiryLatitude').val(Arr.Lat);
                    $('#entiryLongitude').val(Arr.Long);
                    initialize1(Arr.Lat, Arr.Long, '0');
                }
            }
        });
    }
    function getAddLatLong() {
        //console.log("my text",text)
        var addr = $('#mapentityAddress').val();
        var mapdataid=$('#mapBtnDataId').val();
        console.log(mapdataid);
        if (addr) {
           // var addr = text;
            //var addr = '';
        
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                $('#latitude').val(Arr.Lat);
                $('#longitude').val(Arr.Long);
                initialize1(Arr.Lat, Arr.Long, mapdataid);
                

            }
        });
    }
    }
        /* start */

        function getAddLatLong2(text) {
        var mapdataid=$('#mapBtnDataId').val();
        console.log("mapdataid in 2 ",mapdataid)
        if (text) {
           var addr = text;
            //var addr = '';
        
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                // console.log("dataprint--------");
                // console.log(data);
                var Arr = JSON.parse(data);
                $('#latitude').val(Arr.Lat);
                $('#longitude').val(Arr.Long);
                if(mapdataid!=''){
                    initialize1(Arr.Lat, Arr.Long,mapdataid);
                }
                
                else{
                    initialize1(Arr.Lat, Arr.Long,'0');
                }
                

            }
        });
    }
    }
        /* end */


    function initialize() {
        var id = '';

        var input = document.getElementById('entityAddress_0');

        var options = {componentRestrictions: {country: 'us'}};

        var autocomplete = new google.maps.places.Autocomplete(input);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            
            document.getElementById('entiryLatitude').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude').value = place.geometry.location.lng();
            //initialize(place.geometry.location.lat(), place.geometry.location.lng(), '0');
            // $('#longitude').val(place.geometry.location.lng());
            // $('#latitude').val(place.geometry.location.lat());
            // getAddLatLong1(place.formatted_address);
        });

        var input0 = document.getElementById('entityBillingAddress_0');
        var autocomplete0 = new google.maps.places.Autocomplete(input0);
        google.maps.event.addListener(autocomplete0, 'place_changed', function () {
            var place = autocomplete0.getPlace();
            // getAddLatLong2(place.formatted_address);
        });

        var input1 = document.getElementById('mapentityAddress');
        var autocomplete1 = new google.maps.places.Autocomplete(input1);
        google.maps.event.addListener(autocomplete1, 'place_changed', function () {
            var place = autocomplete1.getPlace();
            //getAddLatLong2(place.formatted_address);
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
            initialize1(place.geometry.location.lat(),place.geometry.location.lng(), '0');
            // getAddLatLong2(place.formatted_address);
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<script>
    function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            alert('Please Enter only numbers')
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();

        }
    }
    function isNumberKey(evt)
        {
            $("#mobify").text("");
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 41 || charCode > 57)) {
                //    alert("Only numbers are allowed");
                $("#mobify").text("Only Numbers Are Allowed");
                return false;
            }
            return true;
        }
</script>
<script>
    $(document).ready(function () {
        //var sessdata = '<?php echo $this->session->userdata["fadmin"]['Admin'] ?>';
        //console.log("session data---",sessdata);
        
        var autoApproval = '<?php echo $ProfileData['autoApproval'] ?>';
        if (autoApproval) {
            if (autoApproval == 1) {
                $('#Autoapproval').prop('checked', true);
            } else if (autoApproval == 0) {
                $('#Autoapproval').prop('checked', false);
            }
        }
        $("#entityemail").blur(function(){
           
            var emailstr = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            var email = $('#entityemail').val();
            //console.log(emailstr.test(email))
           if(!(emailstr.test(email)))
           {
                
            $("#err_entityemail").text("Please enter valid email id");
            $("#entityemail").focus();
           }
        })

        $("#orderEmail").blur(function(){
           
           var emailstr = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
           var email = $('#orderEmail').val();
           //console.log(emailstr.test(email))
          if(!emailstr.test(email))
          {
            $("#err_orderEmail").text("Please enter valid email id");
            $("#orderEmail").focus();
          }
       })

        $("#businessNumber").intlTelInput("setNumber", '');
        $("#phone").intlTelInput("setNumber", '');

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class').change(function () {
            $('.error-box').text('');
        });

        $("#businessNumber").on("countrychange", function (e, countryData) {
            $("#bcountryCode").val(countryData.dialCode);
        });
        $("#phone").on("countrychange", function (e, countryData) {
            $("#countryCode").val(countryData.dialCode);
        });


        var val = '<?php echo $ProfileData['forcedAccept'] ?>';
        if (val == 1) {
            $('#forcedAccept').prop('checked', true);
        } else if (val == 2) {
            $('#forcedAccept').prop('checked', false);
        }

        var autoDispatch = '<?php echo $ProfileData['autoDispatch'] ?>';
        if (autoDispatch) {
            if (autoDispatch == 1) {
                $('#autoDispatch').prop('checked', true);
            } else if (val == 0) {
                $('#autoDispatch').prop('checked', false);
            }
        }

        var drivtype = '<?php echo $ProfileData['drivertype']; ?>';

        if (drivtype == "grocer_driver") {
            $('#thirdlitab').show();
            $('#fourthlitab').hide();
        } else if (drivtype == "store_driver") {
            $('#fourthlitab').show();
            $('#thirdlitab').hide();
        }


        $('.driv').click(function () {
            var selected = $("input[type='radio'][name='FData[drivertype]']:checked");

            var driver_type = selected.val();
            if (driver_type == "store_driver") {
                $('#fourthlitab').show();
                $('#thirdlitab').hide();
            }
            if (driver_type == "grocer_driver") {
                $('#thirdlitab').show();
                $('#fourthlitab').hide();
            }
            if (driver_type == "operator_driver") {
                $('#thirdlitab').hide();
                $('#fourthlitab').hide();
            }
        });

        $('#update').click(function () {

            var day = $('.selectDay').val();
            var slot_time;
            var val = [];
            var timeslot = [];
            var businessId = '<?PHP echo $BizId; ?>';
            var status = "grocer";

            $('.slotchecked:checked').each(function (i) {
                val[i] = $(this).val();

                var from = $('#fromSlot' + val[i]).val();
                var to = $('#toSlot' + val[i]).val();

                timeslot[i] = {slot: val[i], From: from, To: to};
                slot_time = JSON.stringify(timeslot);
            });

            if (val.length < 0 || val.length == 0)
            {
                alert('Please Select the slot');
            } else {

                $.ajax({

                    url: "<?php echo base_url('index.php?/Admin') ?>/update_tslot",
                    type: 'POST',
                    data: {slot_time: slot_time, day: day, businessId: businessId, status: status},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $('#mondaymodal').modal('hide');
                    }

                });

            }
        });

        $('#update1').click(function () {

            var day = $('.selectDay1').val();
            var slot_time;
            var val = [];
            var timeslot = [];
            var businessId = '<?PHP echo $BizId; ?>';
            var status = "store";

            $('.slotchecked1:checked').each(function (i) {
                val[i] = $(this).val();

                var from = $('#store_fromSlot' + val[i]).val();
                var to = $('#store_toSlot' + val[i]).val();

                timeslot[i] = {slot: val[i], From: from, To: to};
                slot_time = JSON.stringify(timeslot);
            });

            if (val.length < 0 || val.length == 0)
            {
                alert('Please Select the slot');
            } else {

                $.ajax({

                    url: "<?php echo base_url('index.php?/Admin') ?>/update_tslot",
                    type: 'POST',
                    data: {slot_time: slot_time, day: day, businessId: businessId, status: status},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $('#storeModal').modal('hide');
                    }
                });
            }
        });

    });
</script>

<script>
    // Working hours function
    function setval(val, id) {
        $('#' + id).val(val);
    }
    var times = '<option value="">Time</option>' +
            '<option value="12:45 AM">12:45 AM</option>' +
            '           <option value="1:00 AM">1:00 AM</option>' +
            '           <option value="1:15 AM">1:15 AM</option>' +
            '           <option value="1:30 AM">1:30 AM</option>' +
            '           <option value="1:45 AM">1:45 AM</option>' +
            '           <option value="2:00 AM">2:00 AM</option>' +
            '           <option value="2:15 AM">2:15 AM</option>' +
            '           <option value="2:30 AM">2:30 AM</option>' +
            '           <option value="2:45 AM">2:45 AM</option>' +
            '           <option value="4:00 AM">4:00 AM</option>' +
            '           <option value="4:15 AM">4:15 AM</option>' +
            '           <option value="4:30 AM">4:30 AM</option>' +
            '           <option value="4:45 AM">4:45 AM</option>' +
            '          <option value="5:00 AM">5:00 AM</option>' +
            '          <option value="5:15 AM">5:15 AM</option>' +
            '          <option value="5:30 AM">5:30 AM</option>' +
            '          <option value="5:45 AM">5:45 AM</option>' +
            '          <option value="6:00 AM">6:00 AM</option>' +
            '          <option value="6:15 AM">6:15 AM</option>' +
            '          <option value="6:30 AM">6:30 AM</option>' +
            '          <option value="6:45 AM">6:45 AM</option>' +
            '          <option value="7:00 AM">7:00 AM</option>' +
            '          <option value="7:15 AM">7:15 AM</option>' +
            '          <option value="7:30 AM">7:30 AM</option>' +
            '          <option value="7:45 AM">7:45 AM</option>' +
            '          <option value="8:00 AM">8:00 AM</option>' +
            '          <option value="8:15 AM">8:15 AM</option>' +
            '          <option value="8:30 AM">8:30 AM</option>' +
            '          <option value="8:45 AM">8:45 AM</option>' +
            '          <option value="9:00 AM">9:00 AM</option>' +
            '          <option value="9:15 AM">9:15 AM</option>' +
            '          <option value="9:30 AM">9:30 AM</option>' +
            '          <option value="9:45 AM">9:45 AM</option>' +
            '          <option value="10:00 AM">10:00 AM</option>' +
            '          <option value="10:15 AM">10:15 AM</option>' +
            '          <option value="10:30 AM">10:30 AM</option>' +
            '          <option value="10:45 AM">10:45 AM</option>' +
            '          <option value="11:00 AM">11:00 AM</option>' +
            '          <option value="11:15 AM">11:15 AM</option>' +
            '          <option value="11:30 AM">11:30 AM</option>' +
            '          <option value="11:45 AM">11:45 AM</option>' +
            '          <option value="12:00 PM">12:00 PM</option>' +
            '          <option value="12:15 PM">12:15 PM</option>' +
            '          <option value="12:30 PM">12:30 PM</option>' +
            '          <option value="12:45 PM">12:45 PM</option>' +
            '          <option value="1:00 PM">1:00 PM</option>' +
            '          <option value="1:15 PM">1:15 PM</option>' +
            '          <option value="1:30 PM">1:30 PM</option>' +
            '          <option value="1:45 PM">1:45 PM</option>' +
            '         <option value="2:00 PM">2:00 PM</option>' +
            '         <option value="2:15 PM">2:00 PM</option>' +
            '         <option value="2:30 PM">2:30 PM</option>' +
            '         <option value="2:45 PM">2:45 PM</option>' +
            '         <option value="3:00 PM">3:00 PM</option>' +
            '         <option value="3:15 PM">3:15 PM</option>' +
            '         <option value="3:30 PM">3:30 PM</option>' +
            '         <option value="3:45 PM">3:45 PM</option>' +
            '         <option value="4:00 PM">4:00 PM</option>' +
            '         <option value="4:15 PM">4:15 PM</option>' +
            '         <option value="4:30 PM">4:30 PM</option>' +
            '         <option value="4:45 PM">4:45 PM</option>' +
            '         <option value="5:00 PM">5:00 PM</option>' +
            '         <option value="5:15 PM">5:15 PM</option>' +
            '         <option value="5:30 PM">5:30 PM</option>' +
            '         <option value="5:45 PM">5:45 PM</option>' +
            '         <option value="6:00 PM">6:00 PM</option>' +
            '         <option value="6:15 PM">6:15 PM</option>' +
            '         <option value="6:30 PM">6:30 PM</option>' +
            '         <option value="6:45 PM">6:45 PM</option>' +
            '         <option value="7:00 PM">7:00 PM</option>' +
            '         <option value="7:15 PM">7:15 PM</option>' +
            '         <option value="7:30 PM">7:30 PM</option>' +
            '         <option value="7:45 PM">7:45 PM</option>' +
            '         <option value="8:00 PM">8:00 PM</option>' +
            '         <option value="8:15 PM">8:15 PM</option>' +
            '         <option value="8:30 PM">8:30 PM</option>' +
            '         <option value="8:45 PM">8:45 PM</option>' +
            '         <option value="9:00 PM">9:00 PM</option>' +
            '         <option value="9:15 PM">9:15 PM</option>' +
            '         <option value="9:30 PM">9:30 PM</option>' +
            '         <option value="9:45 PM">9:45 PM</option>' +
            '         <option value="10:00 PM">10:00 PM</option>' +
            '         <option value="10:15 PM">10:15 PM</option>' +
            '         <option value="10:30 PM">10:30 PM</option>' +
            '         <option value="10:45 PM">10:45 PM</option>' +
            '         <option value="11:00 PM">11:00 PM</option>' +
            '         <option value="11:15 PM">11:15 PM</option>' +
            '         <option value="11:30 PM">11:30 PM</option>' +
            '         <option value="11:45 PM">11:45 PM</option>' +
            '         <option value="12:00 AM">12:00 AM</option> ';
    '         <option value="12:15 AM">12:15 AM</option> ';
    '         <option value="12:30 AM">12:30 AM</option> ';

    var count;
    var Sun;
    function addnewforSundayfun() {
        count = countsunday;
        Sun = ++count;
        var txt = '<div  class="sunday' + Sun + '">' +
                '<div class="col-sm-2 text-center">' +
                ' <select  class="form-control col-sm-2" id="SundayFrom' + Sun + '" name="FData[WorkingHours][Sunday][' + Sun + '][From]">' +
                times +
                '</select>' +
                ' </div>' +
                '<div class = "col-sm-1 text-center" > To </div>' +
                '<div class = "col-sm-2 text-center" >' +
                ' <select  class = "form-control col-sm-2" id = "SundayTo' + Sun + '" name = "FData[WorkingHours][Sunday][' + Sun + '][To]" >' +
                times +
                '</select>' +
                '</div><div class="col-sm-1 text-center">And</div></div>';
        ++countsunday;
        if (Sun % 2 === 0 && Sun !== 1) {
            txt = txt + '<div class="col-sm-12 sunday' + Sun + '">&nbsp;</div>';
        }
        $('#sundayDiv').append(txt);
    }
    function removeforSundayfun() {
        if (!Sun) {
            if (countsunday > 0) {
                $(".sunday" + countsunday).remove();
                --countsunday;
            }
        } else {
            $(".sunday" + Sun).remove();
            --Sun;
        }

    }

    var SaturdayCount;
    var Sat;
    function addnewforSaturdayfun() {
        SaturdayCount = countSaturday;
        Sat = ++SaturdayCount;
        var txt = '<div  class="Saturday' + Sat + '">' +
                '<div class="col-sm-2 text-center">' +
                ' <select  class="form-control col-sm-2" id="SaturdayFrom' + Sat + '" name="FData[WorkingHours][Saturday][' + Sat + '][From]">' +
                times +
                '</select>' +
                ' </div>' +
                '<div class = "col-sm-1 text-center" > To </div>' +
                '<div class = "col-sm-2 text-center" >' +
                ' <select  class = "form-control col-sm-2" id = "SaturdayTo' + Sat + '" name = "FData[WorkingHours][Saturday][' + Sat + '][To]" >' +
                times +
                '</select>' +
                '</div><div class="col-sm-1 text-center">And</div></div>';
        ++countSaturday;
        if (Sat % 2 === 0 && Sat !== 1) {
            txt = txt + '<div class="col-sm-12 Saturday' + Sat + '">&nbsp;</div>';
        }
        $('#SaturdayDiv').append(txt);
    }
    function removeforSaturdayfun() {
        if (!Sat) {
            if (countSaturday > 0) {
                $(".Saturday" + countSaturday).remove();
                --countSaturday;
            }
        } else {
            $(".Saturday" + Sat).remove();
            --Sat;
        }


    }

    var FridayCount;
    var F;
    function addnewforFridayfun() {
        FridayCount = countFriday;
        F = ++FridayCount;
        var txt = '<div  class="Friday' + F + '">' +
                '<div class="col-sm-2 text-center">' +
                ' <select  class="form-control col-sm-2" id="FridayFrom' + F + '" name="FData[WorkingHours][Friday][' + F + '][From]">' +
                times +
                '</select>' +
                ' </div>' +
                '<div class = "col-sm-1 text-center" > To </div>' +
                '<div class = "col-sm-2 text-center" >' +
                ' <select  class = "form-control col-sm-2" id = "FridayTo' + F + '" name = "FData[WorkingHours][Friday][' + F + '][To]" >' +
                times +
                '</select>' +
                '</div><div class="col-sm-1 text-center">And</div></div>';
        ++countFriday;
        if (F % 2 === 0 && F !== 1) {
            txt = txt + '<div class="col-sm-12 Friday' + F + '">&nbsp;</div>';
        }
        $('#FridayDiv').append(txt);
    }
    function removeforFridayfun() {
        if (!F) {
            if (countFriday > 0) {
                $(".Friday" + countFriday).remove();
                --countFriday;
            }
        } else {
            $(".Friday" + F).remove();
            --F;
        }

    }

    var ThursdayCount;
    var Th;
    function addnewforThursdayfun() {
        ThursdayCount = countThursday;
        Th = ++ThursdayCount;
        var txt = '<div  class="Thursday' + Th + '">' +
                '<div class="col-sm-2 text-center">' +
                ' <select  class="form-control col-sm-2" id="ThursdayFrom' + Th + '" name="FData[WorkingHours][Thursday][' + Th + '][From]">' +
                times +
                '</select>' +
                ' </div>' +
                '<div class = "col-sm-1 text-center" > To </div>' +
                '<div class = "col-sm-2 text-center" >' +
                ' <select  class = "form-control col-sm-2" id = "ThursdayTo' + Th + '" name = "FData[WorkingHours][Thursday][' + Th + '][To]" >' +
                times +
                '</select>' +
                '</div><div class="col-sm-1 text-center">And</div></div>';
        ++countThursday;
        if (Th % 2 === 0 && Th !== 1) {
            txt = txt + '<div class="col-sm-12 Thursday' + Th + '">&nbsp;</div>';
        }
        $('#ThursdayDiv').append(txt);
    }
    function removeforThursdayfun() {
        if (!Th) {
            if (countThursday > 0) {
                $(".Thursday" + countThursday).remove();
                --countThursday;
            }
        } else {
            $(".Thursday" + Th).remove();
            --Th;
        }

    }

    var WednesdayCount;
    var W;
    function addnewforWednesdayfun() {
        WednesdayCount = countWednesday;
        W = ++WednesdayCount;
        var txt = '<div  class="Wednesday' + W + '">' +
                '<div class="col-sm-2 text-center">' +
                ' <select  class="form-control col-sm-2" id="WednesdayFrom' + W + '" name="FData[WorkingHours][Wednesday][' + W + '][From]">' +
                times +
                '</select>' +
                ' </div>' +
                '<div class = "col-sm-1 text-center" > To </div>' +
                '<div class = "col-sm-2 text-center" >' +
                ' <select  class = "form-control col-sm-2" id = "WednesdayTo' + W + '" name = "FData[WorkingHours][Wednesday][' + W + '][To]" >' +
                times +
                '</select>' +
                '</div><div class="col-sm-1 text-center">And</div></div>';
        ++countWednesday;
        if (W % 2 === 0 && W !== 1) {
            txt = txt + '<div class="col-sm-12 Wednesday' + W + '">&nbsp;</div>';
        }
        $('#WednesdayDiv').append(txt);
    }
    function removeforWednesdayfun() {
        if (!W) {
            if (countWednesday > 0) {
                $(".Wednesday" + countWednesday).remove();
                --countWednesday;
            }
        } else {
            $(".Wednesday" + W).remove();
            --W;
        }

    }

    var TuesdayCount;
    var T;
    function addnewforTuesdayfun() {
        TuesdayCount = countTuesday;
        T = ++TuesdayCount;
        var txt = '<div  class="Tuesday' + T + '">' +
                '<div class="col-sm-2 text-center">' +
                ' <select  class="form-control col-sm-2" id="TuesdayFrom' + T + '" name="FData[WorkingHours][Tuesday][' + T + '][From]">' +
                times +
                '</select>' +
                ' </div>' +
                '<div class = "col-sm-1 text-center" > To </div>' +
                '<div class = "col-sm-2 text-center" >' +
                ' <select  class = "form-control col-sm-2" id = "TuesdayTo' + T + '" name = "FData[WorkingHours][Tuesday][' + T + '][To]" >' +
                times +
                '</select>' +
                '</div><div class="col-sm-1 text-center">And</div></div>';
        ++countTuesday;
        if (T % 2 === 0 && T !== 1) {
            txt = txt + '<div class="col-sm-12 Tuesday' + T + '">&nbsp;</div>';
        }
        $('#TuesdayDiv').append(txt);
    }
    function removeforTuesdayfun() {
        if (!T) {
            if (countTuesday > 0) {
                $(".Tuesday" + countTuesday).remove();
                --countTuesday;
            }
        } else {
            $(".Tuesday" + T).remove();
            --T;
        }

    }

    var MondayCount;
    var M;
    function addnewforMondayfun() {
        MondayCount = countMonday;
        M = ++MondayCount;

//        console.log(M);
        var txt = '<div  class="Monday' + M + '">' +
                '<div class="col-sm-2 text-center">' +
                ' <select  class="form-control col-sm-2" id="MondayFrom' + M + '" name="FData[WorkingHours][Monday][' + M + '][From]">' +
                times +
                '</select>' +
                ' </div>' +
                '<div class = "col-sm-1 text-center" > To </div>' +
                '<div class = "col-sm-2 text-center" >' +
                ' <select  class = "form-control col-sm-2" id = "MondayTo' + M + '" name = "FData[WorkingHours][Monday][' + M + '][To]" >' +
                times +
                '</select>' +
                '</div><div class="col-sm-1 text-center">And</div></div>';

        ++countMonday;
        if (M % 2 === 0 && M !== 1) {
            txt = txt + '<div class="col-sm-12 Monday' + M + ' ">&nbsp;</div>';
        }
        $('#MondayDiv').append(txt);
    }

    function removeforMondayfun() {
        if (!M) {
            if (countMonday > 0) {
                $(".Monday" + countMonday).remove();
                --countMonday;
            }
        } else {
            $(".Monday" + M).remove();
            --M;
        }

//        console.log('remove' + countMonday);
    }
    // Working hours function end 
    $("#MyProfile").addClass("active");
    $(document).ready(function () {

        $("#uploadNewLogo").click(function () {
            $("#logoImageUpload").click();
        });

        $("#uploadNewBanner").click(function () {
            $("#bannerImageUpload").click();
        });

// Upload logo
        $("#logoImageUpload").change(function () {

            var iSize = ($("#logoImageUpload")[0].files[0].size / 1024);

            if (iSize / 1024 > 1)
            {
                alert('Your file is too large');
                return;
                // $("#file_driver_photo").html("your file is too large");
            } else
            {
                iSize = (Math.round(iSize * 100) / 100)
                // $("#file_driver_photo").html(iSize + "kb");
            }

            var formElement = $(this).prop('files')[0];
            var form_data = new FormData();
            form_data.append('OtherPhoto', formElement);
            form_data.append('type', 'logo');
            form_data.append('folder', 'franchiseLogo');
            // console.log(form_data);
            // Upload image ajax function
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Profile/uploadImagesToAws",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                mimeType: "multipart/form-data",
                //                async: false,
                cache: false,
                contentType: false,
                processData: false,
            })
                    .done(function (json) {
//                        console.log(json);
                        if (json.msg === "1") {
                            var fileName = '<?php echo AMAZON_S3_LINK ?>' + json.fileName;
                            $("#uploadNewLogo").val(fileName);
                            $("#logoImage").val(fileName);
                            $("#logoImageUploadStatus").text('Logo uploaded successfully');

                        } else {
                            $("#passwordUpdateMesssage").text('Unable to update password');
                            $(".passwordUpdateError").removeClass('hide');
                            $("#logoImageUploadStatus").text('Unable to upload image. Please try again');
                        }
                    });
        });

// Upload banner
        $("#bannerImageUpload").change(function () {
            var iSize = ($("#bannerImageUpload")[0].files[0].size / 1024);

            if (iSize / 1024 > 1)
            {
                alert('Your file is too large');
                return;
                // $("#file_driver_photo").html("your file is too large");
            } else
            {
                iSize = (Math.round(iSize * 100) / 100)
                // $("#file_driver_photo").html(iSize + "kb");
            }

            var formElement = $(this).prop('files')[0];
            var form_data = new FormData();
            form_data.append('OtherPhoto', formElement);
            form_data.append('type', 'banner');
            form_data.append('folder', 'franchiseBanner');
            // console.log(form_data);
            // Upload image ajax function
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Profile/uploadImagesToAws",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                mimeType: "multipart/form-data",
                //                async: false,
                cache: false,
                contentType: false,
                processData: false,
            })
                    .done(function (json) {
//                        console.log(json);
                        if (json.msg === "1") {
                            var fileName = '<?php echo AMAZON_S3_LINK ?>' + json.fileName;
                            $("#uploadNewBanner").val(fileName);
                            $("#bannerImage").val(fileName);
                            $("#bannerImageUploadStatus").text('Banner uploaded successfully');

                        } else {
                            $("#bannerImageUploadStatus").text('Unable to upload banner image. Please try again');
                        }
                    });
        });



<?php if ($ProfileData['pricing_status'] == 2 && $ProfileData['Driver_exist'] == 1) { ?>
            $('.basefare').show();
<?php } else { ?>
            $('.basefare').hide();
<?php } ?>

        $('.MyProfile').addClass('active');
        $('.profile_thumb').attr('src', "<?php echo base_url(); ?>assets/restaurant_on.png");

        $('#callM').click(function () {
            $('#NewCat').modal('show');
        });

        $.ajax({
            url: "<?php echo base_url(); ?>index.php?/Profile/getSubcatList",
            type: 'POST',
            data: {val: $('#CategoryList').val()},
            datatype: 'json', // fix: need to append your data to the call
            success: function (response) {
                $('#subcatLists').empty();
//                console.log(response);
                var r = JSON.parse(response);
                var html = '';
                var listData='';
                var langData = <?php echo json_encode($language); ?>;
                html = '<option value="">Select Sub Category</option>'
                $.each(r, function (index, row) {
                    listData= (row.storeSubCategoryName.en);
                    $.each(langData,function(i,lngrow){
                        lngcode= lngrow.langCode;
                        var lngvalue = row.storeSubCategoryName.lngcode;
                        lngvalue = (lngvalue==''|| lngvalue==null )?"":lngvalue;
                        if(lngvalue.length > 0)
                       listData +=","+lngvalue; 
                      // console.log(listData);
                    });
                    html += '<option data-name="' + row.name + '"value="' + row._id.$oid + '">' + listData + '</option>';
                });
                $('#subcatLists').append(html);
                $("#subcatLists").val('<?php echo $ProfileData['subCategoryId']; ?>');
            }
           
        });

        $('#CategoryList').on('change', function () {

            var val = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Profile/getSubcatList",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#subcatLists').empty();
                    var r = JSON.parse(response);
                    var html = '';
                    var listData='';
                    var langData = <?php echo json_encode($language); ?>;
                    html = '<option value="">Select Sub Category</option>'
//                     $.each(r, function (index, row) {
// //                        console.log(row);
//                         html += '<option data-name="' + row.name + '"value="' + row._id.$oid + '">' + row.name + '</option>';
//                     });
                    $.each(r, function (index, row) {
                    listData= (row.storeSubCategoryName.en);
                    $.each(langData,function(i,lngrow){
                        lngcode= lngrow.langCode;
                        var lngvalue = row.storeSubCategoryName.lngcode;
                        lngvalue = (lngvalue==''|| lngvalue==null )?"":lngvalue;
                        if(lngvalue.length > 0)
                        listData +=","+lngvalue; 
                      // console.log(listData);
                    });
                    html += '<option data-name="' + row.name + '"value="' + row._id.$oid + '">' + listData + '</option>';
                });
                    $('#subcatLists').append(html);
                }
            });


        });


        if ($('#SelectedCity').val() != '') {
            var enable = '<?PHP echo $enable; ?>';
    
            $('#city').load('<?php echo base_url() ?>index.php?/Profile/get_city', {country: $('#CountryList').val(), CityId: $('#SelectedCity').val(), enable: enable});
        }

        $('#CountryList').change(function () {
            var val = $(this).val();
            if (val != '0') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php?/Profile/getCityList",
                    type: 'POST',
                    data: {val: val},
                    datatype: 'json', // fix: need to append your data to the call
                    success: function (response) {
                        /* set country value to hidden field*/
                        $("#SelectedCountryId").val(val);
                        $('#city').empty();
                        var r = JSON.parse(response);
                        var html = '';
                        html = '<option value="">Select City</option>'
                        $.each(r, function (index, row) {
//                        console.log(row);
                            html += '<option currencySymbol="' + row.currencySymbol + '" baseFare="' + row.baseFare + '" mileagePrice="' + row.mileagePrice + '" mileageAfter="' + row.mileagePriceAfterMinutes + '" timeFee="' + row.timeFee + '" timeFeeAfter="' + row.timeFeeAfterMinutes + '" waitingFee="' + row.waitingFee + '" waitingFeeAfter="' + row.waitingFeeAfterMinutes + '" minimumFare="' + row.minimumFare + '" onDemandCanFee="' + row.onDemandBookingsCancellationFee + '" onDemandCanFeeAfter="' + row.onDemandBookingsCancellationFeeAfterMinutes + '" scheduledCanFee="' + row.scheduledBookingsCancellationFee + '"   scheduledCanFeeAfter="' + row.scheduledBookingsCancellationFeeAfterMinutes + '" convenienceFee="' + row.convenienceFee + '"  data-name="' + row.cityName + '"value="' + row.cityId.$oid + '">' + row.cityName + '</option>';
                        });
                        $('#city').html(html);
                    }
                });
                $('#countryname').val($('#CountryList option:selected').text());
            }

        });

//         $.ajax({
//            url: "<?php echo base_url(); ?>index.php?/Profile/getCityList",
//            type: 'POST',
//            data: {val: $('#CountryList').val()},
//            datatype: 'json', // fix: need to append your data to the call
//            success: function (response) {
////                     console.log(response);
//                $('#city').empty();
//                var r = JSON.parse(response);
//                var html = '';
//                html = '<option value="">Select City</option>'
//                $.each(r, function (index, row) {
//                    if ('<?php echo $storedata['cityId'] ?>' == row.cityId.$oid) {
//                        html += '<option currencySymbol="' + row.currencySymbol + '" baseFare="' + row.baseFare + '" mileagePrice="' + row.mileagePrice + '" mileageAfter="' + row.mileagePriceAfterMinutes + '" timeFee="' + row.timeFee + '" timeFeeAfter="' + row.timeFeeAfterMinutes + '" waitingFee="' + row.waitingFee + '" waitingFeeAfter="' + row.waitingFeeAfterMinutes + '" minimumFare="' + row.minimumFare + '" onDemandCanFee="' + row.onDemandBookingsCancellationFee + '" onDemandCanFeeAfter="' + row.onDemandBookingsCancellationFeeAfterMinutes + '" scheduledCanFee="' + row.scheduledBookingsCancellationFee + '"   scheduledCanFeeAfter="' + row.scheduledBookingsCancellationFeeAfterMinutes + '" convenienceFee="' + row.convenienceFee + '"  data-name="' + row.cityName + '" data-name="' + row.cityName + '"value="' + row.cityId.$oid + '" selected>' + row.cityName + '</option>';
//                        $('.currencySymbol').text(row.currencySymbol);
//                        $('#currencySymbol').val(row.currencySymbol);
//                    } else {
//                        html += '<option currencySymbol="' + row.currencySymbol + '" baseFare="' + row.baseFare + '" mileagePrice="' + row.mileagePrice + '" mileageAfter="' + row.mileagePriceAfterMinutes + '" timeFee="' + row.timeFee + '" timeFeeAfter="' + row.timeFeeAfterMinutes + '" waitingFee="' + row.waitingFee + '" waitingFeeAfter="' + row.waitingFeeAfterMinutes + '" minimumFare="' + row.minimumFare + '" onDemandCanFee="' + row.onDemandBookingsCancellationFee + '" onDemandCanFeeAfter="' + row.onDemandBookingsCancellationFeeAfterMinutes + '" scheduledCanFee="' + row.scheduledBookingsCancellationFee + '"   scheduledCanFeeAfter="' + row.scheduledBookingsCancellationFeeAfterMinutes + '" convenienceFee="' + row.convenienceFee + '"  data-name="' + row.cityName + '" data-name="' + row.cityName + '"value="' + row.cityId.$oid + '" >' + row.cityName + '</option>';
//                    }
//                });
//                $('#city').html(html);
//            }
//        });

        /*$('#city').change(function () {
//            $('#serviceZones').load('<?php echo base_url() ?>index.php?/Business/getZones', {val: $('#city').val()});
            $('#cityname').val($('#city option:selected').text());
            $('#currencySymbol').text($('#city option:selected').attr('currencySymbol'));

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Profile/getZones",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: $('#city').val()
                },
            }).done(function (json) {
//                console.log(json);
                $("#serviceZones").multiselect('destroy');

                if (json.data.length > 0) {
                    for (var i = 0; i < json.data.length; i++) {
                        var serviceZone = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                        $("#serviceZones").append(serviceZone);
                        select.append(serviceZone);
                    }
                    $('#serviceZones').multiselect({
                        includeSelectAllOption: true,
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        buttonWidth: '500px',
                        maxHeight: 300,
                    });
                } else {
                }

            });
        }); */

        $('#BusinessCat').on('change', function () {
            var catID = $(this).val();
            $('#subCatList').load("<?php echo base_url('index.php?/Admin') ?>/getsubcat", {catID: catID});
        });

       /* $.ajax({
            url: "<?php //echo base_url(); ?>index.php?/Profile/getZones",
            type: 'POST',
            dataType: 'json',
            data: {
                val: '<?php //echo $ProfileData['cityId'] ?>'
            },
        }).done(function (json) {
            arr = [];
            $("#serviceZones").multiselect('destroy');

            if (json.data.length > 0) {
                var serviceZone = '';

                var selectedZones = [];

                <?php //foreach ($ProfileData['serviceZones'] as $servicezone) { ?>
                                    selectedZones.push('<?php //echo $servicezone; ?>');
                <?php //} ?>

                for (var i = 0; i < json.data.length; i++) {
                    var selected = '';

                    if (selectedZones.indexOf(json.data[i].id) !== -1) {
                        selected = 'selected';
                    }
                    serviceZone = "<option value=" + json.data[i].id + " " + selected + ">" + json.data[i].title + "</option>";
                    $("#serviceZones").append(serviceZone);
                    arr.push(json.data[i].id);

                }

                $('#serviceZones').multiselect('destroy').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth: '500px',
                    maxHeight: 300,
                });
            }
        }); */

    });

    function submitform()
    {
        var orderEmail = $("#OrderEmails").val();
        if(orderEmail == ''){
            $("#OrderEmails").css("border-color","red"); 
            $("#OrderEmails").focus();
            return;
        }
        var BusinessCat = $("#BusinessCat").val();
        $("#addentity").submit();
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
        $("#finishbutton").addClass("hidden");
        $("#prevbutton").addClass("hidden");
        $("#nextbutton").removeClass("hidden");
        $("#tb1").attr('data-toggle', 'tab');
        $("#tb1").attr('href', '#tab1');
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
//        console.log('profiletab-start');
        var pstatus = true;
        var reason = '';
        $(".text_err").text("");

        var businessname = new Array();
        $(".businessname").each(function () {
            businessname.push($(this).val());
        });
        if ($("#name_0").val() == '' || $("#name_0").val() == null) {
            pstatus = false;
            $("#err_name").text("Franchise name is Missing");
            $("#name_0").focus();
        } else if ($("#entityOwnername").val() == '') {
            pstatus = false;
            $("#err_entityOwnername").text("Owner name is Missing");
            $("#entityOwnername").focus();
        } else if ($("#entityemail").val() == '' || $("#entityemail").val() == null) {
            pstatus = false;
            $("#err_entityemail").text("Email is Missing");
            $("#entityemail").focus();
        } 
        else if ($("#OrderEmails").val() == '' || $("#OrderEmails").val() == null) {
            pstatus = false;
            $("#err_orderEmail").text("Order email is Missing");
            $("#OrderEmails").focus();
        } 
        
       
        else if ($("#entityAddress_0").val() == '' || $("#entityAddress_0").val() == null) {
            pstatus = false;
            $("#err_entityAddress_0").text("Address is Missing");
            $("#entityAddress_0").focus();
        } else if ($("#CategoryList").val() == '' || $("#CategoryList").val() == null) {
            pstatus = false;
            $("#text_CategoryList").text("Category is Missing");
            $("#CategoryList").focus();
        } else if ($("#CountryList").val() == '0') {
            pstatus = false;
            $("#err_CountryList").text("Country is Missing");
            $("#CountryList").focus();
        } else if ($("#city").val() == '0' || $("#city").val() == '' || $("#city").val() == null) {
            pstatus = false;
            $("#err_city").text("City is Missing");
            $("#city").focus();
        } else if (($("#entiryLongitude").val() == '' || $("#entiryLongitude").val() == null) && ($("#entiryLatitude").val() == null || $("#entiryLatitude").val() == '')) {
            pstatus = false;
            $("#err_entiryLatitude").text("logitude and latitude are Missing");
            $("#entiryLongitude").focus();
        }
         /*else if ($("#serviceZones").val() == '' || $("#serviceZones").val() == null) {
            pstatus = false;
            $("#serviceZonesErr").text("serviceZones are Missing");
         } */
        if (pstatus === false)
        {
           console.log('pstatus-false');
            $("#mtab2").removeAttr('data-toggle', 'tab');
            $("#mtab2").removeAttr('href', '#tab2');
            $("#mtab3").removeAttr('data-toggle', 'tab');
            $("#mtab3").removeAttr('href', '#tab3');
            $("#mtab4").removeAttr('data-toggle', 'tab');
            $("#mtab4").removeAttr('href', '#tab4');

            setTimeout(function ()
            {
                proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
            }, 300);
            if (reason != '') {
                alert(reason);
            }
            $("#tab1icon").removeClass("fs-14 fa fa-check");
            return false;
        } else {

           console.log('else');
            $("#mtab2").attr('data-toggle', 'tab');
            $("#mtab2").attr('href', '#tab2');
            $("#mtab3").attr('data-toggle', 'tab');
            $("#mtab3").attr('href', '#tab3');
            $("#mtab4").attr('data-toggle', 'tab');
            $("#mtab4").attr('href', '#tab4');
           
            $("#prevbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");
            return true;
        }
        // $("#prevbutton").removeClass("hidden");
        // $("#nextbutton").removeClass("hidden");
        // $("#finishbutton").addClass("hidden");
        // return true;
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
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");

            return astatus;
        }
    }


    function addresstab1(litabtoremove, divtabtoremove)
    {
        var astatus = true;
        //alert(profiletab());
        if (profiletab(litabtoremove, divtabtoremove))
        {


            if (astatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'fourthlitab', 'tab4');

                }, 100);

                alert("Mandatory Fields Missing")
                $("#tab2icon").removeClass("fs-14 fa fa-check");
                return false;
            }
            $("#tab2icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");
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

    function proceed(litabtoremove, divtabtoremove, litabtoadd, divtabtoadd)
    {
//        console.log(litabtoremove);
//        console.log(litabtoadd);
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
//        console.log(currenttabstatus);
        if (currenttabstatus === "firstlitab")
        {
            var entityname = new Array();
            $(".businessname").each(function () {
                entityname.push($(this).val());
            });
            var entityemail = $("#entityemail").val();
            var entityOwner = $("#entityOwnername").val();
            var CountryList = $("#CountryList").val();
            var city = $("#city").val();
           // var serviceZones = $("#serviceZones").val();
            var entiryLatitude = $("#entiryLatitude").val();
            var entiryLongitude = $("#entiryLongitude").val();
           var protab= profiletab('secondlitab', 'tab2');

            if(protab){
                 /// for finish button
            $("#finishbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");
            $("#prevbutton").removeClass("hidden");
           }
           else{
            $("#prevbutton").addClass("hidden");
            $("#finishbutton").addClass("hidden");
            $("#nextbutton").removeClass("hidden");
           }

            if (entityname && entityemail && entityOwner && entiryLatitude && entiryLongitude) {
                proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
            }
        } 
        
        // else if (currenttabstatus === "secondlitab")
        // {
        //     proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');
        //     $("#finishbutton").removeClass("hidden");
        //     $("#nextbutton").addClass("hidden");
        // }
    }

    function movetoprevious()
    {
        var currenttabstatus = $("li.active").attr('id');
        if ($("#secondlitab").attr('class') === "active")
        {
            profiletab('secondlitab', 'tab2');
            proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
           $("#prevbutton").addClass("hidden");
          
            $("#finishbutton").addClass("hidden");
            $("#nextbutton").removeClass("hidden");
        }
        // else if ($("#thirdlitab").attr('class') === "active")
        // {
        //     addresstab('thirdlitab', 'tab3');
        //     proceed('thirdlitab', 'tab3', 'secondlitab', 'tab2');
        //     $("#nextbutton").removeClass("hidden");
        //     $("#finishbutton").addClass("hidden");
        // } else if ($("#fourthlitab").attr('class') === "active")
        // {
        //     bonafidetab('fourthlitab', 'tab4');
        //     proceed('fourthlitab', 'tab4', 'secondlitab', 'tab2');
        //     $("#nextbutton").removeClass("hidden");
        //     $("#finishbutton").addClass("hidden");
        // }
    }

</script>
<script type="text/javascript">
    $(document).ready(function () {

        var mondayArray = new Array();
        var tuesdayArray = new Array();
        var wednesdayArray = new Array();
        var thursdayArray = new Array();
        var fridayArray = new Array();
        var saturdayArray = new Array();
        var sundayArray = new Array();
<?php
//    $no_of_slots= 24 / $slot_timedata['tslot'];
foreach ($ProfileData['workingHours']['monday'] as $key => $value) {
    ?>
            mondayArray.push('<?php echo $key; ?>');

    <?php
}

foreach ($ProfileData['workingHours']['tuesday'] as $key => $value) {
    ?>
            tuesdayArray.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['wednesday'] as $key => $value) {
    ?>
            wednesdayArray.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['thursday'] as $key => $value) {
    ?>
            thursdayArray.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['friday'] as $key => $value) {
    ?>
            fridayArray.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['saturday'] as $key => $value) {
    ?>
            saturdayArray.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['sunday'] as $key => $value) {
    ?>
            sundayArray.push('<?php echo $key; ?>');

    <?php
}
?>
        var daysArr = {1: mondayArray, 2: tuesdayArray, 3: wednesdayArray, 4: thursdayArray, 5: fridayArray, 6: saturdayArray, 7: sundayArray};

        $('.setSlot').click(function ()
        {
            $('.slotchecked').prop('checked', false);
            $('.selectDay').val($(this).attr('data-id'));
            $('.textChangeDay').text($(this).attr('id'));



            $("#mondaymodal").modal('show');
<?php
for ($i = 1; $i <= $no_of_slots; $i++) {
    ?>

                if ($.inArray('<?php echo $i; ?>', daysArr[$(this).attr('data-id')]) !== -1)
                {
    //                    console.log(daysArr[$(this).attr('data-id')]);
                    $('#id' + '<?php echo $i; ?>').prop('checked', true);
                }
    <?php
}
?>
        });

        var mondayArray1 = new Array();
        var tuesdayArray1 = new Array();
        var wednesdayArray1 = new Array();
        var thursdayArray1 = new Array();
        var fridayArray1 = new Array();
        var saturdayArray1 = new Array();
        var sundayArray1 = new Array();
<?php
//    $no_of_slots= 24 / $slot_timedata['tslot'];

foreach ($ProfileData['workingHours']['monday'] as $key => $value) {
    ?>
            mondayArray1.push('<?php echo $key; ?>');

    <?php
}

foreach ($ProfileData['workingHours']['monday'] as $key => $value) {
    ?>
            tuesdayArray1.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['wednesday'] as $key => $value) {
    ?>
            wednesdayArray1.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['thursday'] as $key => $value) {
    ?>
            thursdayArray1.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['friday'] as $key => $value) {
    ?>
            fridayArray1.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['saturday'] as $key => $value) {
    ?>
            saturdayArray1.push('<?php echo $key; ?>');

    <?php
}
foreach ($ProfileData['workingHours']['sunday'] as $key => $value) {
    ?>
            sundayArray1.push('<?php echo $key; ?>');

    <?php
}
?>
        var daysArr1 = {1: mondayArray1, 2: tuesdayArray1, 3: wednesdayArray1, 4: thursdayArray1, 5: fridayArray1, 6: saturdayArray1, 7: sundayArray1};

        $('.setSlot1').click(function ()
        {
            $('.slotchecked1').prop('checked', false);
            $('.selectDay1').val($(this).attr('data-id'));
            $('.textChangeDay1').text($(this).attr('id'));



            $("#storeModal").modal('show');
<?php
for ($i = 1; $i <= $no_of_slots; $i++) {
    ?>

                if ($.inArray('<?php echo $i; ?>', daysArr1[$(this).attr('data-id')]) !== -1)
                {
    //                    console.log(daysArr1[$(this).attr('data-id')]);
                    $('#sid' + '<?php echo $i; ?>').prop('checked', true);
                }
    <?php
}
?>
        });
    });

</script>

<script>

$(document).ready(function(){

           $("#addentity").validate({
            rules: {
        
                "FData[phone]": {
                    required: true,
                    number: true,
                    validNumber: true
                },
                       
              }
        
        });

       var telInput = $("#phone");
        $.validator.addMethod("validNumber", function (value, element) {
            if (telInput.intlTelInput("isValidNumber")) {
                return true;
            } else {
                return false;
            }
        }, "Please enter valid number");



      

});

   

</script>



<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <!-- <ul class="breadcrumb" style="">
                    <li style="width: 300px"><a href="#" class="active"><?php echo $this->lang->line('FRANCHISE_PROFILE'); ?></a>
                    </li>
                </ul> -->
                <div class="brand inline" style="  width: auto;">
                        <?php echo $this->lang->line('FRANCHISE_PROFILE'); ?>
                    </div>
                <!-- END BREADCRUMB -->
            </div>
            <!-- Nav tabs -->

            <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                <li class="active" id="firstlitab" onclick="managebuttonstate()">
                    <a id="tb1"><i id="tab1icon" class=""></i> <span><?php echo $this->lang->line('Details'); ?></span></a>
                </li>
                <li class="" id="secondlitab">
                    <a onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span><?php echo $this->lang->line('Social_Settings'); ?></span></a>
                </li>

                <!-- <li class="" id="thirdlitab">
                    <a onclick="addresstab('thirdlitab', 'tab3')" id="mtab3"><i id="tab3icon" class=""></i> <span>Working Hours </span></a>
                </li> -->
            </ul>

            <!-- End Nav tabs -->  

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Tab panes -->
                    <form id="BannerImage" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                        <input id="uploadBanner" type="file" name="myMainfile"  style="visibility: hidden;"/>

                    </form>
                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php?/Profile/UpdateProfile" method="post" enctype="multipart/form-data">
                        <input type='hidden' name='BusinessId' value='<?PHP echo $BizId; ?>'> 

                        <!--Start of Tab-->
                        <div class="tab-content">

                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">

                                    <!-- Logo -->
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('LOGO'); ?> <em>*</em></label>
                                        <div class="col-sm-2">
                                            <button  type="button" class="form-control btn btn-sm btn-primary" style="border-radius: 20px;"  name="action" value="" id="uploadNewLogo" <?php echo $disabledmode; ?> ><?php echo $this->lang->line('Upload_new_logo'); ?></button>
                                            <input type="file" class="hide" id="logoImageUpload" name="image" required="required" class="form-control" val="">
                                            <input type="hidden"  id="logoImage" name="FData[profileLogos][logoImage]" value="<?php echo $ProfileData['profileLogos']['logoImage']; ?>" required="required" class="form-control" >
                                            <input type="hidden"  id="" name="FData[profileLogos][seoAllText]" value="<?php echo $ProfileData['profileLogos']['seoAllText']; ?>" class="form-control" >
                                            <input type="hidden"  id="" name="FData[profileLogos][seoTitle]" value="<?php echo $ProfileData['profileLogos']['seoTitle']; ?>" class="form-control" >
                                            <input type="hidden"  id="" name="FData[profileLogos][seoDescription]" value="<?php echo $ProfileData['profileLogos']['seoDescription']; ?>" class="form-control" >
                                            <input type="hidden"  id="" name="FData[profileLogos][seoKeyword]" value="<?php echo $ProfileData['profileLogos']['seoKeyword']; ?>" class="form-control" >
                                        </div>
                                        <?php
                                        if ($ProfileData['profileLogos']['logoImage']):
                                            ?>
                                            <div class="col-sm-2">
                                                <a target="_blank" href="<?php echo $ProfileData['profileLogos']['logoImage']; ?>"class="form-control btn btn-sm btn-primary" style="border-radius: 20px;"  name="action" ><?php echo $this->lang->line('View_current_logo'); ?></a>
                                            </div>
                                        <?php endif ?>
                                        <div class="col-sm-3" style=" font-size: 15px; margin-top: 5px; "><span id="logoImageUploadStatus"></span></div>
                                        <!-- <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="logoError" style=""></div> -->

                                    </div>
                                    <!-- Banner Image -->
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('BANNNER_IMAGE'); ?> <em>*</em></label>
                                        <div class="col-sm-2">
                                            <button  type="button" class="form-control btn btn-sm btn-primary" style="border-radius: 20px;"  name="action" value="" id="uploadNewBanner" <?php echo $disabledmode; ?> ><?php echo $this->lang->line('Upload_new_banner'); ?></button>
                                            <input type="file" id="bannerImageUpload" class="hide" name="image" required="required" class="form-control" val="">
                                            <input type="hidden" id="bannerImage"  name="FData[bannerLogos][bannerimage]" value="<?php echo $ProfileData['bannerLogos']['bannerimage']; ?>" required="required" class="form-control">
                                            <input type="hidden"  id="" name="FData[bannerLogos][seoAllText]" value="<?php echo $ProfileData['bannerLogos']['seoAllText']; ?>" class="form-control" >
                                            <input type="hidden"  id="" name="FData[bannerLogos][seoTitle]" value="<?php echo $ProfileData['bannerLogos']['seoTitle']; ?>" class="form-control" >
                                            <input type="hidden"  id="" name="FData[bannerLogos][seoDescription]" value="<?php echo $ProfileData['bannerLogos']['seoDescription']; ?>" class="form-control" >
                                            <input type="hidden"  id="" name="FData[bannerLogos][seoKeyword]" value="<?php echo $ProfileData['bannerLogos']['seoKeyword']; ?>" class="form-control" >
                                        </div>
                                        <?php
                                        if ($ProfileData['bannerLogos']['bannerimage']):
                                            ?>
                                            <div class="col-sm-2">
                                                <a target="_blank" href="<?php echo $ProfileData['bannerLogos']['bannerimage']; ?>" class="form-control btn btn-sm btn-primary" style="border-radius: 20px;"  name="action" ><?php echo $this->lang->line('View_current_banner'); ?></a>
                                            </div>
                                        <?php endif ?>
                                        <div class="col-sm-3" style=" font-size: 15px; margin-top: 5px; "><span id="bannerImageUploadStatus"></span></div>

                                    </div>

                                    <div id="bussiness_txt">
                                        <div class="form-group lan_append formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('FRANCHISE_NAME'); ?><span style="color:red;font-size: 18px">*</span></label>
                                            <div class="col-sm-6">  
                                                <input type="text" <?PHP echo $enable; ?> id="name_0" name="FData[franchiseName][0]"  value="<?PHP echo $ProfileData['name']['en']; ?>" class=" businessname errr1 form-control error-box-class" <?php  echo $readonlymode; ?> >
                                            </div>
                                            <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err_name" style=""></div>
                                        </div>

                                        <?php
                                        foreach ($language as $val) {
                                            if ($val['Active'] == 1) {
                                                ?>
                                                <div class="form-group lan_append formex" >
                                                    <label for="fname" class=" col-sm-3 control-label">FRANCHISE NAME (<?php echo $val['lan_name']; ?>)</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" <?PHP echo $enable; ?> id="name_<?= $val['lan_id'] ?>" value="<?PHP echo $ProfileData['name'][$val['langCode']]; ?>" name="FData[franchiseName][<?= $val['lan_id'] ?>]"  class="errr2 businessname form-control error-box-class" <?php  echo $readonlymode; ?> >
                                                    </div>

                                                </div>

                                            <?php } else { ?>
                                                <div class="form-group lan_append formex" >
                                                    <label for="fname" class=" col-sm-3 control-label">FRANCHISE NAME (<?php echo $val['lan_name']; ?>)</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" <?PHP echo $enable; ?> id="name_<?= $val['lan_id'] ?>" value="<?PHP echo $ProfileData['name'][$val['langCode']]; ?>" name="FData[franchiseName][<?= $val['lan_id'] ?>]"  class="errr2 businessname form-control error-box-class" <?php  echo $readonlymode; ?>>
                                                    </div>

                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('OWNER_NAME'); ?> <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="errr6 form-control error-box-class"  id="entityOwnername" value='<?PHP echo $ProfileData['ownerName']; ?>' placeholder="Owner Name" name="FData[ownerName]" <?PHP echo $enable; ?>  aria-required="true" <?php  echo $readonlymode; ?>>
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err_entityOwnername" style=""></div>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $coutry_code = $ProfileData['countryCode'];
                                        $mobile = $ProfileData["phone"];
                                        ?>
                                        <script>
                                            $(document).ready(function () {

                                                $("#phone").intlTelInput("setNumber", "<?php echo $coutry_code . ' ' . $mobile ?>");
                                            });
                                        </script>
                                        <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('OWNER_PHONE'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="tel"  id="phone" name="FData[phone]"  class="form-control error-box-class phoneWidth" onkeypress="return isNumberKey(event)" style="width: 250px" <?php  echo $readonlymode; ?>>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('OWNER_EMAIL'); ?> <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="errr5 form-control error-box-class" id="entityemail" value='<?PHP echo $ProfileData['email']; ?>' placeholder="Email" name="FData[email]" <?PHP echo $enable; ?>  aria-required="true" style="color: black;" <?php  echo $readonlymode; ?> >
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err_entityemail" style=""></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Send_Order_Email_To'); ?> <span style="color: red; font-size: 15px">*</span> </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control error-box-class" id="OrderEmails" value='<?PHP echo $ProfileData['OrderEmail']; ?>' placeholder="Order Email" name="FData[OrderEmail]"  aria-required="true">
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err_orderEmail" style=""></div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('WEB_SITE'); ?> </label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control error-box-class" id="entitywebsite" value='<?PHP echo $ProfileData['website']; ?>' placeholder="Web-Site" name="FData[website]"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>

                                    </div>
                                    <input type="hidden" id="countryCode" name="FData[countryCode]" value="<?php echo $ProfileData['countryCode']; ?>">

                                    <div id="bussiness_txt">
                                        <div class="form-group lan_append formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('DESCRIPTION'); ?></label>
                                            <div class="col-sm-6">  
                                                <textarea rows="2" cols="50"  class="errr7 form-control" id="entitydesc" placeholder="Description" name="FData[franchiseDescription][0]"  aria-required="true" ><?PHP echo $ProfileData['description']['en']; ?></textarea>
                                            </div>

                                        </div>

                                        <?php
                                        foreach ($language as $val) {
                                            if ($val['Active'] == 1) {
                                                ?>
                                                <div class="form-group lan_append formex" >
                                                    <label for="fname"  class=" col-sm-3 control-label">DESCRIPTION (<?php echo $val['lan_name']; ?>)</label>
                                                    <div class="col-sm-6">
                                                        <textarea rows="2" cols="50"  class="errr8 form-control" id="entitydesc" placeholder="Description" name="FData[franchiseDescription][<?= $val['lan_id'] ?>]"  aria-required="true"><?PHP echo $ProfileData['description'][$val['langCode']]; ?></textarea>
                                                    </div>

                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group lan_append formex" >
                                                    <label for="fname"  class=" col-sm-3 control-label">DESCRIPTION (<?php echo $val['lan_name']; ?>)</label>
                                                    <div class="col-sm-6">
                                                        <textarea rows="2" cols="50"  class="errr8 form-control" id="entitydesc" placeholder="Description" name="FData[franchiseDescription][<?= $val['lan_id'] ?>]"  aria-required="true"><?PHP echo $ProfileData['description'][$val['langCode']]; ?></textarea>
                                                    </div>

                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>

                                    <div id="Address_txt" >
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('ADDRESS'); ?> <span style="color:red;font-size: 18px">*</span></label>
                                            <div class="col-sm-6">
                                                <textarea class="errr9 form-control entityAddress error-box-class" id="entityAddress_0" placeholder="Address" name="FData[franchiseAddress]"  aria-required="true"  <?php  echo $readonlymode; ?> ><?php echo $ProfileData['franchiseAddress']; ?></textarea>
                                            </div>
                                            <div class="col-md-1">
                                                <div id='map_lat_long'></div>

                                                <button  type="button" id="mapbtn1" class="form-control btn btn-danger btn-sm" style="border-radius: 20px;"  name="action" onclick="callMap()" value="add" data-id="1" <?php echo $disabledmode; ?> >Map</button>
                                                <div id="latlong_error"></div>
                                            </div>
                                            <div class="col-sm-offset-3 col-sm-7 error-box text_err" id="err_entityAddress_0" style=""></div>

                                        </div>

                                    </div>
                                    <div id="BAddress_txt" >
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('BILLING_ADDRESS'); ?></label>
                                            <div class="col-sm-6">
                                                <textarea class="errr9 form-control " id="entityBillingAddress_0" placeholder="Address" name="FData[billingAddress]"  aria-required="true"  ><?php echo $ProfileData['billingAddress']; ?></textarea>
                                            </div>
                                            <div class="col-md-1">
                                                <div id='map_lat_long'></div>

                                                <button  type="button" id="mapbtn2" class="form-control btn btn-danger btn-sm" style="border-radius: 20px;"  name="action" onclick="callMapB()" value="add" data-id="0" ><?php echo $this->lang->line('Map'); ?></button>
                                                <div id="latlong_error"></div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('CATEGORY'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <select id="CategoryList" name='Category' class='form-control error-box-class'  <?PHP echo $enable; ?> <?php echo $disabledmode; ?> >
                                                <option value="">select Category</option>
                                                <?php
                                                if(count($language) < 1){
                                                    foreach ($category as $result) {
                                                        $selected = '';
                                                    if ($ProfileData['categoryId'] == $result['_id']['$oid']) {
                                                        $selected = 'selected';
                                                    }

                                                        echo "<option value=" . $result['_id']['$oid'] . "  data-name='" . $result['storeCategoryName']['en'] . "' $selected>" . $result['storeCategoryName']['en'] . "</option>";
                                                    }
                                                }
                                                else{
                                                    
                                                    foreach ($category as $result) {
                                                        $catData=$result['storeCategoryName']['en'];
                                                        foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                           $lngvalue= ($result['storeCategoryName'][$lngcode]=='') ? "":$result['storeCategoryName'][$lngcode];
                                                           if(strlen($lngvalue)) 
                                                            $catData .= ','.$lngvalue;
                                                        }
                                                        $selected = '';
                                                        if ($ProfileData['categoryId'] == $result['_id']['$oid']) {
                                                            $selected = 'selected';
                                                        }
                                                        
                                                            echo "<option value=" . $result['_id']['$oid'] . "  data-name='" . implode($result['storeCategoryName'], ',') . "'  $selected>" . $catData . "</option>";
                                                       

                                                        
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_CategoryList" style="color:red"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('SUB_CATEGORY'); ?></label>
                                        <div class="col-sm-6">
                                            <div id='SubCatList'>
                                                <select id='subcatLists' class="form-control error-box-class" name='subCategory' <?PHP echo $enable; ?> <?php echo $disabledmode; ?> >
                                                    <option value=''>Select Sub category</option>
                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('COUNTRY'); ?> <em>*</em></label>
                                        <div class="col-sm-6">
                                            <select  id='CountryList' name='' class='errr11 form-control'  <?PHP echo $enable; ?> <?php echo $disabledmode; ?> >
                                                <option value='0'>Select Country</option>
                                                <?php
                                                foreach ($CountryList as $Country) {

                                                    if ((string) $Country['_id']['$oid'] == $ProfileData['countryId']) {
                                                        echo "<option data-name = " . $Country['country'] . " value='" . $Country['_id']['$oid'] . "' data-id='" . $Country['_id']['$oid'] . "' selected>" . $Country['country'] . "</option>";
                                                    
                                                    } else {
                                                        echo "<option data-name = " . $Country['country'] . " value='" . $Country['_id']['$oid'] . "' data-id='" . $Country['_id']['$oid'] . "'>" . $Country['country'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err_CountryList" style=""></div>                                       
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('CITY'); ?> <em>*</em></label>
                                        <div class="col-sm-6">
                                            <div id='' >
                                                <select  id='city' class="errr12 form-control" name='FData[cityId]' <?PHP echo $enable; ?> <?php echo $disabledmode; ?>  >
                                                    <option value='0'>Select City</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err_city" style=""></div>
                                        <input type='hidden' id='SelectedCountryId' name='FData[countryId]' value='<?php echo $ProfileData['countryId']; ?>'>
                                        <input type='hidden' id='SelectedCity' value='<?PHP echo $ProfileData['cityId']; ?>'>
                                        <input type='hidden' name='FData[cityName]' id='cityname' value="<?php echo $ProfileData['cityName']; ?>">
                                        <input type='hidden' name='FData[countryName]' id='countryname' value="<?php echo $ProfileData['countryName']; ?>">
                                        <input type='hidden' name='FData[currencySymbol]' id='currencySymbol' value="<?php echo $ProfileData['currencySymbol']; ?>">

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('LONGITUDE'); ?> <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input  type="text" readonly class="errr14 form-control" id="entiryLongitude" value='<?PHP echo $ProfileData['coordinates']['longitude']; ?>' placeholder="0.00" name="FData[coordinates][longitude]"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err_entiryLongitude" style=""></div>                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('LATITUDE'); ?> <em>*</em></label>
                                        <div class="col-sm-6">
                                            <input  type="text" readonly class="errr15 form-control" id="entiryLatitude" value='<?PHP echo $ProfileData['coordinates']['latitude']; ?>' placeholder="0.00" name="FData[coordinates][latitude]"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err_entiryLatitude" style=""></div>
                                    </div>

                                    <!-- <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">SERVICE ZONES <em>*</em></label>
                                        <div class="col-sm-6">
                                            <select  id='serviceZones' name='FData[serviceZones][]' class='serviceZones errr11 form-control' multiple="multiple" <?PHP //echo $enable; ?>>
                                            </select>
                                        </div> 
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="serviceZonesErr" style=""></div>                                       
                                    </div> -->

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label error-box-class"><?php echo $this->lang->line('AUTO_APPROVAL'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="switch">
                                                <input id="Autoapproval" name="FData[autoApproval]" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;" <?php  echo $readonlymode; ?>>
                                                <label for="Autoapproval"></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- End of Tab1 -->



                            <!---Start of Tab2-->
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label" style="font-size: 20px;   color: black;"><?php echo $this->lang->line('SOCIAL_MEDIA_LINKS'); ?></label>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Google'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['socialLinks']['Google']; ?>' placeholder="Google+ Link" name="FData[socialLinks][Google]"  aria-required="true">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Facebook'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['socialLinks']['Facebook']; ?>' placeholder="Facebook Link" name="FData[socialLinks][Facebook]"  aria-required="true">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Twitter'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['socialLinks']['Twitter']; ?>' placeholder="Twitter Link" name="FData[socialLinks][Twitter]"  aria-required="true">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Instagram'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['socialLinks']['Instagram']; ?>' placeholder="Instagram" name="FData[socialLinks][Instagram]"  aria-required="true">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('LinkedIn'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['socialLinks']['LinkedIn']; ?>' placeholder="Instagram" name="FData[socialLinks][LinkedIn]"  aria-required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End of Tab2 -->

                            <!--Start of Tab3 -->
                            <!-- <div class="tab-pane slide-left padding-20" id="tab3" style="border: 2px"> -->

                            <div class="tab-pane slide-left padding-20" id="tab3" style="border: 2px">
                                <div class="row row-same-height">

                                    <!-- <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Send Order Email To <span style="color: red; font-size: 15px">*</span> </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="OrderEmails" value='<?PHP echo $ProfileData['OrderEmail']; ?>' placeholder="Order Email" name="FData[OrderEmail]"  aria-required="true">
                                        </div>
                                        < ! - - <div class="col-sm-1">
                                            <span style="color: red; font-size: 20px">*</span>
                                        </div> - - >
                                    </div> -->
                                    <!-- working hour button -->
                                    
                                </div>
                            </div>
                            <!--End of Tab3-->



                            <!--Start of Tab4 -->
                            <div class="tab-pane slide-left padding-20" id="tab4" style="border: 2px">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label" style="font-size: 20px;   color: black;">WORKING HOURS</label>

                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="err20" style=""></div>

                                    </div>

                                    <div class="row" >  


                                        <div class="col-md-12 inner">

                                            <div class="col-md-2" >
                                                <div class="row dayheading">
                                                    <div class="col-md-2"><h3 align="center">DAY</h3></div>
                                                </div>
                                                <div class="row" > 
                                                    <div class="col-md-12">                    
                                                        <label for="fname" class="col-sm-1 control-label"><h5>MONDAY<span style="color:red;font-size: 18px"></span></h5></label>

                                                    </div>
                                                </div>


                                                <div class="row" > 
                                                    <div class="col-md-12">                    
                                                        <label for="fname" class="col-sm-1 control-label"><h5>TUESDAY<span style="color:red;font-size: 18px"></span></h5></label>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">                    
                                                        <label for="fname" class="col-sm-1 control-label"><h5>WEDNESDAY<span style="color:red;font-size: 18px"></span></h5></label>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">                    
                                                        <label for="fname" class="col-sm-1 control-label"><h5>THURSDAY<span style="color:red;font-size: 18px"></span></h5></label>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">                    
                                                        <label for="fname" class="col-sm-1 control-label"><h5>FRIDAY<span style="color:red;font-size: 18px"></span></h5></label>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">                    
                                                        <label for="fname" class="col-sm-1 control-label"><h5>SATURDAY<span style="color:red;font-size: 18px"></span></h5></label>

                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">                    
                                                        <label for="fname" class="col-sm-1 control-label"><h5>SUNDAY<span style="color:red;font-size: 18px"></span></h5></label>

                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-md-7" > 
                                                <div class="row dayheading">
                                                    <div class="col-md-6 "><h3>Slots Selected</h3></div>
                                                </div>

                                                <div class="row" > 
                                                    <div class="col-md-12">
                                                        <?php
                                                        foreach ($ProfileData['workingHours']['Monday'] as $key => $value) {

                                                            echo '<button type="button" class="btn btn-prime">' . $value['from'] . ' to ' . $value['to'] . ' </button>';
                                                        }
                                                        ?>
                                                    </div> 
                                                </div>

                                                <div class="row"> 
                                                    <div class="col-md-12">
                                                        <?php
                                                        foreach ($ProfileData['workingHours']['Tuesday'] as $key => $value) {

                                                            echo '<button type="button" class="btn btn-prime">' . $value['from'] . ' to ' . $value['to'] . ' </button>';
                                                        }
                                                        ?>
                                                    </div> 
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php
                                                        foreach ($ProfileData['workingHours']['Wednesday'] as $key => $value) {

                                                            echo '<button type="button" class="btn btn-prime">' . $value['from'] . ' to ' . $value['to'] . ' </button>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php
                                                        foreach ($ProfileData['workingHours']['Thursday'] as $key => $value) {

                                                            echo '<button type="button" class="btn btn-prime">' . $value['from'] . ' to ' . $value['to'] . ' </button>';
                                                        }
                                                        ?>
                                                    </div> 
                                                </div> 

                                                <div class="row">    
                                                    <div class="col-md-12">
                                                        <?php
                                                        foreach ($ProfileData['workingHours']['Friday'] as $key => $value) {

                                                            echo '<button type="button" class="btn btn-prime">' . $value['from'] . ' to ' . $value['to'] . ' </button>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php
                                                        foreach ($ProfileData['workingHours']['Saturday'] as $key => $value) {

                                                            echo '<button type="button" class="btn btn-prime">' . $value['from'] . ' to ' . $value['to'] . ' </button>';
                                                        }
                                                        ?>
                                                    </div> 
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php
                                                        foreach ($ProfileData['workingHours']['Sunday'] as $key => $value) {

                                                            echo '<button type="button" class="btn btn-prime">' . $value['from'] . ' to ' . $value['to'] . ' </button>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">

                                                <div class="row dayheading">
                                                    <div class="col-md-12"><h3>SET SLOT</h3></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary btn-cons btn-animated from-left setSlot1"  id="Monday" data-id='1'>SET SLOT</button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary btn-cons btn-animated from-left setSlot1" id="Tuesday" data-id='2'>SET SLOT</button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary btn-cons btn-animated from-left setSlot1" id="Wednesday" data-id='3'>SET SLOT</button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary btn-cons btn-animated from-left setSlot1" id="Thursday" data-id='4'>SET SLOT</button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary btn-cons btn-animated from-left setSlot1" id="Friday" data-id='5'>SET SLOT</button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary btn-cons btn-animated from-left setSlot1" id="Saturday" data-id='6'>SET SLOT</button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-primary btn-cons btn-animated from-left setSlot1" id="Sunday" data-id='7'>SET SLOT</button>
                                                    </div>
                                                </div>


                                            </div>



                                        </div>
                                    </div> 

                                </div>
                            </div>
                            <!--End of Tab4-->


                        </div>
                    </form>
                </div>





                <script>




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
//                        console.log(img);

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

                <input type='hidden' class='Masterimageurl' name='FData[imageUrl]' value="<?PHP echo $ProfileData['imageUrl']; ?>">
                <input type='hidden' class='Bnnerimageurl' name='FData[bannerImageUrl]' value="<?PHP echo $ProfileData['bannerImageUrl']; ?>">






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






            <!-- END PANEL -->



            <!-- Modal for grocer drivers  -->
            <div class="modal fade" id="mondaymodal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Set slots for <span class="textChangeDay"></span></h4>
                            <input class="selectDay" style="display:none">
                        </div>
                        <div class="modal-body">

                            <?php
                            $i = 1;
                            $id = 10;
                            $id1 = 20;
                            $from = 00;

                            $start = $tslotdata['start_time'];

                            $end = $tslotdata['end_time'];

                            $slot = $tslotdata['delivery_slot'];

                            $timeslots = $slot * 3600;

                            $from = $start;



                            $diff = (int) (($end - $start) / $slot);

                            for ($i = 1; $i <= $diff; $i++) {


                                $to = date("H:i", strtotime($from) + $timeslots);


                                if ($to <= $end) {
                                    echo '<div class="form-group ">    
                <div class="col-sm-12 tableTime">
                <div class="col-sm-2 text-center zeroPadding"><br/><strong>Slot-' . $i . '</strong></div>
                  <div class="col-sm-4 text-center zeroPadding">
                  <select  class="Monday1 form-control" id="fromSlot' . $i . '" name="fromSlot" >';

                                    echo '<option value="' . $from . '">' . $from . ' Hours</option>';


                                    echo '</select>
                </div>
                <div class="col-sm-1 text-center zeroPadding" style="margin-top: 10px">To</div>
                 <div class="col-sm-4 text-center zeroPadding">
                 <select  class="Monday2 form-control col-sm-2" id="toSlot' . $i . '" name="toSlot"  >';

                                    echo '<option value="' . $to . '">' . $to . ' Hours</option>';

                                    echo ' </select>  
                           
                </div>
                  <div class="col-sm-1 text-center zeroPadding">
                     <input type="checkbox" class="slotchecked" name="setSlots[]" value=' . $i . ' id="id' . $i . '"style="margin-top: 10px">
                   </div>
                 </div>                     
        </div>
        <br/><br/>';
                                }

                                $from = $to;
                                $id++;
                                $id1++;
                            }
                            ?>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-success" id="update" >Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            <!-- Modal for store drivers  -->
            <div class="modal fade" id="storeModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Set slots for <span class="textChangeDay1"></span></h4>
                            <input class="selectDay1" style="display:none">
                        </div>
                        <div class="modal-body">

                            <?php
                            $i = 1;
                            $id = 10;
                            $id1 = 20;
                            $from = 00;

                            $start = $ProfileData['store_time_config']['start_time'];

                            $end = $ProfileData['store_time_config']['end_time'];

                            $slot1 = $ProfileData['store_time_config']['tslot'];

                            $timeslots = $slot1 * 3600;

                            $from = $start;



                            $diff = (int) (($end - $start) / $slot1);

                            for ($i = 1; $i <= $diff; $i++) {


                                $to = date("H:i", strtotime($from) + $timeslots);


                                if ($to <= $end) {
                                    echo '<div class="form-group ">    
                <div class="col-sm-12 tableTime">
                <div class="col-sm-2 text-center zeroPadding"><br/><strong>Slot-' . $i . '</strong></div>
                  <div class="col-sm-4 text-center zeroPadding">
                  <select  class="Monday1 form-control" id="store_fromSlot' . $i . '" name="store_fromSlot" >';

                                    echo '<option value="' . $from . '">' . $from . ' Hours</option>';


                                    echo '</select>
                </div>
                <div class="col-sm-1 text-center zeroPadding" style="margin-top: 10px">To</div>
                 <div class="col-sm-4 text-center zeroPadding">
                 <select  class="Monday2 form-control col-sm-2" id="store_toSlot' . $i . '" name="store_toSlot"  >';

                                    echo '<option value="' . $to . '">' . $to . ' Hours</option>';

                                    echo ' </select>  
                           
                </div>
                  <div class="col-sm-1 text-center zeroPadding">
                     <input type="checkbox" class="slotchecked1" name="setSlots1[]" value=' . $i . ' id="sid' . $i . '"style="margin-top: 10px">
                   </div>
                 </div>                     
        </div>
        <br/><br/>';
                                }

                                $from = $to;
                                $id++;
                                $id1++;
                            }
                            ?>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-success" id="update1" >Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- END JUMBOTRON -->
    </div>
    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg"></div>
    <!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->

<div class="modal fade in" id="ForMaps" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog">
    <input type="hidden" id="mapBtnDataId" value="">
        <form action = "" method= "post" onsubmit="return validateForm();">
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
                            <textarea rows="4" cols="50" class="form-control" id="mapentityAddress" placeholder="Address.." name="FData[businessAddress][0]"><?PHP echo $ProfileData['Address'][0]; ?></textarea>

                        </div> 

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

    </div>

</div>

<!-- working hour modal -->
<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >ADD SCHEDULE</span>
            </div>
            <div class="modal-body">
                <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">


                    <!--                    <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-4 control-label"><?php echo "Radius"; ?><span style="color:red;font-size: 12px"> *</span></label>
                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <input type="text"  id="radius" name="radius"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)">
                                            </div>
                                            <div class="col-sm-3 error-box errors" id="rediusErr">
                                            </div>
                                        </div>-->
                    <!--                    <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-4 control-label"><?php echo "Price"; ?><span style="color:red;font-size: 12px"> *</span></label>
                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <input type="text"  id="price" name="price"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)">
                                            </div>
                                            <div class="col-sm-3 error-box errors" id="priceErr">
                                            </div>
                                        </div>-->
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label">Repeat Schedule<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select onchange="checkDays(this)" id="repeatDay" name="repeatDay"  class="form-control error-box-class">
                                <option value=0>Select Schedule</option>
                                <option value=1>Every-Day</option>
                                <option value=2>Weak-Day</option>
                                <option value=3>Week-End</option>
                                <option value=4>Select Days</option>
                            </select>
                        </div>
                        <div class="col-sm-3 error-box errors" id="RepeatScheduleError">
                        </div>
                    </div>


                    <div class="form-group" class="formex" id='bTypeBlock' style="display: none">
                        <label for="fname" class="col-sm-4 control-label ">Days<span style="color:red;font-size: 12px"></span></label>
                        <div class="col-md-6 col-sm-5 col-xs-12">
                            <label><input type="checkbox" class="messageCheckbox" id="Mon"  value="Mon" name="schedule[]"> Mon</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Tue"  value="Tue" name="schedule[]"> Tue</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Wed"  value="Wed" name="schedule[]"> Wed</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Thu"  value="Thu" name="schedule[]"> Thu</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Fri"  value="Fri" name="schedule[]"> Fri</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Sat"  value="Sat" name="schedule[]"> Sat</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Sun"  value="Sun" name="schedule[]"> Sun</label>  &nbsp;
                        </div>
                        <div class="col-sm-3 error-box errors" id="DaysErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label">Duration<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select onchange="checkDuration(this)" id="duration" name="duration"  class="form-control error-box-class">
                                <option value=0>Select Duration</option>
                                <option value=1>This Month</option>
                                <option value=2>2 Months</option>
                                <option value=3>3 Months</option>
                                <option value=4>4 Months</option>
                                <option value=5>Custom</option>
                            </select>
                        </div>
                        <div class="col-sm-3 error-box errors" id="durationErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex" id='startDateBlock' style="display: none">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Start Date"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control datepicker-component" name="startt" id="startt" placeholder="From Date">
                        </div>
                        <div class="col-sm-3 error-box errors" id="startDateErr">
                        </div>
                    </div>
                    <div class="form-group" class="formex" id='endDateBlock' style="display: none">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "End Date"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control datepicker-component" name="endd" id="endd" placeholder="To Date">
                        </div>
                        <div class="col-sm-3 error-box errors" id="endDateErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Start Time"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                            <!--<input type="text"  id="stimeHour" name="stimeHour"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)"><span  class="abs_text" id="sym1">Hour<span>-->
<!--                            <select id="stimeHour" name="stimeHour"  class="form-control error-box-class">
                            <?php
//                                for ($i = 1; $i < 25; $i++) {
//                                    if ($i < 10)
//                                        echo "<option value=0" . $i . ">0" . $i . "</option>";
//                                    else
//                                        echo "<option value=" . $i . ">" . $i . "</option>";
//                            }
                            ?>
                            </select><span  class='abs_text' id='sym1'>Hour<span>-->


                            <input type="text" name="timepicker" class="form-control timepicker" id="starttime"/>


                        </div>

                        <!--                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <input type="text"  id="stimeMinute" name="stimeMinute"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)"><span  class="abs_text" id="sym1">Minute<span>
                                                    <select id="stimeMinute" name="stimeMinute"  class="form-control error-box-class">
                        <?php
                        for ($i = 1; $i < 61; $i++) {
                            if ($i < 10)
                                echo "<option value=0" . $i . ">0" . $i . "</option>";
                            else
                                echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>
                                                    </select><span  class='abs_text' id='sym1'>Minute<span>
                                                            </div>-->
                        <div class="col-sm-3 error-box errors" id="startTimeErr">
                        </div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "End Time"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12  bootstrap-timepicker" >

<!--<select id="etimeHour" name="etimeHour"  class="form-control error-box-class">-->
                            <?php
//                                                for ($i = 1; $i < 25; $i++) {
//                                                    if ($i < 10)
//                                                        echo "<option value=0" . $i . ">0" . $i . "</option>";
//                                                    else
//                                                        echo "<option value=" . $i . ">" . $i . "</option>";
//                                                }
                            ?>

<!--</select><span  class='abs_text' id='sym1'>Hour<span>-->
                            <input type="text" name="timepicker" class="form-control timepicker" id="endtime"/>
                        </div>

                        <!--                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                                                <input type="text"  id="etimeMinute" name="etimeMinute"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)"><span  class="abs_text" id="sym1">Minute<span>
                                                                                <select id="etimeMinute" name="etimeMinute"  class="form-control error-box-class">
                        <?php
                        for ($i = 1; $i < 61; $i++) {
                            if ($i < 10)
                                echo "<option value=0" . $i . ">0" . $i . "</option>";
                            else
                                echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>
                                                                                </select>
                                                                                <span  class='abs_text' id='sym1'>Minute<span>
                                                                                        </div>-->


                        <div class="col-sm-3 error-box errors" id="startTimeErr">
                        </div>
                    </div>




                </form>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box errors responseErr"></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="insert_cat_group" ><?php echo "Add"; ?></button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- working hour modal end -->

<script src="<?php echo ServiceLink; ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?php echo ServiceLink; ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>

<script>
                        var countryData = $.fn.intlTelInput.getCountryData();
                        $.each(countryData, function (i, country) {

                            country.name = country.name.replace(/.+\((.+)\)/, "$1");
                        });
                        $("#businessNumber").intlTelInput({
                            //       allowDropdown: false,
                            autoHideDialCode: false,
                            autoPlaceholder: "off",
                            dropdownContainer: "body",
                            //       excludeCountries: ["us"],
                            formatOnDisplay: false,
                            geoIpLookup: function (callback) {
                                $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                                    var bCountryCode = (resp && resp.country) ? resp.country : "";
                                    callback(bCountryCode);
                                });
                            },
                            initialCountry: "auto",
                            nationalMode: false,
                            //       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                            placeholderNumberType: "MOBILE",
                            //       preferredCountries: ['srilanka'],
                            separateDialCode: true,
                            utilsScript: "<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/utils.js",

                        });
                        $("#phone").intlTelInput({
                            //       allowDropdown: false,
                            autoHideDialCode: false,
                            autoPlaceholder: "off",
                            dropdownContainer: "body",
                            //       excludeCountries: ["us"],
                            formatOnDisplay: false,
                            geoIpLookup: function (callback) {
                                $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                                    var countryCode = (resp && resp.country) ? resp.country : "";
                                    callback(countryCode);
                                });
                            },
                            initialCountry: "auto",
                            nationalMode: false,
                            //       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                            placeholderNumberType: "MOBILE",
                            //       preferredCountries: ['srilanka'],
                            separateDialCode: true,
                            utilsScript: "<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/utils.js",

                        });




</script>
<!-- <script  src="http://104.131.66.74/Grocer/sadmin/application/views/sweetalert/dist/sweetalert.min.js"></script> -->