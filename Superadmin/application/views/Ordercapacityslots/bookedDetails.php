<?php
$status = 1;
?>

<style>
    .btn {
        /* font-size: 11px; */
        width: auto;
        border-radius: 30px;
    }
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }

    .bootstrap-timepicker-widget table td input{
        width: 60px;

    }

    input[type=checkbox] {
        margin: 4px 4px 0px 8px;
    }

    .span_topic{
        padding-left: 7px;
    }
    span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }

    .selectBox {
        position: relative;
    }
    .selectBox select {
        width: 100%;
        font-weight: bold;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    .selectedDrivers{

        height: 28px;
        padding: 6px;
        display: inline-flex;
        margin: 0px 1px 1px;
        font-weight: 600;
        /*background: #5bc0de;*/
        border: 1px solid;
        border-radius: 4px;

    }

    input[type=checkbox], input[type=radio] {
        margin: 4px 5px 0;
        line-height: normal;
    }
    .driverList{
        display: none;
    }
    span.RemoveMore{
        margin-left: 8px;cursor: pointer;
    }

    span.tag {
        padding:4px 8px;
        background-color: #5bc0de;
        font-size:10px;
        display: -webkit-inline-box;
        float: none; 
    }


    .label-info {
        background-color: #5bc0de;
    }


    .startDesc{
        height: 28px;
        padding: 6px;
        display: inline-flex;
        margin: 0px 1px 1px;
        font-weight: 600;
        /*background: #5bc0de;*/
        border: 1px solid;
        border-radius: 4px;
        /*width: 100%;*/
        max-width:400px
    }
    .inputDesc {
        width: 100%;
        min-width:15px!important;
        max-width:400px!important;
        border: none;
    }

    span.tag{
        font-weight: 600;
    }

    #checkboxes,#customerCities,#driversList,#customersList {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxes label,#customerCities label{
        display: block;
    }
    .datepicker{z-index:1151 !important;}
    table{
        color: #333333;
        font-size: 13px;
    }
    .sTable{
        border-collapse: collapse;
        width: 100%;
    }
    .sTable td,.sTable th{
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    .form-control{
        margin:3px 0;
    }
    .cls111{
        padding:0;
    }
</style>
<script type="text/javascript">
    var countTab1 = 0;
    var countTab2 = 0;
    var offset = new Date().getTimezoneOffset();
    Number.prototype.padLeft = function (base, chr) {
                var len = (String(base || 10).length - String(this).length) + 1;
                // console.log(len);
                return len > 0 ? new Array(len).join(chr || '0') + this : this;
            }

   function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
    }
    


    var html;
    var url;
    var expanded = false;
    var driverPushTopicType;
    var customerPushTopicType;
    var getSendPushTopic = [];
    var tab_id = 1;

    function dateTimeReturn(month,stTime){
        var mon = parseInt(month);
        var d = new Date();
            d.setMonth(d.getMonth()+mon);
                    dformat = [(d.getFullYear()),
                    (d.getMonth() + 1).padLeft(),
                        d.getDate().padLeft()].join('-') +
                    ' ' +stTime;
                    console.log(dformat);
                        return dformat
    }
        $(document).ready(function () {


        function callDataTable(status){
                
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/Deliveryschduled/datatable_getBookingDetails/<?php echo $deliveryworkingHourId ?>/'+offset,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                // "aoColumns": [
                //         {"sWidth": "5%"},
                //         {"sWidth": null},
                //         {"sWidth": null},
                //         {"sWidth": null},
                //         {"sWidth": null},
                //         //{"sWidth": null},
                //         {"sWidth":"5%"}
                //     ],
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
//                  $('#big_table_processing').hide();
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {


                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {

                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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
    }

    
        $(document).on('click','.btndelete',function () {
            var valid = $(this).attr('data-id');
            $('#msg_data').text("Are you sure you want to delete the slot?");
            $('#msgid').val(valid);
            $('#confirmModal').modal('show');

            
           
        });
        $(document).on('click','.dltSlot',function () {
            var valid = $(this).attr('data-id');
            // var date = $(this).attr('data-date');
            // var sTime = $(this).attr('data-starttime');
            // var eTime = $(this).attr('data-endtime');

            $('#msgsoltdata').text("Are you sure you want to delete the slot?");
            $('#msgsoltid').val(valid);
            // $('#msgsoltdate').val(date);
            // $('#msgsoltsTime').val(sTime);
            // $('#msgsolteTime').val(eTime);
            $('#slotConfirmModal').modal('show');
        });

        $('#yes').click(function(){
            var val = $('#msgid').val();
            if(val!=0 || val !='' || val!=null){
             //  console.log("val",val);
             $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Deliveryschduled/deleteSchduled",
                    type: "POST",
                    data: {
                        whId:val
                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        $('#confirmModal').modal('hide');
                        callDataTable(1);
                        $('#showMsg').text('Slot Deleted Successfully');
                        $('#afterDelete').modal('show');
                    }
                    })

           }
        });
        $('#yesSlot').click(function(){
            var val = $('#msgsoltid').val();
            // var date = $('#msgsoltdate').val();
            // var sTime = $('#msgsoltsTime').val();
            // var eTime = $('#msgsolteTime').val();

            // console.log(val,date,sTime,eTime);
            
            if(val!=0 || val !='' || val!=null || date!="" || sTime!="" || eTime!=""){
             //  console.log("val",val);
             $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Deliveryschduled/deleteParticularSlot",
                    type: "POST",
                    data: {
                        whId:val,
                        // date: date,
                        // sTime:sTime,
                        // eTime:eTime
                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        $('#slotConfirmModal').modal('hide');
                        $('#slotData').modal('hide');
                        callDataTable(1);
                        $('#showMsg').text('Slot Deleted Successfully');
                        $('#afterDelete').modal('show');
                        
                    }
                    })

           }
        });

       
        $('#datepicker-component').on('changeDate', function () {

            $('.datepicker').hide();
        });

        var currentTab = 1;
        $('.cs-loader').show();
       
        var tab_id = $(this).attr('data-id');
        var table = $('#big_table');
        var searchInput = $('#search-table1');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        // setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/Deliveryschduled/datatable_getBookingDetails/<?php echo $deliveryworkingHourId ?>/'+offset,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                // "aoColumns": [
                //         {"sWidth": "5%"},
                //         {"sWidth": null},
                //         {"sWidth": null},
                //         {"sWidth": null},
                //         {"sWidth": null},
                //         //{"sWidth": null},
                //         {"sWidth":"5%"}
                //     ],
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
//                  $('#big_table_processing').hide();
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {


                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {

                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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
        // }, 1000);

        $('#search-table1').keyup(function () {
            table.fnFilter($(this).val());
            if (tab_id == 1)
            {
                $('.createdSchedule').text("<?php echo $_COOKIE['TotalRecordDisplay']; ?>");
            } else {
               // console.log("number",<?php echo $_COOKIE['TotalRecordDisplay']; ?>);
                $('.NotcreatedSchedule').text("<?php echo $_COOKIE['TotalRecordDisplay']; ?>");
            }
        });
        
        $('#catid').change(function () {
            table.fnFilter($(this).val());
        });


        var count = 0;
        $('#big_table tr').each(function () {
            count++;
        });
        // console.log(count);

        $('#checkallBlock').css('display', 'none');
        $('.changeMode').click(function () {

            $("#search-table1").val("");
            var targetUrl = "";
           // var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            console.log('url', $(this).attr('data-id'));
            if ($(this).attr('data-id') == 1)
            {
               targetUrl = "<?php echo base_url(); ?>index.php?/Deliveryschduled/datatable_getProviderDetails/1/"+offset ;
            } else if($(this).attr('data-id') == 2) {
                targetUrl = "<?php echo base_url(); ?>index.php?/Deliveryschduled/datatable_getProviderDetails/2/"+offset ;
            }
            else{
                targetUrl = "<?php echo base_url(); ?>index.php?/Deliveryschduled/datatable_getProviderDetails/3/"+offset ;
            }
            

            


            var table = $('#big_table');
            tab_id = $(this).attr('data-id');
//            console.log(tab_id);

            if (tab_id != currentTab)
            {
                currentTab = tab_id;
                if (currentTab == '2')
                {
                    $("#start").show();
                    $("#end").hide();
                   // $("#searchData").show();
                    $('#checkallBlock').css('display', 'block');
                } else {
                    $("#start").show();
                    $("#end").show();
                    //$("#searchData").show();
                    $('#checkallBlock').css('display', 'none');
                }
                table.hide();
                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
//                    "sAjaxSource": $(this).attr('data'),
                    "sAjaxSource": targetUrl,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 20,
                    // "aoColumns": [
                    //     {"sWidth": "5%"},
                    //     {"sWidth": null},
                    //     {"sWidth": null},
                    //     {"sWidth": null},
                    //     {"sWidth": null},
                    //     //{"sWidth": null},
                    //     {"sWidth":"5%"}
                    // ],
                    "oLanguage": {
                    },
                    "fnInitComplete": function () {

                        table.show()

                    },
                    "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                          var tbl = $('#big_table').DataTable();
                        
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
                }
                $('.tabs_active').removeClass('active');
                $(this).parent().addClass('active');
                table.dataTable(settings);
                // search box for table
                $('#search-table').keyup(function () {
                    table.fnFilter($(this).val());
                });
                
            }
        });


        var dt = new Date();
        $('.datepicker-component').datepicker({
            format: 'dd/mm/yyyy',
            startDate: dt
//            endDate: date,
        });

        $('.datepicker-component,.datepicker-component1').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        $('.datepicker-component1').datepicker({
//            e ndDate: date,
            format: 'dd/mm/yyyy',
            startDate: dt

        });

        $('#big_table').on('init.dt', function () {


            // var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            // var status = urlChunks[urlChunks.length - 1];
            // //$('#big_table').dataTable().fnSetColumnVis([5], false);
            // if (status == 2)
            // {
            //    // console.log("status==",status);
            //     // $('#big_table').dataTable().fnSetColumnVis([5], false);
            //     // $('#big_table').dataTable().fnSetColumnVis([7], true);
            //     $('#big_table').dataTable().fnSetColumnVis([7], false);
            // }
            // if (status == 3)
            // {
            //     $('#big_table').dataTable().fnSetColumnVis([7], false);
            // }
        });


         $("#starttime").on('change',function(){
         $("#startTimeErr").text("");
          })


    });

    

</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-top: 60px;">

           <a href="<?php echo base_url() ?>index.php?/Deliveryschduled/slotDetails/<?php echo $deliveryworkingHourId;?>"> <strong style="font-size: 11px;margin-left: 15px;">SLOTS</strong></a> ><strong>Details</strong><!-- id="define_page"-->
        </div>
        <!-- <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
            <div class="hide_show">

                <div class="form-group">

                    
                    <div class="col-sm-1 " style="float:right;">
                        <div class="">
                            <button class="btn btn-info" type="button" id="AddSchedule" style="float:right;">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </ul> -->

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <!-- <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
                        <li id= "1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Deliveryschduled/datatable_getProviderDetails/1" data-id="1"><span>TODAY</span><span class="badge createdSchedule" style="background-color: #5bc0de;"></span></a>
                        </li>
                        <li id= "2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/Deliveryschduled/datatable_getProviderDetails/2" data-id="2"><span>PASSED</span><span class="badge NotcreatedSchedule" style="background-color: indianred;"></span></a>
                        </li>
                        <li id= "3" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/Deliveryschduled/datatable_getProviderDetails/3" data-id="3"><span>UPCOMING</span><span class="badge NotcreatedSchedule" style="background-color: indianred;"></span></a>
                        </li>
                        
                    </ul> -->

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent"><div class="cs-loader">
                                    <div class="cs-loader-inner" >
                                        <label class="loaderPoint" style="color:#10cfbd">●</label>
                                        <label class="loaderPoint" style="color:red">●</label>
                                        <label class="loaderPoint" style="color:#FFD119">●</label>
                                        <label class="loaderPoint" style="color:#4d90fe">●</label>
                                        <label class="loaderPoint" style="color:palevioletred">●</label>
                                    </div>
                                </div>


                            </div>
                        </div>

                         <div class="pull-right hide_show" ><input type="text" id="search-table1" class="form-control pull-right" placeholder="Search" style="display: block;margin-right: 15px;margin-top: 10px;width: 140px;border-radius: 13px"> </div> 
                        <!--<div class="pull-right hide_show" style="margin-right: 24px"  id='checkallBlock' style="display: none"> <input type="checkbox" value="110" id="" name="" class="allEditCheckbox"><b>SELECT ALL</b></div></div>  -->

                    <div class="panel-body">
                        <?php
                        echo $this->table->generate();
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<div class="modal fade stick-up" id="msg_model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >Alert</span>
            </div>
            <div class="modal-body">
                <p id="msgpara"></p>
                
            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box errors responseErr"></div>
                <div class="col-sm-8" > 
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Close</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >ADD SCHEDULE</span>
            </div>
            <div class="modal-body">
                <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">


                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label">Repeat Schedule<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select onchange="checkDays(this)" id="repeatDay" name="repeatDay"  class="form-control error-box-class">
                                <option value=0>Select Schedule</option>
                                <option value=1>Every-Day</option>
                                <option value=2>Week-Day</option>
                                <option value=3>Week-End</option>
                                <option value=4>Select Days</option>
                            </select>
                        </div>
                        <div class="col-sm-3 error-box errors" id="RepeatScheduleError">
                        </div>
                    </div>


                    <div class="form-group" class="formex" id='bTypeBlock' style="display: none">
                        <label for="fname" class="col-sm-4 control-label ">Days<span style="color:red;font-size: 12px"></span></label>
                        <div class="col-md-6 col-sm-5 col-xs-12">
                            <label><input type="checkbox" class="messageCheckbox" id="Mon"  value="Mon" name="schedule[]"> Mon</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Tue"  value="Tue" name="schedule[]"> Tue</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Wed"  value="Wed" name="schedule[]"> Wed</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Thu"  value="Thu" name="schedule[]"> Thu</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Fri"  value="Fri" name="schedule[]"> Fri</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Sat"  value="Sat" name="schedule[]"> Sat</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Sun"  value="Sun" name="schedule[]"> Sun</label>  &nbsp;
                        </div>
                        <div class="col-sm-3 error-box errors" id="DaysErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label">Duration<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select onchange="checkDuration(this)" id="duration" name="duration"  class="form-control error-box-class">
                                <option value=0>Select Duration</option>
                                <option value=1>This Month</option>
                                <option value=2>2 Months</option>
                                <option value=3>3 Months</option>
                                <option value=4>4 Months</option>
                                <option value=5>Custom</option>
                            </select>
                        </div>
                        <div class="col-sm-3 error-box errors" id="durationErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex" id='startDateBlock' style="display: none">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Start Date"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control datepicker-component" name="startt" id="startt" placeholder="From Date">
                        </div>
                        <div class="col-sm-3 error-box errors" id="startDateErr">
                        </div>
                    </div>
                    <div class="form-group" class="formex" id='endDateBlock' style="display: none">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "End Date"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control datepicker-component" name="endd" id="endd" placeholder="To Date">
                        </div>
                        <div class="col-sm-3 error-box errors" id="endDateErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Start Time"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                            <!--<input type="text"  id="stimeHour" name="stimeHour"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)"><span  class="abs_text" id="sym1">Hour<span>-->
<!--                            <select id="stimeHour" name="stimeHour"  class="form-control error-box-class">
                            <?php
//                                for ($i = 1; $i < 25; $i++) {
//                                    if ($i < 10)
//                                        echo "<option value=0" . $i . ">0" . $i . "</option>";
//                                    else
//                                        echo "<option value=" . $i . ">" . $i . "</option>";
//                            }
                            ?>
                            </select><span  class='abs_text' id='sym1'>Hour<span>-->


                            <input type="text" name="timepicker" class="form-control timepicker" id="starttime"/>


                        </div>

                        <!--                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <input type="text"  id="stimeMinute" name="stimeMinute"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)"><span  class="abs_text" id="sym1">Minute<span>
                                                    <select id="stimeMinute" name="stimeMinute"  class="form-control error-box-class">
                        <?php
                        for ($i = 1; $i < 61; $i++) {
                            if ($i < 10)
                                echo "<option value=0" . $i . ">0" . $i . "</option>";
                            else
                                echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>
                                                    </select><span  class='abs_text' id='sym1'>Minute<span>
                                                            </div>-->
                        <div class="col-sm-3 error-box errors" id="startTimeErr">
                        </div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "End Time"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12  bootstrap-timepicker" >

<!--<select id="etimeHour" name="etimeHour"  class="form-control error-box-class">-->
                            <?php
//                                                for ($i = 1; $i < 25; $i++) {
//                                                    if ($i < 10)
//                                                        echo "<option value=0" . $i . ">0" . $i . "</option>";
//                                                    else
//                                                        echo "<option value=" . $i . ">" . $i . "</option>";
//                                                }
                            ?>

<!--</select><span  class='abs_text' id='sym1'>Hour<span>-->
                            <input type="text" name="timepicker" class="form-control timepicker" id="endtime"/>
                        </div>

                        <!--                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                                                <input type="text"  id="etimeMinute" name="etimeMinute"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)"><span  class="abs_text" id="sym1">Minute<span>
                                                                                <select id="etimeMinute" name="etimeMinute"  class="form-control error-box-class">
                        <?php
                        for ($i = 1; $i < 61; $i++) {
                            if ($i < 10)
                                echo "<option value=0" . $i . ">0" . $i . "</option>";
                            else
                                echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>
                                                                                </select>
                                                                                <span  class='abs_text' id='sym1'>Minute<span>
                                                                                        </div>-->


                        <div class="col-sm-3 error-box errors" id="startTimeErr">
                        </div>
                    </div>
                    <div class="form-group" class="formex" id='notesId'>
                        <label for="fname" class="col-sm-4 control-label"><?php echo "No of Delivery"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control" name="notes" id="noofdelivery"  onkeypress="return isNumber(event)" placeholder="Enter of Delivery">
                        </div>
                         <div class="col-sm-3 error-box errors" id="noofdeliveryErr">
                        </div>
                    </div>



                </form>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box errors responseErr"></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="insert_cat_group" ><?php echo "Add"; ?></button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="addParticularSlot" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >ADD PARTICULAR TIME SLOT</span>
            </div>
            <div class="modal-body">
                
                <input type="hidden" id="objectid" value=''>
                <div class="form-group" class="formex" id='particularDate'>
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Choose Date"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control datepicker-component" name="pDate" id="pDate" placeholder="From Date">
                        </div>
                        <div class="col-sm-3 error-box errors" id="pDateError">
                        </div>
                    </div>
                            <!-- timepickeer -->
					
					<div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Start Time"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                           
                            <input type="text" name="timepicker" class="form-control timepicker" id="startTimeSlot"/>


                        </div>

                        <!--                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                    <input type="text"  id="stimeMinute" name="stimeMinute"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)"><span  class="abs_text" id="sym1">Minute<span>
                                                    <select id="stimeMinute" name="stimeMinute"  class="form-control error-box-class">
                        <?php
                        for ($i = 1; $i < 61; $i++) {
                            if ($i < 10)
                                echo "<option value=0" . $i . ">0" . $i . "</option>";
                            else
                                echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>
                                                    </select><span  class='abs_text' id='sym1'>Minute<span>
                                                            </div>-->
                        <div class="col-sm-3 error-box errors" id="startTimeSlotErr">
                        </div>
					
                    </div>
                    
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "End Time"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12  bootstrap-timepicker" >
                            <input type="text" name="timepicker" class="form-control timepicker" id="endTimeSlot"/>
                        </div>

                        <!--                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                                                <input type="text"  id="etimeMinute" name="etimeMinute"  class="form-control error-box-class" placeholder="" onkeypress="return isNumberKey(event)"><span  class="abs_text" id="sym1">Minute<span>
                                                                                <select id="etimeMinute" name="etimeMinute"  class="form-control error-box-class">
                        <?php
                        for ($i = 1; $i < 61; $i++) {
                            if ($i < 10)
                                echo "<option value=0" . $i . ">0" . $i . "</option>";
                            else
                                echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?>
                                                                                </select>
                                                                                <span  class='abs_text' id='sym1'>Minute<span>
                                                                                        </div>-->


                        <div class="col-sm-3 error-box errors" id="endTimeSlotErr">
                        </div>
                    </div>

                   <!-- end timepicker -->
                   
            </div>
            <div class="modal-footer">
               
                    <button type="button"  class="btn btn-primary btn-cons" id="addSlot" style>Add</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons " id="cancel">Close</button></div>
                
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="confirmModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >Alert</span>
            </div>
            <div class="modal-body">
                <h5 id="msg_data"></h5>
                <input type="hidden" id="msgid" value=''>
            </div>
            <div class="modal-footer">
               
                    <button type="button"  class="btn btn-primary btn-cons" id="yes" style>Delete</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons " id="cancel">Close</button></div>
                
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="showSlot" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >Show Slot</span>
            </div>
            <div class="modal-body">
                <input type="hidden" id="slotId" value=''>
                <div class="form-group" class="formex" id=''>
                        <label for="date" class="col-sm-4 control-label">Choose Date<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control datepicker-component" name="sDate" id="sDate" placeholder="Date">
                        </div>
                        <div class="col-sm-3 error-box errors" id="sDateError">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="button"  class="pull-left" id="doSearchAll" style="background: transparent;color: #2828da;border: none;">Show All Slots</button>
                    <button type="button"  class="btn btn-primary btn-cons" id="doSearch" style>Search</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons " id="cancel">Close</button></div>
                
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="slotData" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >Particular Slots Details</span>
            </div>
            <div class="modal-body">
                <div id="tableData"></div>
            </div>
            <div class="modal-footer">
               
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons " id="cancel">Close</button></div>
                
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="slotConfirmModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >Alert</span>
            </div>
            <div class="modal-body">
                <h5 id="msgsoltdata"></h5>
                <input type="hidden" id="msgsoltid" value=''>
                <input type="hidden" id="msgsoltdate" value=''>
                <input type="hidden" id="msgsoltsTime" value=''>
                <input type="hidden" id="msgsolteTime" value=''>
            </div>
            <div class="modal-footer">
               
                    <button type="button"  class="btn btn-primary btn-cons" id="yesSlot" style>Delete</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons " id="cancel">Close</button></div>
                
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="afterDelete" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >Alert</span>
            </div>
            <div class="modal-body">
                <div><h5 id ="showMsg"></h5></div>
            </div>
            <div class="modal-footer">
               
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons " id="cancel">Close</button></div>
                
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



