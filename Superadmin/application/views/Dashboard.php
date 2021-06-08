<script src="<?php echo base_url() ?>theme/assets/plugins/nvd3/lib/d3.v2.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>theme/assets/plugins/nvd3/nv.d3.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>theme/assets/plugins/nvd3/src/utils.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>theme/assets/plugins/nvd3/src/tooltip.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>theme/assets/plugins/nvd3/src/interactiveLayer.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>theme/assets/plugins/nvd3/src/models/axis.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>theme/assets/plugins/nvd3/src/models/line.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>theme/assets/plugins/nvd3/src/models/lineWithFocusChart.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>theme/assets/plugins/nvd3/nv.d3.min.css" rel="stylesheet">
<script src="<?php echo base_url() ?>theme/assets/plugins/nvd3/nv.d3.min.js"></script>

<style>
    #tripsLineChart svg {
        height: 90%;
    }
    .canvasjs-chart-credit{
        display:none;
    }
    .tile_count .tile_stats_count .count {
        font-size: 11px;
    }
    .tile_count .tile_stats_count span {
        font-size: 11px;
    }
    #chart2{
        width:420px;
    }
</style>

<style>
    .panel-controls{
        display: none;
    }
</style>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong style="text-transform:capitalize"><?php echo str_replace('_', ' ', $pageTitle); ?> Reports</strong><!-- id="define_page"-->
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <iframe id="customerframe" src="<?php echo chartLink; ?>" style="width: 100%;height:100vh"></iframe>
                    
            </div>
        </div>
    </div>
</div>


<div class="row tile_count">
    
   <!-- <a href="<?php echo base_url();?>index.php?/Voucher"> <button type="button" style="margin:15px" class="btn btn-primary" >Voucher</button></a> -->
</div>
<br>
<div id="tripsLineChart" class="line-chart text-center full-height full-width" data-x-grid="false">

    <svg></svg>
</div>

<!--<div id="chart2" class="line-chart text-center full-height full-width" data-x-grid="false">
    <svg style="height:400px;width:300px"></svg>
</div>-->


<script>


    function get_trips_data(callback) {
        $.ajax({
            url: '<?= base_url() ?>index.php?/Dashboard_controller/tripChartData',
            type: "POST",
            data: {<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            success: function (result) {

                nv.addGraph(function () {
                    var chart = nv.models.stackedAreaChart()
                            .x(function (d) {
                                return d[0]
                            })
                            .y(function (d) {
                                return d[1]
                            })

                            .useInteractiveGuideline(true)
                            ;

                    chart.xAxis
                            .tickFormat(function (d) {
                                return d3.time.format('%d-%b-%y')(new Date(d))
                            });

                    chart.yAxis.tickFormat(d3.format('d'));

                    d3.select('#tripsLineChart svg')
                            .datum(result)
                            .transition().duration(500)
                            .call(chart)
                            ;

                    nv.utils.windowResize(chart.update);

                    $('#tripsLineChart').data('chart', chart);

                    return callback(chart);
                });
            }
        });
    }


    $(document).ready(function () {
        // Init portlets

        var bars = $('.widget-loader-bar');
        var circles = $('.widget-loader-circle');
        var circlesLg = $('.widget-loader-circle-lg');
        var loaderDrivers = $('.widget-loader-drivers');
        var loaderVehicles = $('.widget-loader-vehicles');
        var loaderoperators = $('.widget-loader-operators');



        circles.each(function () {
            var elem = $(this);
            elem.portlet({
                progress: 'circle',
                onRefresh: function () {
                    get_trips_data(function () {
                        elem.portlet({
                            refresh: false
                        });
                    });
                }
            });
        });


        get_trips_data(function () {
            console.log('chart Done');
        });

    });

</script>

