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
    <!-- START PAGE CONTENT changes -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong style="text-transform:capitalize"><?php echo str_replace('_', ' ', $pageTitle); ?> <?php echo $this->lang->line('Reports'); ?></strong><!-- id="define_page"-->
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <iframe id="customerframe" src="<?php echo chartLink.'?id='.$BizId; ?>" style="width: 100%;min-height:100vh;border: none;"></iframe>
            </div>
        </div>
    </div>
</div>





<br>
<div id="tripsLineChart" class="line-chart text-center full-height full-width" data-x-grid="false">
    <svg></svg>
</div>
<!--<div id="chart2" class="line-chart text-center full-height full-width" data-x-grid="false">
    <svg style="height:400px;width:300px"></svg>
</div>-->


<script>

//Donut chart example
//    nv.addGraph(function () {
//        var chart = nv.models.pieChart()
//                .x(function (d) {
//                    return d.label
//                })
//                .y(function (d) {
//                    return d.value
//                })
//                .showLabels(true)     //Display pie labels
//                .labelThreshold(.05)  //Configure the minimum slice size for labels to show up
//                .labelType("percent") //Configure what type of data to show in the label. Can be "key", "value" or "percent"
//                .donut(true)          //Turn on Donut mode. Makes pie chart look tasty!
//                .donutRatio(0.35)     //Configure how big you want the donut hole size to be.
//                ;
//
//        d3.select("#chart2 svg")
//                .datum(exampleData())
//                .transition().duration(350)
//                .call(chart);
//
//        return chart;
//    });
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
//                            .color([
//                                $.Pages.getColor('success'),
//                                $.Pages.getColor('primary'),
//                                $.Pages.getColor('complete'),
//                                $.Pages.getColor('danger')
//                            ])
//                            .showLegend(false)
//                            .margin({
//                                left: 30,
//                                bottom: 35
//                            })
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

