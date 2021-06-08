<?PHP 
error_reporting(false);

//error_reporting(0);
$rupee = "$";
$dataArr = array();
$dataArr[] = array('Time Period', 'Total');
$dataArr[] = array('Today', $todaybooking['today']);
$dataArr[] = array('This Week', $todaybooking['week']);
$dataArr[] = array('This Month', $todaybooking['month']);
$dataArr[] = array('LifeTime', $todaybooking['lifetime']);
?>

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    
    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1.1", {packages: ["bar"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
//        $('.dashboard_thumb').attr('src',"<?php echo base_url();?>/theme/icon/dasboard_on.png");

        var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataArr)?>);
        

        var chart = new google.charts.Bar(document.getElementById('AppUsersChart'));
        

        chart.draw(data);
        
    }
</script>
<!--<script>
    $("#HeaderDashBoard").addClass("active");
    $(document).ready(function () {
        
         $('.dashboard').addClass('active');
        $('.dashboard_thumb').attr('src', "<?php //echo base_url(); ?>assets/dash_board_on.png");


        $('#admin_control').click(function () {

            $('#call_admin').trigger("click");
        });

        $('#broker_control').click(function () {

            $('#broker_admin').trigger("click");
        });
        $('#Products').click(function () {

            $('#All_Products').trigger("click");
        });
        $('#AddOns').click(function () {

            $('#All_AddOns').trigger("click");
        });
        $('#Orders').click(function () {

            $('#All_Orders').trigger("click");
        });

    });

</script>-->
<script type="text/javascript" src="../../js/dashboard.js"></script>
<style>
    #broker_control,#Products,#AddOns,#Orders{
        cursor: pointer;
    }
</style>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="parallax" data-pages="parallax">
            <div class="col-xs-12 container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <!-- <ul class="breadcrumb">
                        <li><a href="#" class="active">Dashboard</a>
                        </li>
                    </ul> -->
                    <div class="brand inline" style="  width: auto;">
                        <?php echo str_replace('_', ' ', $pageTitle); ?> Dashboard
                        <!-- id="define_page"-->
                    </div>
                    <!-- END BREADCRUMB -->
                </div>


                <div class="row">

                    <div class="col-md-12 text-center" id="admin_control">
                        <h3 style="font-size:16px">ORDERS</h3>
                    </div>
                    <div class="col-lg-3 col-xs-6 " id="admin_control">
                        <div class="widget-8 panel no-border bg-success no-margin widget-loader-bar">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner text-center">
                                    <h3>
                                       <?PHP echo $dashborddata['TodayTotalOrders'];?>
                                    </h3>
                                    <p>
                                    <h4 class="no-margin p-b-5 text-white">TODAY</h4>
                                </div>
                            </div>
                        </div><!-- ./col -->
                    </div>
                    <div class="col-lg-3 col-xs-6 " id="admin_control">
                        <div class=" widget-8 panel no-border bg-success no-margin widget-loader-bar">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner text-center">
                                    <h3>
                                        <?PHP echo $dashborddata['WeekTotalOrders'];?>
                                    </h3>
                                    <p>
                                    <h4 class="no-margin p-b-5 text-white">THIS WEEK</h4>
                                </div>
                            </div>
                        </div><!-- ./col -->
                    </div>
                    <div class="col-lg-3 col-xs-6 " id="admin_control">
                        <div class="widget-8 panel no-border bg-success no-margin widget-loader-bar">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner text-center">
                                    <h3>
                                         <?PHP echo $dashborddata['MonthTotalOrders'];?>
                                    </h3>
                                    <p>
                                    <h4 class="no-margin p-b-5 text-white">THIS MONTH</h4>
                                </div>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6 " id="admin_control">
                        <div class="widget-8 panel no-border bg-success no-margin widget-loader-bar">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner text-center">
                                    <h3>
                                         <?PHP echo $dashborddata['TotalOrders'];?>
                                    </h3>
                                    <p>
                                    <h4 class="no-margin p-b-5 text-white">LIFETIME</h4>
                                </div>
                            </div>
                        </div><!-- ./col -->
                    </div>
                </div>




            </div>
            </div>

        </div>
        <!-- END JUMBOTRON -->

        <!-- START CONTAINER FLUID -->
        <div class="col-xs-12 container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->

            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->

    </div>
    <!-- END PAGE CONTENT -->
    <!-- START FOOTER -->
    <div class="col-xs-12 container-fixed-lg footer">
        <?PHP include 'FooterPage.php' ?>
    </div>

    <!-- END FOOTER -->
</div>