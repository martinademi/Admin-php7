
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .imageborder{
        border-radius: 50%;
    }
    .btn{
        border-radius: 25px !important;
    }


    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>


<script type="text/javascript">
    $(document).ready(function () {
        var status = '<?php echo $status; ?>';

        if (status == 3) {
            $('#inactive').show();
            $('#active').hide();
            $('#btnStickUpSizeToggler').show();
            $("#display-data").text("");
        }

        $('.whenclicked li').click(function () {
            // alert($(this).attr('id'));
            if ($(this).attr('id') == 3) {
                $('#inactive').show();
                $('#active').hide();
                $('#btnStickUpSizeToggler').show();
                $("#display-data").text("");

            } else if ($(this).attr('id') == 1) {
                $('#inactive').hide();
                $('#active').show();
                $('#btnStickUpSizeToggler').show();
                $("#display-data").text("");
            }


        });

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
                "iDisplayLength": 50,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/Guest/datatableGuest',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 50,
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

        $(document).on('click', '.customerDetails', function ()
        {
            $('.Name').text($(this).attr('name'));
            $('.Phone').text($(this).attr('phone'));
            $('.Email').text($(this).attr('email'));
            $('.accountType').text($(this).attr('accountType'));
            $('#customerDetailsPopUP').modal('show');
        });



        $('.changeMode').click(function () {

            var table = $('#big_table');
            $('#big_table_processing').show();

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 50,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 50,
                "oLanguage": {

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
                },
            };

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');

            $('#inactive').hide();
            $('#active').show();



            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

        });

//        $('#big_table').on('init.dt', function () {
//
//            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
//            var status = urlChunks[urlChunks.length - 1];
//            var forwhat = urlChunks[urlChunks.length - 2];
//
//            if (status == 3) {
//                $('#big_table').dataTable().fnSetColumnVis([5, 6], false);
//
//            }
//            if (status == 4) {
//                $('#big_table').dataTable().fnSetColumnVis([], false);
//
//            }
//
//        });
//

    });
</script>

<link
    href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css"
    rel="stylesheet" type="text/css" />

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content" >

        <div class="brand inline" style="  width: auto;            
             color: gray;
             margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();         ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();         ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();         ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">GUEST CUSTOMERS</strong><!-- id="define_page"-->
        </div>
        <div id="test"></div>
        <!-- Nav tabs -->
<!--        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">

            <li id="3" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/customer/dt_passenger/3"><span>Accepted</span><span class="badge acceptedDriverCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="4" class="tabs_active <?php echo ($status == 4 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/customer/dt_passenger/4"><span>Rejected</span> <span class="badge rejectedDriverCount" style="background-color:#f0ad4e;"></span></a>
            </li>


            <div class="pull-right m-t-10 new_button" > <button class="btn btn-danger btn-cons" id="delete_passenger" >Delete</button></div>

            <div class="pull-right m-t-10 new_button" > <button class="btn btn-warning btn-cons" id="inactive" >Deactivate</button></div>
            <div class="pull-right m-t-10 new_button"><button class="btn btn-info" id="deviceLogs">Device Logs</button></div>

            <div class="pull-right m-t-10 new_button"> <button class="btn btn-primary btn-cons" id="active">Activate</button></a></div>

        </ul>-->
        <!-- Tab panes -->
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

                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right"  placeholder="Search"> </div>
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

