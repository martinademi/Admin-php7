<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.3.3/d3.min.js" type="text/javascript"></script>
<style>
    .headingText{
        font-size: 13px;
    }
    .headingText1{
        font-size: 12px;
        color:#1ABB9C
    }
    * {
        margin: 0;
        padding: 0;
    }
    body {
        background: #fff;
        font-family: 'Open-Sans',sans-serif;

    }

    #container{
        margin: 0 auto;
        position: relative;
        width:800px;
        overflow: visible;
    }


    .svg {
        width:50000px;
        height:400px;
        overflow: scroll;
        position:absolute;
    }

    .grid .tick {
        stroke: lightgrey;
        opacity: 0.3;
        shape-rendering: crispEdges;
    }
    .grid path {
        stroke-width: 0;
    }
    #tag {
        color: white;
        background: #FA283D;
        width: 150px;
        position: absolute;
        display: none;
        padding: 3px 6px;
        top: -72px!important;
        font-size: 11px;
        right: 26px!important;
    }
    #tag:before {
        border: solid transparent;
        content: ' ';
        height: 0;
        left: 50%;
        margin-left: -5px;
        position: absolute;
        width: 0;
        border-width: 10px;
        border-bottom-color: #FA283D;
        top: -20px;
    }

    i {
        border: solid black;
        border-width: 0 3px 3px 0;
        display: inline-block;
        padding: 2px;
        margin-left: -2px;
    }
    .up {
        transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
        color:green;
    }
    .vl {
        border-left: 3px solid green;

        height: 80px;
    }
    .y_line {
        width: 2px;
        height: 110px;
        background: #73879c;
        position: absolute;
        top: 8px;
        left: 4px;
    }
    .x_line {
        width: 110px;
        height: 2px;
        background: #73879c;
        position: absolute;
        top: 8px;
        left: 4px;
    }
    span.x_axis{
        position: absolute;
        margin-left: 19%;
    }
    span.y_axis {
        position: absolute;
        left: -42px;
        top: 236px;
    }
    span.y_axis1{
        position: absolute;
        left: -56px;
        top: 361px;
        font-weight: 600

    }
    .rightArrow{
        left: 109px;
        top: 2px;
    }
    .x_axis1{
        margin-left: 19%;
        font-weight: 600;
    }


</style>

<script type="text/javascript">

    $(document).ready(function () {


        var table = $('#big_table');

        var date = new Date();
        $('.datepicker-component').datepicker({
            format: 'dd/mm/yyyy',
            endDate: date,
        });

        $('.datepicker-component,.datepicker-component1').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        $('.datepicker-component1').datepicker({
            endDate: date,
            format: 'dd/mm/yyyy'

        });

        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
            $('.searchBox').show();
//            $('.clearBox').hide();
        });


        var settings = {
            "autoWidth": true,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "fnInitComplete": function () {

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


        $('#searchData').click(function () {
            if ($("#start").val())
            {
                var st = $("#start").datepicker().val();
                var startDate = st.split("/")[2] + '-' + st.split("/")[1] + '-' + st.split("/")[0];
                searchedDate = startDate;

//                var end = $("#end").datepicker().val();
//                var endDate = end.split("/")[2] + '-' + end.split("/")[1] + '-' + end.split("/")[0];

//                var timestamp1 = moment(startDate).format("X");
//                var timestamp2 = moment(endDate).format("X");

//                    $('.clearBox').show();
//                    $('.searchBox').hide();
                $('.onlineHour').text('');
                $('.dateShow').text(moment(startDate).format("Do MMM YYYY"));
                var table = $('#big_table');

                $('#tag').empty();
                $('.svg').empty();
                taskArray = [];

                searchedDateFlag = true;

                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: "<?php echo base_url('index.php?/driver_controller') ?>/getShiftLogs",
                    async: false,
                    data: {masterId: "<?php echo $driverID; ?>", from: startDate},
                    success: function (result) {
                        console.log('result',result)
                        $('.tableData').empty();
                        var html = '';
                        if(result.response==null){
                            alert("No Data Found")
                        }else{
                            $.each(result.response, function (i, shifts) {
                            taskArray.push({
                                task: '',
                                type: "Shift " + (i + 1),
                                startTime: shifts.st, //year/month/day
                                endTime: shifts.end,
                                details: shifts.dur

                            });

                            
                            $('.onlineHour').text(shifts.totalOnlineTime);

                            html += '<tr>';
                            html += '<td>' + (i + 1) + '</td>';
                            html += '<td>' + shifts.stTime + '</td>';
                            html += '<td>' + shifts.endTime + '</td>';
                            html += '<td>' + shifts.dur + '</td>';
                            html += '</tr>';
                        });

                        $('.tableData').append(html);

                        drawChart();
                        }
                        
                    }
                });



            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select proper date');

            }

        });
    });</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <ul class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>index.php?/superadmin/Drivers/my/1" class="active">DRIVER (<?php echo $driverData['firstName'] . ' ' . $driverData['lastName']; ?>)</a>
            </li>
            <li>
                <a  class="active">SHIFT LOGS</a>
            </li>

        </ul>

        <div class="row">
            <div class="col-sm-2" style="margin-left: 71px;margin-right: -10px;">
                <div class="" aria-required="true">

                    <div class="input-daterange input-group">
                        <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
<!--                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control datepicker-component1" name="end"  id="end" placeholder="To Date">-->

                    </div>
                </div>
            </div>
            <div class="col-sm-1 searchBox" style="min-width: 104px;">
                <div class="">
                    <button class="btn btn-primary" type="button" id="searchData">Search</button>
                </div>
            </div>
            <div class="col-sm-1 clearBox" style="min-width: 104px;">
                <div class="">
                    <button class="btn btn-info" type="button" id="clearData">Clear</button>
                </div>
            </div>
        </div>
        <hr>
        <br>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <b class="headingText">DATE</span></b> 
            </div>
            <div class="col-sm-4">
                <b class="headingText">ONLINE</b>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <b class="headingText1"><span class="dateShow"><?php echo 'Today ' . date('dS M Y ', time()) ?></span></b> 
            </div>
            <div class="col-sm-4">
                <b class="headingText1"><span class="onlineHour"></span></b>
            </div>
        </div>
<!--          <i class="up"></i>
          <div class="vl" style="float: left"></div>-->
        <div id = "container" style="margin-top:20px;">

            <span class="y_axis">
                <span class="y_line"></span><span class="glyphicon glyphicon-chevron-up"></span>

            </span>
            <span class="y_axis1">SHIFTS</span>

            <div class = "svg" style="border-left: solid 2px;border-bottom:solid 2px;width: 900px;overflow:scroll"></div>
            <div id = "tag"></div>
           
        </div> 


        <div class="" data-pages="parallax" style="margin-top:436px;">
             <div class="row timingY-axix">
                <span class="x_axis">
                    <span class="x_line"></span><span class="glyphicon glyphicon-chevron-right rightArrow"></span>
                </span>
                <span class="x_axis1">TIMINGS</span>
            </div>

            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="margin-left: 0%;">
                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">


                                </div>
                                <div class="panel-body tableDiv">
                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                        <div class="table-responsive" style="overflow-x:hidden;overflow-y:hidden;">

                                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                                <div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer tableWithSearch_referels" id="big_table" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">
                                                        <thead>

                                                            <tr role="row">
                                                                <th  class="sorting_asc " tabindex="0" aria-controls="big_table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px">SL NO.</th>
                                                                <th class="sorting_asc " tabindex="0" aria-controls="big_table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px">START TIME</th>
                                                                <th  class="sorting_asc " tabindex="0" aria-controls="big_table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 120px;font-size:15px">END TIME</th>
                                                                <th  class="sorting_asc " tabindex="0" aria-controls="big_table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 120px;font-size:15px">DURATION</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tableData">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div><div class="row"></div></div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.3.3/d3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>theme/assets/plugins/moment.js"></script>


<script>
    var taskArray = [];
    var table = $('#big_table');
    var searchedDateFlag = false;
    var searchedDate;
    var tableMargin_top = 90;
    ;

    $.ajax({
        dataType: "json",
        type: "POST",
        url: "<?php echo base_url('index.php?/driver_controller') ?>/getShiftLogs",
        async: false,
        data: {masterId: "<?php echo $driverID; ?>", from: '<?php echo date('Y-m-d'); ?>'},
//        data: {masterId: "59f4b2dcebd93be478df36b0", from:1509429600},
        success: function (result) {
            console.log('innnn2')
            $('.tableData').empty();
            var html = '';
            if (result.response)
            {
                $.each(result.response, function (i, shifts) {
                    taskArray.push({
                        task: '',
                        type: "Shift " + (i + 1),
                        startTime: shifts.st, //year/month/day
                        endTime: shifts.end,
                        details: shifts.dur

                    });

                    $('.onlineHour').text(shifts.totalOnlineTime);

                    html += '<tr>';
                    html += '<td>' + (i + 1) + '</td>';
                    html += '<td>' + shifts.stTime + '</td>';
                    html += '<td>' + shifts.endTime + '</td>';
                    html += '<td>' + shifts.dur + '</td>';
                    html += '</tr>';
                });


            }else{
                alert("No data found for <?php echo date('Y-m-d'); ?> Please choose other date",)
            }

            $('.tableData').append(html);
        }
    });

    drawChart();

    function drawChart() {

        var w = 50000;
        var h = taskArray.length * 26;
        if (h < 400)
            h = 400;

        tableMargin_top = h;

        var svg = d3.selectAll(".svg")
                //.selectAll("svg")
                .append("svg")
//                .attr("width", w)
//                .attr("height", h)
                .attr("class", "svg");

        $('.svg').css('height', h);
//        $('.tableDiv').css('margin-top', tableMargin_top-400);
        $('.timingY-axix').css('margin-top', tableMargin_top+40);
//                                       
        var dateFormat = d3.time.format("%Y-%m-%d %H:%M:%S");

        if (searchedDateFlag)
        {
            
            var timeScale = d3.time.scale()
                    .domain([dateFormat.parse(moment(searchedDate).format("YYYY-MM-DD") + ' 00:00:00'), dateFormat.parse(moment(searchedDate).format("YYYY-MM-DD") + ' 23:59:59')])
                    .range([0, w - 100]);

        } else {
            var timeScale = d3.time.scale()
//                .domain([d3.min(taskArray, function (d) {
//                        return dateFormat.parse(d.startTime);
//                    }),
//                    d3.max(taskArray, function (d) {
//                        return dateFormat.parse(d.endTime);
//                    })])
                    .domain([dateFormat.parse(moment().format("YYYY-MM-DD") + ' 00:00:00'), dateFormat.parse(moment().format("YYYY-MM-DD") + ' 23:59:59')])
                    .range([0, w - 100]);
        }
      
        var categories = new Array();
        for (var i = 0; i < taskArray.length; i++) {
            categories.push(taskArray[i].type);
        }

        var catsUnfiltered = categories; //for vert labels

        categories = checkUnique(categories);
        makeGant(taskArray, w, h);
        var title = svg.append("text")
                .text("Shift Logs")
                .attr("x", w / 2)
                .attr("y", 25)
                .attr("text-anchor", "middle")
                .attr("font-size", 18)
                .attr("fill", "#009FFC");

        function makeGant(tasks, pageWidth, pageHeight) {

            var barHeight = 20;
            var gap = barHeight + 4;
            var topPadding = 75;
            var sidePadding = 75;
            var colorScale = d3.scale.linear()
                    .domain([0, categories.length])
                    .range(["#00B9FA", "#F95002"])
                    .interpolate(d3.interpolateHcl);
            makeGrid(sidePadding, topPadding, pageWidth, pageHeight);
            drawRects(tasks, gap, topPadding, sidePadding, barHeight, colorScale, pageWidth, pageHeight);
            vertLabels(gap, topPadding, sidePadding, barHeight, colorScale);
        }


        function drawRects(theArray, theGap, theTopPad, theSidePad, theBarHeight, theColorScale, w, h) {


            var bigRects = svg.append("g")
                    .selectAll("rect")
                    .data(theArray)
                    .enter()
                    .append("rect")
                    .attr("x", 0)
                    .attr("y", function (d, i) {
                        return i * theGap + theTopPad - 2;
                    })
                    .attr("width", function (d) {
                        return w - theSidePad / 2;
                    })
                    .attr("height", theGap)
                    .attr("stroke", "none")
                    .attr("fill", function (d) {
                        for (var i = 0; i < categories.length; i++) {

                            if (d.type == categories[i]) {
                                return d3.rgb(theColorScale(i));
                            }

                        }
                    })
                    .attr("opacity", 0.2);
//            return false;
            var rectangles = svg.append('g')
                    .selectAll("rect")
                    .data(theArray)
                    .enter();
            var innerRects = rectangles.append("rect")
                    .attr("rx", 3)
                    .attr("ry", 3)
                    .attr("x", function (d) {

                        return timeScale(dateFormat.parse(d.startTime)) + theSidePad;
                    })
                    .attr("y", function (d, i) {
                        return i * theGap + theTopPad;
                    })
                    .attr("width", function (d) {
                        var shiftDateSplit = d.startTime.split(":");
                        if (shiftDateSplit[2] != "00")
                            return (timeScale(dateFormat.parse(d.endTime)) - timeScale(dateFormat.parse(d.startTime)));
                    })
                    .attr("height", theBarHeight)
                    .attr("stroke", "none")
                    .attr("fill", function (d) {
                        for (var i = 0; i < categories.length; i++) {

                            if (d.type == categories[i]) {
                                return d3.rgb(theColorScale(i));
                            }

                        }
                    })


            var rectText = rectangles.append("text")
                    .text(function (d) {
                        return d.task;
                    })
                    .attr("x", function (d) {
                        return (timeScale(dateFormat.parse(d.endTime)) - timeScale(dateFormat.parse(d.startTime))) / 2 + timeScale(dateFormat.parse(d.startTime)) + theSidePad;
                    })
                    .attr("y", function (d, i) {
                        return i * theGap + 14 + theTopPad;
                    })
                    .attr("font-size", 11)
                    .attr("text-anchor", "middle")
                    .attr("text-height", theBarHeight)
                    .attr("fill", "#fff");
            rectText.on('mouseover', function (e) {
                // console.log(this.x.animVal.getItem(this));
                var tag = "";
                if (d3.select(this).data()[0].details != undefined) {
                    tag = "Task: " + d3.select(this).data()[0].type + "<br/>" +
//                                        "Type: " + d3.select(this).data()[0].type + "<br/>" +
                            "Starts: " + d3.select(this).data()[0].startTime + "<br/>" +
                            "Ends: " + d3.select(this).data()[0].endTime + "<br/>" +
                            "Duration: " + d3.select(this).data()[0].details;
                } else {
                    tag = "Task: " + d3.select(this).data()[0].type + "<br/>" +
//                                        "Type: " + d3.select(this).data()[0].type + "<br/>" +
                            "Starts: " + d3.select(this).data()[0].startTime + "<br/>" +
                            "Ends: " + d3.select(this).data()[0].endTime;
                }
                var output = document.getElementById("tag");
                var x = this.x.animVal.getItem(this) + "px";
                var y = this.y.animVal.getItem(this) + 25 + "px";
                output.innerHTML = tag;
//                output.style.top = y;
//                output.style.left = x;
                output.style.display = "block";
            }).on('mouseout', function () {
                var output = document.getElementById("tag");
                output.style.display = "none";
            });
            innerRects.on('mouseover', function (e) {
                //console.log(this);
                var tag = "";
                if (d3.select(this).data()[0].details != undefined) {
                    tag = "Task: " + d3.select(this).data()[0].type + "<br/>" +
//                                        "Type: " + d3.select(this).data()[0].type + "<br/>" +
                            "Starts: " + d3.select(this).data()[0].startTime + "<br/>" +
                            "Ends: " + d3.select(this).data()[0].endTime + "<br/>" +
                            "Duration: " + d3.select(this).data()[0].details;
                } else {
                    tag = "Task: " + d3.select(this).data()[0].type + "<br/>" +
//                                        "Type: " + d3.select(this).data()[0].type + "<br/>" +
                            "Starts: " + d3.select(this).data()[0].startTime + "<br/>" +
                            "Ends: " + d3.select(this).data()[0].endTime;
                }
                var output = document.getElementById("tag");
                var x = (this.x.animVal.value + this.width.animVal.value / 2) + "px";
                var y = this.y.animVal.value + 25 + "px";
                output.innerHTML = tag;
//                output.style.top = y;
//                output.style.left = x;
                output.style.display = "block";
            }).on('mouseout', function () {
                var output = document.getElementById("tag");
                output.style.display = "none";
            });
        }


        function makeGrid(theSidePad, theTopPad, w, h) {
            var xAxis = d3.svg.axis()
                    .scale(timeScale)
                    .orient('bottom')
                    .ticks(d3.time.minutes, 1)
                    .tickSize(-h + theTopPad + 20, 0, 0)
//                                .tickFormat(d3.time.format('%d %b'));
                    .tickFormat(d3.time.format('%H:%M'));
            var grid = svg.append('g')
                    .attr('class', 'grid')
                    .attr('transform', 'translate(' + theSidePad + ', ' + (h - 50) + ')')
                    .call(xAxis)
                    .selectAll("text")
                    .style("text-anchor", "middle")
                    .attr("fill", "#000")
                    .attr("stroke", "none")
                    .attr("font-size", 10)
                    .attr("dy", "1em");
        }

        function vertLabels(theGap, theTopPad, theSidePad, theBarHeight, theColorScale) {
            var numOccurances = new Array();
            var prevGap = 0;
            for (var i = 0; i < categories.length; i++) {
                numOccurances[i] = [categories[i], getCount(categories[i], catsUnfiltered)];
            }

            var axisText = svg.append("g") //without doing this, impossible to put grid lines behind text
                    .selectAll("text")
                    .data(numOccurances)
                    .enter()
                    .append("text")
                    .text(function (d) {

                            return d[0];
                    })
                    .attr("x", 10)
                    .attr("y", function (d, i) {
                        if (i > 0) {
                            for (var j = 0; j < i; j++) {
                                prevGap += numOccurances[i - 1][1];
                                // console.log(prevGap);
                                return d[1] * theGap / 2 + prevGap * theGap + theTopPad;
                            }
                        } else {
                            return d[1] * theGap / 2 + theTopPad;
                        }
                    })
                    .attr("font-size", 11)
                    .attr("text-anchor", "start")
                    .attr("text-height", 14)
                    .attr("fill", function (d) {
                        for (var i = 0; i < categories.length; i++) {

                            if (d[0] == categories[i]) {

                                return d3.rgb(theColorScale(i)).darker();
                            }

                        }
                    });
        }

//from this stackexchange question: http://stackoverflow.com/questions/1890203/unique-for-arrays-in-javascript
        function checkUnique(arr) {
            var hash = {}, result = [];
            for (var i = 0, l = arr.length; i < l; ++i) {
                if (!hash.hasOwnProperty(arr[i])) { //it works with objects! in FF, at least
                    hash[ arr[i] ] = true;
                    result.push(arr[i]);
                }
            }
            return result;
        }

//from this stackexchange question: http://stackoverflow.com/questions/14227981/count-how-many-strings-in-an-array-have-duplicates-in-the-same-array
        function getCounts(arr) {
            var i = arr.length, // var to loop over
                    obj = {}; // obj to store results
            while (i)
                obj[arr[--i]] = (obj[arr[i]] || 0) + 1; // count occurrences
            return obj;
        }

// get specific from everything
        function getCount(word, arr) {
            return getCounts(arr)[word] || 0;
        }
    }

</script>
