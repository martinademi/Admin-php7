<?php

if ($status == 1) {
    $vehicle_status = 'New';
    $new = "active";
} else if ($status == 3 && $db == 'my') {
    $vehicle_status = 'Accepted';
    $accept = "active";
} else if ($status == 3 && $db == 'mo') {
    $vehicle_status = 'Online&Free';
    $free = "active";
} else if ($status == 4) {
    $vehicle_status = 'Rejected';
    $reject = 'active';
}
//else if($status == 2) {
//    $vehicle_status = 'Online&Free';
//    $free = 'active';
//  
//}
else if ($status == 30) {
    $$vehicle_status = 'Offile';
    $offline = 'active';
} else if ($status == 567) {
    $$vehicle_status = 'Booked';
    $booked = 'active';
}
?>
<style>
.badge {
    font-size: 9px;
    margin-left: 2px;
}
    .imageborder{
        border-radius: 50%;
    }
    .btn{ font-size: 10px;
        }
td span {
    line-height: 16px;
}
</style>

<script>
      var currentTab = 1;
      var htmlForPlans;
      var htmlForVehicleTypes;
      var tabURL;
    $(document).ready(function () {
        
        //Load the all plans
                  $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getAllPlans",
                    type: "POST",
                    data:  {},
                    dataType: 'json',
                    success: function (result)
                    {
                            htmlForPlans = '';
                            htmlForPlans ='<option value="">PLANS</option>';
                            $.each(result.data,function (i,value)
                           {
                               htmlForPlans +='<option value='+value._id.$oid+' planName='+value.plan_name+'>'+value.plan_name+'</option>';
                           });
                            $('#planFilter').append(htmlForPlans);
                            $('#planFilter').val('<?php echo $this->session->userdata('plan')?>');
                           
                    }
                });
                
        //Load the all vehicle Types
                  $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getAllVehicleTypesForDrivers",
                    type: "POST",
                    data:  {},
                    dataType: 'json',
                    success: function (result)
                    {
                        
                        console.log(result);
                        htmlForVehicleTypes = '';
                        htmlForVehicleTypes ='<option value="">VEHICLE TYPES</option>';
                        $.each(result.data,function (i,value)
                       {
                           htmlForVehicleTypes +='<option value='+value._id.$oid+'>'+value.type_name+'</option>';
                       });
                        $('#vehicleTypeFilter').append(htmlForVehicleTypes);
                        $('#vehicleTypeFilter').val('<?php echo $this->session->userdata('vehicleType')?>');
                           
                    }
                });


    $(document).on('click','.deviceInfo',function ()
    {
        $('.make').text($(this).attr('make'));
        $('.model').text($(this).attr('model'));
        $('.os').text($(this).attr('os'));
        $('.lastLoginDate').text($(this).attr('last_active_dt'));
        $('.pushToken').text($(this).attr('push_token'));
       $('#deviceInfoPopUp').modal('show'); 
 
    });
    
     $('#deviceLogs').click(function ()
          {
              
              var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();
            
              if(val.length == 0)
              {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select one drivers to get device logs');
              }
              else if(val.length > 1)
              {
                  $('#alertForNoneSelected').modal('show');
                 $("#display-data").text('Please select only one drivers to get device logs');
              }
              else{
                   $('#device_log_data').empty();
                     $.ajax({
                            url: "<?php echo base_url('index.php?/superadmin') ?>/getDeviceLogs/driver",
                            type: "POST",
                            data: {mas_id: $('.checkbox:checked').val()},
                            dataType: 'json',
                            success: function (result)
                            {
                                
                                  var html = '';
                                  var deviceType = '';
                                  $('#d_name_history').text(result.data.firstName+' '+result.data.lastName)
                                 $.each(result.data.devices, function (index,logs) {
                                    deviceType = '-';
                                    if(logs.deviceType != 0 && logs.deviceType != "")
                                    {
                                        if(logs.deviceType == 1)
                                             deviceType = 'IOS';
                                        else if(logs.deviceType == 2)
                                             deviceType = 'ANDRIOD';
                                    }
//                                        deviceType = ((logs.deviceType != 0)?((logs.deviceType != 0)?'IOS':'ANDRIOD')):'-';
                                        html = "<tr>";
                                        html += "<td>"+deviceType+"</td>";
                                        html += "<td>"+logs.appversion+"</td>";
                                        html += "<td>"+logs.devMake+"</td>";
                                        html += "<td>"+logs.devModel+"</td>";
                                        html += "<td>"+logs.deviceId+"</td>";
                                        html += "<td>"+logs.pushToken+"</td>";
                                        html += "<td>"+moment(logs.serverTime['$date']).format("DD-MM-YYYY HH:mm:ss")+"</td>";
                                       
                                        html += "</tr>";
                                        $('#device_log_data').append(html);
                                        
                                 });
                                        
                                
                            }
                        });
                  
                    $('#deviceLogPopUp').modal('show');
                }
          });
   

        $("#define_page").html("Drivers");

        $('.drivers').addClass('active');
        $('.Drivers').attr('src', "<?php echo base_url(); ?>/theme/icon/drivers_on.png");
//        $('.driver_thumb').addClass("bg-success");

        $("#document_data").click(function () {


            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                 $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_DOC_VIEW); ?>);
            } else if (val.length > 1)
            {

                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_DOC_VIEW); ?>);
            }
            else
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#myModaldocument');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#myModaldocument').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

            }

            $('#doc_body').html('');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/documentgetdata",
                type: "POST",
                data: {mas_id: $('.checkbox:checked').val()},
                dataType: 'json',
                success: function (result)
                {


                    $.each(result, function (index, doc) {
                        
                            var html = "<tr><td style='text-align: center;'>";
                                html += "Profile Pic</td><td style='text-align: center;'>" + "<a href="+doc.image+" target='_blank'><img src="+doc.image+" style='height:46px;width:52px' class='img-circle'></a></td></tr>";

                            html += "<tr><td style='text-align: center;'>Driving Licence</td>" + "<td style='text-align: center;'><a href="+doc.driverLicense+"  target='_blank'><img src=" +doc.driverLicense+" style='height:46px;width:52px' class='img-circle'></a></td>"
                             

                            html += "</tr>";
                             $('#doc_body').append(html);
                        

                    });
                    $("#documentok").click(function () {
                        $('.close').trigger('click');
                    });

                }
            });
//            });

            $("#editdriver").click(function () {


                $("#display-data").text("");
                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).
                        get();
                if (val.length == 0) {
                 $('#alertForNoneSelected').modal('show');
                    $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_EDIT); ?>);
                } else if (val.length > 1)
                {

                     $('#alertForNoneSelected').modal('show');
                    $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_ONLYEDIT); ?>);
                }
                else
                {

//               window.locaton = "<?php echo base_url() ?>index.php?/superadmin/editdriver" + val;
                    window.location = "<?php echo base_url('index.php?/superadmin') ?>/editdriver/" + val;
                }
            });


        });




        $("#chekdel").click(function () {

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length > 0) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#deletedriver');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                }
                else
                {
                    $('#deletedriver').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    }
                    else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorbox").text(<?php echo json_encode(POPUP_DRIVERS_DELETE); ?>);
                tabURL = $('li.active').children("a").attr('data');
                
                
                $("#yesdelete").click(function () {

//            if(confirm("Are you sure to Delete " +val.length + " Drivers")){
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deleteDrivers",
                        type: "POST",
                        data: {masterid: val},
                        success: function (result) {
                            $(".close").trigger('click');
                             refreshContent(tabURL);
                        }
                    });
                });
            }



            else {
                 $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_DELETE); ?>);
            }

        });

        $("#accept").click(function () {
        $('.errors').text('');

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            
           
            if (val.length == 1) {
                 $('#confirmmodel').modal('show')
                 
                 //get Driver Plans
                  $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getAllPlans",
                    type: "POST",
                    data:  {id:$('.checkbox:checked').val()},
                    dataType: 'json',
                    success: function (result)
                    {
                        htmlForPlans = '';
                        $('#plans').empty();
                        if(result.driverData.planID)
                        {
                            if(result.driverData.planID.$oid)
                            {
                                
                                      htmlForPlans ='<option value="0">Select</option>';
                                      $.each(result.data,function (i,value)
                                      {
                                          if(result.driverData.planID.$oid == value._id.$oid)
                                          htmlForPlans +='<option value='+value._id.$oid+' planName='+value.plan_name+' selected>'+value.plan_name+'</option>';
                                      else
                                          htmlForPlans +='<option value='+value._id.$oid+' planName='+value.plan_name+'>'+value.plan_name+'</option>';
                                      });
                                       $('#plans').append(htmlForPlans);
                                       $('.planDiv').hide();
                            }
                            else{
                                        
                                        htmlForPlans ='<option value="0">Select</option>';
                                        $.each(result.data,function (i,value)
                                       {
                                           htmlForPlans +='<option value='+value._id.$oid+' planName='+value.plan_name+'>'+value.plan_name+'</option>';
                                       });
                                        $('#plans').append(htmlForPlans);
                                        $('.planDiv').show();
                                        
                                        var currentdate = new Date(); 
                                        var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth()+1) + '-'  + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
                                        $('#time_hidden').val(datetime);
                                       
                            }
                        }
                        else{
                            
                              $('.planDiv').show();
                              htmlForPlans ='<option value="0">Select</option>';
                               $.each(result.data,function (i,value)
                               {
                                   htmlForPlans +='<option value='+value._id.$oid+' planName='+value.plan_name+'>'+value.plan_name+'</option>';
                               });

                               $('#plans').append(htmlForPlans);
                                $('#plans').val('0');
                                
                                var currentdate = new Date(); 
                                var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth()+1) + '-'  + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
                                $('#time_hidden').val(datetime);
                        }
                    }
                });
                 
                $("#ve_compan").text("");
               
            }
            else
            {
                 $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_FOR_ACCEPT); ?>);

            }

        });
        
        
         $("#confirmed").click(function () {
                   
                    var val = $('.checkbox:checked').val();
                    
                    if($('#plans').val() == '0')
                    {
                        $('#plansErr').text('Please select any one plan to accept');
                    }
                    else{
                         tabURL = $('li.active').children("a").attr('data');
                         
                    
                    $("#ve_compan").val('');

                    var company = $("#company_select").val();

                        $.ajax({
                            url: "<?php echo base_url('index.php?/superadmin') ?>/acceptdrivers",
                            type: "POST",
                            data: {val: val,planActiveDate:$('#time_hidden').val(),planID:$('#plans').val(),planName:$("#plans option:selected").attr('planName')},
                            dataType: 'json',
                            success: function (response)
                            {
                                
                                $('#acceptdrivermsg').modal('show');
                                    
                                $("#errorbox_accept").text(<?php echo json_encode(POPUP_MSG_ACCEPTED); ?>);

                                $("#accepted_msg").click(function(){
                                    $('.close').trigger('click');
                                });
                                refreshContent(tabURL);

                            }


                        });

                        $(".close").trigger('click');

                        $("#ve_compan").val('');
                        $("#company_select").val('');
                        }

//                    }
                });



        $('#driverresetpassword').click(function () {
        
            $("#display-data").text("");
            $(".errors").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 0) {
                 $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_RESET_PASSWORD); ?>);

            } else if (val.length > 1)
            {

                 $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_PASSENGERS_ONLYONEPASS); ?>);
            }
            else
            {
                    $('#myModal1_driverpass').modal('show');
            }
        });



        $("#editpass_msg").click(function () {
        
        
            $("errorpass").text("");
            
            var newpass = $("#newpass1").val();
            var confirmpass = $("#confirmpass1").val();
            var reg = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;    //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;

            if (newpass == "" || newpass == null)
            {
//                alert("please enter the new password");
                $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_PASSENGERS_PASSNEW); ?>);
            }
//            else if (!reg.test(newpass))
//            {
////                alert("please enter the password with atleast one chareacter and one letter");
//                $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
//            }
            else if (confirmpass == "" || confirmpass == null)
            {
//                alert("please confirm the password");
                $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_PASSENGERS_PASSCONFIRM); ?>);
            }
            else if (confirmpass != newpass)
            {
//                alert("please confirm the same password");
                $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_PASSENGERS_SAMEPASSCONFIRM); ?>);
            }
            else
            {
//                
                //Getting encrypted password
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo APILink;?>app/hashpassword',
                       data:{password:newpass},
                        success: function (result) {
                             console.log(result);
                            if(result.statusCode != 400)
                            {
                                
                                 $.ajax({
                                        url: "<?php echo base_url('index.php?/superadmin') ?>/editdriverpassword",
                                        type: 'POST',
                                        data: {
                                            newpass: result.password,
                                            val: $('.checkbox:checked').val()
                                        },
                                        dataType: 'JSON',
                                        success: function (response)
                                        {
                                            if (response.flag != 1) {

                                                $(".close").trigger('click');

                                                var size = $('input[name=stickup_toggler]:checked').val()
                                                var modalElem = $('#confirmmodelss');
                                                if (size == "mini")
                                                {
                                                    $('#modalStickUpSmall').modal('show')
                                                }
                                                else
                                                {
                                                    $('#confirmmodelss').modal('show')
                                                    if (size == "default") {
                                                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                                                    }
                                                    else if (size == "full") {
                                                        modalElem.children('.modal-dialog').addClass('modal-lg');
                                                    }
                                                }

                                                $("#errorboxdatass").text(<?php echo json_encode(POPUP_DRIVERS_NEWPASSWORD); ?>);
                                                $("#confirmedss").hide();


                                                $(".newpass").val('');
                                                $(".confirmpass").val('');
                                            }
                                            else if(response.flag == 1)
                                            {
                                                 $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_DRIVERS_NEWPASSWORD_FAILED); ?>);

                                            }

                                        }

                                    });

                            }
                            else{
                                alert('While getting encrypted password something went wrong');
                                return false;
                            }
                        }
                   })

               
            }

        });





        $("#reject").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).
                    get();
            if (val.length > 0) {

                //      if (confirm("Are you sure to inactive " + val.length + " passengers"))

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                }
                else
                {
                     $.ajax({
                            url: "<?php echo base_url() ?>index.php?/superadmin/getAllDriversDetails",
                            type: "POST",
                            data: {mas_id: val},
                            dataType: 'json',
                             success: function (result)
                             {
                                 var firstName = '';
                                 if(result.driverCount > 0)
                                 {
                                     
                                     $.each(result.driverData,function(i,response)
                                     {
                                         if(i == 0)
                                          firstName += response.firstName+' '+response.lastName;
                                      else
                                          firstName += ','+response.firstName+' '+response.lastName;
                                     });
//                                     console.log(firstName);
                                      $("#errorboxdatas").text('This driver has on-going trips so first complete them before you make this driver in-active');
                                 }
                                 else{
                                      $("#errorboxdatas").text('Are you sure you want to reject drivers');
                                 }
                             }
                         });
                    $('#confirmmodels').modal('show');
                  
                }
               
                 tabURL = $('li.active').children("a").attr('data');
                        

                $("#confirmeds").click(function () {
                    
                             $.ajax({
                                      url: "<?php echo base_url() ?>index.php?/superadmin/rejectdrivers",
                                     type: "POST",
                                       data: {val: val,date:(new Date().getTime())/1000},
                                       dataType: 'json',
                                      
                                       success: function (result)
                                       {
                                            $('#confirmmodels').modal('hide');
                                            refreshContent(tabURL);
                                       }
                                   });
                });
            }
            else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_RELECT); ?>);
            }

        });
        
        $("#ban").click(function () {
            $('.okButton').show();
             $('.closeButton').hide();
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length > 0) {
                    $('#banMsg').text('Are you sure you want to ban drivers');
                    $('#banPopUp').modal('show');
            }
            else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_RELECT); ?>);
            }

        });
        
        $('.closeButton').click(function ()
{
    $('.close').trigger('click');
    });
        
         $("#banButton").click(function () {
         var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
                     tabURL = $('li.active').children("a").attr('data');
                             $.ajax({
                                      url: "<?php echo base_url() ?>index.php?/superadmin/banDrivers",
                                     type: "POST",
                                       data: {val: val},
                                       dataType: 'json',
                                      
                                       success: function (result)
                                       {
                                            if(parseInt(result.apiResponse) > 0)
                                            {
                                                console.log('here');
                                                $('#banMsg').text('The driver has on-ongoing trips so please first manage those before you attempt to ban the driver');
                                                $('.okButton').hide();
                                                $('.closeButton').show();
                                            }else{
                                                    
                                                    refreshContent(tabURL);
                                                    $(".close").trigger('click');
                                            }
                                       }
                                   });
                });


        $("#editdriver").click(function () {
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 0) {
                 $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_EDIT); ?>);

            } else if (val.length > 1)
            {

                 $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_ONLYEDIT); ?>);
            }
            else
            {
                window.location = "<?php echo base_url() ?>index.php?/superadmin/editdriver/" + val;
            }
        });

    });

</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('.cs-loader').show();
    
     var table = $('#big_table');
     var searchInput = $('#search-table');
     $('.hide_show').hide();
     searchInput.hide();
     table.hide();
     
     
      $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/getDriversCount",
                type: "POST",
                dataType: 'json',
                 async:true,
                success: function (response)
                {
                    $('.newDriverCount').text(response.data.New);
                    $('.acceptedDriverCount').text(response.data.Accepted);
                    $('.rejectedDriverCount').text(response.data.Rejepted);
                     $('.bannedDriverCount').text(response.data.Banned);
                    $('.onlineDriverCount').text(response.data.Online);
                    $('.offlineDriverCount').text(response.data.offline);
                    $('.loggedOutDriverCount').text(response.data.loggedOut);
                }
            });

        var status = '<?php echo $status; ?>';

        if (status == 1) {

            $("#display-data").text("");
//            alert('asdf');
            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').show();
            $('#accept').show();
            $('#add').show();
            $('#ban').hide();
            
             $('#driver_logout').hide();

        }


        $('#my1').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').show();
            $('#accept').show();
            $('#add').show();
          
        });
        $('#my3').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').show();
            $('#chekdel').show();
            $('#reject').hide();
            $('#accept').hide();
            $('#add').show();
           

        });

        $('#my4').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').hide();
            $('#editdriver').hide();
            $('#accept').show();
            $('#add').show();
           

        });
        $('#my5').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').hide();
            $('#accept').show();
            $('#add').hide();
            $('#ban').hide();
           

        });


        $('#mo3').click(function () {

            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').hide();

            $('#reject').hide();
            $('#accept').hide();

            $('#editdriver').hide();
            $('#joblogs').hide();
            $('#driverresetpassword').hide();
            $('#document_data').show();

            $('#add').hide();
           
        });
        $('#mo30').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').hide();
            $('#reject').hide();
            $('#accept').hide();
            $('#editdriver').hide();
            $('#driverresetpassword').hide();
            $('#document_data').show();
            $('#add').hide();
           

        });
        $('#mo567').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').hide();
            $('#editdriver').hide();
            $('#reject').hide();
            $('#driverresetpassword').hide();
            $('#document_data').show();
            $('#reject').hide();
            $('#accept').hide();
            $('#add').hide();
          

        });


  setTimeout(function() {
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_drivers/my/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url()?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                table.show()
                   $('.cs-loader').hide()
                  $('.hide_show').show();
                   searchInput.show()
                   
                      
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
        
            }, 1000);
        
        

        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            var forwhat = urlChunks[urlChunks.length - 2];
            if (forwhat == 'my') {
                if(status == 1)
                     $('#big_table').dataTable().fnSetColumnVis([4,7,8,10,11,12,14], false);
                else{
                    if(status == 3)
                        $('#big_table').dataTable().fnSetColumnVis([11,12], false);
                   else if(status == 4)
                        $('#big_table').dataTable().fnSetColumnVis([1,4,5,6,7,9,10,12,13,14], false);
                    else if(status == 5)
                    {
                         $('#big_table').dataTable().fnSetColumnVis([1,4,5,6,7,9,10,11,13,14], false);
                    }
                } 
            }else{
                if(status == 3)
                     $('#big_table').dataTable().fnSetColumnVis([11,12,13], false);
                 else
                     $('#big_table').dataTable().fnSetColumnVis([11,12,14], false);
            }

        });
        
        
        $("#driver_logout").click(function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }). get();
            if (val.length > 0) {
                
                $('#Model_manual_logout').modal('show');
            }
            else
            {
                 $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_LOGOUT); ?>);

            }

        });
        
         $("#ok_to_logout").click(function () {
                 var val = $('.checkbox:checked').map(function () {
                                return this.value;
                            }).get();
                            tabURL = $('li.active').children("a").attr('data');
                            
                        $.ajax({
                            url: "<?php echo base_url() ?>index.php?/superadmin/driver_logout",
                            type: "POST",
                            data: {val: val},
                            dataType: 'json',
                            success: function (response)
                            {
                                
                                $("#errorbox_logout").text(<?php echo json_encode(POPUP_MSG_LOGOUT); ?>);
                                $(".close").trigger('click');
                                 
                                refreshContent(tabURL);

                            }

                        });     

                        $("#ve_compan").val('');
                        $("#company_select").val('');

                    
                });

        $('.changeMode').click(function () {
      
        
        var tab_id = $(this).attr('data-id');
            
            if(currentTab != tab_id)
            {
                  $('#big_table').hide();
           
                    currentTab = tab_id;
            $('#big_table').hide();
            $("#display-data").text("");


            if ($(this).data('id') == 1) {
            $('#chekdel').show();
            $('#reject').show();
            $('#accept').show();
            $('#add').show();
            $('#document_data').show();
            $('#driverresetpassword').hide();
            $('#editdriver').show();
             $('#driver_logout').hide();
            $('#ban').hide();


            }
            else if ($(this).data('id') == 2) {
               $("#display-data").text("");
                $('#driverresetpassword').show();
                $('#chekdel').show();
                $('#reject').hide();
                $('#document_data').show();
                $('#joblogs').show();
                $('#editdriver').show();
                 $('#driver_logout').hide();
                 $('#ban').show();


            }
            else if ($(this).data('id') == 3) {
               $("#display-data").text("");
            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').hide();
            $('#reject').hide();
            $('#document_data').show();
            $('#editdriver').hide();
             $('#ban').hide();


            }
            
             else if ($(this).data('id') == 4) {
               
                 $('#driver_logout').show();
                   $('#reject').hide();
                   $('#ban').show();
                   $('#document_data').show();
           }
            else if ($(this).data('id') == 5) {
                 $('#driver_logout').hide();
                  $('#reject').hide();
                 $('#ban').show();
                 $('#document_data').show();
            }
             else if ($(this).data('id') == 6) {
                 $('#driver_logout').hide();
                  $('#reject').hide();
                 $('#ban').show();
                 $('#document_data').show();
                 
            }
             else if ($(this).data('id') == 7) {
                 $('#reject').hide();
                    $('#chekdel').show();
                    $('#accept').show();
                    $('#add').hide();
                    $('#deviceLogs').hide();
                    $('#editdriver').hide();
                    $('#driver_logout').hide();
                    $('#document_data').show();
                     $('#driverresetpassword').hide();
            }
            
            
      $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/getDriversCount",
                type: "POST",
                dataType: 'json',
                async:true,
                success: function (response)
                {
                    $('.newDriverCount').text(response.data.New);
                    $('.acceptedDriverCount').text(response.data.Accepted);
                    $('.rejectedDriverCount').text(response.data.Rejepted);
                    $('.bannedDriverCount').text(response.data.Banned);
                    $('.onlineDriverCount').text(response.data.Online);
                    $('.offlineDriverCount').text(response.data.offline);
                    $('.loggedOutDriverCount').text(response.data.loggedOut);
                }
            });




            $('#big_table_processing').toggle();

            var table = $('#big_table');

            var settings = {
                "autoWidth": false,
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
                    "sProcessing": "<img src='<?php echo base_url()?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
                 $('#big_table').show();
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

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');
            table.dataTable(settings);
            
             if(currentTab == 1)
                     $('#big_table').dataTable().fnSetColumnVis([4,7,8,10,11,12,14], false);
             else if(currentTab == 2)
                     $('#big_table').dataTable().fnSetColumnVis([11,12,13,14], false);
             else if(currentTab == 3)
                     $('#big_table').dataTable().fnSetColumnVis([1,4,5,6,7,9,10,12,13,14], false);
            else if(currentTab == 7)
                $('#big_table').dataTable().fnSetColumnVis([1,4,5,6,7,9,10,11,13,14], false);
            else if(currentTab != 4)
               $('#big_table').dataTable().fnSetColumnVis([12,13,14], false);

            
            }

        });
        
        
        $(document).on('click','.getDriverDetails',function()
        {
             $('.dname').text('');
             $('.demail').text('');
             $('.dphone').text('');
            
                $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/getDriverDetails",
                        type: "POST",
                        data: {mas_id:$(this).attr('mas_id')},
                        dataType: 'json',
                        success: function (result) {
                            
                             var accoutType = (result.driverData.accountType == 2)?'Operator':'Freelancer';
                                $('.dprofilePic').attr('src','');
                                $('.dprofilePic').hide();
                                    if(result.driverData.firstName != null)
                                    {
                                        $('.dname').text(result.driverData.firstName+' '+result.driverData.lastName);
                                        $('.demail').text(result.driverData.email);
                                        $('.dphone').text(result.driverData.countryCode+result.driverData.mobile);
                                        $('.dbusinessType').text(accoutType);
                                        
                                        if(result.driverData.image != '')
                                        {
                                           $('.dprofilePic').attr('src',result.driverData.image);
                                           $('.dprofilePic').show();
                                        }
                                    }
                                
                            $('#getDriverDetails').modal('show');//Code in footer.php
                            
                        }
                    }); 
        });

    });

    function refreshTableOnCityChange() {

     $('#big_table').hide();
        var table = $('#big_table');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
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
                "sProcessing": "<img src='<?php echo base_url()?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                   $('#big_table').show();


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
    
     function refreshTableOnActualcitychagne() {
   
     $('#big_table').hide();
        $('#big_table_processing').show();
        var table = $('#big_table');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
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
             
            },
            "fnInitComplete": function () {
                 $('#big_table').show();
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
    
     function refreshContent(url) {
      
     
       $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/getDriversCount",
                type: "POST",
                dataType: 'json',
                 async:true,
                success: function (response)
                {
                    $('.newDriverCount').text(response.data.New);
                    $('.acceptedDriverCount').text(response.data.Accepted);
                    $('.rejectedDriverCount').text(response.data.Rejepted);
                    $('.bannedDriverCount').text(response.data.Banned);
                    $('.onlineDriverCount').text(response.data.Online);
                    $('.offlineDriverCount').text(response.data.offline);
                    $('.loggedOutDriverCount').text(response.data.loggedOut);
                }
            });
   
     $('#big_table').hide();
        $('#big_table_processing').show();
        var table = $('#big_table');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
             
            },
            "fnInitComplete": function () {
                 $('#big_table').show();
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
</script>


<style>
    .exportOptions{
        display: none;
    }
/*    .btn-cons {
        margin-right: 5px;
        min-width: 102px;
    }
    .btn{
        font-size: 13px;
    }*/
</style>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;">
         
            <strong >DRIVERS</strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">



                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked">
                        <li id= "my1" class="tabs_active <?php echo $new ?>" style="cursor:pointer">
                            <a  class="changeMode New_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/1" data-id="1"><span><?php echo LIST_NEW; ?></span><span class="badge newDriverCount" style="background-color: #337ab7;"></span></a>
                        </li>
                        <li id= "my3" class="tabs_active <?php echo $accept ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/3" data-id="2"><span><?php echo LIST_ACCEPTED; ?></span> <span class="badge acceptedDriverCount" style="background-color: #5bc0de;"></span></a>
                        </li>
                        <li id= "my4" class="tabs_active <?php echo $reject ?>" style="cursor:pointer">
                            <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/4" data-id="3"><span>REJECTED</span> <span class="badge rejectedDriverCount" style="background-color:#f0ad4e;"></span></a>
                        </li>
                        <li id= "my5" class="tabs_active" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/5" data-id="7"><span>BANNED</span> <span class="badge bannedDriverCount" style="background-color:#33312f;"></span></a>
                        </li>
<!--                        <li id= "my5" class="tabs_active" style="cursor:pointer">
                            <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/5" data-id="7"><span>DUE FOR RENEWAL</span> <span class="badge renewalDriverCount" style="background-color:#f0ad4e;"></span></a>
                        </li>-->


                        <li id= "mo3" class="tabs_active <?php echo $free ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/mo/3" data-id="4"><span>ONLINE</span><span class="badge bg-green onlineDriverCount"></span></a>
                        </li>
                        <li id= "mo30" class="tabs_active <?php echo $offline ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/mo/30" data-id="5"><span><?php echo LIST_OFFLINE; ?> </span><span class="badge offlineDriverCount" style="background-color: darkgray;"></span></a>
                        </li>
                        <li id= "mo567" class="tabs_active <?php echo $booked ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/mo/567" data-id="6"><span>LOGGED OUT</span> <span class="badge loggedOutDriverCount" style="background-color: indianred;"></span></a>
                        </li>


                    </ul>
                   
                       <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                           <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">

                               
                        <div class=""><button class="btn btn-primary pull-right m-t-10 " id="deviceLogs"  style="margin-top: 5px;">Device Logs</button></div>
                        <div class=""><button class="btn btn-primary pull-right m-t-10 " id="driver_logout"  style="margin-top: 5px;"><?php echo BUTTON_MANUAL_LOGOUT;?></button></div>
         
                        <div class=""><button class="btn btn-primary pull-right m-t-10 " id="document_data"  style="margin-top: 5px;"><?php echo BUTTON_DOCUMENT ?></button></div>
                        <div class=""> <button class="btn btn-primary pull-right m-t-10" id="driverresetpassword" style="margin-top: 5px;"><?php echo BUTTON_RESETPASSWORD; ?></button></a></div>

                        <div class=""> <button class="btn btn-danger pull-right m-t-10" id="chekdel" style="margin-top: 5px;"><?php echo BUTTON_DELETE; ?></button></a></div>

                        <div class=""> <button class="btn btn-warning pull-right m-t-10" id="reject" style="margin-top: 5px;">Reject</button></a></div>
                        <div class=""> <button class="btn btn-warning pull-right m-t-10" id="ban" style="margin-top: 5px;">Ban</button></a></div>
                        <div class=""> <button class="btn btn-success pull-right m-t-10" id="accept" style="margin-top: 5px;"><?php echo BUTTON_ACTIVE; ?></button></a></div>
                       
                        
                        <div class=""><button class="btn btn-info pull-right m-t-10 " id="editdriver" style="margin-top: 5px;"><?php echo BUTTON_EDIT; ?></button></div>
                        <div class=""><a href="<?php echo base_url() ?>index.php?/superadmin/addnewdriver"> <button class="btn btn-primary pull-right m-t-10" id="add" style="margin-top: 5px;"><?php echo BUTTON_ADD; ?></button></a></div>


                    </ul>
                           </div>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="row">
                                     <div class="cs-loader">
                                                <div class="cs-loader-inner" >
                                                    <label class="loaderPoint" style="color:#10cfbd">●</label>
                                                    <label class="loaderPoint" style="color:red">●</label>
                                                    <label class="loaderPoint" style="color:#FFD119">●</label>
                                                    <label class="loaderPoint" style="color:#4d90fe">●</label>
                                                    <label class="loaderPoint" style="color:palevioletred">●</label>
                                            </div>
                                          </div>
                                      <div class="hide_show" style="display:none;">
                                            
                                          <div class="form-group">
                                                <div class="col-sm-8" style="width: auto;" >
                                                    <select id="mainFilter" name="mainFilter" class="form-control Filters">
                                                        <option value="">FILTER</option>
                                                        <option value="1">Vehicle Type</option>
                                                        <option value="2">Driver Type</option>
                                                        <option value="3">Driver Plan</option>
                                                    </select>

                                                </div>
                                            </div>
                                          
                                          <div class="form-group vehivleTypeFilterDiv" style="display:none;">
                                                    <div class="col-sm-8" style="width: auto;" >
                                                        <select id="vehicleTypeFilter" name="vehicleTypeFilter" class="form-control Filters">
                                                        <option value="">VEHICLE TYPE</option>
                                                        </select>
                                                    </div>
                                                </div>
                                             
                                          
                                            <div class="form-group driverTypeFilterDiv" style="display:none;">
                                                <div class="col-sm-8" style="width: auto;" >
                                                    <select id="operatorType" name="operatorType" class="form-control Filters">
                                                        <option value="">DRIVER TYPE</option>
                                                        <option value="1">Freelancer</option>
                                                        <option value="2">Operator</option>
                                                    </select>

                                                </div>
                                            </div>

                                           <div class="form-group showOperators operatorsFilterDiv" style="display:none;">
                                                <div class="col-sm-8" style="width: auto;" >

                                                <select id="companyid" name="company_select" class="form-control Filters">
                                                    <option value="0">OPERATOR</option>
                                                </select>

                                                </div>
                                            </div>
                                          
                                            <div class="form-group planFilterDiv" style="display:none;">
                                                  <div class="col-sm-8" style="width: auto;" >
                                                  <select id="planFilter" name="planFilter" class="form-control Filters">

                                                  </select>

                                                  </div>
                                              </div>
                                         
                                        </div>
                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                   
                                       
                                    </div>
                                        
                                      
                                     
                                </div>
                             
                                <div class="panel-body" style="margin-top: 1%;">

                                    <?php

                                    echo $this->table->generate();
                                    ?>

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

<input type="hidden" name="current_dt" id="time_hidden" value=""/>


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACCEPT</span>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            
            <div class="modal-body">
            <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                <div class="form-group">
                    <label for="fname" class="col-sm-12 control-label">Please make sure you have validated all the documents submitted before you approve the driver’s membership</label>
                    

                </div>
                
                 <div class="form-group planDiv">
                     <label for="fname" class="col-sm-2 control-label">Plans<span style="" class="MandatoryMarker"> *</span></label>
                     <div class="col-md-6 col-sm-6 col-xs-6">
                         <select class="form-control" id="plans" name="plans">
                             <option value="0"></option>
                         </select>
                     </div>
                     <div class="col-md-3 col-sm-3 col-xs-3 errors" id="plansErr"></div>
                </div>
              
            </form>
            </div>


            <div class="modal-footer">
                <div class="row">
                  
                    <div class="col-sm-6 " id="ve_compan"></div>
                    <div class="col-sm-6" >
                       <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                         <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="confirmed" >ACCEPT</button></div>
                    </div>
                </div>
            </div>
        </div><!--
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>






<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <span class="modal-title">REJECT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                       <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    <div class="pull-right m-t-10"><button type="button" class="btn btn-warning pull-right" id="confirmeds" >Reject</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="banPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <span class="modal-title">BAN</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="banMsg" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                       <button type="button" class="btn btn-warning pull-right closeButton"  style="display:none;">Ok</button>
                       <div class="pull-right m-t-10"><button type="button" class="btn btn-warning pull-right okButton" id="banButton">Yes</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="myModal1_driverpass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
        <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="modal-header">

                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <span class="modal-title">RESET PASSWORD</span>
                </div>


                <div class="modal-body">
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_NEWPASSWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="newpass1" name=""  class="newpass form-control" placeholder="New Password">
                        </div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_CONFIRMPASWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="confirmpass1" name="" class="confirmpass form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>

                  <div class="modal-footer">
                        <div class="col-sm-6 error-box errors" id="errorpass_driversmsg"></div>
                        <div class="col-sm-6" >
                            <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                             <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="editpass_msg" ><?php echo BUTTON_SUBMIT; ?></button></div>
                        </div>
                    </div>
  </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>






<div class="modal fade stick-up" id="confirmmodelss" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatass" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                         <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="confirmedss" ><?php echo BUTTON_OK; ?></button></div>
                    </div>
                </div>
            </div>
        </div>
        <a href="vehicletype_addedit.php"></a>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="deletedriver" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                 <span class="modal-title">DELETE</span>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
               
                    <div class="col-sm-4" ></div>
                   
                    <div class="col-sm-8">
                         <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdelete" >Delete</button></div>
                    </div>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="acceptdrivermsg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                 <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
         
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox_accept" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default pull-right" id="accepted_msg" >Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="myModaldocument" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <span class="modal-title">DOCUMENTS</span>
                </div>


                 <div class="modal-body">
            <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->
            
           <table class="table table-bordered">
                <thead>
                  <tr>
                   
                    <th style="width:20%;text-align: center;">TYPE</th>
                    <th style="width:10%;text-align: center;">PREVIEW</th>
                    
                  </tr>
                </thead>
               <tbody id="doc_body">

              </tbody>
              </table>
        </div>
        <div class="modal-footer">
            
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>
                <!-- /.modal-dialog -->
            </div>


        </div>
    </div> </div>

<div class="modal fade stick-up" id="Model_manual_logout" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <span class="modal-title">LOGOUT</span>
            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox_logout" style="text-align:center"><?php echo ARE_YOU_SURE_TO_LOGOUT_THIS_DRIVER; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="ok_to_logout" ><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="deviceInfoPopUp" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <span class="modal-title">DEVICE INFO</span>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           
        </div>
        <div class="modal-body">
            
           <div class="form-group row">
               
                <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Make</label>
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <span style="" class="make"></span>
                </div>
            </div>
        
            <div class="form-group row">
                <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Model</label>
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <span style="" class="model"></span>
                </div>
                     
            </div>
         
            <div class="form-group row">
                <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">OS</label>
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <span style="" class="os"></span>
                </div>
                      
            </div>
            <div class="form-group row">
                <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Last Login Date & Time</label>
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <span style="" class="lastLoginDate"></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Push Token</label>
                <div class="col-md-8 col-sm-8 pushToken" style="word-break: break-all;">
                    
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<div class="modal fade stick-up" id="deviceLogPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           
            <div class="modal-header">
               <span class="modal-title">DEVICE INFO</span>
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           
            </div>
            <div class="modal-body form-horizontal">
                <div class="row">
                    <span style="color:#738092;font-weight:700;margin-left: 10px;">Driver Name : <span id="d_name_history" style="color:#1ABB9C;"></span></span>
                </div>
                <br>
                 <div class="table-responsive">
                <table class='table table-striped table-bordered table-hover demo-table-search' id="devices_datatable">
                    <thead>
                        <th >DEVICE TYPE</th>
                        <th style="">APP VERSION</th>
                         <th style="">DEVICE MAKE</th>
                        <th style="">DEVICE MODEL</th>
                        <th style="">DEVICE ID</th>
                        <th style="">PUSH TOKEN</th>
                        <th style="">LAST LOGGED IN DATE</th>
                    </thead>
                    
                    
                    <tbody id="device_log_data">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>