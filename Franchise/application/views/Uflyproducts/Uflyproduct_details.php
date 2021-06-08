<?php
date_default_timezone_set('UTC');
$rupee = "$";
error_reporting(0);

if ($status == 5) {
    $vehicle_status = 'New';
    $new = "active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
} else if ($status == 2) {
    $vehicle_status = 'Accepted';
    $accept = "active";
} else if ($status == 4) {
    $vehicle_status = 'Rejected';
    $reject = 'active';
} else if ($status == 2) {
    $vehicle_status = 'Free';
    $free = 'active';
} else if ($status == 1) {

    $active = 'active';
}
?>

<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    .btn {
    border-radius: 25px !important;
}
</style>
<script>


    var countryArray = [];
    function LoadCities()
    {
        var country = $("#countryid option:selected").val();


        $.ajax({
            url: "<?php echo base_url('index.php?/superadmin') ?>/showAvailableCities",
            type: "POST",
            data: {country: country},
            dataType: 'JSON',
            success: function (response)
            {

//                alert(JSON.stringify(response));
//                $("#selectedcity").html('');
////
//
//                var i = 0;
//                alert(response.length);
//                
//                for (i = 0; i <= 500; i++) {
//
//                    $("#selectedcity").append("<option value=" + response[i].City_Id + ">" + response[i].City_Name + "</option>");
//
//                }

                $.each(response, function (key, value)
                {
//                    var regex = new RegExp("/^" + $('#search-box').val() + "/");
//                    if (regex.match(value.City_Name)) {
                    var city = {label: value.City_Name, id: value.City_Id};
                    countryArray.push(city);
//                    }
//                    countryArray.push(value.City_Name);
//                    $("#selectedcity").append("<option value=" + value.City_Id + ">" + value.City_Name + "</option>");
                });

                $("#search-box").autocomplete({
                    source: countryArray,
                    select: function (event, ui) {

                        $('#search-box-hidden').val(ui.item.id);


                    }
                });
            }
        });
    }
</script>



<script>




    $(document).ready(function () {



        $('.compaigns').addClass('active');
        $('.compaigns').attr('src', "<?php echo base_url(); ?>/theme/icon/campaigns_on.png");
        $('.compaigns_thumb').addClass("bg-success");

        $('#latitudeedit').keypress(function (event) {
            if (event.which < 46
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46
                    && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot
        });

        $('#longitudeedit').keypress(function (event) {
            if (event.which < 46
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46
                    && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot
        });


        $('#latitude').keypress(function (event) {
            if (event.which < 46
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46
                    && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot
        });

        $('#longitude').keypress(function (event) {
            if (event.which < 46
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46
                    && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot
        });



        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });







        $('#btnStickUpSizeToggler').click(function () {
            $("#display-data").text("");
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModal');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#myModal').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
        });



        $('#editcitypage').click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                //     alert("please select any one city");
                $("#display-data").text(<?php echo json_encode(POPUP_CITY_ANYONE); ?>);
            } else if (val.length > 1) {

                //       alert("please select only one city to edit");
                $("#display-data").text(<?php echo json_encode(POPUP_CITY_ONLYONE); ?>);
            }
            else {

//                if (confirm("Are you sure to Edit this city"))
//                {

//                    alert('lat:' + $('.checkbox:checked').parent().siblings('td.latitude').text());
//                alert('lat:' + $('.checkbox:checked').closest('tr').find('.latitide').text());

                var size = $('input[name=stickup_toggler]:checked').val();
                var modalElem = $('#myanotherModal');
//                $('#latitudeedit').val($('.checkbox:checked').closest('tr').find('.latitide').text());
//                $('#longitudeedit').val($('.checkbox:checked').closest('tr').find('.longitude').text());
                $('#latitudeedit').val($('.checkbox:checked').parent().prev().prev().text());
                $('#longitudeedit').val($('.checkbox:checked').parent().prev().text());

                if (size == "mini") {

                    $('#modalStickUpSmall').modal('show')

                }
                else
                {
                    $('#myanotherModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
//                }

            }
        });





        $("#insert").click(function () {

            $("#addcity").text("");

            var coun = $("#countryid").val();
            var city = $("#search-box-hidden").val();
            var latitude = $("#latitude").val();
            var longitude = $("#longitude").val();
            var reg = /[0-9]+[.[0-9]+]?/;     //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;

            if (coun == "0") {
//                alert("please select country");
                $("#addcity").text(<?php echo json_encode(POPUP_SELECT_COUNTRY); ?>);
            }
            else if (city == "" || city == null) {
                $("#addcity").text(<?php echo json_encode(POPUP_SELECT_CITY); ?>);
            }
            else if (latitude == "" || latitude == null)
            {
//                alert("please enter the latitude");
                $("#addcity").text(<?php echo json_encode(POPUP_CITY_LAT); ?>);
            }
            else if (!reg.test(latitude))
            {
//                alert("please enter valid data");
                $("#addcity").text(<?php echo json_encode(POPUP_CITY_LATVAL); ?>);
            }
            else if (longitude == "" || longitude == null)
            {
//                alert("please enter the longitude");
                $("#addcity").text(<?php echo json_encode(POPUP_CITY_LOT); ?>);
            }
            else if (!reg.test(longitude))
            {
//                alert("please enter valid data");
                $("#addcity").text(<?php echo json_encode(POPUP_CITY_LONVAL); ?>);
            }
            else
            {



                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/insertcities",
                    type: 'POST',
                    data: {
                        country: coun,
                        city: city,
                        lat: latitude,
                        lng: longitude
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {

                        $(".close").trigger("click");
//                        

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

                        $("#confirmeds").hide();

                        if (response.flag == '0') {
                            $('#errorboxdatas').text(response.msg);
                            $("#countryid").val("");
                            $("#search-box-hidden").val("");
                            $("#latitude").val("");
                            $("#longitude").val("");

                        } else if (response.flag == '1') {
                            $('#errorboxdatas').text(response.msg);
//                            $("#errorboxdatas").text(<?php echo json_encode(POPUP_LAT_LONG_ADDED); ?>);

//                            $(".close").trigger("click");
                        }
                        //     alert(response.msg);

                        var table = $('#big_table');


                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": "<?php echo base_url() ?>index.php?/superadmin/datatable_promodetails",
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            
                            "oLanguage": {
                                "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                            },
                            "fnInitComplete": function () {
                                //oTable.fnAdjustColumnSizing();

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

                        // search box for table
                        $('#search-table').keyup(function () {
                            table.fnFilter($(this).val());
                        });

                    }

                });
            }

        });



        $("#insertlonlat").click(function () {
            $("#longlat").text("");
            var val = $('.checkbox:checked').val();

//        var table = $('#big_table').DataTable();




            var lat = $("#latitudeedit").val();
            var lon = $("#longitudeedit").val();
            var reg = /[0-9]+[.[0-9]+]?/;


            if (lat == "" || lat == null)
            {
//                alert("please enter the latitude");
                $("#longlat").text(<?php echo json_encode(POPUP_CITY_LAT); ?>);
            }
            else if (!reg.test(lat))
            {
//                alert("please enter valid data at latitude");
                $("#longlat").text(<?php echo json_encode(POPUP_CITY_LATVAL); ?>);

            }
            else if (lon == "" || lon == null)
            {
//                alert("please enter the longitude");
                $("#longlat").text(<?php echo json_encode(POPUP_CITY_LOT); ?>);
            }
            else if (!reg.test(lon))
            {
//                alert("please enter valid data at longitude");
                $("#longlat").text(<?php echo json_encode(POPUP_CITY_LONVAL); ?>);
            }
            else
            {





                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/editlonglat",
                    type: 'POST',
                    data: {
                        val: val,
                        lat: lat,
                        lon: lon
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        //  alert("completed");

                        $(".close").trigger("click");
//                        

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

                        $("#errorboxdatas").text(<?php echo json_encode(POPUP_LAT_LONG_UPDATED); ?>);
                        $("#confirmeds").hide();
//                        $("#errorboxdatas").text(<?php echo json_encode(POPUP_LAT_LONG_UPDATED); ?>);
//                         $("#confirmeds").hide();



                    }

                });
            }



        });
        $('.changeMode').click(function () {

            var table = $('#big_table');


            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo base_url() ?>index.php?/superadmin/datatable_promodetails",
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();

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
                },
            };

//            $('.tabs_active').removeClass('active');
//
//            $(this).parent().addClass('active');



            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

        });








        $("#chekdel").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).
                    get();
            if (val.length > 0)
            {
                //  if (confirm("Are you sure to Delete " + val.length + " cities")) {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdata").text(<?php echo json_encode(CITY_DELETE); ?>);

                $("#confirmed").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deletecities",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {

                            $(".close").trigger("click");

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });


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
                            if (result.flag == '1') {
                                $("#errorboxdatas").text(result.msg);

                            }
                            else if (result.flag == '0') {
                                $("#errorboxdatas").text(result.msg);
                            }
                            $("#confirmeds").hide();
                        }
                    });
                });

            }
            else
            {
//                alert("select atleast one city");
                $("#display-data").text(<?php echo json_encode(POPUP_CITY_ATLEAST); ?>);
            }

        });


    });










</script>

<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#big_table');

        $('#big_table_processing').show();
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_promodetails',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                $('#big_table_processing').hide();
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

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

    });
</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="jumbotron" data-pages="parallax">

            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="margin-left: 20px;">
                    <li><a href="<?php echo base_url('index.php?/superadmin') ?>/compaigns/2" class=""><?php echo LIST_COMPAIGNS; ?></a>
                    </li>
                    <li ><a href="#" class="active">PROMO DETAILS</a>
                    </li>

                </ul>
                <!-- END BREADCRUMB -->
            </div>
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">





                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup  bg-white">

                        <li class="active" style="cursor:pointer">
                            <a  data = "<?php echo base_url(); ?>index.php?/superadmin/promo_details"><span><?php echo LIST_OF_PROMOTION_ANALYTICS; ?></span></a>
                        </li>

<!--                        <div class="pull-right m-t-10"><a href="<?php echo base_url() ?>index.php?/superadmin/addnewcity"> <button class="btn btn-primary btn-cons"><span><?php echo BUTTON_CITIES; ?></button></a></div>
                        <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler"><span><?php echo BUTTON_ADD_NEW; ?></button></a></div>-->
<!--                        <button class="btn btn-green btn-lg pull-right" id="btnStickUpSizeToggler" style="background-color:#10CFBD;line-height:14px"><?php echo BUTTON_ADD_NEW; ?></button></div>-->


                    </ul>
                    <!-- Tab panes -->

                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="error-box" id="display-data" style="text-align:center"></div>
                                <!--<div id="big_table_processing" class="dataTables_processing" style=""><img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif"></div>-->


                                <div class="pull-right m-t-10" class="btn-group" style="margin-left: 5px">


                                    <!--
                                                                    <div class="pull-right m-t-10" class="btn-group" style="margin-left: 5px">
                                                                        <button type="button" class="btn btn-success" id="chekdel"><i class="fa fa-trash-o"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="pull-right m-t-10" class="btn-group" style="margin-left: 5px">
                                                                        <button class="btn btn-green btn-lg pull-right" id="editcitypage"   style="line-height: 14px;color: #ffffff !important;margin-right: 2px;background-color: #10cfbd;" class="btn btn-success"  >
                                                                            <i class="fa fa-pencil"></i>
                                                                        </button>
                                                                    </div>-->


                                    <div class="m-t-10 pull-right" class="btn-group searchbtn" style="margin-left: 5px">


                                        <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?>"/> 


                                    </div>
                                    <!--<div class=" m-t-10 error-box"  style="margin-left: 5px;text-align:center" id="display-data"></div>-->




                                </div>
                                &nbsp;
                                <div class="panel-body">


                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer tableWithSearch_referels" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">
                                                <thead>

                                                    <tr role="row">
                                                        <th  rowspan="2" class="sorting_asc " tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"> INVOICE VALUE</th>
                                                        <th  rowspan="2" class="sorting_asc " tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"> DISCOUNT</th>
                                                        <th  rowspan="2" class="sorting_asc " tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px">  VALUE AFTER DISCOUNT</th>
                                                        <th  rowspan="2" class="sorting_asc " tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"> USED ON</th>
                                                        <th  rowspan="2" class="sorting_asc " tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"> BOOKING ID</th>
                                                        <th  rowspan="2" class="sorting_asc " tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"> CUSTOMER ID</th>
                                                        <th  rowspan="2" class="sorting_asc " tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px">CUSTOMER EMAIL</th>
                                                    </tr>

                                                </thead>
                                                <tbody>

                                                    <?php
                                                    
//                                                    $bookingid = $promo_details[0]['bookings'][0]['booking_id'];
//                                                    $bookingid = $promo_details[0]['bookings'][0]['slave_id'];
//                                                    $bookingid = $promo_details[0]['bookings'][0]['email'];
//                                                    $bookingid = $promo_details[0]['bookings'][0]['booking_id'];
                                                    
                                                    
                                                    foreach($promo_details as $data){ ?>
                                                    
                                                    <tr role="row"  class="gradeA odd">
                                                        <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $currency_details." ".$data['sub_total']; ?></p></td>
                                                        <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $currency_details." ". $data['discount'] ?></p></td>
                                                        <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $currency_details." ".$data['amount'] ?></p></td>
                                                        <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $data['appointment_dt']; ?></p></td>
                                                        <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $data['appointment_id'] ?></p></td>
                                                        <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $data['slave_id'] ?></p></td>
                                                        <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $data['email'] ?></p></td>
                                                        <!--<td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $data['email'] ?></p></td>-->
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>


                                            <div class="row"></div>

                                        </div>
                                    </div>

                                </div>
                            </div>



                        </div>
                    </div>





                </div>

            </div>
            <!-- END PANEL -->
        </div>
    </div>


    <div class="container-fluid container-fixed-lg footer">
        <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
                <span class="hint-text">Copyright @ 3Embed software technologies, All rights reserved</span>

            </p>

            <div class="clearfix"></div>
        </div>
    </div>










    <div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-header">

                        <div class=" clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>

                        </div>
                        <h3> <?php echo SELECT_COUNTRY_ANDCITY; ?></h3>
                    </div>

                    <br>
                    <br>

                    <div class="modal-body">

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label" ><?php echo FIELD_CITIES_COUNTRY; ?><span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">

                                <select id="countryid" name="country_select"  class="form-control error-box-class" onchange="LoadCities()">
                                    <option value="0">Select Country</option>
                                    <?php
                                    foreach ($country as $result) {

                                        echo "<option value=" . $result->Country_Id . ">" . $result->Country_Name . "</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="form-group" class="formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_VEHICLE_SELECTCITY; ?><span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="search-box"  placeholder="City Name" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>
                                    <input type="hidden" id="search-box-hidden" class="form-control error-box-class" />
                                    <div id="suggesstion-box"></div>
                                </div>
                            </div>
                        </div>
                        <!--                    <div class="form-group" class="formex">
                                                <label for="fname" class="col-sm-4 control-label">Select city</label>
                                                <div class="col-sm-6">
                        
                                                    <select id="selectedcity" name="city_select"  class="form-control" >
                        
                                                    </select>
                                                </div>
                                            </div>-->

                        <br>
                        <br>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label">    <?php echo FIELD_VEHICLETYPE_LATITUDE; ?><span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="latitude" name="latitude"  class="form-control error-box-class" placeholder="eg:234.3432">
                            </div>
                        </div>

                        <br>
                        <br>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label"> <?php echo FIELD_VEHICLETYPE_LONGITUDE; ?><span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="longitude" name="longitude" class="form-control error-box-class" placeholder="eg:3632.465">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-4" ></div>
                            <div class="col-sm-4 error-box" id="addcity"></div>
                            <div class="col-sm-4" >
                                <button type="button" class="btn btn-primary pull-right" id="insert" ><?php echo BUTTON_ADD; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
        </button>
    </div>


    <div class="modal fade stick-up" id="myanotherModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-header">

                        <div class=" clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>

                        </div>
                        <h3> <?php echo LIST_CITY_TABLE_EDITCITIESGEO ?> </h3>
                    </div>
                    <br>
                    <br>


                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_VEHICLETYPE_LATITUDE; ?></label>
                        <div class="col-sm-6">
                            <input type="text"  id="latitudeedit" name="latitude"  class="form-control error-box-class" placeholder="eg:234.3432">
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_VEHICLETYPE_LONGITUDE; ?></label>
                        <div class="col-sm-6">
                            <input type="text"  id="longitudeedit" name="longitude" class="form-control error-box-class" placeholder="eg:3632.465">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4 error-box" id="longlat" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right changeMode" id="insertlonlat" ><?php echo BUTTON_SUBMIT ?></button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



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

                        <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

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
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
