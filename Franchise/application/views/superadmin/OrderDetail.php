<script>
    $(document).ready(function () {
        $('#callM').click(function () {

            $('#NewCat').modal('show');
        });
        $("#tableWithSearch").removeClass("dataTable");
        $("#tableWithSearch").removeClass("no-footer");
    });
    //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function Delservice(thisval) {
        $('#deletemodal').modal('show');
        var entityidid = thisval.id;
        $("#deletelink").attr('href', "<?php echo base_url() ?>index.php/Admin/DeleteProduct/" + entityidid);
    }


</script>


<style>

    #tableWithSearch_paginate,#tableWithSearch_info{
        display: none !important;
    }

</style>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="margin-left: 20px;">
                    <!--                    <li>
                                            <a href="<?php echo base_url() ?>index.php/Admin/loadDashbord">Dashboard</a>
                                        </li>-->
                    <li>
                        <a href="<?php echo base_url() ?>index.php/Admin/Orders">Orders</a>
                    </li>
                    <li><a href="#" class="active">Order Detail</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>



            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="panel-heading">

                        <div class="panel-body">
                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive">
                                    <table class="table" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                        <thead>
                                            <tr role="row">
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Slno</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Item Name</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Price</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Qty</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                                    Amount</th>

                                            </tr>

                                        </thead>
                                        <tbody>

                                            <?php
                                            $count = 1;

                                            foreach ($OrderDetails['Items'] as $result) {
                                                ?>
                                                <tr role="row" class="odd">
                                                    <td id = "d_no" class="v-align-middle sorting_desc"> <p><?php echo $count ?></p></td>
                                                    <td id = "fname_" class="v-align-middle"> 
                                                        <?php
                                                        if ($result["PortionTitle"] != '') {
                                                            echo $result["ProductName"] . ' (' . $result["PortionTitle"] . ')';
                                                        } else {
                                                            echo $result["ProductName"];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td id = "fname_" class="v-align-middle"> <p><?php echo $result["PortionPrice"] ?></p></td>
                                                    <td id = "lname_" class="v-align-middle"><p> <?php echo $result["Qty"] ?> </p></td>

                                                    <td id = "lname_" class="v-align-middle"><p> <?php echo $result["Qty"] * $result["PortionPrice"] ?> </p></td>



                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                            <tr>
                                                <td id = "d_no" class="v-align-middle"> <p></p></td>
                                                <td id = "fname_" class="v-align-middle"> </td>
                                                <td id = "fname_" class="v-align-middle"> <p></p></td>
                                                <td id = "lname_" class="v-align-middle"><p>Amount</p></td>
                                                <td id = "lname_" class="v-align-middle"><p></p></td>
                                            </tr>
                                            <tr>
                                                <td id = "d_no" class="v-align-middle"> <p></p></td>
                                                <td id = "fname_" class="v-align-middle"> </td>
                                                <td id = "fname_" class="v-align-middle"> <p></p></td>
                                                <td id = "lname_" class="v-align-middle"><p>Tax</p></td>
                                                <td id = "lname_" class="v-align-middle"><p></p></td>
                                            </tr>


                                        </tbody>
                                    </table></div></div></div>
                    </div>
                </div>
                <!-- END PANEL -->
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




