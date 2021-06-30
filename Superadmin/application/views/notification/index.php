<?php
$status = 1;
?>
<style>
    input[type=checkbox] {
        margin: 4px 4px 0px 8px;
    }
    .span_topic{
        padding-left: 7px;
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

    .selectedDrivers{

        height: 28px;
        padding: 6px;
        display: inline-flex;
        margin: 0px 1px 1px;
        font-weight: 600;
        /*background: #5bc0de;*/
        border: 1px solid;
        border-radius: 4px;

    }

    input[type=checkbox], input[type=radio] {
        margin: 4px 5px 0;
        line-height: normal;
    }
    .driverList{
        display: none;
    }
    span.RemoveMore{
        margin-left: 8px;cursor: pointer;
    }

    span.tag {
        padding:4px 8px;
        background-color: #5bc0de;
        font-size:10px;
        display: -webkit-inline-box;
        float: none; 
    }


    .label-info {
        background-color: #5bc0de;
    }


    .startDesc{
        height: 28px;
        padding: 6px;
        display: inline-flex;
        margin: 0px 1px 1px;
        font-weight: 600;
        /*background: #5bc0de;*/
        border: 1px solid;
        border-radius: 4px;
        /*width: 100%;*/
        max-width:400px
    }
    .inputDesc {
        width: 100%;
        min-width:15px!important;
        max-width:400px!important;
        border: none;
    }

    span.tag{
        font-weight: 600;
    }


    #checkboxes,#customerCities,#driversZones,#customerZones,#driversList,#customersList,#storeList,#storeCities,#storeZones {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxes label,#customerCities label,#customerZones label,#driversZones label,#storeCities label,#storeZones label{
        display: block;
    }

    .ui-autocomplete{
        z-index: 5000;
    }

    .pac-container {
    z-index: 1051 !important;
}
</style>
<script src="//maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAP_API_KEY ?>&v=3&libraries=drawing,places"></script>
<script type="text/javascript">
    var html;
    var url;
    var expanded = false;
    var driverPushTopicType;
    var customerPushTopicType;
    var getSendPushTopic = [];


    var alreadyselectedDrivers = [];
    var alreadyselectedCustomers = [];
    var alreadyselectedStore = [];
    
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
    var expanded1 = false;
    function showCheckboxes1() {
        var checkboxes = document.getElementById("customerCities");
        if (!expanded1) {
            checkboxes.style.display = "block";
            expanded1 = true;
        } else {
            checkboxes.style.display = "none";
            expanded1 = false;
        }
    }
    var expanded2 = false;
    function showCheckboxes1() {
        var checkboxes = document.getElementById("customerCities");
        if (!expanded2) {
            checkboxes.style.display = "block";
            expanded2 = true;
        } else {
            checkboxes.style.display = "none";
            expanded2 = false;
        }
    }
    var expanded3 = false; //store
    function showCheckboxes3() {
        var checkboxes = document.getElementById("storeCities");
        if (!expanded3) {
            checkboxes.style.display = "block";
            expanded3 = true;
        } else {
            checkboxes.style.display = "none";
            expanded3 = false;
        }
    }

    var expandedDriverList = false;
    function showDriversCheckboxes() {
        var checkboxes = document.getElementById("driversList");
        if (!expandedDriverList) {
            checkboxes.style.display = "block";
            expandedDriverList = true;
        } else {
            checkboxes.style.display = "none";
            expandedDriverList = false;
        }
    }
    var expandedCustomerList = false;
    function showCustomersCheckboxes() {
        var checkboxes = document.getElementById("customersList");
        if (!expandedCustomerList) {
            checkboxes.style.display = "block";
            expandedCustomerList = true;
        } else {
            checkboxes.style.display = "none";
            expandedCustomerList = false;
        }
    }
    var expandedStoreList = false; //store
    function showStoreCheckboxes() {
        var checkboxes = document.getElementById("storeList");
        if (!expandedStoreList) {
            checkboxes.style.display = "block";
            expandedStoreList = true;
        } else {
            checkboxes.style.display = "none";
            expandedStoreList = false;
        }
    }

    $(document).ready(function () {

        var currentTab = 1;
        $('.cs-loader').show();
        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/Sendnotification/datatable_getPushDetails/2',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    table.show()
                    $('.cs-loader').hide()
                    searchInput.show()

                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback
                            });
                }
            };

            table.dataTable(settings);

            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });
        }, 1000);




        $('.changeMode').click(function () {
            
            var table = $('#big_table');
            var tab_id = $(this).attr('data-id');

            if (tab_id != currentTab)
            {
                currentTab = tab_id; 
                if (currentTab == '1')
                {
                    $('.sendPushCustomers').hide();
                    $('.sendPushStore').hide();
                    $('.sendPush').show();

                } else if(currentTab == '2' ){
                    $('.sendPushCustomers').show();
                    $('.sendPushStore').hide();
                    $('.sendPush').hide();
                }else{
                    $('.sendPushStore').show();
                    $('.sendPush').hide();
                    $('.sendPushCustomers').hide();
                }
                table.hide();

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": $(this).attr('data'),
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 20,
                    "oLanguage": {
                    },
                    "fnInitComplete": function () {

                        table.show()

                    },
                    'fnServerData': function (sSource, aoData, fnCallback)
                    {
                        $.ajax
                                ({
                                    'dataType': 'json',
                                    'type': 'POST',
                                    'url': sSource,
                                    'data': aoData,
                                    'success': fnCallback
                                });
                    }
                };

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');



                table.dataTable(settings);

                // search box for table
                $('#search-table').keyup(function () {
                    table.fnFilter($(this).val());
                });
            }

        });

        // search drivers for individual-----DRIVER---------------------
        $('#searchDrivers').keyup(function () {

            $('.checkboxDrivers').each(function () {
                if ($(this).is(':checked'))
                    alreadyselectedDrivers.indexOf($(this).attr('id')) === -1 ? alreadyselectedDrivers.push($(this).attr('id')) : '';
            });

            if ($(this).val() != '')
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/Sendnotification') ?>/getDriversBySerach",
                    type: "POST",
                    dataType: 'JSON',
                    data: {serachData: $(this).val()},
                    success: function (response)
                    {
                        
                        html = '';
                        $('.driverSelectionDiv').show();
                        $('#driversList').empty();
//                        $('.selectedDriversList').empty();

                        if (response.data)
                        {
                            console.log('store---->',response.data);
                            $.each(response.data, function (index, row) {
                                if (alreadyselectedDrivers.indexOf(row._id.$oid) === -1)
                                {

                                    html += '<label for="' + row._id.$oid + '">';
                                    html += '<input type="checkbox" class="checkboxDrivers" name="driversList[]" city="' + row.cityName + '" pushTopic="' + row.pushToken + '" fname="' + row.email + '" id="' + row._id.$oid + '" value="' + row.pushTopic + '"/>' + row.firstName +' '+ row.lastName + ' | ' + row.countryCode + row.mobile;
                                    html += ' </label><br>';
                                } else {
                                    html += '<label for="' + row._id.$oid + '">';
                                    html += '<input checked type="checkbox" class="checkboxDrivers" name="driversList[]" city="' + row.cityName + '" pushTopic="' + row.pushToken + '" fname="' + row.email + '" id="' + row._id.$oid + '" value="' + row.pushTopic + '"/>' + row.email + ' | ' + row.countryCode + row.mobile;
                                    html += ' </label><br>';
                                }
                            });
                        }



                        $('#driversList').css('display', 'block');
                        $('#driversList').append(html);
                    }
                });
            } else {
                $('#driversList').empty();
//                $('.selectedDriversList').empty();
            }
        });

        //Adding drivers to the list
        $(document).on('click', '.checkboxDrivers', function ()
        {
            if ($(this).is(":checked"))
            {
                $('.selectedDriversList').append('<span class="tag label label-info" id="RemoveControl_' + $(this).attr('id') + '">' + $(this).attr('fname') + '<input  style="display:none;" class="inputDesc"  type="text"  value="' + $(this).attr('id') + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + '" pushToken="'+
                $(this).attr('pushTopic') +'" style="">x</span></span>');

            } else {
                $('#RemoveControl_' + $(this).attr('id')).remove();
            }
        });

        //Adding cities to the list---DRIVER 
        $(document).on('click', '.checkbox1', function ()
        {

            if ($(this).is(":checked"))
                $('.selectedCitiesList').append('<span class="tag label label-info" id="RemoveControl_' + $(this).attr('id') + '">' + $(this).attr('cityName') + '<input  style="display:none;" class="inputDesc"  type="text"  value="' + $(this).attr('id') + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + '" pushToken = "'+ $(this).attr('id') + '" style="">x</span></span>');
            else
                $('#RemoveControl_' + $(this).attr('id')).remove();

        });
        //Adding cities to the list---DRIVER
        $(document).on('click', '.allDriverZones', function ()
        {

            if ($(this).is(":checked"))
                $('.selectedDriverZonesList').append('<span class="tag label label-info" id="RemoveControl_' + $(this).attr('id') + '">' + $(this).attr('zoneName') + '<input  style="display:none;" class="inputDesc"  type="text"  value="' + $(this).attr('id') + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + '" style="">x</span></span>');
            else
                $('#RemoveControl_' + $(this).attr('id')).remove();

        });


        //Adding cities to the list---CUSTOMER
        $(document).on('click', '.allCustomerCities', function ()
        {

            if ($(this).is(":checked"))
                $('.selectedCustomerCitiesList').append('<span class="tag label label-info" id="RemoveControl_' + $(this).attr('id') + '">' + $(this).attr('cityName') + '<input  style="display:none;" class="inputDesc"  type="text"  value="' + $(this).attr('id') + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + '" style="">x</span></span>');
            else
                $('#RemoveControl_' + $(this).attr('id')).remove();

        });

        //Adding area zone to the list---CUSTOMER
        $(document).on('click', '.allCustomerZones', function ()
        {

            if ($(this).is(":checked"))
                $('.selectedCustomerZonesList').append('<span class="tag label label-info" id="RemoveControl_' + $(this).attr('id') + '">' + $(this).attr('zoneName') + '<input  style="display:none;" class="inputDesc"  type="text"  value="' + $(this).attr('id') + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + '" style="">x</span></span>');
            else
                $('#RemoveControl_' + $(this).attr('id')).remove();

        });

        //*********store******
        //Adding cities to the list---STORE
        $(document).on('click', '.allStoreCities', function ()
        {

            if ($(this).is(":checked"))
                $('.selectedStoreCitiesList').append('<span class="tag label label-info" id="RemoveControl_' + $(this).attr('id') + '">' + $(this).attr('cityName') + '<input  style="display:none;" class="inputDesc"  type="text"  value="' + $(this).attr('id') + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + '" style="">x</span></span>');
            else
                $('#RemoveControl_' + $(this).attr('id')).remove();

        });
        //Adding cities to the list---STORE 
        $(document).on('click', '.allStoreZones', function ()
        {

            if ($(this).is(":checked"))
                $('.selectedStoreZonesList').append('<span class="tag label label-info" id="RemoveControl_' + $(this).attr('id') + '">' + $(this).attr('zoneName') + '<input  style="display:none;" class="inputDesc"  type="text"  value="' + $(this).attr('id') + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + '" style="">x</span></span>');
            else
                $('#RemoveControl_' + $(this).attr('id')).remove();

        });

        $(document).on('click', '.RemoveMore', function ()
        {
            $('#' + $(this).attr('data-id')).attr('checked', false);
            $('#RemoveControl_' + $(this).attr('data-id')).remove();
            var index = alreadyselectedDrivers.indexOf($(this).attr('data-id'));
            if (index > -1) {
                alreadyselectedDrivers.splice(index, 1);
            }
        });


        //Drivers cool
        $('.sendPush').click(function () {
            $('.errors').text('');
            $('.driversSerachBoxDiv').show();
            $('.pushNotification_cityDiv').hide();
            $('.selectedCitiesList').empty();
            $('.checkbox1').attr('checked', false);
            $('#driversZones').empty();

            $('#driverPushForm')[0].reset();
            //Load the city initially
            $.ajax({
                url: "<?php echo base_url('index.php?/sendnotification') ?>/getCities",
                type: "POST",
                dataType: 'JSON',
                data: {},
                success: function (response)
                {
                    html = '';
                    $.each(response.cities, function (i, row)
                    {

                        html += '<label for="' + row.cityId.$oid + '">';
                        html += '<input type="checkbox" class="checkbox1" id="' +row.cityId.$oid + '" cityName="' + row.cityName + '" name="cities[]" pushTopic="' + row.fcmTopic + '"  value="' + row.cityId.$oid + '"/>' + row.cityName;
                        html += ' </label>';
                    });
                    $('#checkboxes').css('display', 'block'); 
                    $('#checkboxes').append(html);

                    //------------AREA ZONES------------------- zones initially loaded for driver
                            
                    html1 = '';
                    $.each(response.areaZones, function (i, row)
                    {
                        html1 += '<label for="' + row._id.$oid + '">';
                        html1 += '<input type="checkbox" class="allDriverZones" id="' + row._id.$oid + '" name="zones[]" zoneName="' + row.title + '"   value="' + row._id.$oid + '"/>' + row.title;
                        html1 += ' </label>';
                    });
                    $('#driversZones').css('display', 'block');
                    $('#driversZones').append(html1);
                    
                }
            });
            $('#sendPushPopUp').modal('show');
        });


        $('#submitPushDriver').click(function () {

            $('.error-box').text('');
//            var topicName = '';
             getSendPushTopic = [];
			 var topicType = $('input:radio.pushNotification:checked').attr('data-id');
           
             var pType=$('input[name=notificationType]:checked').val();
             
             if(pType==7){
              var  pushType=1;
             }else{
              var  pushType=2;
             }

           
            if (topicType == '1' && $('.checkboxDrivers:checked').length == 0)
            {

                $('#pushNotification_cityErr').text('Please select at least one driver');
            } else if (topicType == '2' && $('.checkbox1:checked').length == 0)
                $('#pushNotification_cityErr').text('Please choose the city');
            else if (topicType == '4' && $('.allDriverZones:checked').length == 0)
                $('#pushNotification_cityErr').text('Please choose the zones');
            else if ($('#pushTitle').val() == '')
                $('#pushTitleErr').text('Please enter the title');
            else if ($('#pushMessage').val() == '')
                $('#pushMessageErr').text('Please enter the message');
            else {

                var ids = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();


                switch (parseInt(topicType))
                {
                    case 1:
                        $('.checkboxDrivers').each(function () {

                            if ($(this).is(':checked'))
                            {
                                if ($(this).attr('pushtopic') != 'undefined' && $(this).attr('pushtopic') != '')
                                {
                                    if (getSendPushTopic == '')
                                        getSendPushTopic += $(this).attr('pushtopic');
                                    else
                                        getSendPushTopic += ',' + $(this).attr('pushtopic');
                                }
                            }
                        });
                        break;
                    case 2:   
                        $('.checkbox1').each(function () {
                            if ($(this).is(':checked'))
                            {
                                if (getSendPushTopic == '')
                                    getSendPushTopic += $(this).val();
                                else
                                    getSendPushTopic += ',' + $(this).val();
                            }
                        });
                        break;
                    case 3:
                        $('.checkbox1').each(function () {
                           

                                if (getSendPushTopic == '')
                                    getSendPushTopic += $(this).val();
                                else
                                    getSendPushTopic += ','+$(this).val();
                            
                        });
                        break;
                    case 4:  
                        $('.allDriverZones').each(function () {
                            if ($(this).is(':checked'))
                            {
                                if (getSendPushTopic == '')
                                    getSendPushTopic += $(this).val();
                                else
                                    getSendPushTopic += ',' + $(this).val();
                            }
                        });
                        break;
                    case 5:
                        $('.allDriverZones').each(function () {

                            // if ($(this).attr('pushtopic') != 'undefined')
                            //     if (getSendPushTopic == '')
                            //         getSendPushTopic += $(this).attr('pushtopic');
                            //     else
                            //         getSendPushTopic += ',' + $(this).attr('pushtopic');


                            if (getSendPushTopic == '')
                                    getSendPushTopic += $(this).val();
                                else
                                    getSendPushTopic += ','+$(this).val();

                        });
                        break;

                }

                switch (parseInt(topicType)) {
                    case 1:
                        driverPushTopicType = 1;
                        break;
                    case 2:
                        driverPushTopicType = 2;
                        break;
                    case 3:
                        driverPushTopicType = 2;
                        break;
                    case 4:
                        driverPushTopicType = 3;
                        break;
                    case 5:
                        driverPushTopicType = 3;
                        break;
                  

                }

              

                url = $('li.tabs_active.active').children("a").attr('data');

                var longitude=$('#entiryLongitude').val();
                var latitude=$('#entiryLatitude').val();
                var imageUrl=$('#imagesProductImg').val();
                var knowMoreUrl="";
                var radiusVal=$('#radius').val();

                if(longitude==""){
                    longitude="0"
                }
                
                if(latitude==""){
                    latitude="0"
                }            


                if(radiusVal==""){
                    var radius="";
                }else{
                    var radius=parseInt($('#radius').val());
                }             
                
                
                //var datarel=JSON.stringify({userType: 2, type: pushType,topicType: topicType, title: $('#pushTitle').val(), body: $('#pushMessage').val(), topics: getSendPushTopic,longitude:longitude,latitude:latitude,radius:radius,imageUrl:imageUrl,knowMoreUrl:knowMoreUrl });
                //console.log('datarel---',datarel)
                
                
                // chnages
                $.ajax({
                    url: '<?php echo sendNotification ?>pushnotificaton/',
                    type: "POST",
                    data:  JSON.stringify({userType: 2, type: pushType,topicType: topicType, title: $('#pushTitle').val(), body: $('#pushMessage').val(), topics: getSendPushTopic,longitude:longitude,latitude:latitude,radius:radius,imageUrl:imageUrl,knowMoreUrl:knowMoreUrl }),
                    contentType: "application/json",
                  
                    success: function (json,textStatus, xhr)
                    {
                        console.log('rel---',json);
                        $('#driverPushForm')[0].reset();
                        $('#driversList').empty();
                        $('.selectedDriversList').empty();

                        if (xhr.status == 200)
                        {
                            $('.close').trigger('click');
                            refreshContent(url);//Load datatable

                        } else
                            alert('Error..! while sending a push');
                    },error: function (jqXHR, textStatus, errorThrown) {
                            if (jqXHR.status == 500) {
                                alert('Internal error: ' + jqXHR.responseText);
                            } else {
                                alert('Unexpected error.');
                            }
                        }
                });


            }
        });
        //------------------------END------------------------------------------



        //Customers-------------------------START---------------------------------- 
        $('#searchCustomers').keyup(function () {
            $('.checkboxCustomers').each(function () {
                if ($(this).is(':checked'))
                    alreadyselectedCustomers.indexOf($(this).attr('id')) === -1 ? alreadyselectedCustomers.push($(this).attr('id')) : '';
            });


            if ($(this).val() != '')
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/Sendnotification') ?>/getCustomersBySerach",
                    type: "POST",
                    dataType: 'JSON',
                    data: {serachData: $(this).val()},
                    success: function (response)
                    {
                        console.log('customer',response);
                        html = '';
                        $('.customerSelectionDiv').show();
                        $('#customersList').empty();
//                        $('.selectedCustomersList').empty();

                        if (response.data)
                        {
                            $.each(response.data, function (index, row) {
                                if (alreadyselectedCustomers.indexOf(row._id.$oid) === -1)
                                {
                                    html += '<label for="' + row._id.$oid + '">';
                                    html += '<input type="checkbox" class="checkboxCustomers" city="' + row.cityName + '" name="customersList[]" pushTopic="' + row.fcmTopic + '" fname="' + row.email + '" id="' + row._id.$oid + '" value="' + row.fcmTopic + '"/>' + row.email + ' | ' + row.countryCode + row.phone;
                                    html += ' </label><br>';
                                } else {

                                    html += '<label for="' + row._id.$oid + '">';
                                    html += '<input checked type="checkbox" class="checkboxCustomers" city="' + row.cityName + '" name="customersList[]" pushTopic="' + row.fcmTopic + '" fname="' + row.email + '" id="' + row._id.$oid + '" value="' + row.fcmTopic + '"/>' + row.email + ' | ' + row.phone.countryCode + row.phone.phone;
                                    html += ' </label><br>';
                                }


                            });
                        }

                        $('#customersList').css('display', 'block');
                        $('#customersList').append(html);
                    }
                });
            } else {
                $('#customersList').empty();
//                $('.selectedCustomersList').empty();
            }
        });



        $(document).on('click', '.checkboxCustomers', function ()
        {
            if ($(this).is(":checked"))
            {
//                
                $('.selectedCustomersList').append('<span class="tag label label-info" id="RemoveControl_' + $(this).attr('id') + '">' + $(this).attr('fname') + '<input  style="display:none;"  class="inputDesc"  type="text"  value="' + $(this).attr('id') + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + '" style="">x</span></span>');

            } else {
                $('#RemoveControl_' + $(this).attr('id')).remove();
            }
        });
        $('.sendPushCustomers').click(function () {

            $('.errors').text('');

            $('.customersSerachBoxDiv').show();
            $('#customerPushForm')[0].reset();
            $('#customersList').empty();
            $('.selectedCustomersList').empty();
            $('#customerCities').empty();
            $('#customerZones').empty();


            $('.pushNotificationCustomers_cityDiv').hide();
            $('.selectedCustomerCitiesList').empty();

            //Load the city initially
            $.ajax({
                url: "<?php echo base_url('index.php?/Sendnotification') ?>/getCities",
                type: "POST",
                dataType: 'JSON',
                data: {},
                success: function (response)
                {

                      //------------CITIES------------------------
                   var html5 = '';
                    $.each(response.cities, function (i, row)
                    {

                        html5 += '<label for="' + row.cityId.$oid + '">';
                        html5 += '<input type="checkbox" class="allCustomerCities" id="' + row.cityId.$oid + '" name="cities[]" cityName="' + row.cityName + '" pushTopic="' + row.fcmTopic + '"  value="' + row.cityId.$oid + '"/>' + row.cityName;
                        html5 += ' </label>';
                    });
                    $('#customerCities').css('display', 'block');
                    $('#customerCities').append(html5);


                    //------------AREA ZONES-------------------
                    html = '';
                    $.each(response.areaZones, function (i, row)
                    {

                        html += '<label for="' + row._id.$oid + '">';
                        html += '<input type="checkbox" class="allCustomerZones" id="' + row._id.$oid + '" name="zones[]" zoneName="' + row.title + '"   value="' + row._id.$oid + '"/>' + row.title;
                        html += ' </label>';
                    });
                    $('#customerZones').css('display', 'block');
                    $('#customerZones').append(html);
                }
            });
            $('#sendPushCustomerPopUp').modal('show');
        });

        // **************strore********* //2
         $('.sendPushStore').click(function () {
           //  alert("clicked store");

            $('.errors').text('');

            $('.storeSerachBoxDiv').show();
            $('#storePushForm')[0].reset();
            $('#storeList').empty();
            $('.selectedStoreList').empty();
            $('#storeCities').empty();
            $('#storeZones').empty();


            $('.pushNotificationStore_cityDiv').hide();
            $('.selectedStoreCitiesList').empty();

            //Load the city initially
            $.ajax({
                url: "<?php echo base_url('index.php?/Sendnotification') ?>/getCities",
                type: "POST",
                dataType: 'JSON',
                data: {},
                success: function (response)
                {

                      //------------CITIES------------------------
                   var html5 = '';
                    $.each(response.cities, function (i, row)
                    {

                        html5 += '<label for="' + row.cityId.$oid + '">';
                        html5 += '<input type="checkbox" class="allStoreCities" id="' + row.cityId.$oid + '" name="cities[]" cityName="' + row.cityName + '" pushTopic="' + row.fcmTopic + '"  value="' + row.cityId.$oid + '"/>' + row.cityName;
                        html5 += ' </label>';
                    });
                    $('#storeCities').css('display', 'block');
                    $('#storeCities').append(html5);


                    //------------AREA ZONES-------------------

                    html = '';
                    $.each(response.areaZones, function (i, row)
                    {

                        html += '<label for="' + row._id.$oid + '">';
                        html += '<input type="checkbox" class="allStoreZones" id="' + row._id.$oid + '" name="zones[]" zoneName="' + row.title + '"   value="' + row._id.$oid + '"/>' + row.title;
                        html += ' </label>';
                    });
                    $('#storeZones').css('display', 'block');
                    $('#storeZones').append(html);
                }
            });
            $('#sendPushStorePopUp').modal('show');
        });


        // search store
        $(document).on('click', '.checkboxStore', function ()
        {
            if ($(this).is(":checked"))
            {
//                
                $('.selectedStoreList').append('<span class="tag label label-info" id="RemoveControl_' + $(this).attr('id') + '">' + $(this).attr('fname') + '<input  style="display:none;"  class="inputDesc"  type="text"  value="' + $(this).attr('id') + '" ><span class="RemoveMore" data-id="' + $(this).attr('id') + '" style="">x</span></span>');

            } else {
                $('#RemoveControl_' + $(this).attr('id')).remove();
            }
        });

        $('#searchStore').keyup(function () {
            $('.checkboxStore').each(function () {
                if ($(this).is(':checked'))
                    alreadyselectedStore.indexOf($(this).attr('id')) === -1 ? alreadyselectedStore.push($(this).attr('id')) : '';
            });


            if ($(this).val() != '')
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/Sendnotification') ?>/getStoreManagerBySerach",
                    type: "POST",
                    dataType: 'JSON',
                    data: {serachData: $(this).val()},
                    success: function (response)
                    {
                        console.log('store',response);
                        html = '';
                        $('.storeSelectionDiv').show();
                        $('#storeList').empty();
//                        $('.selectedCustomersList').empty();

                        if (response.data)
                        {

                            console.log('store detaisl',response.data);
                            $.each(response.data, function (index, row) {
                                if (alreadyselectedStore.indexOf(row._id.$oid) === -1)
                                {
                                    html += '<label for="' + row._id.$oid + '">';
                                    html += '<input type="checkbox" class="checkboxStore" city="' + row.cityName + '" name="storeList[]" pushTopic="' + row.fcmManagerTopic + '" fname="' + row.email + '" id="' + row._id.$oid + '" value="' + row.fcmTopic + '"/>' + row.email + ' | ' + row.countryCode + row.phone;
                                    html += ' </label><br>';
                                } else {

                                    html += '<label for="' + row._id.$oid + '">';
                                    html += '<input checked type="checkbox" class="checkboxStore" city="' + row.cityName + '" name="storeList[]" pushTopic="' + row.fcmManagerTopic + '" fname="' + row.email + '" id="' + row._id.$oid + '" value="' + row.fcmTopic + '"/>' + row.email + ' | ' + row.phone.countryCode + row.phone.phone;
                                    html += ' </label><br>';
                                }


                            });
                        }
                      
                        $('#storeList').css('display', 'block');
                        $('#storeList').append(html);
                    }
                });
            } else {
                $('#storeList').empty();
//                $('.selectedCustomersList').empty();
            }
        });
        //end store
        //************end store  ***** */
        

        // push notification for driver
        $("input[name='notificationType']").change(function(){

               if ($(this).val() == '7') {
                  
                  $('#imageDiv').hide();
                  $("#imagesProductImg").val('')                
                  $('.imagesProduct').attr('src', '');
                  $('.imagesProduct ').hide();
                  $('#cat_photos').val('');
                

               } else if ($(this).val() == '8') {
                $('#imageDiv').show();
                
                }         
        });

        //Drivers 
        $('.pushNotification').click(function () {
            $('.driversSerachBoxDiv').hide();
            $('.pushNotification_cityDiv').hide();
            $('.driverSelectionDiv').hide();
            $('.selectedDriversList').hide();
            $('.selectedCitiesList').hide();
            $('.selectedCitiesList').empty();

            $('.pushNotification_zonesDiv').hide();
            $('.selectedDriverZonesList').hide();
            $('.selectedDriverZonesList').empty();
            $('.checkbox1').attr('checked', false);
            $('#searchDrivers').val('');
            if ($(this).attr('data-id') == '1')
            {
                console.log('1')
                $('#driversList').empty();
                $('.driversSerachBoxDiv').show();
                $('.selectedDriversList').show();
                $('.selectedDriverZonesList').show();
                $('#radiusDiv').hide();
                $('#cityZonefilter').hide();

                 $('#cityFilter').val('');
                $('#driversZones').empty();
            } else if ($(this).attr('data-id') == '2')
            {

                console.log('2')
                $('.pushNotification_cityDiv').show();
                $('.selectedCitiesList').show();
                $('.selectedDriverZonesList').show();
                $('#radiusDiv').hide();
                $('#cityZonefilter').hide();

                $('#cityFilter').val('');
                $('#driversZones').empty();
            } else if ($(this).attr('data-id') == '4')
            {
                console.log('3')
                $('.pushNotification_zonesDiv').show();
                $('.selectedDriverZonesList').show();
                $('#radiusDiv').hide();
                $('#cityZonefilter').show();

                $('#cityFilter').val('');
                $('#driversZones').empty();
            }else if ($(this).attr('data-id') == '6')
            {
                console.log('4')
                $('#radiusDiv').show();
                $('#cityZonefilter').hide();
                $('#cityFilter').val('');
                $('#driversZones').empty();
            }
            


        });



         // push notification for customer 
         $("input[name='customernotificationType']").change(function(){

                if ($(this).val() == '7') {
                
                $('#customerimageDiv').hide();
                $("#customerimagesProductImg").val('')                
                $('.customerimagesProduct').attr('src', '');
                $('.customerimagesProduct ').hide();
                $('#customercat_photos').val('');
                

                } else if ($(this).val() == '8') {
                $('#customerimageDiv').show();
                
                }         
            });

        $('.pushNotificationCustomers').click(function () {
            $('.pushNotificationCustomers_cityDiv').hide();
            $('.customersSerachBoxDiv').hide();
            $('.customerSelectionDiv').hide();
            $('.selectedCustomersList').hide();
            $('.selectedCustomerZonesList').empty();
            $('.pushNotificationCustomers_ZonesDiv').hide();
            $('.pushNotificationCustomers_cityDiv').hide();
            $('.selectedCustomerCitiesList').empty();
            $('.allCustomerCities').attr('checked', false);
            $('.allCustomerZones').attr('checked', false);
            $('.checkbox1').attr('checked', false);

            if ($(this).attr('data-id') == '1')
            {
                console.log('c1');
                $('#customersList').empty();
                $('.selectedCustomersList').show();
                $('.customersSerachBoxDiv').show();
                $('#customercityZonefilter').hide();

                $('#customercityFilter').hide();
                $('#customercityFilter').val('');
                $('#customerZones').empty();
                $('#customerradiusDiv').hide();

            } else if ($(this).attr('data-id') == '2')
            {
                console.log('c2');
                $('.pushNotificationCustomers_cityDiv').show();
                $('#customercityZonefilter').hide();

                 $('#customercityFilter').hide();
                 $('#customercityFilter').val('');
                 $('#customerZones').empty();
                 $('#customerradiusDiv').hide();

            } else if ($(this).attr('data-id') == '4')
            {
                console.log('c3');
                $('.pushNotificationCustomers_ZonesDiv').show();
                $('#customercityZonefilter').show();
                $('#customercityFilter').show();
                $('#customerradiusDiv').hide();

            }else if ($(this).attr('data-id') == '6')
            {
                console.log('c4')
                $('#customerradiusDiv').show();
                $('#customercityZonefilter').hide();
                $('#customercityFilter').val('');
                $('#customerZones').empty();
            }
        });
        //store

        // push notification for customer 
         $("input[name='storenotificationType']").change(function(){

                if ($(this).val() == '7') {
                
                $('#storeimageDiv').hide();
                $("#storeimagesProductImg").val('')                
                $('.storeimagesProduct').attr('src', '');
                $('.storeimagesProduct ').hide();
                $('#storecat_photos').val('');
                

                } else if ($(this).val() == '8') {
                $('#storeimageDiv').show();
                
                }         
            });
        $('.pushNotificationStore').click(function () {
            //alert("clicked radio");
            
            $('.pushNotificationStore_cityDiv').hide();
            $('.storeSerachBoxDiv').hide();
            $('.storeSelectionDiv').hide();
            $('.selectedStoreList').hide();
            $('.selectedStoreZonesList').empty();
            $('.pushNotificationStore_ZonesDiv').hide();
            $('.pushNotificationStore_cityDiv').hide();
            $('.selectedStoreCitiesList').empty();
            $('.allStoreCities').attr('checked', false);
            $('.allStoreZones').attr('checked', false);
            $('.checkbox1').attr('checked', false);

            if ($(this).attr('data-id') == '1')
            {
                console.log('s1');
                $('#storeList').empty();
                $('.selectedStoreList').show();
                $('.storeSerachBoxDiv').show();

                 $('#storecityFilter').hide();
                $('#storecityFilter').val('');
                $('#storeZones').empty();
               

            } else if ($(this).attr('data-id') == '2')
            {
                console.log('s2');
                $('.pushNotificationStore_cityDiv').show();
                
                 $('#storecityFilter').hide();
                 $('#storecityFilter').val('');
                 $('#storeZones').empty();

            } else if ($(this).attr('data-id') == '4')
            {
                console.log('s3');
                $('.pushNotificationStore_ZonesDiv').show();
               
                 $('#storecityZonefilter').show();
                $('#storecityFilter').show();
            }else if ($(this).attr('data-id') == '6')
            {
                console.log('s4');
                $('#storeradiusDiv').show();
                $('#storecityZonefilter').hide();
                $('#storecityFilter').val('');
                $('#storeZones').empty();
            }
        });

        //Customer
        $('#submitPushCustomer').click(function () {
            $('.error-box').text('');
//            var topicName = '';
            //getSendPushTopic = '';
            getSendPushTopic=[];
            var topicType = $('input:radio.pushNotificationCustomers:checked').attr('data-id');

            var pType=$('input[name=customernotificationType]:checked').val();
             
             if(pType==7){
              var  pushType=1;
             }else{
              var  pushType=2;
             }

            if (topicType == '2' && $('.allCustomerCities:checked').length == 0)
                $('#pushNotificationCustomer_cityErr').text('Please choose the city');
            else if (topicType == '4' && $('.allCustomerZones:checked').length == 0)
                $('#pushNotificationCustomer_zoneErr').text('Please choose zones');
            else if ($('#pushTitleCustomer').val() == '')
                $('#pushTitleCustomerErr').text('Please enter the title');
            else if ($('#pushMessageCustomer').val() == '')
                $('#pushMessageCustomerErr').text('Please enter the message');
            else {

                var ids = $('.allCustomerCities:checked').map(function () {
                    return this.value;
                }).get();


                switch (parseInt(topicType)) {
                    case 1:
                        $('.checkboxCustomers').each(function () {

                            if ($(this).is(':checked'))
                            {
                                if ($(this).val() != 'undefined' && $(this).val() != '')
                                {
                                    if (getSendPushTopic == '')
                                        getSendPushTopic += $(this).val();
                                    else
                                        getSendPushTopic += ',' + $(this).val();
                                }
                            }
                        });
                        break;
                    case 2:
                        $('.allCustomerCities').each(function () {
                            if ($(this).is(':checked'))
                            {
                                if (getSendPushTopic == '')
                                    getSendPushTopic += $(this).val();
                                else
                                    getSendPushTopic += ',' + $(this).val();
                            }
                        });
                        break;
                    case 3:
                        $('.allCustomerCities').each(function () {
                            if (getSendPushTopic == '')
                                getSendPushTopic += $(this).val();
                            else
                                getSendPushTopic += ',' + $(this).val();
                        });
                        break;
                    case 4: 
                        $('.allCustomerZones').each(function () {
                            if ($(this).is(':checked'))
                            {
                                if (getSendPushTopic == '')
                                    getSendPushTopic += $(this).val();
                                else
                                    getSendPushTopic += ',' + $(this).val();
                            }
                        });
                        break;
                    case 5:

                        $('.allCustomerZones').each(function () {

                            if (getSendPushTopic == '')
                                getSendPushTopic += $(this).val();
                            else
                                getSendPushTopic += ',' + $(this).val();
                        });
                        break;

                }

                switch (parseInt(topicType)) {
                    case 1:
                        customerPushTopicType = 1;
                        break;
                    case 2:
                        customerPushTopicType = 2;
                        break;
                    case 3:
                        customerPushTopicType = 2;
                        break;
                    case 4:
                        customerPushTopicType = 3;
                        break;
                    case 5:
                        customerPushTopicType = 3;
                        break;

                }

                url = $('li.tabs_active.active').children("a").attr('data');

                var longitude=$('#customerentiryLongitude').val();
                var latitude=$('#customerentiryLatitude').val();
                var imageUrl=$('#customerimagesProductImg').val();
                var knowMoreUrl="";
                var radiusVal=$('#customerradius').val();

                if(longitude==""){
                    longitude="0"
                }

                if(latitude==""){
                    latitude="0"
                }    

                if(radiusVal==""){
                    var radius="";
                }else{
                    var radius=parseInt($('#customerradius').val());
                }      

              //  var datarel=JSON.stringify({userType: 1, type: pushType,topicType: topicType, title: $('#pushTitleCustomer').val(), body: $('#pushMessageCustomer').val(), topics: getSendPushTopic,longitude:longitude,latitude:latitude,radius:radius,imageUrl:imageUrl,knowMoreUrl:knowMoreUrl});
              
                $.ajax({
                    
                    url: '<?php echo sendNotification ?>pushnotificaton/',
                    type: "POST",
                    data:  JSON.stringify({userType: 1, type: pushType,topicType: topicType, title: $('#pushTitleCustomer').val(), body: $('#pushMessageCustomer').val(), topics: getSendPushTopic,longitude:longitude,latitude:latitude,radius:radius,imageUrl:imageUrl,knowMoreUrl:knowMoreUrl }),
                    contentType: "application/json",
                    //dataType: 'JSON',
                    
                    success: function (json,textStatus, xhr)
                    {
                        $('#driverPushForm')[0].reset();
                        $('#driversList').empty();
                        $('.selectedDriversList').empty();

                        if (xhr.status == 200)
                        {
                            $('.close').trigger('click');
                            refreshContent(url);//Load datatable
                        } else
                            alert('Error..! while sending a push');
                    },error: function (jqXHR, textStatus, errorThrown) {
                            if (jqXHR.status == 500) {
                                alert('Internal error: ' + jqXHR.responseText);
                            } else {
                                alert('Unexpected error.');
                            }
                        }
                });


            }
        });


        

        // *******store***********
             //Customer click of push notification
        $('#submitPushStore').click(function () {
           //alert('store');
            $('.error-box').text('');
//           
            getSendPushTopic=[];
            var topicType = $('input:radio.pushNotificationStore:checked').attr('data-id');

            var pType=$('input[name=storenormalNotification]:checked').val();
             
             if(pType==7){
              var  pushType=1;
             }else{
              var  pushType=2;
             }

            if (topicType == '2' && $('.allStoreCities:checked').length == 0)
                $('#pushNotificationCustomer_cityErr').text('Please choose the store');
            else if (topicType == '4' && $('.allStoreZones:checked').length == 0)
                $('#pushNotificationCustomer_zoneErr').text('Please choose zones');
            else if ($('#pushTitleStore').val() == '')
                $('#pushTitleCustomerErr').text('Please enter the title');
            else if ($('#pushMessageStore').val() == '')
                $('#pushMessageCustomerErr').text('Please enter the message');
            else {

                var ids = $('.allCustomerStore:checked').map(function () {
                    return this.value;
                }).get();


                switch (parseInt(topicType)) {
                    case 1:
                        $('.checkboxStore').each(function () {

                            if ($(this).is(':checked'))
                            {
                                if ($(this).attr('pushtopic') != 'undefined' && $(this).attr('pushtopic') != '')
                                {
                                    if (getSendPushTopic == '')
                                        getSendPushTopic += $(this).attr('pushtopic');
                                    else
                                        getSendPushTopic += ',' + $(this).attr('pushtopic');
                                }
                            }
                        });
                        break;
                    case 2:
                        $('.allStoreCities').each(function () {
                            if ($(this).is(':checked'))
                            {
                                if (getSendPushTopic == '')
                                    getSendPushTopic += $(this).val();
                                else
                                    getSendPushTopic += ',' + $(this).val();
                            }
                        });
                        break;
                    case 3:
                        $('.allStoreCities').each(function () {
                            if (getSendPushTopic == '')
                                getSendPushTopic += $(this).val();
                            else
                                getSendPushTopic += ',' + $(this).val();
                        });
                        break;
                    case 4:
                        $('.allStoreZones').each(function () {
                            if ($(this).is(':checked'))
                            {
                                if (getSendPushTopic == '')
                                    getSendPushTopic += $(this).val();
                                else
                                    getSendPushTopic += ',' + $(this).val();
                            }
                        });
                        break;
                    case 5:

                        $('.allStoreZones').each(function () {

                            if (getSendPushTopic == '')
                                getSendPushTopic += $(this).val();
                            else
                                getSendPushTopic += ',' + $(this).val();
                        });
                        break;

                }

                switch (parseInt(topicType)) {
                    case 1:
                        storePushTopicType = 1;
                        break;
                    case 2:
                        storePushTopicType = 2;
                        break;
                    case 3:
                        storePushTopicType = 2;
                        break;
                    case 4:
                        storePushTopicType = 3;
                        break;
                    case 5:
                        storePushTopicType = 3;
                        break;

                }

                url = $('li.tabs_active.active').children("a").attr('data');

                var longitude=$('#storeentiryLongitude').val();
                var latitude=$('#storeentiryLatitude').val();
                var imageUrl=$('#storeimagesProductImg').val();
                var knowMoreUrl="";
                var radiusVal=$('#storeradius').val();

                if(longitude==""){
                    longitude="0"
                }

                if(latitude==""){
                    latitude="0"
                }    

                if(radiusVal==""){
                    var radius="";
                }else{
                    var radius=parseInt($('#storeradius').val());
                }      

              //  var datarel=JSON.stringify({userType: 3, type: pushType, title: $('#pushTitleStore').val(), body: $('#pushMessageStore').val(), topics: getSendPushTopic,longitude:longitude,latitude:latitude,radius:radius,imageUrl:imageUrl,knowMoreUrl:knowMoreUrl });
              
                $.ajax({ 
                    url: '<?php echo sendNotification ?>pushnotificaton/',
                    type: "POST",
                    data:  JSON.stringify({userType: 3, type: pushType,topicType: topicType, title: $('#pushTitleStore').val(), body: $('#pushMessageStore').val(), topics: getSendPushTopic,longitude:longitude,latitude:latitude,radius:radius,imageUrl:imageUrl,knowMoreUrl:knowMoreUrl }),
                    dataType: 'JSON',
                  
                    success: function (json,textStatus, xhr)
                    {
                        if (xhr.status == 200)
                        {
                            $('.close').trigger('click');
                            refreshContent(url);//Load datatable
                        } else
                            alert('Error..! while sending a push');
                    },error: function (jqXHR, textStatus, errorThrown) {
                            if (jqXHR.status == 500) {
                                alert('Internal error: ' + jqXHR.responseText);
                            } else {
                                alert('Unexpected error.');
                            }
                        }
                });


            }
        });
        //*******end store */
    });

    function refreshContent(tabURL) {

        var table = $('#big_table');
        table.hide();

        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": tabURL,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    table.show()


                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback
                            });
                }
            };

            table.dataTable(settings);

        }, 1000);
    }


      function isNumberKey(evt)
    {
        // chnag
        var regex = new RegExp("^[0-9.]");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }

       $(document).ready(function () {
        //    cities
		$.ajax({
                url: "<?php echo base_url(); ?>index.php?/Orders/getCities",
                type: "POST",
                data: {},
                dataType: "JSON",
                
                success: function (result) {
                     $('#cityFilter').empty();
                     $('#customercityFilter').empty();
                     $('#storecityFilter').empty();
                     
                   
                    if(result.data){
                         
                          var html5 = '';
				   var html5 = '<option cityName="" value="" >Select city</option>';
                          $.each(result.data, function (index, row) {
                              
                               html5 += '<option value="'+row.cityId.$oid+'" cityName="'+row.cityName+'">'+row.cityName+'</option>';

                             
                          });
                            $('#cityFilter').append(html5); 
                            $('#customercityFilter').append(html5); 
                            $('#storecityFilter').append(html5); 

                    }

                     
                }
            });


            // driver city filter
             $('#cityFilter').on('change', function () {

                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/business/getZones",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            val: $('#cityFilter').val()
                        },
                    }).done(function (json) {
                        console.log(json);
                        
                    $('#driversZones').empty();

                    var zonelist=json.data;
                    html = '';
                    $.each(zonelist, function (i, row)
                    {

                        html += '<label for="' + row.id + '">';
                        html += '<input type="checkbox" class="allDriverZones" id="' + row.id + '" name="zones[]" zoneName="' + row.title + '"   value="' + row.id + '"/>' + row.title;
                        html += ' </label>';
                    });
                    $('#driversZones').css('display', 'block');
                    $('#driversZones').append(html);

                    });

        });

        //customer city filter
             $('#customercityFilter').on('change', function () {

                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/business/getZones",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            val: $('#customercityFilter').val()
                        },
                    }).done(function (json) {
                        console.log(json);
                        
                    $('#customerZones').empty();

                    var zonelist=json.data;
                    html = '';
                    $.each(zonelist, function (i, row)
                    {

                        html += '<label for="' + row.id + '">';
                        html += '<input type="checkbox" class="allCustomerZones" id="' + row.id + '" name="zones[]" zoneName="' + row.title + '"   value="' + row.id + '"/>' + row.title;
                        html += ' </label>';
                    });
                    $('#customerZones').css('display', 'block');
                    $('#customerZones').append(html);


                    // $.each(response.areaZones, function (i, row)
                    // {

                    //     html += '<label for="' + row._id.$oid + '">';
                    //     html += '<input type="checkbox" class="allCustomerZones" id="' + row._id.$oid + '" name="zones[]" zoneName="' + row.title + '"   value="' + row._id.$oid + '"/>' + row.title;
                    //     html += ' </label>';
                    // });
                    // $('#customerZones').css('display', 'block');
                    // $('#customerZones').append(html);

                    });

        });

        
        //store city filter
             $('#storecityFilter').on('change', function () {

                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/business/getZones",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            val: $('#storecityFilter').val()
                        },
                    }).done(function (json) {
                        console.log(json);
                        
                    $('#storeZones').empty();

                    var zonelist=json.data;
                    html = '';
                    $.each(zonelist, function (i, row)
                    {

                        html += '<label for="' + row.id + '">';
                        html += '<input type="checkbox" class="allStoreZones" id="' + row.id + '" name="zones[]" zoneName="' + row.title + '"   value="' + row.id + '"/>' + row.title;
                        html += ' </label>';
                    });
                    $('#storeZones').css('display', 'block');
                    $('#storeZones').append(html);

                    });

                    // html = '';
                    // $.each(response.areaZones, function (i, row)
                    // {

                    //     html += '<label for="' + row._id.$oid + '">';
                    //     html += '<input type="checkbox" class="allStoreZones" id="' + row._id.$oid + '" name="zones[]" zoneName="' + row.title + '"   value="' + row._id.$oid + '"/>' + row.title;
                    //     html += ' </label>';
                    // });
                    // $('#storeZones').css('display', 'block');
                    // $('#storeZones').append(html);

        });



    });

       

</script>
<script>
    var addressType = '';
    function callMap() {
        $('#mapentityAddress').val('');
        $('#mapBtnDataId').val($('#mapbtn1').attr("data-id"));
        $('#ForMaps').modal('show');
        addressType = 1;
        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
            $('#latitude').val($('#entiryLatitude').val());
            $('#longitude').val($('#entiryLongitude').val());
            initialize1($('#entiryLatitude').val(), $('#entiryLongitude').val());
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
    function callMap1() {
        $('#mapentityAddress').val('');
        $('#mapBtnDataId').val($('#mapbtn2').attr("data-id"));
        $('#ForMaps').modal('show');
        addressType = 2;
        if ($('#entityAddress_01').val() != "") {
            $('#mapentityAddress').val($('#entityAddress_01').val());
            $.ajax({
                url: "<?php echo base_url(); ?>application/views/get_latlong.php",
                method: "POST",
                data: {Address: $('#mapentityAddress').val()},
                datatype: 'json', // fix: need to append your data to the call
                success: function (data) {
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
        //console.log("Test");
        $('#mapBtnDataId').val('');
        $('#ForMaps').modal('hide');
    }

    function Take() {
        if (addressType == 1) {
            $('#entiryLongitude').val($('#longitude').val());
            $('#entiryLatitude').val($('#latitude').val());
            $('.entityAddress').val($('#mapentityAddress').val());
        } else if (addressType == 2) {
            $('#entityAddress_01').val($('#mapentityAddress').val());
        }
        $('#mapBtnDataId').val('');
        $('#ForMaps').modal('hide');
    }

    function initialize1(lat, long, from) {

        console.log('initialise here');
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
                        $('#entiryLongitude').val(marker.getPosition().lng());
                        $('#entiryLatitude').val(marker.getPosition().lat());
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

        console.log('getAddLatlang 1772');

        var addr = $('#entityAddress_0').val();
        if (!addr) {
            var addr = text;
        }
        console.log('-----');
        console.log(addr);
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                console.log('data----',data);
                if (Arr.flag == 1) {
                    $('#entiryLatitude').val(Arr.Lat);
                    $('#entiryLongitude').val(Arr.Long);
                    initialize1(Arr.Lat, Arr.Long, '0');
                }
            }
        });
    }

    // customer
    function getAddLatLongcustomer(text) {

        console.log('getAddLatlang cust');

        var addr = $('#customerentityAddress_0').val();
        if (!addr) {
            var addr = text;
        }
        console.log('-----');
        console.log(addr);
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                console.log('data----',data);
                if (Arr.flag == 1) {
                    $('#customerentiryLatitude').val(Arr.Lat);
                    $('#customerentiryLongitude').val(Arr.Long);
                    initialize1(Arr.Lat, Arr.Long, '0');
                }
            }
        });
    }


    // store

    function getAddLatLongstore(text) {

        console.log('getAddLatlang store');

        var addr = $('#storeentityAddress_0').val();
        if (!addr) {
            var addr = text;
        }
        console.log('-----');
        console.log(addr);
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                console.log('data----',data);
                if (Arr.flag == 1) {
                    $('#storeentiryLatitude').val(Arr.Lat);
                    $('#storeentiryLongitude').val(Arr.Long);
                    initialize1(Arr.Lat, Arr.Long, '0');
                }
            }
        });
    }

    function getAddLatLong() {
        console.log('clicked1');
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
        console.log('init');
        var id = '';

        // autocomplete
        var input = document.getElementById('entityAddress_0');
        // var input = document.getElementById('customerentityAddress_0');
        // var input = document.getElementById('storeentityAddress_0');

        var options = {componentRestrictions: {country: 'us'}};

        var autocomplete = new google.maps.places.Autocomplete(input);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            
            document.getElementById('entiryLatitude').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude').value = place.geometry.location.lng();
            //initialize(place.geometry.location.lat(), place.geometry.location.lng(), '0');
            $('#longitude').val(place.geometry.location.lng());
            $('#latitude').val(place.geometry.location.lat());
            getAddLatLong1(place.formatted_address);
        });

        var input0 = document.getElementById('customerentityAddress_0');
        var autocomplete0 = new google.maps.places.Autocomplete(input0);
        google.maps.event.addListener(autocomplete0, 'place_changed', function () {
            var place = autocomplete0.getPlace();

            document.getElementById('customerentiryLatitude').value = place.geometry.location.lat();
            document.getElementById('customerentiryLongitude').value = place.geometry.location.lng();

            getAddLatLongcustomer(place.formatted_address);
        });

        var input1 = document.getElementById('storeentityAddress_0');
        var autocomplete1 = new google.maps.places.Autocomplete(input1);
        google.maps.event.addListener(autocomplete1, 'place_changed', function () {
            var place = autocomplete1.getPlace();
            //getAddLatLong2(place.formatted_address);
            document.getElementById('storeentiryLatitude').value = place.geometry.location.lat();
            document.getElementById('storeentiryLongitude').value = place.geometry.location.lng();
            getAddLatLongstore(place.formatted_address);
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);


</script>

<script>
         $(document).on('change', '.catImage', function () {
            
           var fieldID = 0;
           var ext = $(this).val().split('.').pop().toLowerCase();
           var formElement = $(this).prop('files')[0];
           uploadImage(fieldID, ext, formElement);
       })

        $(document).on('change', '.customercatImage', function () {
            
            var fieldID = 1;
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
            uploadImage(fieldID, ext, formElement);
        })

         $(document).on('change', '.storecatImage', function () {
            
            var fieldID = 2;
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
            uploadImage(fieldID, ext, formElement);
        })

         function uploadImage(fieldID, ext, formElement)
        {
            if ($.inArray(ext, ['jpg', 'JPEG','png','PNG']) == -1) {
              alert("please upload .jpg image")
            } else
            {
                var form_data = new FormData();
                var amazonPath = " http://s3.amazonaws.com"
                var file_data = formElement;
                var fileName = file_data.name;
                form_data.append('OtherPhoto', file_data);
                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image');
                form_data.append('folder', 'first_level_category');
                
                $(document).ajaxStart(function () {
                    if(fieldID < 3)
                    $("#insert").prop("disabled",true)
                    else
                    $("#editbusiness").prop("disabled",true)
                  
                });

                $.ajax({
                    url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",
                    beforeSend: function () {
                    },
                    success: function (result) {
                        console.log('pas1');
                        if(fieldID == 0){
                           
                           $("#imagesProductImg").val(result.fileName) 
                           $(".imagesProduct").attr('src',result.fileName)
                           $(".imagesProduct").css('display','inline'); 
                        }else  if(fieldID == 1){
                            
                           $("#customerimagesProductImg").val(result.fileName) 
                           $(".customerimagesProduct").attr('src',result.fileName)
                           $(".customerimagesProduct").css('display','inline'); 
                        }else  if(fieldID == 2){
                            
                            $("#storeimagesProductImg").val(result.fileName) 
                            $(".storeimagesProduct").attr('src',result.fileName)
                            $(".storeimagesProduct").css('display','inline'); 
                         }
                        
                       
                        $(document).ajaxComplete(function () {
                            if(fieldID < 3)
                            $("#insert").prop("disabled",false)
                            else
                            $("#editbusiness").prop("disabled",false)
                       
                        });
                        

                    },
                    error: function () {

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
    }

</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">

            <strong><?= strtoupper($this->lang->line('sendnotifications')); ?></strong><!-- id="define_page"-->
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
                        <li id= "1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Sendnotification/datatable_getPushDetails/2" data-id="1"><span><?= strtoupper($this->lang->line('driver')); ?></span></a>
                        </li>
                        <li id= "2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/Sendnotification/datatable_getPushDetails/1" data-id="2"><span><?= strtoupper($this->lang->line('customer')); ?></span></a>
                        </li>
                        <!-- <li id= "3" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/Sendnotification/datatable_getPushDetails/3" data-id="3"><span><?= strtoupper($this->lang->line('store')); ?></span></a>
                        </li> -->

                        <div class="pull-right cls111" style="margin-right: 10px;">
                            <button class="btn btn-primary sendPush"  style="margin-top:5px">Send</button>
                        </div>
                        <div class="pull-right cls111">
                            <button class="btn btn-primary sendPushCustomers"  style="margin-top:5px;display:none;">Send</button>
                        </div>
                        <div class="pull-right cls111">
                            <button class="btn btn-primary sendPushStore"  style="margin-top:5px;display:none;">Send</button>
                        </div>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <!--<div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>-->
                                    <div class="cs-loader">
                                        <div class="cs-loader-inner" >
                                            <label class="loaderPoint" style="color:#10cfbd">●</label>
                                            <label class="loaderPoint" style="color:red">●</label>
                                            <label class="loaderPoint" style="color:#FFD119">●</label>
                                            <label class="loaderPoint" style="color:#4d90fe">●</label>
                                            <label class="loaderPoint" style="color:palevioletred">●</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php
                            echo $this->table->generate();
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade stick-up" id="sendPushPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?= strtoupper($this->lang->line('sendpush')); ?></span>
            </div>
            <br>
            <div class="modal-body">
                <form id="driverPushForm" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

                    <!-- push notification type -->

                    <div class="form-group">

                            <div class="col-sm-3">
                                <label for="address">
                                Notification Type<span style="" class="MandatoryMarker"> *</span>
                                    </label>
                            </div>                           
                           
                            <div class="col-sm-3">
                                <label for="topic_normalNotification">
                                    <input type="radio"  name="notificationType" id="normalNotification"  data-id="7" value="7" checked/><span >Push notification</span>
                                </label>
                            </div>

                            <div class="col-sm-3" style="display: none;">
                                <label for="topic_richNotification">
                                    <input type="radio"  name="notificationType" id="richNotification" data-id="8"   value="8"/><span >Rich push notification</span>
                                </label>                        
                            </div>                                                 
                       
                      </div>


                    <!-- first column -->
                     <div class="form-group">

                            <div class="col-sm-3">
                                <label for="address">
                                <?= ucfirst($this->lang->line('topic')); ?><span style="" class="MandatoryMarker"> *</span>
                                    </label>
                            </div>                           
                           
                            <div class="col-sm-2">
                                <label for="topic_individual">
                                    <input type="radio" class="pushNotification" name="driverPushTopic" id="topic_individual"  data-id="1" value="1" checked/><span class="span_topic"><?= ucfirst($this->lang->line('individual')); ?></span>
                                </label>
                            </div>

                            <div class="col-sm-2">
                                <label for="topic_city">
                                    <input type="radio" class="pushNotification" name="driverPushTopic" id="topic_city" data-id="2"   value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('city')); ?></span>
                                </label>                        
                            </div>

                            <div class="col-sm-2">
                                <label for="topic_allCitiesDrivers">
                                    <input type="radio" class="pushNotification" name="driverPushTopic" data-id="3" id="topic_allCitiesDrivers" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('allcities')); ?></span>
                                </label>                        
                            </div>                         
                       
                      </div>

                       <!-- second column -->
                     <div class="form-group">

                            <div class="col-sm-3"></div>

                            <div class="col-sm-2">
                                <label for="topic_ZoneDrivers">
                                    <input type="radio" class="pushNotification" name="driverPushTopic" data-id="4" id="topic_ZoneDrivers" value="3"/><span class="span_topic">Zone</span>
                                </label>
                            </div>

                            <div class="col-sm-2">
                                <label for="topic_allZoneDrivers">
                                    <input type="radio" class="pushNotification" name="driverPushTopic" data-id="5" id="topic_allZoneDrivers" value="3"/><span class="span_topic">All Zone</span>
                                </label>                  
                            </div>

                            <div class="col-sm-2">
                                 <label for="topic_allZoneDrivers">
                                    <input type="radio" class="pushNotification" name="driverPushTopic" data-id="6" id="topic_radius" value="3"/><span class="span_topic">Radius</span>
                                </label>                       
                            </div>                         
                       
                      </div>

                    <!-- commented -->

                    <!-- <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('topic')); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6 row">
                            <label for="topic_individual">
                                <input type="radio" class="pushNotification" name="driverPushTopic" id="topic_individual"  data-id="1" value="1" checked/><span class="span_topic"><?= ucfirst($this->lang->line('individual')); ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">
                            <label for="topic_city">
                                <input type="radio" class="pushNotification" name="driverPushTopic" id="topic_city" data-id="2"   value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('city')); ?></span>
                            </label>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">

                            <label for="topic_allCitiesDrivers">
                                <input type="radio" class="pushNotification" name="driverPushTopic" data-id="3" id="topic_allCitiesDrivers" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('allcities')); ?></span>
                            </label>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">

                            <label for="topic_ZoneDrivers">
                                <input type="radio" class="pushNotification" name="driverPushTopic" data-id="4" id="topic_ZoneDrivers" value="3"/><span class="span_topic">Zone</span>
                            </label>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">

                            <label for="topic_allZoneDrivers">
                                <input type="radio" class="pushNotification" name="driverPushTopic" data-id="5" id="topic_allZoneDrivers" value="3"/><span class="span_topic">All Zone</span>
                            </label>

                        </div>
                    </div> -->

                    <!-- commented -->
                    <div class="form-group driversSerachBoxDiv">
                        <label for="fname" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('searchdrivers')); ?></label>
                        <div class="col-sm-6">
                            <input class="form-control" id="searchDrivers" name="searchDrivers" placeholder="Search..">
                        </div>

                    </div>
                    <div class="form-group driverSelectionDiv" style="display: none;">
                        <label for="fname" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="multiselect">
                                <div class="selectBox " onclick="showDriversCheckboxes()">
                                    <select class="form-control" style="display: none;">
                                        <option>Select</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="driversList" style="overflow-x: scroll;max-height: 125px;margin-top: -10px;"></div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group driverSelectionDiv">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="selectedDriversList" style="border-style:groove;min-height:70px;padding: 6px; height: auto;" ></div>
                        </div>
                    </div>
                    <div class="form-group pushNotification_cityDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label">City<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <div class="multiselect">
                                <div class="selectBox " onclick="showCheckboxes()">
                                    <select class="form-control" style="display: none;">
                                        <option>Select</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="checkboxes" style="overflow-x: scroll;max-height: 125px;"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushNotification_cityErr"></div>
                    </div>

                    <div class="form-group pushNotification_cityDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="selectedCitiesList" style="border-style:groove;min-height:70px;padding: 6px; height: auto;" ></div>
                        </div>
                    </div>

                     <div class="form-group" class="formex" id="cityZonefilter" style="display:none">
                        <label for="fname" class="col-sm-3 control-label">Select City<span style="" class="MandatoryMarker"> </span></label>
                        <div class="col-sm-6">
                           
                                <select class="form-control pull-left" id="cityFilter">
                            
                                </select> 
                           
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushMessageErr"></div>
                    </div>

                    <div class="form-group pushNotification_zonesDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label">Zone<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <div class="multiselect">
                                <div class="selectBox " onclick="showCheckboxes()">
                                    <select class="form-control" style="display: none;">
                                        <option>Select</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="driversZones" style="overflow-x: scroll;max-height: 125px;"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushNotification_zonesErr"></div>
                    </div>

                    <div class="form-group pushNotification_zonesDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="selectedDriverZonesList" style="border-style:groove;min-height:70px;padding: 6px; height: auto;" ></div>
                        </div>
                    </div>


                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('title')); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <textarea cols="10" rows="5" class="form-control" id="pushTitle" name="pushTitle"></textarea>
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('message')); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="pushMessage" name="pushMessage"></textarea>
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushMessageErr"></div>
                    </div>

                <!-- driver  -->
                    <div id="radiusDiv" style="display:none">

                    <!-- map start -->
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-3 control-label">Address<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                <textarea class="form-control entityAddress error-box-class" id="entityAddress_0" placeholder="Address" name="Address" autocomplete="new-entityAddress_0" aria-required="true"  onkeyup="getAddLatLong1(this)" style="max-width: 100%;"></textarea>
                                </div>
                                
                                <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                            </div>
                            <input type="hidden" class="form-control" id="entiryLongitude" value='' placeholder="0.00" name="longitude"  aria-required="true" >
                            <input type="hidden" class="form-control" id="entiryLatitude" value='' placeholder="0.00" name="latitude"  aria-required="true">

                        <!-- map end -->
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-3 control-label">Radius<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                <input type="text"   id="radius" name="radiusr"  class="form-control error-box-class" onkeypress="return isNumberKey(event)">
                                </div>
                                <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                            </div>                          

                    </div>

                     <div class="form-group" class="formex" id="imageDiv" style="display:none">
                                <label for="fname" class="col-sm-3 control-label">Image<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class catImage"  name="cat_photos" id="cat_photos"  placeholder="">
                                </div>
                        <input type="hidden" id="imagesProductImg" value="">
                        <img src="" style="width: 35px; height: 35px; display: none;" class="imagesProduct style_prevu_kit">
                               
                                <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                    </div>
                </form>
            </div>

            <br>
            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-success pull-right" id="submitPushDriver"><?= ucfirst($this->lang->line('send')); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="sendPushCustomerPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?= strtoupper($this->lang->line('sendpushcustomer')); ?></span>
            </div>
            <br>
            <div class="modal-body">
                <form id="customerPushForm" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

                 <!-- push notification type -->

                    <div class="form-group">

                            <div class="col-sm-3">
                                <label for="address">
                                Notification Type<span style="" class="MandatoryMarker"> *</span>
                                    </label>
                            </div>                           
                           
                            <div class="col-sm-3">
                                <label for="topic_normalNotification">
                                    <input type="radio"  name="customernotificationType" id="customernormalNotification"  data-id="7" value="7" checked/><span >Push notification</span>
                                </label>
                            </div>

                            <div class="col-sm-3" style="display: none;">
                                <label for="topic_richNotification">
                                    <input type="radio"  name="customernotificationType" id="customerrichNotification" data-id="8"   value="8"/><span >Rich push notification</span>
                                </label>                        
                            </div>                                                 
                       
                      </div>


                    <!-- first column -->
                     <div class="form-group">

                            <div class="col-sm-3">
                                <label for="address">
                                <?= ucfirst($this->lang->line('topic')); ?><span style="" class="MandatoryMarker"> *</span>
                                    </label>
                            </div>                           
                           
                            <div class="col-sm-2">
                                <label for="topic_individual">
                                    <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" id="customer_topic_individual"  data-id="1" value="1" checked/><span class="span_topic"><?= ucfirst($this->lang->line('individual')); ?></span>
                                </label>
                            </div>

                            <div class="col-sm-2">
                                <label for="topic_city">
                                <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" id="customer_topic_city" data-id="2" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('city')); ?></span>
                                </label>                        
                            </div>

                            <div class="col-sm-2">
                                <label for="topic_allCitiesDrivers">
                                <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" data-id="3" id="customer_topic_allCities" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('allcities')); ?></span>
                                </label>                        
                            </div>                         
                       
                      </div>

                       <!-- second column -->
                     <div class="form-group">

                            <div class="col-sm-3"></div>

                            <div class="col-sm-2">
                                <label for="topic_ZoneDrivers">
                                <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" data-id="4" id="customer_topic_zone" value="3"/><span class="span_topic"><?= ucfirst($this->lang->line('zone')); ?></span>
                                </label>
                            </div>

                            <div class="col-sm-2">
                                <label for="topic_allZoneDrivers">
                                <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" data-id="5" id="customer_topic_allZone" value="3"/><span class="span_topic"><?= ucfirst($this->lang->line('allZone')); ?></span>
                                </label>                  
                            </div>

                            <div class="col-sm-2">
                                 <label for="topic_allZoneDrivers">
                                 <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" data-id="6" id="customer_topic_radius" value="3"/><span class="span_topic">Radius</span>
                                 

                                </label>                       
                            </div>                         
                       
                      </div>

                      <!-- commented -->

                    <!-- <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('topic')); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6 row">
                            <label for="customer_topic_individual">
                                <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" id="customer_topic_individual"  data-id="1" value="1" checked/><span class="span_topic"><?= ucfirst($this->lang->line('individual')); ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">
                            <label for="customer_topic_city">
                                <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" id="customer_topic_city" data-id="2" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('city')); ?></span>
                            </label>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">

                            <label for="customer_topic_allCities">
                                <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" data-id="3" id="customer_topic_allCities" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('allcities')); ?></span>
                            </label>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">

                            <label for="customer_topic_zone">
                                <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" data-id="4" id="customer_topic_zone" value="3"/><span class="span_topic"><?= ucfirst($this->lang->line('zone')); ?></span>
                            </label>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">

                            <label for="customer_topic_allZone">
                                <input type="radio" class="pushNotificationCustomers" name="customerPushTopic" data-id="5" id="customer_topic_allZone" value="3"/><span class="span_topic"><?= ucfirst($this->lang->line('allZone')); ?></span>
                            </label>

                        </div>
                    </div> -->
                    <!-- commented end -->

                    <div class="form-group customersSerachBoxDiv">
                        <label for="fname" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('searchcustomer')); ?></label>
                        <div class="col-sm-6">
                            <input class="form-control" id="searchCustomers" name="searchCustomers" placeholder="Search..">
                        </div>

                    </div>
                    <div class="form-group customerSelectionDiv" style="display: none;">
                        <label for="fname" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="multiselect">
                                <div class="selectBox " onclick="showCustomersCheckboxes()">
                                    <select class="form-control"  style="display: none;">
                                        <option>Select</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="customersList" style="overflow-x: scroll;max-height: 125px;margin-top: -10px;"></div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group customerSelectionDiv">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="selectedCustomersList" style="border-style:groove;min-height:70px;padding: 6px; height: auto;" ></div>
                        </div>
                    </div>
                    <div class="form-group pushNotificationCustomers_cityDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label">City<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <div class="multiselect">
                                <div class="selectBox " onclick="showCheckboxes1()">
                                    <select class="form-control"  style="display: none;">
                                        <option>Select</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="customerCities" style="overflow-x: scroll;max-height: 125px;"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 error-box" id="pushNotificationCustomer_cityErr"></div>
                    </div>
                    <div class="form-group pushNotificationCustomers_cityDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="selectedCustomerCitiesList" style="border-style:groove;min-height:70px;padding: 6px; height: auto;" ></div>
                        </div>
                    </div>

                     <div class="form-group" class="formex" id="customercityZonefilter" style="display:none" >
                        <label for="fname" class="col-sm-3 control-label">Select City<span style="" class="MandatoryMarker"> </span></label>
                        <div class="col-sm-6">
                           
                                <select class="form-control pull-left" id="customercityFilter">
                            
                                </select> 
                           
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushMessageErr"></div>
                    </div>

                    <!--All Zones-->
                    <div class="form-group pushNotificationCustomers_ZonesDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label">Zones<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <div class="multiselect">
                                <div class="selectBox " onclick="showCheckboxes2()">
                                    <select class="form-control"  style="display: none;">
                                        <option>Select</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="customerZones" style="overflow-x: scroll;max-height: 125px;"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 error-box" id="pushNotificationCustomer_zoneErr"></div>
                    </div>

                    <div class="form-group pushNotificationCustomers_ZonesDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="selectedCustomerZonesList" style="border-style:groove;min-height:70px;padding: 6px; height: auto;" ></div>
                        </div>
                    </div>


                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('title')); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="pushTitleCustomer" name="pushTitleCustomer"></textarea>
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushTitleCustomerErr"></div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('message')); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="pushMessageCustomer" name="pushMessageCustomer"></textarea>
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushMessageCustomerErr"></div>
                    </div>

                     <div id="customerradiusDiv" style="display:none" >
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-3 control-label">Address<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                <textarea class="form-control customerentityAddress error-box-class" id="customerentityAddress_0" placeholder="Address" name="Address" autocomplete="new-entityAddress_0" aria-required="true"  onkeyup="getAddLatLongcustomer(this)" style="max-width: 100%;"></textarea>
                                </div>
                              
                                <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                            </div>
                            <input type="hidden" class="form-control" id="customerentiryLongitude" value='' placeholder="0.00" name="customerlongitude"  aria-required="true" >
                            <input type="hidden" class="form-control" id="customerentiryLatitude" value='' placeholder="0.00" name="customerlatitude"  aria-required="true">

                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-3 control-label">Radius<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                <input type="text"   id="customerradius" name="customerradiusr"  class="form-control error-box-class" onkeypress="return isNumberKey(event)">
                                </div>
                                <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                            </div>                          

                    </div>

                     <div class="form-group" class="formex" id="customerimageDiv" style="display:none" >
                                <label for="fname" class="col-sm-3 control-label">Image<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class customercatImage"  name="customercat_photos" id="customercat_photos"  placeholder="">
                                </div>
                        <input type="hidden" id="customerimagesProductImg" value="">
                        <img src="" style="width: 35px; height: 35px; display: none;" class="customerimagesProduct style_prevu_kit">
                               
                                <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                    </div>

                </form>
            </div>

            <br>
            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-success pull-right" id="submitPushCustomer"><?= ucfirst($this->lang->line('send')); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--********** store************  -->
<div class="modal fade stick-up" id="sendPushStorePopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?= strtoupper($this->lang->line('sendpushstore')); ?></span>
            </div>
            <br>
            <div class="modal-body">
                <form id="storePushForm" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">



                 <!-- push notification type -->

                    <div class="form-group">

                            <div class="col-sm-3">
                                <label for="address">
                                Notification Type<span style="" class="MandatoryMarker"> *</span>
                                    </label>
                            </div>                           
                           
                            <div class="col-sm-3">
                                <label for="topic_normalNotification">
                                    <input type="radio"  name="storenotificationType" id="storenormalNotification"  data-id="7" value="7" checked/><span >Push notification</span>
                                </label>
                            </div>

                            <div class="col-sm-3">
                                <label for="topic_richNotification">
                                    <input type="radio"  name="storenotificationType" id="storerichNotification" data-id="8"   value="8"/><span >Rich push notification</span>
                                </label>                        
                            </div>                                                 
                       
                      </div>


                    <!-- first column -->
                     <div class="form-group">

                            <div class="col-sm-3">
                                <label for="address">
                                <?= ucfirst($this->lang->line('topic')); ?><span style="" class="MandatoryMarker"> *</span>
                                    </label>
                            </div>                           
                           
                            <div class="col-sm-2">
                                <label for="topic_individual">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" id="store_topic_individual"  data-id="1" value="1" checked/><span class="span_topic"><?= ucfirst($this->lang->line('individual')); ?></span>
                                </label>
                            </div>

                            <div class="col-sm-2">
                                <label for="topic_city">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" id="sustomer_topic_city" data-id="2" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('city')); ?></span>
                                </label>                        
                            </div>

                            <div class="col-sm-2">
                                <label for="topic_allCitiesDrivers">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" data-id="3" id="store_topic_allCities" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('allcities')); ?></span>
                                </label>                        
                            </div>                         
                       
                      </div>

                       <!-- second column -->
                     <div class="form-group">

                            <div class="col-sm-3"></div>

                            <div class="col-sm-2">
                                <label for="topic_ZoneDrivers">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" data-id="4" id="store_topic_zone" value="3"/><span class="span_topic"><?= ucfirst($this->lang->line('zone')); ?></span>
                                </label>
                            </div>

                            <div class="col-sm-2">
                                <label for="topic_allZoneDrivers">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" data-id="5" id="store_topic_allZone" value="3"/><span class="span_topic"><?= ucfirst($this->lang->line('allZone')); ?></span>
                                </label>                  
                            </div>

                            <div class="col-sm-2">
                                 <label for="topic_allZoneDrivers">
                                 <input type="radio" class="pushNotificationStore" name="storePushTopic" data-id="6" id="store_topic_radius" value="3"/><span class="span_topic">Radius</span>
                                 

                                </label>                       
                            </div>                         
                       
                      </div>

                      <!-- commented -->

                    <!-- <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('topic')); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6 row">
                            <label for="customer_topic_individual">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" id="store_topic_individual"  data-id="1" value="1" checked/><span class="span_topic"><?= ucfirst($this->lang->line('individual')); ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">
                            <label for="customer_topic_city">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" id="sustomer_topic_city" data-id="2" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('city')); ?></span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">

                            <label for="customer_topic_allCities">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" data-id="3" id="store_topic_allCities" value="2"/><span class="span_topic"><?= ucfirst($this->lang->line('allcities')); ?></span>
                            </label>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">

                            <label for="customer_topic_zone">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" data-id="4" id="store_topic_zone" value="3"/><span class="span_topic"><?= ucfirst($this->lang->line('zone')); ?></span>
                            </label>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6 row">

                            <label for="customer_topic_allZone">
                                <input type="radio" class="pushNotificationStore" name="storePushTopic" data-id="5" id="store_topic_allZone" value="3"/><span class="span_topic"><?= ucfirst($this->lang->line('allZone')); ?></span>
                            </label>

                        </div>
                    </div> -->

                    <!-- commented end -->

                    <div class="form-group storeSerachBoxDiv">
                        <label for="fname" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('searchstore')); ?></label>
                        <div class="col-sm-6">
                            <input class="form-control" id="searchStore" name="searchStore" placeholder="Search..">
                        </div>

                    </div>
                    <div class="form-group storeSelectionDiv" style="display: none;">
                        <label for="fname" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="multiselect">
                                <div class="selectBox " onclick="showStoreCheckboxes()">
                                    <select class="form-control"  style="display: none;">
                                        <option>Select</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="storeList" style="overflow-x: scroll;max-height: 125px;margin-top: -10px;"></div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group storeSelectionDiv">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="selectedStoreList" style="border-style:groove;min-height:70px;padding: 6px; height: auto;" ></div>
                        </div>
                    </div>
                    <div class="form-group pushNotificationStore_cityDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label">City<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <div class="multiselect">
                                <div class="selectBox " onclick="showCheckboxes1()">
                                    <select class="form-control"  style="display: none;">
                                        <option>Select</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="storeCities" style="overflow-x: scroll;max-height: 125px;"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 error-box" id="pushNotificationCustomer_cityErr"></div>
                    </div>
                    <div class="form-group pushNotificationStore_cityDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="selectedStoreCitiesList" style="border-style:groove;min-height:70px;padding: 6px; height: auto;" ></div>
                        </div>
                    </div>

                     <div class="form-group" class="formex" id="storecityZonefilter" style="display:none" >
                        <label for="fname" class="col-sm-3 control-label">Select City<span style="" class="MandatoryMarker"> </span></label>
                        <div class="col-sm-6">
                           
                                <select class="form-control pull-left" id="storecityFilter">
                            
                                </select> 
                           
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushMessageErr"></div>
                    </div>


                    <!--All Zones-->
                    <div class="form-group pushNotificationStore_ZonesDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label">Zones<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <div class="multiselect">
                                <div class="selectBox " onclick="showCheckboxes2()">
                                    <select class="form-control"  style="display: none;">
                                        <option>Select</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="storeZones" style="overflow-x: scroll;max-height: 125px;"></div>
                            </div>
                        </div>
                        <div class="col-sm-3 error-box" id="pushNotificationCustomer_zoneErr"></div>
                    </div>
                    <div class="form-group pushNotificationStore_ZonesDiv" style="display: none;">
                        <label for="address" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="selectedStoreZonesList" style="border-style:groove;min-height:70px;padding: 6px; height: auto;" ></div>
                        </div>
                    </div>


                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('title')); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="pushTitleStore" name="pushTitleStore"></textarea>
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushTitleCustomerErr"></div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?= ucfirst($this->lang->line('message')); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="pushMessageStore" name="pushMessageStore"></textarea>
                        </div>
                        <div class="col-sm-3 error-box errors" id="pushMessageCustomerErr"></div>
                    </div>

                     <div id="storeradiusDiv" style="display:none" >
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-3 control-label">Address<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                <textarea class="form-control entityAddress error-box-class" id="storeentityAddress_0" placeholder="Address" name="Address" autocomplete="new-entityAddress_0" aria-required="true"  onkeyup="getAddLatLongstore(this)" style="max-width: 100%;"></textarea>
                                </div>
                              
                                <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                            </div>
                            <input type="hidden" class="form-control" id="storeentiryLongitude" value='' placeholder="0.00" name="longitude"  aria-required="true" >
                            <input type="hidden" class="form-control" id="storeentiryLatitude" value='' placeholder="0.00" name="latitude"  aria-required="true">

                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-3 control-label">Radius<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                <input type="text"   id="storeradius" name="storeradiusr"  class="form-control error-box-class" onkeypress="return isNumberKey(event)">
                                </div>
                                <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                            </div>                          

                    </div>

                     <div class="form-group" class="formex" id="storeimageDiv" style="display:none" >
                                <label for="fname" class="col-sm-3 control-label">Image<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class storecatImage"  name="storecat_photos" id="storecat_photos"  placeholder="">
                                </div>
                        <input type="hidden" id="storeimagesProductImg" value="">
                        <img src="" style="width: 35px; height: 35px; display: none;" class="storeimagesProduct style_prevu_kit">
                               
                                <div class="col-sm-3 error-box errors" id="pushTitleErr"></div>
                    </div>

                </form>
            </div>

            <br>
            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-success pull-right" id="submitPushStore"><?= ucfirst($this->lang->line('send')); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- store end -->




