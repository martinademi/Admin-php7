
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    form#addentity h5 {
        padding-left: 10px;
        font-weight: 600;
    }
     .pac-container {
        background-color: #FFF;
        z-index: 2000;
        position: fixed;
        display: inline-block;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBm-C5-fDUpvqMaT_8wfAZXXI56hVcFk4g"></script>

<script>
    
     function callMap() {
//        alert();
//       
        $('#ForMaps').modal('show');


        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
            initialize1($('#entiryLatitude').val(), $('#entiryLongitude').val());
            $('#mapentityAddress').val($('#entityAddress_0').val());
        } else {
            initialize1(20.268455824834792, 85.84099235520011);
        }
    }
      function Cancel() {
        $('#ForMaps').modal('hide');
     
    }

    function Take() {
//        alert();
        $('#entiryLongitude').val($('#longitude').val());
        $('#entiryLatitude').val($('#latitude').val());
        $('.entityAddress').val($('#mapentityAddress').val());
//        $('#entityAddress').val($('#entityAddress').val());

//        $('#entityAddress2').val($('#address2').val());

        $('#ForMaps').modal('hide');
      
    }
    
     function initialize1(lat, long, from) {

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
//                        $('#latitude').val(marker.getPosition().lat());
//                        $('#longitude').val(marker.getPosition().lng());
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

        var addr = text.value;
//        alert(addr)
//        alert(text.value);
        $.ajax({
            url: "https://tebse.com/Tebse/Business/application/views/superadmin/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                 console.log(Arr.Lat);
                $('#entiryLatitude').val(Arr.Lat);
                $('#entiryLongitude').val(Arr.Long);

//                initialize1(Arr.Lat, Arr.Long, '1');
            }
        });
    }
    function getAddLatLong(text) {

        var addr = text.value;
//        alert(addr)
//        alert(text.value);
        $.ajax({
            url: "https://tebse.com/Tebse/Business/application/views/superadmin/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                 console.log(Arr.Lat);
                $('#latitude').val(Arr.Lat);
                $('#longitude').val(Arr.Long);

//                initialize1(Arr.Lat, Arr.Long, '1');
            }
        });
    }
   

</script>

<script type="text/javascript">
    function initialize() {
        var id = '';
//        $('.entityAddress').each(function(){
//                alert($(this).attr("id"));
//                  id = $(this).attr("id");
                  
//                  console.log(input);
           
//        var input = document.getElementById('entityAddress');
//        var input = document.getElementById(id);
        var input = document.getElementById('entityAddress_0');
        
        var options = {componentRestrictions: {country: 'us'}};

        var autocomplete = new google.maps.places.Autocomplete(input);
      
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            //alert('i am here');
            var place = autocomplete.getPlace();
//            document.getElementById('city2').value = place.name;
            document.getElementById('entiryLatitude').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude').value = place.geometry.location.lng();
//            console.log(place.geometry);
            initialize(place.geometry.location.lat(), place.geometry.location.lng(), '0');
            $('#longitude').val(place.geometry.location.lng());
            $('#latitude').val(place.geometry.location.lat());



        });
//    });
        var input1 = document.getElementById('mapentityAddress');
          var autocomplete1 = new google.maps.places.Autocomplete(input1);
        google.maps.event.addListener(autocomplete1, 'place_changed', function () {
            var place = autocomplete1.getPlace();
//            document.getElementById('city2').value = place.name;
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
            
//            initialize(place.geometry.location.lat(), place.geometry.location.lng(), '0');
//            $('#longitude').val(place.geometry.location.lng());
//            $('#latitude').val(place.geometry.location.lat());
            //alert("This function is working!");
            //alert(place.name);
            // alert(place.address_components[0].long_name);

        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!--<script>
    var map;
    var marker;
    var myLatlng = new google.maps.LatLng(20.268455824834792, 85.84099235520011);

    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();

    function getAddLatLong1(text) {

        var addr = text.value;
//        alert(addr)
//        alert(text.value);
        $.ajax({
            url: "https://tebse.com/Tebse/Business/application/views/superadmin/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                 console.log(Arr.Lat);
                $('#entiryLatitude').val(Arr.Lat);
                $('#entiryLongitude').val(Arr.Long);

//                initialize(Arr.Lat, Arr.Long, '1');
            }
        });
    }
   

    function initialize() {
//       $('.entityAddress').each(function(){
        var id = '';
       
       $('.entityAddress').each(function(){
//                alert($(this).attr("id"));
                  id = $(this).attr("id");
                  
//                  console.log(input);
           
//        var input = document.getElementById('entityAddress');
        var input = document.getElementById(id);
//        console.log(input);
        var options = {componentRestrictions: {country: 'us'}};

         var autocomplete = new google.maps.places.Autocomplete(input);
       
//        console.log(autocomplete);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
//            console.log(place);
//            document.getElementById('city2').value = place.name;
            document.getElementById('entiryLatitude').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude').value = place.geometry.location.lng();
           
            initialize(place.geometry.location.lat(), place.geometry.location.lng(), '0');
//            $('#entiryLatitude').val(place.geometry.location.lat());
//            $('#entiryLongitude').val(place.geometry.location.lng());
            
            //alert("This function is working!");
            //alert(place.name);
            // alert(place.address_components[0].long_name);

           });
           });
          
         

    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>-->
<script>
    $(document).ready(function () {
        
          $('.Pickup').show();  
        $('.Delivery').show(); 
        $('.basefare').hide();
        
        $('#CountryList').change(function () {

            $('#CityList').load('http://104.236.207.219/Business/index.php/superadmin/get_cities', {country: $('#CountryList').val()});
            $('#countryname').val($('#CountryList option:selected').text());
//            alert($('#CountryList option:selected').text());
        });
        $('#cityLists').change(function () {
//            alert();
//            alert($('#cityLists option:selected').text());
            $('#cityname').val($('#cityLists option:selected').text());
        });

        if ($('#SelectedCity').val() != '') {
//            alert($('#SelectedCity').val());
            var enable = '<?PHP echo $enable; ?>';
//            alert(enable);
            $('#CityList').load('http://104.236.207.219/Business/index.php/superadmin/get_cities', {country: $('#CountryList').val(), CityId: $('#SelectedCity').val(), enable: enable});
        }

//        $("#subCatId").multiselect({
//                              columns: 1,
//                              placeholder: 'Select Sub-cuisines'
//                               });

        $('#CatId').on('change', function () {

            var catID = $(this).val();
            $('#subcat').load("<?php echo base_url('index.php/superadmin') ?>/getsubcat", {catID: catID});


        });


        $('#insert').click(function () {

            var status = '<?php echo $status; ?>';
            var Master = '<?php echo $BizId; ?>';
            $('.clearerror').text("");
            var BusinessName = new Array();
            
//            varBusinessName BusinessName = $(".businessname").val();
                $(".businessname").each(function (){
                    BusinessName.push($(this).val());
                });
                
            var Description = new Array();
            
//            varBusinessName BusinessName = $(".businessname").val();
                $(".description").each(function (){
                    Description.push($(this).val());
                });
                
                var Address = new Array();

    //            varBusinessName BusinessName = $(".businessname").val();
                    $(".entityAddress").each(function (){
                        Address.push($(this).val());
                    });
//             BusinessName = BusinessName.push(.val())
                    
            var OwnerName = $("#ownername").val();
            var Phone = $("#phone").val();
            var Email = $("#email").val();
            var Password = $("#password").val();
            var Website = $("#website").val();
//            var Description = $(".description").val();
//            var Address = $(".entityAddress").val();
            var Country = $("#CountryList").val();
            var city = $("#cityLists").val();
            var Postalcode = $("#entitypostalcode").val();
            var Longitude = $("#entiryLongitude").val();
            var Latitude = $("#entiryLatitude").val();
            var BizId = $("#BizId").val();
            var CatId = $("#CatId").val();
            var subCatId = $("#subCatId").val();
            var pricing = $("#pricing").val();
            var drivers = $("#drivers").val();
            var tier1 = parseInt($("#tier1").val());
            var tier2 = parseInt($("#tier2").val());
            var tier3 = parseInt($("#tier3").val());
            var notes = $("#notes").val();
             var avgcooktime = $("#avgcooktime").val();
            var Budget = $("#budget").val();
            
//            console.log(tier1);
//            console.log(tier2);
//            console.log(tier3);
            
            //            var CatId = $("#CatId").val();
//            var pricing= $('input[type="radio"]:checked').val();
            var minorderVal = $('#entiryminorderVal').val();
            var freedelVal = $('#freedelVal').val();
//            console.log(BusinessName);
//            var cash = $("#cash").val();
            var Pcash = $('#Pcash:checked').map(function () {
                return this.value;
            }).get();
            var Pcredit_card = $('#Pcredit_card:checked').map(function () {
                return this.value;
            }).get();
            var Psadad = $('#PSADAD:checked').map(function () {
                return this.value;
            }).get();

            var Dcash = $('#Dcash:checked').map(function () {
                return this.value;
            }).get();
            var Dcredit_card = $('#Dcredit_card:checked').map(function () {
                return this.value;
            }).get();
            var Dsadad = $('#DSADAD:checked').map(function () {
                return this.value;
            }).get();

            var passwordstrong = /^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/;
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

            if (BusinessName == "" )
            {
                $("#clearerror").text("Please enter the store name");
            } else if (OwnerName == "" || OwnerName == null)
            {
                $("#clearerror").text("Please enter the owner name");
            } else if (Phone == "" || Phone == null)
            {
                $("#clearerror").text("Please enter the phone number");
            } else if (Email == "" || Email == null)
            {
                $("#clearerror").text("Please enter your email id");
            } else if (!emails.test(Email))
            {
                $("#clearerror").text( "Please enter valid email id" );
            } else if (Password == "" || Password == null)
            {
                $("#clearerror").text( "Please enter the password " );
            } else if (!passwordstrong.test(Password))
            {
                $("#clearerror").text("Password  length must be 6 characters and at least one number followed by character only");
            } else if (Website == "" || Website == null)
            {
                $("#clearerror").text( "Please select the website");
            } else if (Description == "" || Description == null)
            {
                $("#clearerror").text("Please enter the description");
            } else if (Address == "" || Address == null)
            {
                $("#clearerror").text("Please enter the address");
            } else if (Country == "0" || Country == null)
            {
                $("#clearerror").text("Please select the country");
            } else if (city == "0" || city == null)
            {
                $("#clearerror").text("Please select the city");
            } else if (Postalcode == "" || Postalcode == null)
            {
                $("#clearerror").text("Please enter the postalcode");
            } else if (CatId == "0")
            {
                $("#clearerror").text("Please select the category");
            } else if (subCatId == "0")
            {
                $("#clearerror").text("Please select the sub-categories");
            } else if (pricing == "0")
            {
                $("#clearerror").text("Please select the pricing modal");
            } else if (tier1 == "" || tier1 == null)
            {
                $("#clearerror").text("Please enter the tier 1 radius");
            } else if (tier2 == "" || tier2 == null)
            {
                $("#clearerror").text("Please enter the tier 2 radius");
            } else if (tier1 > tier2) 
            {
                $("#clearerror").text("tier 2 radius should be greater than tier 1 radius");
            } else if (tier3 == "" || tier3 == null)
            {
                $("#clearerror").text("Please enter the tier 3 radius");
            } else if (tier2 > tier3)
            {
                $("#clearerror").text("tier 3 radius should be greater than tier 2 radius");
            }

//            else if (BizId !== '0') {
//                $.ajax({
//                    type: "POST",
////                    url: "http://postmenu.cloudapp.net/iDeliver/Business/index.php/superadmin/CopyBusiness",
//                    url: "<?php echo base_url('index.php/superadmin') ?>/CopyBusiness",
//                    data: { BizId: BizId, 
//                            BusinessName: BusinessName, 
//                            OwnerName: OwnerName, 
//                            Phone:Phone,
//                            Email: Email,
//                            Password: Password, 
//                            Website:Website,
//                            Description:Description,
//                            Address:Address,
//                            Country:Country,
//                            city:city,
//                            Postalcode:Postalcode,
//                            CatId: CatId, 
//                            subCatId:subCatId,
//                            pricing:pricing,
//                            drivers:drivers,
//                            cash:cash,
//                            credit_card:credit_card,
//                            sadad:sadad
//                        },
//                                
//                    dataType: "JSON",
//                    success: function (result) {
//
//                        $('.close').trigger('click');
//                        var size = $('input[name=stickup_toggler]:checked').val()
//                var modalElem = $('#addmodal');
//                if (size == "mini")
//                {
//                    $('#modalStickUpSmall').modal('show')
//                } else
//                {
//                    $('#addmodal').modal('show')
//                    if (size == "default") {
//                        modalElem.children('.modal-dialog').removeClass('modal-lg');
//                    } else if (size == "full") {
//                        modalElem.children('.modal-dialog').addClass('modal-lg');
//                    }
//                }
//                $("#errorboxaddmodal").text(<?php echo json_encode(POPUP_BUSINESS_ADD); ?>);
//                $("#confirmeds1").hide();
//
//                        if (result.flag === 0) {
//                            var table = $('#big_table');
//
//                            var settings = {
//                                "autoWidth": false,
//                                "sDom": "<'table-responsive't><'row'<p i>>",
//                                "destroy": true,
//                                "scrollCollapse": true,
//                                "iDisplayLength": 20,
//                                "bProcessing": true,
//                                "bServerSide": true,
//                                "sAjaxSource": '<?php echo base_url() ?>index.php/superadmin/datatable_businessmgt/3',
//                                "bJQueryUI": true,
//                                "sPaginationType": "full_numbers",
//                                "iDisplayStart ": 20,
//                                "oLanguage": {
////                                    "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
//                                },
//                                "fnInitComplete": function () {
//
//                                    $('#big_table_processing').hide();
//                                },
//                                'fnServerData': function (sSource, aoData, fnCallback)
//                                {
//                                    $.ajax
//                                            ({
//                                                'dataType': 'json',
//                                                'type': 'POST',
//                                                'url': sSource,
//                                                'data': aoData,
//                                                'success': fnCallback
//                                            });
//                                }
//                            };
//
//                            table.dataTable(settings);
//
//                            // search box for table
//                            $('#search-table').keyup(function () {
//                                table.fnFilter($(this).val());
//                            });
//
//                        } else {
//                            alert('Email Already Exist.');
//                        }
//                    },
//                    error: function () {
//                        alert('Error occured');
//                    }
//                });
//            } else               
            else {

                $.ajax({
                    url: "<?php echo base_url() ?>index.php/superadmin/insertbusiness/",
                    type: 'POST',
                    data: {
                        Master:Master,
                        BusinessName: BusinessName,
                        OwnerName: OwnerName,
                        Phone: Phone,
                        Email: Email,
                        Password: Password,
                        Website: Website,
                        Description: Description,
                        Address: Address,
                        Longitude: Longitude,
                        Latitude: Latitude,
                        Country: Country,
                        city: city,
                        Postalcode: Postalcode,
                        CatId: CatId,
                        subCatId: subCatId,
                        pricing: pricing,
                        minorderVal: minorderVal,
                        freedelVal: freedelVal,
                        drivers: drivers,
                        Pcash: Pcash,
                        Pcredit_card: Pcredit_card,
                        Psadad: Psadad,
                        Dcash: Pcash,
                        Dcredit_card: Pcredit_card,
                        Dsadad: Dsadad,
                        tier1: tier1,
                        tier2: tier2,
                        tier3: tier3,
                        notes:notes,
                         avgcooktime:avgcooktime,
                        Budget:Budget
                    },
                    dataType: 'JSON',
                    async: true,
                    success: function (response)
                    {
                        window.location = "<?php echo base_url('index.php/superadmin') ?>/Centers";
//              
                    }

                });
            }

        });

        $('.lan_check').change(function () {
            if ($(this).is(':checked')) {
                var val = this;
                var html = '<div class="form-group formex cat_lan_' + $(val).val() + '"">\
                            <label for="fname" class="col-sm-3 control-label">    <?php echo FIELD_BUSINESSNAME_NAME; ?>  (' + $(val).attr('data-id') + ') <span style="color:red;font-size: 18px">*</span></label>\
                            <div class="col-sm-6">\
                                <input type="text"  id="businessname_' + $(val).val() + '" name="Businessname[' + $(val).val() + ']"  class="form-control error-box-class" >\
                            </div>\
                        </div>';
                $('#bussiness_txt').append(html);
                
                var html = '<div class="form-group formex cat_lan_' + $(val).val() + '"">\
                            <label for="fname" class="col-sm-3 control-label"> DESCRIPTION (' + $(val).attr('data-id') + ')<span style="color:red;font-size: 18px">*</span></label>\
                            <div class="col-sm-6">\
                                <textarea type="text"  id="description_' + $(val).val() + '" name="Descrition[' + $(val).val() + ']"  class="form-control error-box-class" ></textarea>\n\
                            </div>\
                          </div>';
                $('#description_txt').append(html);
                
                var html = '<div class="form-group formex cat_lan_' + $(val).val() + '"">\
                            <label for="fname" class="col-sm-3 control-label">Address (' + $(val).attr('data-id') + ')<span style="color:red;font-size: 18px">*</span></label>\
                            <div class="col-sm-6">\
                                <textarea class="form-control" id="Adress_' + $(val).val() + '" placeholder="Address" name="Address[0]"  aria-required="true" onkeyup="getAddLatLong1(this)"></textarea>\
                            </div>\
                          </div>';
                $('#Address_txt').append(html);
            } else {
                $('.cat_lan_' + $(this).val()).remove();
            }
//            $('#cat_subcat').trigger('change');
        });
    });
    
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
    
     function selectprice(){
//        alert();
          var pricing = $("#pricing").val();
          var drivers = $("#drivers").val();
       
         if (pricing == "2" && drivers == '1')
            {
                if(drivers == '1'){
//                alert();
                $('.basefare').show();
//                $('.range').show();
//                $('.Priceperkm').show();
//                $("#clearerror").text(<?php echo json_encode(POPUP_PASSENGERS_PRICING); ?>);
                } 
            }
            else{
//            alert();
              $('.basefare').hide();
                $('#range').val('');
                $('#Priceperkm').val('');
                $('#basefare').val('');
            }
    }

</script>


<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="">
                    <li><a href="#" class="active">BUSINESS MANAGEMENT</a>
                    </li>

                    <li style="width: 100px"><a href="#" class="active">ADD NEW</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>

            <div class="container-fluid container-fixed-lg bg-white">
                <form id="addentity" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="tab-content">
<!--                        <div class='col-sm-12'>
                            <div class='col-sm-3'>
                                <div class="checkbox check-success disabled">
                                    <input type="checkbox" value="0" id="checkbox0" data-id='English' disabled checked>
                                    <label for="checkbox0">English</label>
                                </div>
                            </div>
                            <?php
//                            foreach ($language as $val) {
//                                $s = '';
//                                if (array_search($val['lan_id'], $elan) != false) {
//                                    $s = 'checked';
//                                }
                                ?>
                                <div class='col-sm-3'>
                                    <div class="checkbox check-success <?= $landis ?>">
                                        <input type="checkbox" class='lan_check' value="<?= $val['lan_id'] ?>" id="checkbox<?= $val['lan_id'] ?>" data-id='<?= $val['lan_name'] ?>' <?= $landis ?> <?= $s ?>>
                                        <label for="checkbox<?= $val['lan_id'] ?>"><?= $val['lan_name'] ?></label>
                                    </div>
                                </div>
                            <?php // } ?>
                        </div>-->
                        <br>
                        <hr>
                        <h5>General Information</h5>
                        <hr>

                        <br>
                        <div id="bussiness_txt">
                            <div class="form-group lan_append formex">
                                <label for="fname" class="col-sm-3 control-label"> Business Name (English) <span style="color:red;font-size: 18px">*</span></label>
                                  <div class="col-sm-6">  
                                <input type="text"   id="businessname_0" name="Businessname[0]"  class=" businessname form-control error-box-class" >
                                  </div>
                             </div>
                            
                                    <?php
                                     foreach ($language as $val) {
//                                         print_r($val);
                                    ?>
                            <div class="form-group lan_append formex" >
                                   <label for="fname" class=" col-sm-3 control-label">  Business Name (<?= $val['lan_name']?>) <span style="color:red;font-size: 18px">*</span></label>
                                   <div class="col-sm-6">
                                     <input type="text"  id="businessname_<?= $val['lan_id'] ?>" name="Businessname<?= $val['lan_id'] ?>"  class=" businessname form-control error-box-class" >
                                   </div>
                            </div>
                                  
                                        <?php } ?>
                            
                               
                            
                        </div>

                        <!--                    <div class="form-group" class="formex">
                                                <div class="frmSearch">
                                                    <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_BUSINESSNAME_NAME; ?><span style="color:red;font-size: 18px">*</span></label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="businessname" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>
                        
                                                        <div id="suggesstion-box"></div>
                                                    </div>
                                                </div>
                                            </div>-->
                        

                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Owner Name<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="ownername" name="Ownername"  class="form-control error-box-class" >
                            </div>
                        </div>
                        

                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Phone Number<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="phone" name="Phone"  class="form-control error-box-class" >
                            </div>
                        </div>

                        

                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Email<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="email" name="Email"  class="form-control error-box-class" >
                            </div>
                        </div>

                        

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">Password<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="password" name="Password"  class="form-control error-box-class" >
                            </div>
                        </div>
                        
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label"> Website<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="website" name="Website"  class="form-control error-box-class" >
                            </div>
                        </div>
                       
                        <div id="description_txt">
                        <div class="form-group lan_append formex">
                            <label for="fname" class="col-sm-3 control-label"> Description (English)<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="description" name="Descrition[0]"  class="description form-control error-box-class" ></textarea>
                            </div>
                        </div>
                            <?php
                               foreach ($language as $val) {
//                                   print_r($val);
                             ?>
                            <div class="form-group lan_append formex" >
                                   <label for="fname" class=" col-sm-3 control-label"> Description (<?php echo $val['lan_name']; ?>) <span style="color:red;font-size: 18px">*</span></label>
                                   <div class="col-sm-6">
                                    <textarea type="text"  id="description" name="Descrition[<?= $val['lan_id'] ?>]"  class="description form-control error-box-class" ></textarea>
                                    <!--<input type="text"  id="description" name="Descrition<?= $val['lan_id'] ?>"  class="form-control error-box-class" >-->
                                   </div>
                            </div>
                            <?php } ?>
                        
                        </div>
                        
                        <div id="Address_txt" >
                            <div class="form-group formex">
                                <label for="fname" class="col-sm-3 control-label ">Address (English)<span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control entityAddress" id="entityAddress_0" placeholder="Address" name="Address[0]"  aria-required="true"  onkeyup="getAddLatLong1(this)"></textarea>
                                </div>
                            </div>
                              <?php
                                     foreach ($language as $val) {
//                                         print_r($val);
                              ?>
                            <div class="form-group lan_append formex" >
                                   <label for="fname" class=" col-sm-3 control-label"> Address (<?php echo $val['lan_name']; ?>) <span style="color:red;font-size: 18px">*</span></label>
                                   <div class="col-sm-6">
                                     <textarea class="form-control entityAddress" id="entityAddress_<?= $val['lan_id'] ?>" placeholder="Address" name="Address[<?= $val['lan_id'] ?>]"  aria-required="true" ></textarea>
                                   </div>
                                   <button  type="button" class=" btn btn-danger btn-sm" 
                                     style="margin-top: -50px;
                                     width: 5%;
                                     border-radius: 45px;
                                     position: relative;
                                     height: 41px;
                                     font-size: 13px;" 
                                     accesskey="" name="action" onclick="callMap();" value="add">Map</button>
                            </div>
                                  
                             <?php } ?>
                            <!--<div class="col-sm-1">-->
                                <!--<span style="color: red; font-size: 20px">*</span>-->
                            <!--</div>-->
                            <!--                                        <div class="col-md-1">
                                                                        <div id='map_lat_long'></div>
                            
                                                                        <button  type="button" class="form-control btn btn-danger btn-sm" style="border-radius: 20px;"  name="action" onclick="callMap();" value="add">Map</button>
                                                                        <div id="latlong_error"></div>
                                                                    </div>-->
                        </div>


                       

                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Country<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <select id='CountryList' name='Country' class='form-control'  <?PHP echo $enable; ?>>
                                    <option value="0">Select Country</option>
                                    <?php
                                    foreach ($country as $result) {

                                        echo "<option value=" . $result->Country_Id . ">" . $result->Country_Name . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <!--<span style="color: red; font-size: 20px">*</span>-->
                            </div>
                        </div>

                        
                        <input type='hidden' name='cityname' id='cityname'>
                        <input type='hidden' name='countryname' id='countryname'>
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">City<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <div id='CityList'>
                                    <select id='cityLists' class="form-control" name='City' <?PHP echo $enable; ?> >
                                        <option value=''>Select City</option>

                                    </select>
                                </div>
                            </div>
                           <!--<input type='hidden' id='SelectedCity' value='<?PHP // echo $ProfileData['City'];  ?>'>-->
                            <div class="col-sm-1">
                                <!--<span style="color: red; font-size: 20px">*</span>-->
                            </div>
                        </div>

                        
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Postal Code<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="entitypostalcode" value='' placeholder="0" name="PostalCode"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>
                            <div class="col-sm-1">
                                <!--<span style="color: red; font-size: 20px">*</span>-->
                            </div>
                        </div>

                        
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Longitude<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="entiryLongitude" value='' placeholder="0.00" name="Longitude"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>
                            <div class="col-sm-1">
                                <!--<span style="color: red; font-size: 20px">*</span>-->
                            </div>
                        </div>
                        
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Latitude<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="entiryLatitude" value='' placeholder="0.00" name="Latitude"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>
                            <div class="col-sm-1">
                                <!--<span style="color: red; font-size: 20px">*</span>-->
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">Avg cooking time</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="avgcooktime" value='' placeholder="hh:mm:ss" name="avgcooktime"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>
                            <div class="col-sm-1">
                                <!--<span style="color: red; font-size: 20px">*</span>-->
                            </div>
                        </div>
                      
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">Budget</label>
                            <div class="col-sm-6">
                                <select id="budget" name="bud_select"  class="form-control error-box-class" >
                                    <option value="0">Select Budget</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                        </div>

                        <br>
                        
                        <h5>Restaurant Category Settings</h5>
                        <hr>
                        <br>

                        <div class="form-group formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-3 control-label">Category<span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <select id="CatId" name="cat_select"  class="form-control error-box-class" >
                                        <option value="">Select Category</option>


                                            <?php
                                            foreach ($category as $result) {
                                                echo "<option value=" . $result['Categoryid'] . ">" . implode($result['Categoryname'],',') . "</option>";
                                            }
                                            ?>

                                    </select>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-group  formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-3 control-label">Sub-Category<span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6" id="subcat" >
                                    <!--                                 style=" border: 1px solid gainsboro;
                                                                                                            padding: 10px 10px;
                                                                                                            border-radius: 3px;
                                                                                                            max-height: 100px;
                                                                                                            overflow-y: scroll;
                                                                                                            font-size: 12px;
                                                                                                            color: black;"
                                    -->
                                    <select id="subCatId" name="subcat_select[]"  class="form-control error-box-class" >
                                        <option value="">Select Sub-Category</option>


<?php
//                                    foreach ($category as $result) {
//                                        echo "<option value=" . $result['Categoryid'] . ">" . $result['Categoryname'] . "</option>";
//                                    }
?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        
                        <h5>Driver Settings</h5>
                        <hr>
                        <br>
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Drivers Type</label>
                            <div class="col-sm-6">
                                <select id="drivers" onchange="selectprice();"  name="cat_select"  class="form-control error-box-class" >
                                    <option value="">Select Drivers</option>
                                    <option value="0">Jaiecom Pool</option>
                                    <option value="1">Store Drivers</option>
                                    <option value="2">Offline Drivers</option>
                                </select>
                            </div>

                        </div>
                        <br>
                        
                        <h5>Price Settings</h5>
                        <hr>
                        <br>

                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Pricing Model</label>
                            <div class="col-sm-6">
                                <select id="pricing"  onchange="selectprice();"  name="cat_select"  class="form-control error-box-class" >
                                    <option value="0">Select Pricing</option>
                                    <option value="1">Zonal Pricing</option>
                                    <option value="2">Mileage Pricing</option>
                                </select>
                            </div>

                        </div>
                        

                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Minimum Order Value (SAR)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="entiryminorderVal" value='' placeholder="Minimum Order Value" name="MinimumOrderValue"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>

                        </div>
                        

                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Free Delivery Above (SAR)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="freedelVal" value='' placeholder="Free Delivery Above" name="FreeDeliveryAbove"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>

                        </div>
                        <div class="form-group  basefare" >
                        <!--<br>-->
                        <!--<br>-->
                        <div class="form-group formex">
                        
                            <label for="fname" class="col-sm-3 control-label">Base Fare (SAR)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="basefare" value='' placeholder="Base Fare" name="Basefare"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>

                        </div>
                        <!--<br>-->
                        <!--<br>-->

                        <div class="form-group formex range">
                        
                            <label for="fname" class="col-sm-3 control-label">Range (SAR)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="range" value='' placeholder="Range" name="Range"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>

                        </div>
                       <!--<br>-->
                        <!--<br>-->
                        <div class="form-group formex Priceperkm">
                           
                            <label for="fname" class="col-sm-3 control-label">Price/Km (SAR)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="Priceperkm" value='' placeholder="Price/Km" name="priceperkm"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>

                        </div>
                        </div>
                        <!--<br>-->
                        <br>
                        <hr>
                        <h5>Service Settings</h5>
                        <!--<hr>-->
                        <br>
                       <div class="form-group" class="formex">

                         <div class="frmSearch">
                             <label for="fname" class="col-sm-3 control-label">Order Type<span style="color:red;font-size: 18px">*</span></label>
                             <div class="col-sm-6" id="accepts" >
                                 <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts" id="accepts_1" value="1"> Pickup
                                    <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts" id="accepts_2" value="2"> Delivery
                                    <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts" id="accepts_3" value="3"> Both<br>
                               </div>
                         </div>
                        </div>
                        
                        <br>
                        <hr>
                        
                        <h5>Payment Settings</h5>
                        <hr>
                        <br>

                        <div class="form-group formex Pickup">
                            <label for="fname" class="col-sm-3 control-label">Payment method for Pickup<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="checkbox" class="Pcheckbox_" name="payment[]" id="Pcash" value="1" >&nbsp;&nbsp;<label>Cash</label> 
                                <!--<br>-->
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="Pcheckbox_" name="payment[]" id="Pcredit_card" value="1" >&nbsp;&nbsp;<label>Credit Card</label> 
                                <!--<br>-->
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="checkbox_" name="payment[]" id="PSADAD" value="1" >&nbsp;&nbsp;<label>SADAD</label> 
                            </div>
                        </div>
                       

                        <div class="form-group formex Delivery">
                            <label for="fname" class="col-sm-3 control-label">Payment method for Delivery<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="checkbox" class="Dcheckbox_" name="payment[]" id="Dcash" value="1" >&nbsp;&nbsp;<label>Cash</label> 
                                <!--<br>-->
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="Dcheckbox_" name="payment[]" id="Dcredit_card" value="1" >&nbsp;&nbsp;<label>Credit Card</label> 
                                <!--<br>-->
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="Dcheckbox_" name="payment[]" id="DSADAD" value="1" >&nbsp;&nbsp;<label>SADAD</label> 
                            </div>
                        </div>

                        

                        <!--                    <div class="form-group" class="formex">
                                                <label for="fname" class="col-sm-3 control-label">Store Drivers<span style="color:red;font-size: 18px">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="checkbox" class="checkbox_" name="sdrivers" id="yes" value="1" /> 
                                                </div>
                                            </div>
                                            
                                             <br>
                                            <br> 
                                            <div class="form-group" class="formex">
                                                <label for="fname" class="col-sm-3 control-label">Jaiecom Drivers<span style="color:red;font-size: 18px">*</span></label>
                                                <div class="col-sm-6">
                                                    <input type="checkbox" class="checkbox_" name="jdrivers" id="yes" value="0" /> 
                                                </div>
                                            </div>-->

                        <br>
                        
                        <h5>Dispatch Settings</h5>
                        <hr>
                        <br>
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Tier 1 radius (Km)<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="tier1" name="tier1"  class="form-control error-box-class" >
                            </div>
                        </div>
                        <br>
                        <!--<br>-->
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Tier 2 radius (Km)<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="tier2" name="tier2"  class="form-control error-box-class" >
                            </div>
                        </div>
                        <!--<br>-->
                        
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label">Tier 3 radius (Km)<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="tier3" name="tier3"  class="form-control error-box-class" >
                            </div>
                        </div>
                        <br>
                        <hr>
                        <h5>Notes</h5>
                        <hr>
                        <br>
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label"> Note </label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="notes" name="notes"  class="description form-control error-box-class" ></textarea>
                            </div>
                        </div>
                       
                        <!--<br>-->

                        <div class="row">
                            <div class="col-sm-4" ></div>
                            <div class="col-sm-4 error-box" id="clearerror"></div>
                            <div class="col-sm-4" >
                                <button type="button" class="btn btn-primary pull-right" id="insert" >Add</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
</div>


<div class="modal fade stick-up" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxaddmodal" style="font-size: large;text-align:center">Are you sure you wish to activate the selected business ?</div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds1" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade in" id="ForMaps" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
        <div class="modal-dialog">

            <!--<form id="search_form" action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCenter" method= "post" onsubmit="return validateForm();">-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"  class="close" onclick='Cancel();' data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Drag Marker To See Address</h4>
                    </div>

                    <div class="modal-body"><div class="form-group" >
                            <div id="myMap" style="width: 544px; height: 250px;"></div><br/>
                            <!--                            <div class="form-group">
                                                            <label>Address Line </label>
                                                            <input type="text" class="form-control" value="" placeholder="Address ..." name="address" id="address" onkeyup="getAddLatLong(this);">
                                                            <textarea class="form-control" id="entityAddress" placeholder="Address..." name="FData[Address]" onkeyup="getAddLatLong(this)"><?PHP echo $ProfileData['Address']; ?></textarea>
                            
                                                        </div> -->
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" value="<?PHP echo $ProfileData['Address']; ?>" placeholder="Address ..." name="FData[Address]"
                                       id="mapentityAddress" onkeyup="getAddLatLong(this);" on  >
                            </div> 

                            <div class="col-md-6">
                                <label>Latitude</label>
                                <input type="text" class="form-control" value="" placeholder="Latitude ..." name="latitude" id="latitude">
                            </div> 
                            <div class="col-md-6">
                                <label>Longitude</label>
                                <input type="text" class="form-control" value="" placeholder="Longitude ..." name="longitude" id="longitude">
                            </div> 

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick='Cancel();'>Close</button>
                        <input type="button" id="TakeMapAddress"  data-dismiss="modal" class="btn btn-primary" onclick='Take();' value="Take Address" >

                    </div>
                </div>
            <!--</form>-->
            </form>

        </div>

    </div>