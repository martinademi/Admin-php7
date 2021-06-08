<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);
error_reporting(E_ALL);

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

<script type="text/javascript">
    $(document).ready(function () {


        var status = '<?php echo $status; ?>';

        var table = $('#big_table');


        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_document/' + status,
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
            }
        };




        table.dataTable(settings);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });


        $('.changeMode').click(function () {

            var table = $('#big_table');


            var settings = {
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

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');



            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

        });


        $('#companyid').change(function () {

            var table = $('#big_table');


            var settings = {
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": $(".whenclicked li.active").children('a').attr('data'),
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
                },
            };

            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

//            $.ajax({
//                url: "<?php echo base_url('index.php?/superadmin') ?>/driversInCompany",
//                type: "POST",
//                success: function (result) {
//                    $('#cityid').html(result);
//                }
//            });

        });


    });

</script>


<script>
    $(document).ready(function () {
        $("#define_page").html("Document");
        $('.document').addClass('active');
        $('.document_thumb').addClass("bg-success");

        var table = $('#tableWithSearch1');

        var settings = {
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

        $('.download_file').click(function () {
            $('#download_link').val($(this).attr('data'));
            $('#download_image').submit();
        });

        $('#searchData').click(function () {


            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

            $('#createcontrollerurl').attr('href', '<?php echo base_url() ?>index.php?/superadmin/Get_dataformdate/' + st + '/' + end);

        });

        $('#search_by_select').change(function () {


            $('#atag').attr('href', '<?php echo base_url() ?>index.php?/superadmin/search_by_select/' + $('#search_by_select').val());

            $("#callone").trigger("click");
        });


        $("#chekdel").click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length > 0) {
                if (confirm("Are you sure to Delete " + val.length + " Vehicle")) {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deleteVehicles",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result) {
                            alert(result.affectedRows)

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });
                        }
                    });
                }

            } else {
                alert("Please mark any one of options");
            }

        });


    });

</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper" style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;
             font-size: 20px;
             color: gray;
             margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();           ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();           ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();           ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">DOCUMENTS</strong><!-- id="define_page"-->
        </div>
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <!--            <div class="inner">-->
                <!--                <!-- START BREADCRUMB -->
                <!--                <ul class="breadcrumb">-->
                <!--                    <li>-->
                <!--                        <p>Company</p>-->
                <!--                    </li>-->
                <!--                    <li><a>Vehicles</a>-->
                <!--                    </li>-->
                <!--                    <li><a href="#" class="active">--><?php //echo $vehicle_status;            ?><!--</a>-->
                <!--                    </li>-->
                <!--                </ul>-->
                <!--                <!-- END BREADCRUMB -->
                <!--            </div>-->






                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup bg-white whenclicked">
                        <li id="1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_document/1"><span><?php echo LIST_DRIVERSLICENSE; ?></span></a>
                        </li>
                        <li id="1" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>">
                            <a class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_document/2"><span><?php echo LIST_BANKPASSBOOK; ?></span></a>
                        </li>
                        <li id="1" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_document/3"><span><?php echo LIST_CARRIAGEPERMIT; ?></span></a>
                        </li>
                        <li id="1" class="tabs_active <?php echo ($status == 4 ? "active" : ""); ?>">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_document/4"><span><?php echo LIST_CR; ?></span></a>
                        </li>

                        <li id="1" class="tabs_active <?php echo ($status == 5 ? "active" : ""); ?>">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_document/5"><span><?php echo LIST_INSURENCECERTIFICATE; ?></span></a>
                        </li>

                        <?php if ($status == 1 || $status == 2) { ?>
                            <div class="pull-right m-t-10" > 


                                <div class="pull-right " style="margin-right: 10px; width: 150px;margin-bottom: 5px;">

<!--
                                    <select id="cityid" name="city_select"  class="form-control"  >
                                        <option value="0"><?php echo SELECT_BY_DRIVER ?></option>
                                        <?php
                                        foreach ($master as $result) {

                                            echo "<option value=" . $result->mas_id . ">" . $result->first_name . $result->last_name . "</option>";
                                        }
                                        ?>

                                    </select>-->

                                </div>
                            </div>
                        <?php } elseif ($status == 3 || $status == 4 || $status == 5) {
                            ?>


                            <div class="pull-right m-t-10" > 


                                <div class="pull-right " style="margin-right: 10px; width: 150px;margin-bottom: 5px;">


                                    <select id="cityid" name="city_select"  class="form-control"  >
                                        <option value="0"><?php echo SELECT_BY_DRIVER ?></option>
                                        <?php
                                        foreach ($master as $result) {


                                            echo "<option value=" . $result->mas_id . ">" . $result->first_name . $result->last_name . "</option>";
                                        }
                                        ?>

                                    </select>

                                </div>
                            </div>

                        <?php } ?>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <!--                                --><?php //if($status == '5') {            ?>
                                    <!--                                    <div class="pull-left"><a href="--><?php //echo base_url()            ?><!--index.php?/superadmin/addnewvehicle"> <button class="btn btn-primary btn-cons">ADD</button></a></div>-->
                                    <!--                                --><?php //}            ?>

                                    <div class="row clearfix pull-right" >


                                        <div class="col-sm-12">
                                            <div class="searchbtn" >

                                                <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                            </div>

                                        </div>
                                    </div>

                                    <br>
                                    <br>


                                    <div class="panel-body">
<!--                                        --><?php //echo $this->table->generate(); ?>

                                                                          

                                        <?php if ($status == 1 || $status == 2) { ?>


                                                                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="big_table" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">
                                                                                                <thead>

                                                                                                    <tr role="row">
                                                                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"><?php echo DOCUMENT_TABLE_DOCUMENTID; ?></th>
                                                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:15px"><?php echo DOCUMENT_TABLE_FIRSTNAME; ?></th>
                                                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 150px;font-size:15px"><?php echo DOCUMENT_TABLE_LASTNAME; ?></th>
                                                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 131px;font-size:15px"><?php echo DOCUMENT_TABLE_VIEW; ?></th>
                                                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 98px;font-size:15px"><?php echo DOCUMENT_TABLE_EXPIRYDATE; ?></th>
                                                                                                    </tr>


                                                                                                </thead>
                                                                                                <tbody>










                                            <?php
                                            $i = '1';
                                            foreach ($document_data as $result) {
                                                ?>


                                                                                                            <tr role="row"  class="gradeA odd">
                                                                                                                <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->doc_ids; ?></p></td>
                                                                                                                <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->first_name; ?></p></td>
                                                                                                                <td class="v-align-middle"><?php echo $result->last_name; ?></td>
                                                                                                                <td class="v-align-middle"><button><a target="_blank" href="<?php echo "http://107.170.66.211/roadyo_live/pics/" . $result->url; ?>">view</a></button><button  class="download_file" data="<?php echo "http://107.170.66.211/roadyo_live/pics/" . $result->url; ?>" style="margin-left: 50px">Download</button></td>
                                                                                                                <td class="v-align-middle"><?php echo $result->expirydate; ?></td>
                                                                                                            </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                                                                                </tbody>
                                                                                            </table></div>
                                        <?php } ?>
                                                                                <form role="form"  action="<?php echo base_url(); ?>index.php?/superadmin/downloadDocument" id="download_image" method="post">
                                                                                    <input type="hidden" name="image_link" id="download_link" />
                                                                                </form>

                                        <?php if ($status == 3 || $status == 4 || $status == 5 || $status == 6) { ?>
                                                                                        <div class="panel-body">
                                                                                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="big_table" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">
                                                                                                        <thead>

                                                                                                            <tr role="row">
                                                                                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"><?php echo DOCUMENT_TABLE_DOCUMENTID; ?></th>
                                                                                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:15px"><?php echo DOCUMENT_TABLE_VEHICLEID; ?></th>
                                                                                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 150px;font-size:15px"><?php echo DOCUMENT_TABLE_COMPANY; ?></th>
                                                                                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 131px;font-size:15px"><?php echo DOCUMENT_TABLE_VIEW; ?></th>
                                                                                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 98px;font-size:15px"><?php echo DOCUMENT_TABLE_EXPIRYDATE; ?></th>
                                                                                                            </tr>


                                                                                                        </thead>
                                                                                                        <tbody>




                                            <?php
                                            $i = '1';
                                            foreach ($document_data as $result) {
                                                ?>


                                                                                                                    <tr role="row"  class="gradeA odd">
                                                                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->docid; ?></p></td>
                                                                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->vechileid; ?></p></td>
                                                                                                                        <td class="v-align-middle"><?php echo $result->companyname; ?></td>
                                                                                                                        <td class="v-align-middle"><button><a target="_blank" href="<?php echo "http://107.170.66.211/roadyo_live/pics/" . $result->url; ?>">view</a></button><button  style="margin-left: 50px">Download</button></td>
                                                                                                                        <td class="v-align-middle"><?php echo $result->expirydate; ?></td>
                                                                                                                    </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                                                                                        </tbody>
                                                                                                        </thead>
                                                                                                    </table>
                                        <?php } ?>


                                                                                            <div class="row"></div></div>
                                    </div>
                                </div>
                                <!--END PANEL--> 
                            </div>
                        </div>
                    </div>




                </div>
            </div>




        </div>


    </div>
    <!-- END JUMBOTRON -->

    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->

        <!-- END PLACE PAGE CONTENT HERE -->
    </div>
    <!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
        <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
                <span class="hint-text">Copyright @ 3Embed software technologies, All rights reserved</span>
               
            </p>
           
            <div class="clearfix"></div>
        </div>
    </div>
<!-- END FOOTER -->
</div>

</div>
