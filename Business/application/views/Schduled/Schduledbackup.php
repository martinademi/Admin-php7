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
    

    function checkDays(val)
    {
        $("#RepeatScheduleError").text("");
        $('#bTypeBlock').css('display', 'none');
        if ($("#repeatDay").val() == "4")
        {
            $('#bTypeBlock').css('display', 'block');
        }
    }

    function checkDuration(val)
    {
        $("#durationErr").text("");              
        $('#startDateBlock').css('display', 'none');
        $('#endDateBlock').css('display', 'none');
        if ($("#duration").val() == "5")
        {
//            if ($("#repeatDay").val() != "4")
//            {
            $('#startDateBlock').css('display', 'block');
            $('#endDateBlock').css('display', 'block');
//            }
        }
    }
   
    


    var html;
    var url;
    var expanded = false;
    var driverPushTopicType;
    var customerPushTopicType;
    var getSendPushTopic = [];
    var tab_id = 1;

    function dateTimeReturn(month,stTime){
        var mon = parseInt(month)+1;
        var d = new Date,
                    dformat = [(d.getFullYear()),
                    (d.getMonth() + mon).padLeft(),
                        d.getDate().padLeft()].join('-') +
                    ' ' +stTime;
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Schduled/datatable_getProviderDetails/'+status+'/'+offset,
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
                                    // $('.cs-loader').hide();
                                    // table.show()
                                    // searchInput.show()
                                    $('#big_table').fadeIn('slow');
                                    $('#big_table_processing').hide();
                                },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {


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
    }

        $('#repeatDay').change(function(){
           //$('.messageCheckbox').prop("checked",false);
           var repeatDayVal = $('#repeatDay').val();
           if(repeatDayVal ==1){
            $('.messageCheckbox').prop("checked",true);
           }
           else if(repeatDayVal == 2){
               $("#Mon").prop("checked",true);
               $("#Tue").prop("checked",true);
               $("#Wed").prop("checked",true);
               $("#Thu").prop("checked",true);
               $("#Fri").prop("checked",true);
               $("#Sat").prop("checked",false);
               $("#Sun").prop("checked",false);
           }
           else if(repeatDayVal == 3){
               $("#Mon").prop("checked",false);
               $("#Tue").prop("checked",false);
               $("#Wed").prop("checked",false);
               $("#Thu").prop("checked",false);
               $("#Fri").prop("checked",false);
               $("#Sat").prop("checked",true);
               $("#Sun").prop("checked",true);
           }
           else{
            $('.messageCheckbox').prop("checked",false);
           }
        })
        $('#myModal').on('hidden.bs.modal', function () {
            $('#bTypeBlock').css('display', 'none');
            $('#startDateBlock').css('display', 'none');
            $('#endDateBlock').css('display', 'none');
            $(this).find('form')[0].reset();
        });
        $(document).on('click','.btnedit',function () {
            console.log("check")
            var val = $(this).attr('data-id');
            alert(val);
        });
        $(document).on('click','.btnslot',function () {
            $('#addSlot').prop('disabled',false);
            $('#pDate').val('');
            var valid = $(this).attr('data-id');
            //console.log(valid)
            $('#objectid').val(valid);
            $('#addParticularSlot').modal('show');

            
           
        });
        $(document).on('click','.btnview',function () {
            // $('#tableData').text('');
            // var valid = $(this).attr('data-id');
            // $.ajax({
            //         url: "<?php echo base_url() ?>index.php?/Schduled/getSlotSchduled",
            //         type: "POST",
            //         data: {
            //             whId:valid
            //         },
            //         dataType: 'json',
            //         success: function (response)
            //         {
            //             $('#tableData').append(response);
            //             $('#slotData').modal('show');
            //         }
            //         })
            var valid = $(this).attr('data-id');
            $('#slotId').val(valid);
            $('#showSlot').modal('show');

            
           
        });
        $(document).on('click','.btndelete',function () {
            var valid = $(this).attr('data-id');
            $('#msg_data').text("Are you sure you want to delete the slot?");
            $('#msgid').val(valid);
            $('#confirmModal').modal('show');

            
           
        });
        $(document).on('click','.dltSlot',function () {
            var valid = $(this).attr('data-id');
            var date = $(this).attr('data-date');
            var sTime = $(this).attr('data-starttime');
            var eTime = $(this).attr('data-endtime');
            console.log(valid,date,sTime,eTime);
            $('#msgsoltdata').text("Are you sure you want to delete the slot?");
            $('#msgsoltid').val(valid);
            $('#msgsoltdate').val(date);
            $('#msgsoltsTime').val(sTime);
            $('#msgsolteTime').val(eTime);
            $('#slotConfirmModal').modal('show');
        });

        $('#doSearch').click(function(){
            $('#tableData').text('');
            //var valid = $(this).attr('data-id');
            var valid = $('#slotId').val();
            var dateObject = $("#sDate").datepicker("getDate");
            var slotDate = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject.getDate()).slice(-2);   
            console.log(slotDate);
            if(slotDate==''||slotDate==null || slotDate=='NaN-aN-aN'){
                alert("Date is mandatory ");
            } 
            else{
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Schduled/getSlotSchduled",
                    type: "POST",
                    data: {
                        whId:valid,
                        date:slotDate,
                        offset:offset
                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        $('#tableData').append(response);
                        $('#slotData').modal('show');
                    }
                    })
            }
            
        })
        $('#doSearchAll').click(function(){
            $('#tableData').text('');
            var valid = $('#slotId').val();
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Schduled/getSlotSchduled",
                    type: "POST",
                    data: {
                        whId:valid,
                        offset:offset
                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        $('#tableData').append(response);
                        $('#slotData').modal('show');
                    }
                    })
        })


        $('#yes').click(function(){
            var val = $('#msgid').val();
            if(val!=0 || val !='' || val!=null){
             //  console.log("val",val);
             $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Schduled/deleteSchduled",
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
            var date = $('#msgsoltdate').val();
            var sTime = $('#msgsoltsTime').val();
            var eTime = $('#msgsolteTime').val();

            console.log(val,date,sTime,eTime);
            
            if(val!=0 || val !='' || val!=null || date!="" || sTime!="" || eTime!=""){
             //  console.log("val",val);
             $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Schduled/deleteParticularSlot",
                    type: "POST",
                    data: {
                        whId:val,
                        date: date,
                        sTime:sTime,
                        eTime:eTime
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

        $('#addSlot').click(function(){
            Number.prototype.padLeft = function (base, chr) {
                var len = (String(base || 10).length - String(this).length) + 1;
                return len > 0 ? new Array(len).join(chr || '0') + this : this;
            }
            var offset = new Date().getTimezoneOffset();
            var objId=$('#objectid').val();
            var sTimeSlot = $('#startTimeSlot').val();
            var eTimeSlot = $('#endTimeSlot').val();
            var clientST = sTimeSlot;
            var clientET = eTimeSlot;
            //var slotDate = $('#pDate').val();
            var dateObject = $("#pDate").datepicker("getDate");

            var slotDateStart = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject.getDate()).slice(-2)+' '+sTimeSlot;

            slotDateStart = new Date(slotDateStart);
            slotDateStart.setMinutes(slotDateStart.getMinutes() + offset);
            sTimeSlot = [slotDateStart.getHours().padLeft(),
                        slotDateStart.getMinutes().padLeft(),
                        slotDateStart.getSeconds().padLeft()].join(':');

            var slotDateEndTime = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) +              '-' + ("0" + dateObject.getDate()).slice(-2)+' '+eTimeSlot;    
           
            slotDateEndTime = new Date(slotDateEndTime);
            slotDateEndTime.setMinutes(slotDateEndTime.getMinutes() + offset);
            eTimeSlot = [slotDateEndTime.getHours().padLeft(),
                        slotDateEndTime.getMinutes().padLeft(),
                        slotDateEndTime.getSeconds().padLeft()].join(':');
            


            var slotDate = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject.getDate()).slice(-2);
            var slotDate4StartTS = slotDate+' '+clientST;
            var slotDate4EndTS = slotDate+' '+clientET;
            slotDate = new Date(slotDate);
            slotDate.setMinutes(slotDate.getMinutes() + offset);
            slotDate = [
                    slotDate.getFullYear(),(slotDate.getMonth()+1).padLeft(),slotDate.getDate().padLeft()
                ].join('-');


            console.log("obj id = ",objId,"date = ",slotDate,"stime = ",sTimeSlot,"eTime= ",eTimeSlot);
            
            if($("#pDate").val() == '' )
            {
                $('#pDateError').text("Please enter correct date");
            }
            else if(sTimeSlot == ''){
                $('#startTimeSlotErr').text("Please enter Start time");
            }
            else if(eTimeSlot == ''){
                $('#endTimeSlotErr').text("Please enter end time");
            }
            else if(sTimeSlot.localeCompare(eTimeSlot)>=0){
                    $('#startTimeSlotErr').text("Start time should be less than end time");
                }
            else{
                $('#addSlot').prop('disabled',true);
            $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Schduled/addSlotSchduled",
                    type: "POST",
                    data: {
                        objId:objId,
                        slotDate:slotDate,
                        sTimeSlot:sTimeSlot,
                        slotDate4StartTS:slotDate4StartTS,
                        slotDate4EndTS:slotDate4EndTS,
                        eTimeSlot:eTimeSlot
                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        if(response.flag ==1){
                            $('#addParticularSlot').modal('hide');
                            callDataTable(1);
                            $("#msgpara").text(response.msg);
                            $("#msg_model").modal('show');
                        }
                        else{
                            $('#addParticularSlot').modal('hide');
                            $("#msgpara").text(response.msg);
                            $("#msg_model").modal('show');
                        }
                        
                    }
                    })
                }
                
        })

        $("#insert_cat_group").click(function () {
           
            // var fid = $('.checkbox:checked').map(function () {
            //     return this.value;
            // }).get();

            Number.prototype.padLeft = function (base, chr) {
                var len = (String(base || 10).length - String(this).length) + 1;
                return len > 0 ? new Array(len).join(chr || '0') + this : this;
            }
            
            //get current time
            var offset = new Date().getTimezoneOffset();
           // console.log("offset",offset);
            var d = new Date();
                d.setMinutes(d.getMinutes() + offset);
                    dformat = [(d.getFullYear()),
                    (d.getMonth() + 1).padLeft(),
                        d.getDate().padLeft()].join('-') +
                    ' ' +
                [d.getHours().padLeft(),
                        d.getMinutes().padLeft(),
                        d.getSeconds().padLeft()].join(':');

            var deviceTime = dformat;
            //end   
            var notes = $('#scheduleNotes').val();
            var startTime = $('#starttime').val();
            var endTime = $('#endtime').val();
            var stTime = startTime+":00";
            var enTime = endTime+":00";
            console.log('startTime', startTime);
            console.log('endTime', endTime);  

            var dateObject = $("#startt").datepicker("getDate");
            var startDate = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject.getDate()).slice(-2)+' '+stTime;
            

            var dateObject = $("#endd").datepicker("getDate"); // get the date object
            var endDate = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject.getDate()).slice(-2)+' '+enTime;
            
            var repeatDay = parseInt($("#repeatDay").val());
            var duration = $('#duration').val();

            

            var day = [];
            if ($('#Mon').is(":checked") == true)
            {
                day.push("Mon");
            }
            if ($('#Tue').is(":checked") == true)
            {
                day.push("Tue");
            }
            if ($('#Wed').is(":checked") == true)
            {
                day.push("Wed");
            }
            if ($('#Thu').is(":checked") == true)
            {
                day.push("Thu");
            }
            if ($('#Fri').is(":checked") == true)
            {
                day.push("Fri");
            }
            if ($('#Sat').is(":checked") == true)
            {
                day.push("Sat");
            }
            if ($('#Sun').is(":checked") == true)
            {
                day.push("Sun");
            }
            if (day.length <= 0)
            {
                console.log("dayddd");
                day = null;
            }

            var catStatus = true;
            var daysflag = false;

            if ($("#repeatDay").val() == "0" || $("#repeatDay").val() == "")
            {
                $("#RepeatScheduleError").text("Please Select Repeat Schedule");
                catStatus = false;
            } else if ($("#repeatDay").val() == "4")
            {

                $("[name='schedule[]']:checked").each(function () {

                    daysflag = true;
                    // do stuff
                });
                if (!daysflag) {
                    catStatus = false;
                    $("#DaysErr").text("Please Select atleast one day.");
                }

            }



            if ($("#duration").val() == "0" || $("#duration").val() == "")
            {
                $("#durationErr").text("Please Select Duration");
                catStatus = false;
            } else if ($("#duration").val() == "5") {
                if ($("#startt").val() == "")
                {
                    catStatus = false;
                    $("#startDateErr").text("Please select start date.");
                }
                if ($("#endd").val() == "")
                {
                    catStatus = false;
                    $("#endDateErr").text("Please select end date.");
                }

            }
            if(startTime >= endTime){
                catStatus = false;
                $("#startTimeErr").text("Start time and end time is not correct");

            }
            var mydu =parseInt($("#duration").val()); 
            if(mydu > 0  && mydu < 5 )
            {
                switch(mydu){
                    case 1:
                        startDate = dateTimeReturn(0,stTime);
                        endDate = dateTimeReturn(1,enTime);
                        break;
                        case 2:
                            startDate = dateTimeReturn(0,stTime);
                            endDate = dateTimeReturn(2,enTime);
                        break;
                        case 3:
                            startDate = dateTimeReturn(0,stTime);
                            endDate = dateTimeReturn(3,enTime);
                        break;
                        case 4:
                        startDate = dateTimeReturn(0,stTime);
                        endDate = dateTimeReturn(4,enTime);
                        break;
                }
            }
            var startTime4TS = startDate;
            var endTime4TS = endDate;
            startDate = new Date(startDate);
            startDate.setMinutes(startDate.getMinutes() + offset);

            startTime = [startDate.getHours().padLeft(),
              startDate.getMinutes().padLeft(),
              startDate.getSeconds().padLeft()].join(':');

            startDate = [
                    startDate.getFullYear(),(startDate.getMonth()+1).padLeft(),startDate.getDate().padLeft()
                ].join('-')+' '+
              [startDate.getHours().padLeft(),
              startDate.getMinutes().padLeft(),
              startDate.getSeconds().padLeft()].join(':');



            endDate = new Date(endDate);
            endDate.setMinutes(endDate.getMinutes() + offset);
            endTime = [endDate.getHours().padLeft(),
              endDate.getMinutes().padLeft(),
              endDate.getSeconds().padLeft()].join(':');

            endDate = [
                    endDate.getFullYear(),(endDate.getMonth()+1).padLeft(),endDate.getDate().padLeft()
                ].join('-')+' '+
              [endDate.getHours().padLeft(),
              endDate.getMinutes().padLeft(),
              endDate.getSeconds().padLeft()].join(':');
             
            if (catStatus)
            {
                $("#insert_cat_group").prop("disabled",true);
               // console.log("start date=",startDate,"end date=",endDate,"startTime=",startTime,"endTime=",endTime,"deviceTime=",deviceTime,"repeatDay=",repeatDay,"days=",day,"duration=",duration, "notes=",notes)
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Schduled/addSchduled",
                    type: "POST",
                    data: {
                        //BusinessId:fid,
                        startTime: startTime,
                        endTime: endTime,
                        startDate: startDate,
                        endDate: endDate,
                        startTime4TS : startTime4TS,
                        endTime4TS : endTime4TS,
                        deviceTime: deviceTime,
                        //repeatDay: repeatDay,
                        days: day,
                        duration: duration,
                        status: 1,
                        notes: notes                     
                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        console.log(response);
                        if (response.flag == 1)
                        {
                            console.log("insert msg= ",response.msg)   
                            $(".close").trigger('click');
                            $("#repeatDay").val("0");
                            $("#duration").val("0");
                             // rload datatable
                             callDataTable(1);                                                               


                          
                        }
                        else if(response.flag == 2){
                            console.log("not insert msg= ",response.msg)
                           // $(".close").trigger('click');
                           $("#myModal").modal('hide');
                            $("#repeatDay").val("0");
                            $("#duration").val("0");
                            $("#msgpara").text(response.msg);
                            $("#msg_model").modal('show');

                        }
                    }
                });
            }

        });

        $('.allEditCheckbox').click(function () {
            if ($('.allEditCheckbox').is(':checked'))
                $('.checkAllEditCheckobx').attr('checked', true);
            else
                $('.checkAllEditCheckobx').attr('checked', false);
        });

        $('#datepicker-component').on('changeDate', function () {

            $('.datepicker').hide();
        });

        // $('#big_table').on('init.dt', function () {


        //     var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
        //     var status = urlChunks[urlChunks.length - 2];
        //     switch(status){
        //         case 2: 
        //         $('#big_table').dataTable().fnSetColumnVis([7], false);
        //         break;
        //         case 3:
        //         $('#big_table').dataTable().fnSetColumnVis([7], false);
        //         break;
        //     }
            
        // });


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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/Schduled/datatable_getProviderDetails/1/'+offset,
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

        //$("#AddSchedule").hide();
        $('#checkallBlock').css('display', 'none');
        $('.changeMode').click(function () {

            $("#search-table1").val("");
            var targetUrl = "";
            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            console.log('url', $(this).attr('data-id'));
            if ($(this).attr('data-id') == 1)
            {
               targetUrl = "<?php echo base_url(); ?>index.php?/Schduled/datatable_getProviderDetails/1/"+offset ;
            } else if($(this).attr('data-id') == 2) {
                targetUrl = "<?php echo base_url(); ?>index.php?/Schduled/datatable_getProviderDetails/2/"+offset ;
            }
            else{
                targetUrl = "<?php echo base_url(); ?>index.php?/Schduled/datatable_getProviderDetails/3/"+offset ;
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
                    $("#AddSchedule").show();
                    $('#checkallBlock').css('display', 'block');
                } else {
                    $("#start").show();
                    $("#end").show();
                    //$("#searchData").show();
                    $("#AddSchedule").show();
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



        $("#AddSchedule").click(function () {
            $('#insert_cat_group').prop('disabled',false);
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length >= 1) {
                $("#msgpara").text("Invalid Selection");
                $("#msg_model").modal('show');
            } else
            {
                $('#myModal').modal('show');
                
            }


        });

        $('#big_table').on('init.dt', function () {


            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            //$('#big_table').dataTable().fnSetColumnVis([5], false);
            if (status == 2)
            {
               // console.log("status==",status);
                // $('#big_table').dataTable().fnSetColumnVis([5], false);
                // $('#big_table').dataTable().fnSetColumnVis([7], true);
                $('#big_table').dataTable().fnSetColumnVis([7], false);
            }
            if (status == 3)
            {
                $('#big_table').dataTable().fnSetColumnVis([7], false);
            }
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

            <strong style="font-size: 12px;margin-left: 15px;">WORKING HOURS</strong><!-- id="define_page"-->
        </div>
        <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
            <div class="hide_show">

                <div class="form-group">

                    
                    <div class="col-sm-1 " style="float:right;">
                        <div class="">
                            <button class="btn btn-info" type="button" id="AddSchedule" style="float:right;">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </ul>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
                        <li id= "1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Schduled/datatable_getProviderDetails/1" data-id="1"><span>ACTIVE</span><span class="badge createdSchedule" style="background-color: #5bc0de;"></span></a>
                        </li>
                        <li id= "2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/Schduled/datatable_getProviderDetails/2" data-id="2"><span>EXPIRED</span><span class="badge NotcreatedSchedule" style="background-color: indianred;"></span></a>
                        </li>
                        <li id= "3" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/Schduled/datatable_getProviderDetails/3" data-id="3"><span>DELETED</span><span class="badge NotcreatedSchedule" style="background-color: indianred;"></span></a>
                        </li>
                        
                    </ul>

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
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Notes"; ?></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control" name="notes" id="scheduleNotes" placeholder="Enter Notes">
                        </div>
                        <!--" <div class="col-sm-3 error-box errors" id="startDateErr">
                        </div> -->
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



