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
    var driverval;
    var driverName;
    var countryCode;
    var mobile;
    var deleteSlotid;


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
   
      function isNumberKey(evt, obj) {
         

            var charCode = (evt.which) ? evt.which : event.keyCode
            var value = obj.value;
            var dotcontains = value.indexOf(".") != -1;
            if (dotcontains)
                if (charCode == 46) return false;
            if (charCode == 46) return true;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    


    var html;
    var url;
    var expanded = false;
    var driverPushTopicType;
    var customerPushTopicType;
    var getSendPushTopic = [];
    var tab_id = 1;
    var zId='<?php echo $zoneId; ?>';
    var sId='<?php echo $slotId; ?>';

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
                                    console.log('first');
                        function callDataTable(zoneId, status){
                               
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/DeliveryAssignDriver/datatable_getProviderDetails/'+zoneId+'/'+status+'/'+offset,
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                              
                                "oLanguage": {
                                },
                                "fnInitComplete": function () {
                                  
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

       
        $('#doSearchAll').click(function(){
            $('#tableData').text('');
            var valid = $('#slotId').val();
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/DeliveryAssignDriver/getSlotSchduled",
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
             var zoneId = '<?php echo $zoneId; ?>';
             $.ajax({
                    url: "<?php echo base_url() ?>index.php?/DeliveryAssignDriver/deleteSchduled",
                    type: "POST",
                    data: {
                        whId:val
                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        $('#confirmModal').modal('hide');
                        callDataTable(zoneId,1);
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
            var zoneId = '<?php echo $zoneId; ?>'
            if(val!=0 || val !='' || val!=null || date!="" || sTime!="" || eTime!=""){
             //  console.log("val",val);
             $.ajax({
                    url: "<?php echo base_url() ?>index.php?/DeliveryAssignDriver/deleteParticularSlot",
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
                        callDataTable(zoneId,1);
                        $('#showMsg').text('Slot Deleted Successfully');
                        $('#afterDelete').modal('show');
                        
                    }
                    })

           }
        });

        $('#addSlot').click(function(){
           
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
                var zoneId = '<?php echo $zoneId; ?>'
            $.ajax({
                    url: "<?php echo base_url() ?>index.php?/DeliveryAssignDriver/addSlotSchduled",
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
                            callDataTable(zoneId,1);
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

        $('#storeFilter').on('change', function () {
               
                driverval = $('#storeFilter option:selected').val();
                driverName =$('#storeFilter option:selected').attr('drivername');    
                countryCode=$('#storeFilter option:selected').attr('countryCode');    
                mobile=$('#storeFilter option:selected').attr('mobile');                   
                
        });

        $("#insert_cat_group").click(function () {
            

            var orderCapacity=$('#orderCapacity').val();
            var zoneDeliveryId='<?php echo $zoneDeliveryId; ?>';
            var listInZone;
            if ($('#listInZone').is(':checked')) {
                listInZone=1;		
	     	}else{
                listInZone=0;		
             }

            console.log('listInZone----',listInZone);
             
               $.ajax({
                    url: "<?php echo base_url('index.php?/DeliveryAssignDriver') ?>/addDriver",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        driverval:driverval,
                        driverName:driverName,
                        orderCapacity:orderCapacity,
                        mobile:mobile,
                        countryCode:countryCode,
                        zoneDeliveryId:zoneDeliveryId,
                        listInZone:listInZone


                    },
                    success: function (result) {

                       
                        location.reload();

                    }

                });

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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/DeliveryAssignDriver/datatable_getProviderDetails/<?php echo $zoneId; ?>/1/'+offset+'/<?php echo $zoneDeliveryId; ?>',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
               
                "oLanguage": {
                },
                "fnInitComplete": function () {
                   
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
            $('#driverAssignModal').modal('show');

        });

       

        

       

       

        // add schedule modal
        $(document).on('click','.scheduleModal',function () {
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


         $("#starttime").on('change',function(){
         $("#startTimeErr").text("");
          })


          $.ajax({
                url: "<?php echo base_url(); ?>index.php?/DeliveryAssignDriver/getDriver",
                type: "POST",
                data: {
                    zoneId:'<?php echo $zoneDeliveryId;?>'
                },
                dataType: "JSON",
                
                success: function (result) {
                     $('#storeFilter').empty();
                
                    if(result.data){
                         
                          var html15 = '';
				   var html15 = '<option storeName="" value="" >Select Driver</option>';
                          $.each(result.data, function (index, row) {
                            
                              html15 += '<option value="'+row._id.$oid+'" driverName="'+row.firstName+'" countryCode="'+row.countryCode+'" mobile="'+row.mobile+'">'+row.firstName+'</option>';                             
                          });
                            $('#storeFilter').append(html15);    
                    }

                     
                }
            });



            $('#big_table').on("click", '.checkboxProduct', function () {
               
                var id = $(this).val();
                if($(this). prop("checked") == true){
                   $("#"+id).prop('disabled',false);                    
                }
                else{
                  //  $("#"+id).val('');
                    $("#"+id).prop('disabled',true);                    
                }         
            });

            
        //     $('#big_table').on("click", '.deleteDriverSlot', function () {
        //         var driverId=$(this).attr('data-id');
        //         var zoneDeliveryId='<?php echo $zoneDeliveryId; ?>';
        //         console.log(driverId);

        //         $.ajax({
        //                 url: "<?php echo base_url() ?>index.php?/DeliveryAssignDriver/deleteDriverSlot/"+zoneDeliveryId+'/'+driverId,
        //                 type: "POST",
        //                 data: {
        //                     driverId:driverId
        //                 },
        //                 dataType: 'json',   
        //                 success: function (response)
        //                 {
        //                     location.reload();
        //                 }
        //             });
              
        //    });

           $('#big_table').on("click", '.deleteDriverSlot', function () {

               $('#driverslotdelete').modal('show');
               var driverId=$(this).attr('data-id');
               deleteSlotid=driverId;
              
           });

           

           $('#deleteSlotmodal').click(function(){

            driverId=deleteSlotid;
            var zoneDeliveryId='<?php echo $zoneDeliveryId; ?>';
            $.ajax({
                    url: "<?php echo base_url() ?>index.php?/DeliveryAssignDriver/deleteDriverSlot/"+zoneDeliveryId+'/'+driverId,
                    type: "POST",
                    data: {
                        driverId:driverId
                    },
                    dataType: 'json',   
                    success: function (response)
                    {
                        location.reload();
                    }
                });

           });

           

    // add button
            $("#AddSlotsDriver").click(function () {
             
                    $("#setPrice").prop("disabled",true)
                    $("#showMsg").empty();
                  
                    var oQuantity={};
                    var val = $('.checkboxProduct:checked').map(function () {
                        var id =  $(this).attr('data');
                        var OrderQuantity=$('#'+id).val();
                        oQuantity[id]=OrderQuantity
                        return OrderQuantity;
                    }).get();
                    console.log('oQuantity',oQuantity);
                    var zoneDeliveryId='<?php echo $zoneDeliveryId; ?>';
                
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/DeliveryAssignDriver/AddNewDriverSlot/"+zoneDeliveryId,
                        type: "POST",
                        data: {
                            oQuantity:oQuantity
                        },
                        dataType: 'json',   
                        success: function (response)
                        {
                            location.reload();
                        }
                    });
               

        });


    });

    

</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-top: 60px;">

            <strong style="font-size: 12px;margin-left: 15px;">ASSIGN DRIVER</strong><!-- id="define_page"-->
        </div>
        <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
            <div class="hide_show">

                <div class="form-group">

                    
                    <!-- <div class="col-sm-1 " style="float:right;">
                        <div class="">
                            <button class="btn btn-info" type="button" id="AddSchedule" style="float:right;">Add</button>
                        </div>
                    </div> -->

                    <div class="col-sm-1 " style="float:right;">
                        <div class="">
                            <button class="btn btn-info" type="button" id="AddSlotsDriver" style="float:right;">Add</button>
                        </div>
                    </div>

                </div>
            </div>
        </ul>

        <div class="row">
           <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                

                <div class="pull-left col-sm-6" >

                        <div class="">
                            <ul class="breadcrumb" style="background:white;margin-top: 0%;">
                                <li><a class="active" href="<?php echo base_url() ?>index.php?/Zones_Controller" class="">Zones</a> </li>
                                <li><a class="active" href="<?php echo base_url() ?>index.php?/Deliveryslots/slots/<?php echo $zoneId;?>/<?php echo $slotId;?>" class="">Delivery Schedule</a> </li>
                                <li><a class="active" href="#" class="">Assign Driver</a> </li>

                            </ul>
                        </div>

                        
                </div>

                    <!-- Tab panes -->
                    <div class="tab-content ">                        
                         <div class="pull-right hide_show" ><input type="text" id="search-table1" class="form-control pull-right" placeholder="Search" style="display: block;margin-right: 15px;margin-top: 5px;width: 140px;border-radius: 13px"> 
                    </div>                     

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


<!-- Driver assign modal -->
<div class="modal fade" id="driverAssignModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Assign Driver</h4>
        </div>
        <div class="modal-body">
          <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">


   

                <div class="form-group" class="formex" id='notesId'>
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Driver Name"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control pull-left" id="storeFilter">

                            </select> 
                        </div>
                         <div class="col-sm-3 error-box errors" id="orderCapacityErr">
                        </div>
                    </div>
                  
                 <!-- <div class="form-group" class="formex" id='notesId'>
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Driver Name"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <p>james</p>
                        </div>
                         <div class="col-sm-3 error-box errors" id="orderCapacityErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex" id='notesId'>
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Driver Number"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                        <p>78457845784</p>
                        </div>
                         <div class="col-sm-3 error-box errors" id="orderCapacityErr">
                        </div>
                    </div>                 -->

                   <div class="form-group" class="formex" id='notesId'>
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Order Capacity"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control" name="notes" id="orderCapacity"  onkeypress="return isNumber(event)" placeholder="Enter of Order Capacity">
                        </div>
                         <div class="col-sm-3 error-box errors" id="orderCapacityErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex" id='notesId'>
                        <label for="fname" class="col-sm-4 control-label"><?php echo "List driver in zone"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <label><input type="checkbox"  id="listInZone" value=""></label>
                        </div>
                        
                    </div>
                </form>
        </div>
        <div class="modal-footer">
           <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="insert_cat_group" ><?php echo "Add"; ?></button></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="driverslotdelete" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete..?</p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" id="deleteSlotmodal" value="">Ok</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>
      </div>
      
    </div>
  </div>



