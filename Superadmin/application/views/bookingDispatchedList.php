
<script>
    $(document).ready(function () {
        
        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_bookingDispatchedList/'+<?php echo $orderID;?>,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "columns": [
                   
                    null,
                    null,
                    null,
                    null,
                    null
                ],
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

    });

</script>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


         <ul class="breadcrumb" style="margin-top: 5%;">
            <li>
                <a href="<?php echo base_url() ?>index.php?/superadmin/unassignedBookings" class="active">DISPATCHED DRIVER LIST</a>
            </li>
            <li>
                <a href="#" class="active">BOOKING ID- <?php echo $orderID;?></a>
            </li>
        </ul>
       

        <ul class="nav nav-tabs nav-tabs-simple bg-white ">

            <div class="pull-right" style="margin-right: 1.3%;"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>" area-controls="big_table"> </div>


        </ul>


        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
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



                            </div>
                            &nbsp;
                            <div class="panel-body">

<?php
echo $this->table->generate();
//                                     
?>

                            </div>
                        </div>
                        <!-- END PANEL -->
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


