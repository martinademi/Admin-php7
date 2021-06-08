<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    .txtaln{padding-top: 13px;}
</style>
<script>
    $(document).ready(function () {
        $("#define_page").html("Driver Review");
        $('.driver_review').addClass('active');

        $('#searchData').click(function () {
            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

            $('#createcontrollerurl').attr('href', '<?php echo base_url() ?>index.php?/parametersController/Get_dataformdate/' + st + '/' + end);

        });

        $('#search_by_select').change(function () {
            $('#atag').attr('href', '<?php echo base_url() ?>index.php?/parametersController/search_by_select/' + $('#search_by_select').val());
            $("#callone").trigger("click");
        });

        var table = $('#tableWithSearch1');

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "sPaginationType": "bootstrap",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 20,
            "order": [[0, "desc"]]
        };

        table.dataTable(settings);

        $('#search-table1').keyup(function () {
            table.fnFilter($(this).val());
        });

        $("#active").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 0)
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
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_PASSENGERS_ACTIVATE); ?>);

                $("#confirmeds").click(function () {
                    {
                        $.ajax({
                            url: "<?php echo base_url('index.php?/parametersController') ?>/activedriver_review",
                            type: "POST",
                            data: {val: val},
                            dataType: 'json',
                            success: function (result)
                            {

                                $('.checkbox:checked').each(function (i) {
                                    $(this).closest('tr').remove();
                                });
                                $(".close").trigger('click');
                            }
                        });
                    }

                });

            } else
            {
                $("#displayData").modal("show");

                //      alert("select atleast one passenger");
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERREVIEW_ATLEAST); ?>);
            }

        });
        $(document).on('click', '.getDriverDetails', function ()
        {
            $('.dname').text('');
            $('.demail').text('');
            $('.dphone').text('');

            $.ajax({
                url: "<?php echo base_url('index.php?/parametersController') ?>/getDriverDetails",
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
                        $('.dprofilePic').attr('src', result.driverData.image);
                        $('.dprofilePic').show();

                    }


                    $('#getDriverDetails').modal('show');

                }
            });
        });
        $(document).on('click', '.getCustomerDetails', function ()
        {

            $.ajax({
                url: "<?php echo base_url('index.php?/parametersController') ?>/getCustomerDetails",
                type: "POST",
                data: {slave_id: $(this).attr('slave')},
                dataType: 'json',
                success: function (result) {
                    if (result.driverData.name != null)
                    {
                        $('.sprofilePic').attr('src', '');
                        $('.sname').text(result.driverData.name);
                        $('.semail').text(result.driverData.email);
                        $('.sphone').text(result.driverData.countryCode + result.driverData.phone);
                        $('.sprofilePic').attr('src', result.driverData.profile_pic);
                        $('.sprofilePic').show();
                    }

                    $('#getCustomerDetails').modal('show');

                }
            });
        });

    });

</script>


<script type="text/javascript">
    $(document).ready(function () {

        var status = '<?php echo $status; ?>';

        if (status == 1) {
            $('#inactive').show();
            $('#active').hide();
            $("#display-data").text("");
        }


        $('#big_table_processing').show();

        var table = $('#big_table');

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url(); ?>index.php?/parametersController/datatable_orderreviewdetails/<?php echo $storeId; ?>',
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
<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <!-- <div class="brand inline" style="  width: auto;color:#0090d9;margin-left: 30px;padding-top: 20px;">
            <strong><a href="<?php echo base_url(); ?>index.php?/parametersController/order_review/1">STORE REVIEW & RATING</a> => </strong>
            <strong><a href="#">STORE REVIEW DETAILS</a> </strong>
        </div> -->

        
        <div class="brand inline" style="  width: auto; margin-top: 60px;">
            <strong style="font-size: 12px;margin-left: 15px;">STORE REVIEW & RATING</strong>
        </div>

        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent ">


                <div class="pull-left col-sm-6" >

                    <div class="">
                        <ul class="breadcrumb" style="background:white;margin-top: 0%;">
                            <li><a class="active" href="<?php echo base_url() ?>index.php?/parametersController/order_review/1" class="">Driver Review & Details</a> </li>
                            <li><a class="active" href="#" class=""><?php echo $storeName;?></a> </li>
                        </ul>
                    </div>
                </div>

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>
                                    <div class="dltbtn">


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

</div>
