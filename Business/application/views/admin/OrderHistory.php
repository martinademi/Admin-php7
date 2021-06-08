
<?php header('Access-Control-Allow-Origin: *'); ?>
<script>
   

    $(document).ready(function () {

     var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {
            $('#big_table_processing').show();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/Business/datatableOrderHistory/<?php echo $BizId; ?>',
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









 $("#HeaderOrderhistory").addClass("active");




                        $('.HeaderOrderhistory').addClass('active');
//        $('.icon-thumbnail').attr('<?php echo base_url(); ?>assets/dash_board_on.png"');
                        $('.orderhistory_thumb').attr('src', "<?php echo base_url(); ?>assets/icn_orderhistory_on.png");


                        $('#callM').click(function () {

                            $('#NewCat').modal('show');
                        });


                        $(".moveUp").click(function (e) {
                            var event = e || window.event;
                            event.preventDefault();
                            var row = $(this).closest('tr');

//            alert(1);

                            $.ajax({
                                url: "<?PHP echo AjaxUrl; ?>changeProductCatOrder",
                                type: "POST",
                                data: {kliye: 'interchange', curr_id: row.attr('id'), prev_id: row.prev().attr('id'), b_id: '<?php echo $BizId; ?>'},
                                success: function (result) {

                                }
                            });
                            row.prev().insertAfter(row);
                            $('#saveOrder').trigger('click');
                        });

                        $(".moveDown").click(function (e) {
                            var event = e || window.event;
                            event.preventDefault();
                            var row = $(this).closest('tr');
//            alert(row.attr('id'));
//            alert(row.next().attr('id'));
                            $.ajax({
                                url: "<?PHP echo AjaxUrl; ?>changeProductCatOrder",
                                type: "POST",
                                data: {kliye: 'interchange', prev_id: row.attr('id'), curr_id: row.next().attr('id'), b_id: '<?php echo $BizId; ?>'},
                                success: function (result) {

//                    alert("intercange done" + result);

                                }
                            });
                            row.insertAfter(row.next());
                            $('#saveOrder').trigger('click');
                        });




$(document).on('click', '.getDriverDetails', function ()
        {
            $('.dname').text('');
            $('.demail').text('');
            $('.dphone').text('');

            $.ajax({
                url: "<?php echo superadminLink; ?>index.php?/superadmin/getDriverDetails",
                type: "POST",
                data: {mas_id: $(this).attr('mas_id')},
                dataType: 'json',
                success: function (result) {
                    var accoutType = (result.driverData.accountType == 2) ? 'Operator' : 'Freelancer';
                    $('.dprofilePic').attr('src', '');
                    $('.dprofilePic').hide();
                    if (result.driverData.firstName != null)
                    {
                        $('.dname').text(result.driverData.firstName + ' ' + result.driverData.lastName);
                        $('.demail').text(result.driverData.email);
                        $('.dphone').text(result.driverData.countryCode + result.driverData.mobile);
                        $('.dbusinessType').text(accoutType);

//                                        if(result.driverData.image != '')
//                                        {
                        $('.dprofilePic').attr('src', result.driverData.image);
                        $('.dprofilePic').show();
//                                        }
                    }

                    $('#getDriverDetails').modal('show');//Code in footer.php

                }
            });
        });
        $(document).on('click', '.getCustomerDetails', function ()
        {

            $.ajax({
                url: "<?php echo superadminLink; ?>index.php?/superadmin/getCustomerDetails",
                type: "POST",
                data: {slave_id: $(this).attr('slave')},
                dataType: 'json',
                success: function (result) {

                    if (result.driverData.name != null)
                    {
                        $('.sprofilePic').attr('src', '');
                        $('.sprofilePic').hide();
                        $('.sname').text(result.driverData.name);
                        $('.semail').text(result.driverData.email);
                        $('.sphone').text(result.driverData.countryCode + result.driverData.phone);

                        $('.sbusinessName').text('N/A');
                        if (typeof result.driverData.businessName != 'undefined')
                            $('.sbusinessName').text(result.driverData.businessName);

                        $('.sbusinessAddress').text('N/A');
                        if (typeof result.driverData.businessAddress != 'undefined')
                            $('.sbusinessAddress').text(result.driverData.businessAddress);

//                                           if(result.driverData.profile_pic != '')
//                                           {
                        $('.sprofilePic').attr('src', result.driverData.profile_pic);
                        $('.sprofilePic').show();
//                                           }
                    }


                    $('#getCustomerDetails').modal('show');//Code in footer.php

                }
            });
        });


                    });
                    //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

                    function Delservice(thisval) {
                        $('#deletemodal').modal('show');
                        var entityidid = thisval.id;
                        $("#deletelink").attr('href', "<?php echo base_url() ?>index.php/Admin/DeleteProduct/" + entityidid);
                    }

</script>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
             <strong style="color:#0090d9;">ORDER HISTORY</strong>
        </div>
        
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
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
                                   
                                
                                </div>
                                &nbsp;


                                <div class="panel-body">

                                    <?php echo $this->table->generate(); ?>

                                </div>

                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>

    <!-- END FOOTER -->
</div>
    <div class="container-fluid container-fixed-lg footer">
<?PHP include 'FooterPage.php' ?>
    </div>
     <!--END FOOTER--> 
<div class="modal fade" id="getCustomerDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">CUSTOMER DETAILS</strong>
            </div>
            <div class="modal-body">
                <br>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <img src="" class="img-circle sprofilePic style_prevu_kit" alt="pic" style="width: 80px;height:80px;display: none;">
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group row" style="margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="sname"></span>
                            </div>

                        </div>
                        <div class="form-group row" style="margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="semail"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Phone</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="sphone"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Business Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="sbusinessName"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Business Address</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="sbusinessAddress"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

    

<div class="modal fade" id="getDriverDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">DRIVER DETAILS</strong>
            </div>
            <div class="modal-body">
                <br>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-2"><br>
                        <img src="" class="img-circle dprofilePic style_prevu_kit"  alt="pic" style="width:80px;height:80px;display: none;">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="dname"></span>
                            </div>

                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="demail"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Phone</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="dphone"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Business Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="dbusinessType"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


