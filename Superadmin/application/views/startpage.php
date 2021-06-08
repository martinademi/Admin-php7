
<!--
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


        var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataArr) ?>);
        var dataearning = google.visualization.arrayToDataTable(<?php echo json_encode($dataArrearning) ?>);

        var chart = new google.charts.Bar(document.getElementById('AppUsersChart'));
        var chartearning = new google.charts.Bar(document.getElementById('AppUsersChartearning'));

        chart.draw(data);
        chartearning.draw(dataearning);
    }

    $(document).ready(function () {

//
        $('#booking_week').click(function () {

            var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataper_week) ?>);
            var chart = new google.charts.Bar(document.getElementById('AppUsersChart'));
            chart.draw(data);

        });
        $('#booking_month').click(function () {

            var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataper_month) ?>);
            var chart = new google.charts.Bar(document.getElementById('AppUsersChart'));
            chart.draw(data);

        });
    });
</script>-->
<style>
    .panel-controls{
        display: none;
    }
    .col-md-3{
        cursor: pointer;
    }
    .page-sidebar{
        display:none;
    }
     .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
   

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>

<script>
    $(document).ready(function () {
        

        $('.startpage').addClass('active');
        $('.startpage_thumb').addClass("bg-success"); 
        
    });
</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
<!--                <div class="inner">
                     START BREADCRUMB 
                    <ul class="breadcrumb">
                        <li>
                            <p>COMPANY</p>
                        </li>
                        <li><a href="#" class="active">DashBoard</a>
                        </li>
                    </ul>

                    <h3>MASTER PAGE</h3>
                     END BREADCRUMB 
                </div>-->


                <div class="row">



                    <div class="col-md-3">
                        <div class="widget-9 panel no-border bg-success no-margin widget-loader-bar">
                            <div class="container-xs-height full-height">

                                <div class="row-xs-height">
                                       <a href="http://postmenu.cloudapp.net/Taxi/superadmin/dashboard/index.php/superadmin/Dashboard">
                                    <h3 class="text-white" style="  TEXT-ALIGN: CENTER; MARGIN-TOP: 50PX;">ROADYO</h3>
                                 
                                    </a>
                                </div>

                            </div>
                          </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="widget-9 panel no-border bg-primary no-margin widget-loader-bar">
                            <div class="container-xs-height full-height">

                                <div class="row-xs-height">
                                    <!--<a href="#" class="">-->
                                    <h3 class="text-white" style="  TEXT-ALIGN: CENTER; MARGIN-TOP: 50PX;">DOCTOR</h3>
                                    
                                    <!--</a>-->
                                </div>

                            </div>
                          </div>
                    </div>
                    
                    
                    <div class="col-md-3">
                        <div class="widget-9 panel no-border bg-success no-margin widget-loader-bar">
                            <div class="container-xs-height full-height">

                                <div class="row-xs-height">
                                    <!--<a href="#" class="">-->
                                    <h3 class="text-white" style="  TEXT-ALIGN: CENTER; MARGIN-TOP: 50PX;">-----</h3>
                                    
<!--                                    </a>-->
                                </div>

                            </div>
                          </div>
                    </div>
                    
                    
                    
                    <div class="col-md-3">
                        <div class="widget-9 panel no-border bg-primary no-margin widget-loader-bar">
                            <div class="container-xs-height full-height">

                                <div class="row-xs-height">
<!--                                     <a href="#" class="">-->
                                    <h3 class="text-white" style="  TEXT-ALIGN: CENTER; MARGIN-TOP: 50PX;">-----</h3>
                                   
<!--                                    </a>-->
                                </div>

                            </div>
                          </div>
                    </div>
                    
                   
                </div>




            </div>

            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->




                <!-- END PANEL -->
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