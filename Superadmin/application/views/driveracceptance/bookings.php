<style>
    .tooltip > .tooltip-inner {background-color:#50606C;}
</style>
<script>
    var type =  "<?php echo $type;?>";
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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/DriverAcceptanceController/datatable_bookingDetails/<?php echo $type;?>/<?php echo $driverID;?>',
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
        
         $('#big_table').on('init.dt', function () {

            switch (type) {
                case 'acceptedBookings':
                    $('#big_table').dataTable().fnSetColumnVis([5,6,7], false);
                    break;
                case 'rejectedBookings':
                    $('#big_table').dataTable().fnSetColumnVis([4,6,7], false);
                    break;
                case 'cancelledBookings':
                    $('#big_table').dataTable().fnSetColumnVis([4,5,7], false);
                    break;
                case 'ignoredBookings':
                    $('#big_table').dataTable().fnSetColumnVis([4,5,6], false);
                    break;
              
            }
        });

    });
</script>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">
         
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url('index.php?/DriverAcceptanceController') ?>" class="">DRIVER ACCEPTANCE RATE</a>
            </li>

            <li><a href="#" class="active"><?php echo $driverData['firstName'].' '.$driverData['lastName'];?></a>
            </li>
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
                </div></div></div>
        <div class="container-fluid container-fixed-lg">

        </div>
    </div>

</div> 

