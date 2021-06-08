<!--start of map script-->
<style>

    .dispatcher{

    }
    .nav-tabs-fillup li{
        display: none;
    }
    .header{
        display: none;

    }

/*    html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow: hidden;
    }*/

    #map-canvas {
        margin: 0;
        padding: 0;
        height: 750px;
        border: 1px solid #ccc;
        width: 100%;
        /*display: none;*/

    }

    #headerpart{
        display: none;
    }
    .nav-tabs-fillup li {
        margin-top: 0px !important;
    }
    .datepicker{z-index:1151 !important;}
    #map_canvas {display:none;}

</style>

<link rel="stylesheet" href="http://css-spinners.com/css/spinner/whirly.css" type="text/css">
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>


<script src="http://ubilabs.github.io/geocomplete/jquery.geocomplete.js"></script>

<!---->

<script type="text/javascript">

    $(document).ready(function(){



        initialize('1',"");
        $('.close_quick').click(function(){
            $('#quickview').hide();
        });

        $('#selected_option').change(function(){

            initialize($(this).val());

        });

        var active = "display_left";

        $('#arrow').click(function () {
            $('#display_left').animate({"margin-top": '-551px'});
            $(this).css('display','none');
            $('#arrowdown').show();

        });

        $('#arrowdown').click(function () {

            $('#display_left').animate({"margin-top": '0px'});
            $(this).css('display','none');
            $('#arrow').show();
        });



        $('.whirly-loader').hide();

        $("#resize").click(function() {
//            alert('testing');
            google.maps.event.trigger(map, 'resize');
        });

        $('#userstatus').hide();

        $('.nav-tabs-fillup').click(function(){


            if($('#apbkg').hasClass('active')){
                $('#circle').hide();

            }
            else{
                $('#circle').show();

            }

//                 $('#circle').show();


        });


//        displayMap();

        var table = $('#tableWithSearchDriver');

        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "sPaginationType": "bootstrap",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 11
        };

        table.dataTable(settings);


        $('#search-tableDriver').keyup(function() {
            table.fnFilter($(this).val());
        });



        $('#search-tableclient').keyup(function() {
            tableclient.fnFilter($(this).val());
        });

        var tableclient = $('#tableWithSearchClient');
        tableclient.dataTable(settings);

        var tablewithdriverlist = $('#tableWithSearchDriverList');

        tablewithdriverlist.dataTable(settings);

        $('.tableWithSearchDriverListsearch').keyup(function() {
            tablewithdriverlist.fnFilter($(this).val());
        });





    });






var map;



var marker;

var customerlat = '13.0288555';
var customerlong = '77.58961360000001';

navigator.geolocation.getCurrentPosition(GetLocation);
function GetLocation(location) {
    customerlat = location.coords.latitude;
customerlong = location.coords.longitude;

}

//var customerlat = customerlat;
var type_id = '0';

var masters_id_globle={};
var masters_marker = {};
var icon = "http://107.170.66.211/roadyo_live/Wko8TuOH/icons/indica_green.png";
var globleset_status_id = '';
var interval;

function initialize(slectedval,type_id) {

    var myLatlng = new google.maps.LatLng(customerlat,customerlong);
    var mapOptions = {
        zoom:10,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

    marker = new google.maps.Marker({
        animation: google.maps.Animation.DROP,
        position: myLatlng,
        map: map,
        icon: '<?php echo base_url()?>theme/assets/img/locatin-arrow.gif',
        optimized: false
    });


    $.ajax({
        type: "post",
        url: "<?php echo base_url()?>index.php?/superadmin/get_vehicle_type",
        data: {pic_lat : customerlat, pic_long : customerlong},
        dataType: "json",
        success: function (result) {
            var code = '<option value="">ALL</option>';
            $.each(result,function(index,row){
                code +="<option value="+row.type_id+">"+row.type_name+"</option>";

            });
            $('#vehicle_type').html(code);
            $('#vehicle_type').val(type_id);
        }

    });

    $.ajax({
        type: "POST",
        url: "<?php echo  base_url("index.php?/superadmin/getDtiversArround")?>",
        data: {
            lattitude: customerlat, longitude: customerlong,selected:slectedval,type_id:type_id
        },
        dataType: 'json',
        success: function (response) {

            if (response.result.length > 0) {

                $('#test').html(response.result);
//                if (response.result[0].id != '')
//                    sample(response.result[0].id);


                $.each(response.result, function (index, row) {


                    var pos = new google.maps.LatLng(row.lat, row.lon);

                    marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        icon: row.icon
                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        var driverId = row.id;
                        sample(driverId);
                    });

                    masters_id_globle[row.id] = row.id;
                    masters_marker[row.id + '_marker'] = marker;

                });
            }

            call_function_after(masters_id_globle,slectedval,type_id);

        }
        
    });




}

function call_function_after(masters_id,slectedval,type_id){


    interval = window.setInterval(function () {
        $.ajax({
            type: "POST",
            url: "<?php echo  base_url("index.php?/superadmin/refreshMap")?>",
            data: {lattitude: customerlat, longitude: customerlong,ids:masters_id,selected:slectedval,type_id:type_id},
            dataType: "JSON",
            success: function (res) {
                var o = res.online;

                var data = res.master_data;

                if(data != null)
                    var newData = Object.keys(data).map(function(k) { return data[k] });

                if(res.online != null)
                    var arr = $.map(o, function(el) { return el; });
                
//                alert('ads'+newData.masters_id[key].lat);

                for(var key in masters_id)
                {
                    if(!arr){
                        masters_marker[masters_id[key]+'_marker'].setVisible(false);
                    }
                    else if(arr.indexOf(masters_id[key]) != -1)
                    {
//                        alert('ads'+masters_id[key]);
//                        alert(res.master_data[masters_id[key]].lat);
                        var pos = new google.maps.LatLng(res.master_data[masters_id[key]].lat,res.master_data[masters_id[key]].lon);
                        masters_marker[masters_id[key]+'_marker'].setVisible(true);
                        masters_marker[masters_id[key]+'_marker'].setPosition(pos);

                    }else{
                        masters_marker[masters_id[key]+'_marker'].setVisible(false);
                    }

                }

                var masters = $.map(masters_id, function(el) { return el; });
                for(var key in arr)
                {
                    if($.inArray(arr[key], masters) == -1)
                    {

                        var num = arr[key];
                        var marker2 ;
                        for(var i=0;i<=newData.length;i++){
                            if(num == newData[i]['id']){
//                                                alert(newData[i]['lat']+"id"+arr[key]+'lon'+newData[i]['lon']);
                                var pos = new google.maps.LatLng(newData[i]['lat'],newData[i]['lon']);
                                marker2 = new google.maps.Marker({
                                    position: pos,
                                    map: map,
                                    icon:newData[i]['icon']
                                });
                                google.maps.event.addListener(marker2, 'click', function () {
                                    var driverId = arr[key];
                                    sample(driverId);
                                });
                                masters_marker[arr[key]+'_marker'] = marker2;
                                masters_id_globle[arr[key]]=arr[key];

                            }
                        }

                    }

                }



            }
        });
    }, 3000);


}

function toolcliked(val){

    clearInterval(interval);
    var selectd_type = $('#vehicle_type').val();
    globleset_status_id = val; // available or all other
    initialize(val,selectd_type);
    masters_id_globle={};
    masters_marker = {};
    $('#quickview').hide();
}

function on_vehicle_type_change(val){

    clearInterval(interval);
    var selectd_type = val.value;
    initialize(globleset_status_id,selectd_type);
    masters_id_globle={};
    masters_marker = {};
}
 function on_city_change(val){
     customerlat = $(val).children(":selected").attr("lat").trim();
     customerlong = $(val).children(":selected").attr("longt").trim();
     clearInterval(interval);
     var selectd_type = $('#vehicle_type').val();

     initialize(globleset_status_id,selectd_type);
     masters_id_globle={};
     masters_marker = {};


 }

function sample(driverId) {

    $.ajax({
        type: "POST",
        url: "<?php echo  base_url("index.php?/superadmin/getDtiverDetail")?>",
        data: {did: driverId},
        dataType: 'json',
        success: function (response) {


            $('#dynamic_driver_display').html(response.html);


        }
    });
}




</script>


<!--/** end of map script-->


<!--// customer--> 


<script>
    $(document).ready(function(){
        $('.customer').addClass('active');
      });
</script>
<link rel="stylesheet" href="http://www.jacklmoore.com/colorbox/example3/colorbox.css" />
<script src="http://www.jacklmoore.com/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, width:"100%", height:"100%"});
    });
</script>


<div class="tab-pane slide-left" id="slide5">
    <div class="row column-seperation">
        <div class="col-md-12 new-12">



            <div class="container-fluid container-fixed-lg bg-white new-container">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    
                    <!--godzview take place here-->
                    
                    
                    
                    
                    <div class="row">
<div class="col-md-12">
    <div class="col-md-3">
        <div class="col-md-12">
            <label>Cities</label>
            <select  name="cities" id="cities" class="btn btn-success btn-clean" style="border-radius: 7px;border-color:transparent;" onchange="on_city_change(this)">
                <option value="0">Select ...</option>
             <?php sort($cities);
             usort($cities, "my_cmp");

             function my_cmp($a, $b) {
                 if ($a->City_Name == $b->City_Name) {
                     return 0;
                 }
                 return ($a->City_Name < $b->City_Name) ? -1 : 1;
             }

             foreach($cities as $city){

                 echo '<option value="'.$city->City_Id.'" lat="'.$city->City_Lat.'" longt="'.$city->City_Long.'">'.$city->City_Name.'</option>';

             }?>
            </select>

        </div>

    </div>
    <div class="col-md-9">

        <div class="col-md-3">
            <label>Vehicle Type</label>
            <select  name="vehicle_type" id="vehicle_type" class="btn btn-success btn-clean" style="border-radius: 7px;border-color:transparent;" onchange="on_vehicle_type_change(this)">

            </select>

        </div>

        <div class="col-md-9" style="height: 32px;">
            <input type="text" style="background: green;width: 20px;border:none;border-radius: 5px;margin-left: 8px;cursor: pointer" readonly="readonly" onclick="toolcliked(1)"> Available
            <input type="text" style="background: blue;width: 20px;border:none;border-radius: 5px;margin-left: 8px;cursor: pointer" readonly="readonly" onclick="toolcliked(2)"> On the way
            <input type="text" style="background: yellow;width: 20px;border:none;border-radius: 5px;margin-left: 8px;cursor: pointer" readonly="readonly" onclick="toolcliked(3)"> Arrived
            <input type="text" style="background:  #626262;width: 20px;border:none;border-radius: 5px;margin-left: 8px;cursor: pointer" readonly="readonly" onclick="toolcliked(4)">  Loaded & Started
            <input type="text" style="background: red;width: 20px;border:none;border-radius: 5px;margin-left: 8px;cursor: pointer" readonly="readonly" onclick="toolcliked(5)"> Dropped & Unloaded
            
        </div>
    </div>

    <div class="pull-right">
        <div class="btn-group btn-group-vertical" data-toggle="buttons-radio" id="dynamic_driver_display">



        </div>


    </div>

    <div class="whirly-loader" style="margin-left: 50%;z-index: 100;margin-top: 15%;position: absolute;">
        Loading…
    </div>


    <!-- END PANEL -->

</div>





<div id="map-canvas"></div>


































</div>
                    
                    
                    
                    
                    
                    
                    
                    
                    <!--end of godzview-->
                    
                    
                </div>
                <!-- END PANEL -->
            </div>






        </div>

    </div>
</div>


<!--this is the end of customers tab-->



<!--the div which we needs to close is it follows-->
</div>





</div>








</div>




</div>









</div>

