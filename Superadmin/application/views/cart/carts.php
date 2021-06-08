<!-- 
city = 5
zone = 0
store = 4
franchise = 3
 -->


<style>
  span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .pos_relative2{
        padding-right:10px
    }
    #currencySymbol{
        padding-left: 10px;
    }

    .paging_full_numbers{
        margin-right: 1%;
    }
    .dataTables_info {
        margin-left: 1%;
    }
    .table-responsive{
        overflow-x:hidden;
        overflow-y:hidden;
    }
    .radio input[type=radio], .radio-inline input[type=radio] {
        margin-left: 0px; 
    }
    .lastButton{
        margin-right:1.8%;
    }
    .btn{
        border-radius: 25px !important;
    }
   


    .btncontrols {
        margin: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        color: white;
        background-color: cornflowerblue;
    }

    /*#cities,*/
    #editnow {
        border: 1px solid transparent;
        border-radius: 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        color: white;
        background-color: darkgray;
    }

    .success {
        color: springgreen;
    }

    .error {
        color: red;
    }

    .waitmsg {
        display: inline;
        margin-left: 50%;

    }

    .modal .modal-body p {
        color: aliceblue;
    }

    .displayinline {
        display: inline;
    }


    /*------------for auto complete search box---------------------*/

    .controls {
        margin: 10px 0;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        /*        font-size: 15px;*/
        font-weight: 600;
        /*margin-left: 12px;*/
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        /*width: 300px;*/
        /*border-radius: 5px;*/
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #pac-input1 {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        border-radius: 5px;
    }

    #pac-input1:focus {
        border-color: #4d90fe;
    }


    .pac-container,.select2-drop {
        font-family: Roboto;
        z-index: 99999 !important;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #target {
        width: 345px;
    }

    .header{
        height:60px !important;
    }
    .header h3{
        margin:10px 0 !important;
    }
    .rating>.rated {
        color: #10cfbd;
    }
    .social-user-profile {
        width: 83px;
    }
    td a:before{
        color:transparent;
    }
    /*	.DataTables_sort_wrapper {
        text-align: center;
    }*/
</style>
<!--AIzaSyCNJ9nkXGQumgO3N_uQGaT3pZAbGB8q2vE-->
<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCAnpL4IiJt_jeFspg16XQshxmbnl-zGbU&sensor=false&language=en-AU&libraries=drawing,places"></script>
<!-- <script src="<?php echo base_url() ?>mqttwsCart.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>webSocketCart.js" type="text/javascript"></script> -->

<script>

    function isCharacterKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
//        if (charCode > 31 && (charCode < 41 || charCode > 57)) 
        if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 123) && charCode != 32) {
            return false;
        }
        return true;
    }

    function refreshContent() {

        $('#big_table').hide();
        $('#big_table_processing').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo base_url() ?>index.php?/CartsController/datatable_carts",
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').show();
            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                // csrf protection
                aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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

    }


      $(document).ready(function () {

          $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        var date = new Date();
        $('.datepicker-component').datepicker({
        });
        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
        });


        $('#datepicker-component').on('changeDate', function () {

            $('.datepicker').hide();
        });



      });
     
</script> 

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .pac-container {
        z-index: 1051 !important;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>




<script>

    $(document).ready(function () {
        
        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
            refreshData();
        });
        
        $('#searchData').click(function () {
            if ($("#start").val() && $("#end").val())
            {
                var st = $("#start").datepicker().val();
                var startDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1];
                var end = $("#end").datepicker().val();
                var endDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];
                var table = $('#big_table');
                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/CartsController/datatable_carts/' + startDate + '/' + endDate,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 20,
                    "oLanguage": {
                        "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
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
            } else
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_DRIVERS_DEACTIVAT_DATEOFBOOKING); ?>);
                $("#confirmeds").click(function () {
                    $('.close').trigger('click');
                });
            }
        });
        
        
        
        
        
        
        
        
        
        
        
        
//         client.onMessageArrived = function (message) {
// //               console.log("Msg",message);
//             var topicName = message.destinationName;
//             console.log(topicName);
//             var topic = topicName.split("/");
// //            console.log(topic);
//             console.log(topic[1]);
//             if (topicName == 'cartUpdates/')
//             {
//                 console.log('message', message);
//                  $('#big_table').find('tr:first').find('th:first').trigger('click');
//                 $('#search-table').trigger('keyup');
//             }
//         };
        
         
          $(document).on('click', '.cartDetails', function ()
        {
            var cartId = '';
//            cartId = $(".cartDetails").attr('cartId');
            cartId = $(this).attr('cartId');
        
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/CartsController/getCartDetails/" + cartId,
            type: 'GET',
            dataType: 'json',
            data: {
            },
        })
        .done(function(json) {
            console.log(json);
            if (json.status) {
               $('#cartStore').empty();
                 $.each(json.data, function (index, row){
                     var html ='';
                    html ='<tr><td>'+row.storeName+'</td>'
                          +'<td>'+row.itemName+'</td>'
                          +'<td>'+row.qty+'</td>'
                          +'<td>'+row.unitPrice+'</td>'
                          +'<td>'+row.total+'</td></tr>';
                $('#cartStore').append(html);

            });
            $('#cartDetailsModal').modal('show');
                
            }else{
               
            }
            
        });

        });
          $(document).on('click', '.actionDetails', function ()
        {
            var cartId = '';
            cartId = $(this).attr('cartId');
        
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/CartsController/getActionDetails/" + cartId,
            type: 'GET',
            dataType: 'json',
            data: {
            },
        })
        .done(function(json) {
            console.log(json);
            if (json.status) {
               $('#actionStore').empty();
                 $.each(json.data, function (index, row){
                     var html ='';
                    html ='<tr><td>'+row.storeName+'</td>'
                          +'<td>'+row.itemName+'</td>'
                          +'<td>'+row.qty+'</td>'
                          +'<td>'+row.unitPrice+'</td>'
                          +'<td>'+row.total+'</td>'
                          +'<td>'+row.action+'</td>'
                          +'<td>'+row.timestamp+'</td></tr>';
                $('#actionStore').append(html);

            });
            $('#actionDetailsModal').modal('show');
                
            }else{
               
            }
            
        });

        });
       
        



        $('#clearform').click(function (e) {
            $('#addCityForm')[0].reset();
            $('#cityNameErr').text("");
            $('#currencyNameErr').text("");

        });

        $('.Ok').click(function ()
        {
            var table = $('#big_table');
            $('#big_table').fadeOut('slow');
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo base_url() ?>index.php?/CartsController/datatable_carts",
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
                    $('.cs-loader').hide();

                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    // csrf protection
                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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
        });

    });

</script>

<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                // "scrollX": true,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/CartsController/datatable_carts',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {

                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    // csrf protection
                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('.getCartDetails').click(function(){
            
        });



        // On change of filter
        $("#search_by_select").change(function(){
            var filterValue = $("#search_by_select").val();
             var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                // "scrollX": true,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/CartsController/datatable_carts/' + filterValue,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {

                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    // csrf protection
                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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

        });


    });
    function refreshData(){
     var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                // "scrollX": true,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/CartsController/datatable_carts',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {

                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    // csrf protection
                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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
</script>

<style>
    .exportOptions{
        display: none;
    }
</style>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong>CARTS</strong>

        </div>
        <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
         <div style="margin-left:1.5%;" style="display:none;" class="hide_show">
             <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                          <div class="row clearfix">
<!--                                <div class="col-sm-2">
                                        <div class="form-group ">
                                            <select id="search_by_select" class="form-control"   style="background-color:gainsboro;height:30px;font-size:12px;">
                                                    <option value="" disabled selected>FILTER</option>
                                                    <option value="5">CITY</option>
                                                    <option value="0">ZONES</option>
                                                    <option value="4">STORES</option>
                                                    <option value="3">FRANCHISE</option>
                                                     <option value="10">STATUS</option> 
                                                     <option value="3">FRANCHISE</option> 
                                            </select>
                                            <input type="button" id="callone" style="display: none;"/>
                                        </div>
                                </div>-->

                                <div class="col-sm-3">
                                    <div class="" aria-required="true">

                                        <div class="input-daterange input-group">
                                            <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">

                                        </div>

                                    </div>

                                </div>
                                <div class="col-sm-1" style="margin-right: 15px;">
                                    <!-- <div class=""> -->
                                        <button class="btn btn-primary" type="button" id="searchData">Search</button>
                                    <!-- </div> -->
                                </div>
                                 <div class="col-sm-1" style="margin-right: 15px;">
                                    <!-- <div class=""> -->
                                        <button class="btn btn-info" type="button" id="clearData">Clear</button>
                                    <!-- </div> -->
                                </div>

<!--                                <div class="col-sm-1" style="margin-right: 15px;">
                                    <div class="form-group ">
                                        <button class="btn btn-info" type="submit" style="background-color: #3e4165;border-color:#3e4165" name="" id=""><a style="color: white;" class="exportAccData" href="">Export</a></button>
                                        </div>
                                </div>-->
                            </div>
                           </div>
                           </div>
         </ul>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">


                <div class="panel panel-transparent ">


                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="cs-loader">
                                    <div class="cs-loader-inner" >
                                        <label class="loaderPoint" style="color:#10cfbd">●</label>
                                        <label class="loaderPoint" style="color:red">●</label>
                                        <label class="loaderPoint" style="color:#FFD119">●</label>
                                        <label class="loaderPoint" style="color:#4d90fe">●</label>
                                        <label class="loaderPoint" style="color:palevioletred">●</label>
                                    </div>
                                </div>

                                <div class="pull-right">
                                    <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo $this->lang->line('search'); ?>"/> 

                                </div>
                                &nbsp;
                                <div class="panel-body" style="padding: 0px; margin-top: 2%;">

                                    <?php echo $this->table->generate(); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>
<input type="hidden" id="cityExistsName" name="cityExistsName">

<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset">
            <span class="copy-right"></span>

        </p>

        <div class="clearfix"></div>
    </div>
</div>








<div class="modal fade stick-up" id="deleteModel-cities" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DELETE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <input type="hidden" name="deleteCityID" id="deleteCityID">
                <div class="row">
 
                    <div class="error-box modalPopUpText" id="errorboxdata" ></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <div class="pull-right m-t-10"><button type="button" class="btn btn-danger pull-right" id="confirmed" >Delete</button></div>
                    <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>


                </div>

            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>





<div class="modal fade stick-up" id="cartDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">CART DETAILS</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">STORE NAME</th>
                          <th scope="col">ITEM Name</th>
                          <th scope="col">QUANTITY</th>
                          <th scope="col">UNIT PRICE</th>
                          <th scope="col">TOTAL</th>
                        </tr>
                      </thead>
                      <tbody id="cartStore">
                        
                        
                      </tbody>
                    </table>
                   
                </div>
            </div>

            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="actionDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">ACTION DETAILS</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">STORE NAME</th>
                          <th scope="col">ITEM Name</th>
                          <th scope="col">QUANTITY</th>
                          <th scope="col">UNIT PRICE</th>
                          <th scope="col">TOTAL</th>
                          <th scope="col">ACTION</th>
                          <th scope="col">ACTION TIME</th>
                        </tr>
                      </thead>
                      <tbody id="actionStore">
                        
                        
                      </tbody>
                    </table>
                   
                </div>
            </div>

            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="deletePopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">DELETE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="errorbox" >Do you want to delete city/cities..?</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="deleteCity" >Delete</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="cityExistsPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">ALERT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="errorbox ">This city already exists!!</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">OK</button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">ALERT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="errorbox " >Please select atleast one city..!!</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">OK</button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="errorModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">ALERT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="errorbox1 " >Invalid Selection</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">OK</button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="cartModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">Details</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>






