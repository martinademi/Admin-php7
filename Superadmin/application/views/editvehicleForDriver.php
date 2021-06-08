<?php
$goodTypesAll = array();
 foreach ($speciality_data as $googType)
  {
     $goodTypesAll[$googType['_id']['$oid']]=$googType['name'];
 }
 
 $allVehicleTypeGoodTypes = array();
 foreach ($vehicleTypes as $vType)
    {
    
        if($vType['_id']['$oid'] == $vehicleData['type_id']['$oid'])
        {
           
            $allVehicleTypeGoodTypes =$vType['goodTypes'];
            break;
        }

   }

?>
<style>
    .form-horizontal .form-group
    {
        margin-left: 13px;
    }
    .multiselect {
  width: 200px;
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

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}
.selectedGood{
/*    padding: 6px;
    display: inline-flex;
    margin: 0px 1px 1px;
    font-weight: 600;*/
height: 28px;
   padding: 6px;
    display: inline-flex;
    margin: 0px 1px 1px;
    font-weight: 600;
    /*background: #5bc0de;*/
    border: 1px solid;
    border-radius: 4px;
}
.inputCheckbox{
    border: none;
}
.RemoveMore{
    color: #6185b0;height: 18px;
}
input[type=checkbox], input[type=radio] {
    margin: 4px 5px 0;
    line-height: normal;
}
</style>
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    
    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>
  <script>
      
      var idNum = 0;

 function RemoveMore(Id)
{
    $('#RemoveControl'+Id).remove();
}

var expanded = false;
function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
    $(document).ready(function (){
         $('#selected_driver').empty();
//          htmlDriverList+='<option value="">select</option>';
            <?php
           foreach ($driversList as $driver)
                {
                    if($driver['_id']['$oid'] == $vehicleData['mas_id']['$oid'])
                    {
                    ?>      
                            id = '<?php echo $driver['_id']['$oid'];?>'
                            name = '<?php echo trim($driver['firstName']).'-'.trim($driver['lastName']).'-'.$driver['email'].'-'.$driver['mobile'];?>';
                            mobile = '<?php echo $driver['mobile'];?>';
                            name1 =   '<?php echo trim($driver['firstName']).' '.trim($driver['lastName']);?>';    
                   htmlDriverList+='<option value="'+id+'" driverName="'+name1+'" driverMobile="'+mobile+'">'+name+'</option>';
                   
                   <?php
                    }
                }
        ?>
        $('#selected_driver').append(htmlDriverList);
         $(document).on('click','.checkbox1',function ()
        {
            if($(this).is(":checked"))
            {
                 $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl'+$(this).attr('id')+'"><input readonly type="text" class="inputCheckbox" value="'+$(this).attr('goodType')+'"><input type="button"  value="&#10008" data-id="'+$(this).attr('id')+'" class="RemoveMore">')
                 $('#goodType').val($(this).attr('id'));
            }
            else{
               RemoveMore($(this).attr('id'));
            }
        });
       $(document).on('click','.RemoveMore',function ()
        {
             $('#'+$(this).attr('data-id')).attr('checked',false);
            $('#RemoveControl'+$(this).attr('data-id')).remove();
        });

        var accType = '<?php echo $vehicleData['account_type'];?>';
        var company = '<?php echo $vehicleData['operator']['$oid'];?>';
        var mas_id = '<?php echo $vehicleData['mas_id']['$oid'];?>';
//        var name = '<?php echo $vehicleData['driverName'];?>';
//       console.log(name);
        $('#operatorName').val('<?php echo $vehicleData['operatorName'];?>');
        $('#driverName').val('<?php echo $vehicleData['driverName'];?>');
        $('#driverMobile').val('<?php echo $vehicleData['driverMobile'];?>');
        $('#vehicleTypeName').val('<?php echo $vehicleData['type'];?>');
        $('#vehicleMakeName').val('<?php echo $vehicleData['make'];?>');
        $('#vehicleModelName').val('<?php echo $vehicleData['model'];?>');
        
        if(accType == 2)
        {
            $('#Operator').attr('checked',true);
            $('#Freelancer').attr('disabled',true);
             $('#company_select').val(company);
             $('#selected_driver').val('');
             $('#selected_driver').attr('disabled',true);
        }
        else
        {
            $('#selected_driver').prop('disabled',false);
            $('#Operator').attr('disabled',true);
            $('#Freelancer').attr('checked',true);
            $('#company_select').attr('disabled',true);
        }
       $('#selectedOwnerType').val(accType);
        $('#goodType').val('<?php echo $vehicleData['goodTypes'];?>')

        $('#vehiclemake').val('<?php echo $vehicleData['makeId']['$oid'];?>')
        $('#vehiclemodel').val('<?php echo $vehicleData['modelId']['$oid'];?>')

          $('#getvechiletype').val('<?php echo $vehicleData['type_id']['$oid'];?>')

    $('#selected_driver').val(mas_id);

    });
    </script>

<script>
    var htmlDriverList;

    $(document).ready(function () {
        
        
        
        
        //show selected good types
        <?php
                foreach ($allVehicleTypeGoodTypes as $vType)
                {
                   if(in_array($vType,$vehicleData['goodTypes']))
                   {
                         ?>
                               goodTypeID = '<?php echo $vType;?>';
                               goodType = '<?php echo $goodTypesAll[$vType];?>';
                               
                            $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl'+goodTypeID+'"><input readonly type="text" class="inputCheckbox" value="'+goodType+'"><input type="button" value="&#10008" data-id="'+goodTypeID+'" class="RemoveMore">')
            <?php
                     }
                     else{
                         
                     }
                }
                
                ?>
        
       
          $(":file").on("change", function(e) {
             var fieldID = $(this).attr('id');
            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                $(this).val('');
                alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
            }
            else
            {
                var type;
                var folderName;
                 switch($(this).attr('id'))
                {
                    case "imagefiles": type = 1;
                                       folderName = 'VehicleImage';  
                                        break;
                    case "regcertificate": type = 2;
                                       folderName = 'VehicleDocuments';  
                                        break;
                    case "motorcertificate": type = 3;
                                       folderName = 'VehicleDocuments';  
                                        break;
                               default :type = 4;
                                        folderName = 'VehicleDocuments';  
                                         
                }
               
                     
                
                 var formElement = $(this).prop('files')[0];
                 var form_data = new FormData();
             
                    form_data.append('OtherPhoto', formElement);
                    form_data.append('type', 'Vehicles');
                    form_data.append('folder',folderName);
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/superadmin/upload_images_on_amazon",
                        type: "POST",
                        data: form_data,
                        dataType: "JSON",
                        async: false,
                        beforeSend: function () {
        //                    $("#ImageLoading").show();
                        },
                        success: function (result) {
                            
                              switch(type)
                            {
                                case 1: $('#imagefiles').val('<?php echo AMAZON_URL;?>'+result.fileName);
                                        break;
                                case 2: $('#regcertificate').val('<?php echo AMAZON_URL;?>'+result.fileName);;
                                         break;
                                case 3: $('#motorcertificate').val('<?php echo AMAZON_URL;?>'+result.fileName);;
                                         break;
                                case 4: $('#contractpermit').val('<?php echo AMAZON_URL;?>'+result.fileName);;
                                         break;
                            }
                            

                        },
                        error: function () {

                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
              }
       });
       
       $('#company_select').change(function () {
             $('#operatorName').val($('#company_select option:selected').attr('operator'));
              $('#selected_driver').load('<?php echo base_url() ?>index.php?/superadmin/ajax_call_to_get_types/driverselect', {company_id: $('#company_select').val()});
        });
         $('#operatorName').val($('#company_select option:selected').attr('operatorName'));
         $('#driverName').val($('#selected_driver option:selected').attr('driverName'));
            $('#driverMobile').val($('#selected_driver option:selected').attr('driverMobile'));

         $('#selected_driver').change(function () {
            $('#driverName').val($('#selected_driver option:selected').attr('driverName'));
            $('#driverMobile').val($('#selected_driver option:selected').attr('driverMobile'));
             
        });
        

//        $("#datepicker1").datepicker({ minDate: 0});
        var date = new Date();
        $('.datepicker-component').datepicker({
            startDate: date
        });
        

           $('#getvechiletype').change(function () {
           
             html = '';
             $('#checkboxes').empty();
             $('.selectedGood').remove();
             
            $('#vehicleTypeName').val($('#getvechiletype option:selected').attr('typeName'));
            $.ajax({
                    dataType: "json",
                    type:'POST',
                    url: "<?= base_url() ?>index.php?/superadmin/ajax_call_to_get_types/getGoodTypes",
                    data:{vehicleTypeID:$('#getvechiletype').val()},
                    async: false, 
                    success: function(result) {
                       
                        $.each(result.allGoodTypes,function (index,response)
                        {
                           
                            if($.inArray(response._id.$oid,result.vehicleTypGoodTypes) !== -1)
                            {
                                html += '<label for="'+response._id.$oid+'">';
                                html += '<input type="checkbox" class="checkbox1" name="goodType[]" id="'+response._id.$oid+'" goodType="'+response.name+'" value="'+response._id.$oid+'"/>'+response.name;
                                html += ' </label>';
                            }
                        });
                        
                        $('#checkboxes').append(html);
                         
                    }
                  }); 
        });



        $('#vehiclemake').change(function () {
             $('#vehicleMakeName').val($('#vehiclemake option:selected').attr('name'));
            $('#vehiclemodel').load('<?php echo base_url() ?>index.php?/superadmin/ajax_call_to_get_types/vmodel', {adv: $('#vehiclemake').val()});
        });
        
        $('#vehiclemodel').change(function () {
            $('#vehicleModelName').val($('#vehiclemodel option:selected').attr('name'));
            
        });

        
    });




    function managebuttonstate()
    {
        $("#prevbutton").addClass("hidden");
       
         $("#cancelbutton").removeClass("hidden");
        
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
//        alert('in profiletab');
        var pstatus = true;

        $("#error-box").text("");

        $("#ve_compan").val('');
        $("#ve_city").val('');
        $("#ve_type").val('');
        $("#ve_make").val('');
        $("#v_modal").val('');
        $("#v_image").val('');

        var company = $("#company_select").val();
        var cityselect = $("#city_select").val();
        var vtype = $("#getvechiletype").val();
        var vmake = $('#vehiclemake').val();
        var vmodal = $('#vehiclemodel').val();
        var viewimage = $("#imagefiles").val();
         var driver_select = $("#selected_driver").val();

        var goodType = $("#goodType").val();
        var selectedOwnerType = $("#selectedOwnerType").val();
        
        if (company == "" && selectedOwnerType == '2')
        {
            $("#ve_compan").text(<?php echo json_encode(POPUP_DRIVER_FIRSTNAME); ?>);
            pstatus = false;
        }
         else if((driver_select == "" && selectedOwnerType == 1))
        {
            $("#driver").text('Please select a driver');
            pstatus = false;
        }

        else if (vtype == "" || vtype == null)
        {
            $("#ve_city").text("");
            $("#ve_type").text(<?php echo json_encode(POPUP_DRIVER_MOBILE); ?>);
            pstatus = false;
        }
         else if (goodType == "")
        {
            $("#goodTypeErr").text('Please select good type');
            pstatus = false;
        }


        else if (vmake == "" || vmake == null)
        {
            $("#ve_type").text("");
            $("#ve_make").text(<?php echo json_encode(POPUP_SELECT_VEHICLEMAKE); ?>);
            pstatus = false;
        }

        else if (vmodal == "" || vmodal == null)
        {
            $("#ve_make").text("");
            $("#v_modal").text(<?php echo json_encode(POPUP_DRIVER_MOBILE); ?>);
            pstatus = false;
        }


        else if ((viewimage == "" || viewimage == null) && $('#viewimage_hidden').val() == '')
        {
            $("#ve_make").text("");
            $("#v_modal").text("");
            $("#v_image").text(<?php echo json_encode(POPUP_SELECT_VEHICLEIMAGE); ?>);
            pstatus = false;
        }


        if (pstatus === false)
        {
            setTimeout(function ()
            {
                proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
            }, 300);

            $("#tab1icon").removeClass("fs-14 fa fa-check");
            $("#cancelbutton").removeClass("hidden");
            return false;
        }
        $("#tab1icon").addClass("fs-14 fa fa-check");
         $("#cancelbutton").removeClass("hidden");
        $("#prevbutton").removeClass("hidden");
        $("#nextbutton").removeClass("hidden");
        $("#finishbutton").addClass("hidden");
        return true;
    }

    function addresstab(litabtoremove, divtabtoremove)
    {
        var astatus = true;
//        alert('in address tab');

        if (profiletab(litabtoremove, divtabtoremove))
        {

            $(".error-box").text("");

            $("#vehi_reg").val('');
            $("#vehicl_plate").val('');
            $("#ve_insurence").val('');
            $("#v_color").val('');


            var regno = $("#vechileregno").val();
            var licenseno = $("#licenceplaetno").val();
            var insurenceno = $("#Vehicle_Insurance_No").val();
            var vcolor = $('#vechilecolor').val();

            if (regno == "" || regno == null)
            {
                $("#vehi_reg").text('Please enter the registration number');
                astatus = false;
            }


            else if (licenseno == "" || licenseno == null)
            {
                $("#vehi_reg").text("");

                $("#vehicl_plate").text('Please enter the licence plate number');
                astatus = false;
            }


            else if (insurenceno == "" || insurenceno == null)
            {
                $("#vehicl_plate").text("");
                $("#ve_insurence").text('Please enter the insurance number');
                astatus = false;
            }



            if (astatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'secondlitab', 'tab2');

                }, 100);

                $("#tab2icon").removeClass("fs-14 fa fa-check");
                return false;

            }

            $("#tab3icon").addClass("fs-14 fa fa-check");
             $("#cancelbutton").removeClass("hidden");
            $("#finishbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");

            return astatus;
        }
        alert('after address tab');
    }




    function bonafidetab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (addresstab(litabtoremove, divtabtoremove))
        {

            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'thirdlitab', 'tab3');

                }, 100);

                $("#tab3icon").removeClass("fs-14 fa fa-check");
                return false;
            }

            $("#tab2icon").addClass("fs-14 fa fa-check");
            $("#cancelbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");
            return bstatus;

        }
    }

    function signatorytab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (bonafidetab(litabtoremove, divtabtoremove))
        {
            if (isBlank($("#regcertificate").val()) || isBlank($("#motorcertificate").val()) || isBlank($("#contractpermit").val()) || $("#entitydegination").val() === "null")
            {
                bstatus = false;
            }

            if (validateEmail($("#entityemail").val()) !== 2)
            {
                bstatus = false;
            }

            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'fourthlitab', 'tab4');

                }, 100);

                alert("complete 4 tab properly");
                $("#tab4icon").removeClass("fs-14 fa fa-check");
                return false;
            }

            $("#tab4icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");

            return bstatus;
        }

    }


    function proceed(litabtoremove, divtabtoremove, litabtoadd, divtabtoadd)
    {
        $("#" + litabtoremove).removeClass("active");
        $("#" + divtabtoremove).removeClass("active");

        $("#" + litabtoadd).addClass("active");
        $("#" + divtabtoadd).addClass("active");
    }

    /*-----managing direct click on tab is over -----*/

    //manage next next and finish button
    function movetonext()
    {


        var currenttabstatus = $("li.active").attr('id');
        if (currenttabstatus === "firstlitab")
        {
            profiletab('secondlitab', 'tab2');


            proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
        }
        else if (currenttabstatus === "secondlitab")
        {

            bonafidetab('thirdlitab', 'tab3');

//            alert('after bonafied');
            proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');

        }
        else if (currenttabstatus === "thirdlitab")
        {
            bonafidetab('fourthlitab', 'tab4');
            proceed('thirdlitab', 'tab3', 'fourthlitab', 'tab4');
            $("#finishbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");
        }
    }

    function movetoprevious()
    {
        var currenttabstatus = $("li.active").attr('id');
        if (currenttabstatus === "secondlitab")
        {
            profiletab('secondlitab', 'tab2');
            proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
            $("#prevbutton").addClass("hidden");
        }
        else if (currenttabstatus === "thirdlitab")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('thirdlitab', 'tab3', 'secondlitab', 'tab2');
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");

//            $("#nextbutton").removeClass("hidden");
//            $("#finishbutton").addClass("hidden");
        }
////    else if(currenttabstatus === "fourthlitab")
////    {
////        bonafidetab('fourthlitab','tab4');
////        proceed('fourthlitab','tab4','thirdlitab','tab3');
////        $("#nextbutton").removeClass("hidden");
////        $("#finishbutton").addClass("hidden");
////    }
    }

//here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function validate() {

        if (!isBlank($("#Firstname").val()))
        {
            if (!isAlphabet($("#Firstname").val()))
            {
                $("#errorbox").html("Enter only character in First name");
                return false;
            }
        }
        else
        {
            $("#errorbox").html("First name is blank");
            return false;
        }
    }
    function validateForm()
    {
        if (!isBlank($("#Firstname").val()))
        {
            if (!isAlphabet($("#Firstname").val()))
            {
                $("#errorbox").html("Enter only character in First name");
                return false;
            }
        }
        else
        {
            $("#errorbox").html("First name is blank");
            return false;
        }

        if (!isBlank($("#Lastname").val()))
        {
            if (!isAlphabet($("#Lastname").val()))
            {
                $("#errorbox").html("Enter only character in Last name");
                return false;
            }
        }
        else
        {
            $("#errorbox").html("Last name is blank");
            return false;
        }

        if (validateEmail($("#Email").val()) == 1)
        {

            $("#errorbox").html("Enter valid email");
            return false;
        }

        if (isBlank($("#Password").val()))
        {
            $("#errorbox").html("Password is Blank");
            return false;
        }

        if (!MatchPassword($("#Password").val(), $("#Cpassword").val()))
        {
            $("#errorbox").html("Password not matching");
            return false;
        }
        // return true;
    }



    function submitform()
    {


        $("#error-box").text("");

        $("#v_upload_cr").val('');
        $("#ve_expire").val('');
        $("#vehicle_uploadmotor").val('');
        $("#expire_insurence_date").val('');
        $("#vehicle_up_carrp").val('');
        $("#vehicle_expire_date").val('');

        var regcertificate = $("#regcertificate").val();
        var expirerc = $("#expirationrc").val();
        var motorcertificate = $("#motorCertificate").val();
        var expiremotor = $("#expirationinsurance").val();

        var carriagepermit = $("#PermitCertificate").val();
        var date = $("#date").val();
        var entitydegnation = $("#entitydegination").val();
        var edate = $("#edate").val();


//
        if ((regcertificate == "" || regcertificate == null) && $('#regcertificate_hidden').val() == '')
        {
            $("#v_upload_cr").text(<?php echo json_encode(POPUP_SELECT_VEHICLEUPLOADREGNO); ?>);
        }


        if (expirerc == "" || expirerc == null)
        {

            $("#v_upload_cr").text("");
            $("#ve_expire").text(<?php echo json_encode(POPUP_SELECT_VEHICLE_DATE); ?>);

        }


        else if ((motorcertificate == "" || motorcertificate == null) && $('#motorcertificate_hidden').val() == '')
        {
            $("#ve_expire").text("");
            $("#vehicle_uploadmotor").text(<?php echo json_encode(POPUP_SELECT_VINSURENCENUMBER_INSURENCE); ?>);

        }


        else if (expiremotor == "" || expiremotor == null)
        {
            $("#vehicle_uploadmotor").text("");
            $("#expire_insurence_date").text(<?php echo json_encode(POPUP_SELECT_VEHICLE_DATE); ?>);

        }

        else if ((carriagepermit == "" || carriagepermit == null) && $('#carriagepermit_hidden').val() == '')
        {
            $("#expire_insurence_date").text("");
            $("#vehicle_up_carrp").text(<?php echo json_encode(POPUP_SELECT_VEHICLECOLOR_CARRIAGE_PERMIT); ?>);

        }


        else if (edate == "" || edate == null)
        {
            $("#vehicle_up_carrp").text("");
            $("#vehicle_expire_date").text(<?php echo json_encode(POPUP_SELECT_VEHICLE_DATE); ?>);
            return false;
        }

        else {
            $('#addentity').submit();
        }

    }
    
    function cancel(){
    
            window.location="<?php echo base_url('index.php?/superadmin') ?>/Vehicles/1";
    }

</script>



<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
  
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="margin-top: 5%;">
                    <li><a href="<?php echo base_url('index.php?/superadmin') ?>/Vehicles/1" class=""><?php echo LIST_VEHICLE; ?></a>
                    </li>

                    <li style="width: 100px"><a href="#" class="active">EDIT</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>

  <div class="content">
        <!-- START JUMBOTRON -->
        <div class="bg-white" data-pages="parallax">

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <li class="active tabs_active" id="firstlitab" onclick="managebuttonstate()">
                            <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span><?php echo LIST_VEHICLE_VEHICLESETUP; ?></span></a>
                        </li>
                        <li class="tabs_active" id="secondlitab">
                            <a data-toggle="tab" href="#tab2" onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span><?php echo LIST_VEHICLE_DETAILS; ?></span></a>
                        </li>
                        <li class="tabs_active" id="thirdlitab">
                            <a data-toggle="tab" href="#tab3" onclick="addresstab('thirdlitab', 'tab3')"><i id="tab3icon" class=""></i> <span><?php echo LIST_VEHICLE_DOCUMETS; ?></span></a>
                        </li>
                      
                    </ul>
                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/superadmin/editNewVehicleData/<?php echo $vehId;?>/1" method="post" enctype="multipart/form-data">
                        <div class="tab-content">
                            <input type="hidden" value="<?php echo $vehId; ?>" name="vehicle_id"/>
                            <?php

                                 $accType = $vehicleData['account_type'];
                                ?>
                           
                            
                                <div class="tab-pane padding-20 slide-left active" id="tab1">
                                    <div class="row row-same-height">
                                        
                                        
                                        <div class="form-group" class="formexx">
                                        <label for="address" class="col-sm-2 control-label">Ownership Type<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-5">
                                                <input type="radio" class="radio-success" name="OwnershipType" id="Operator" value="2" checked>
                                                    <label>Operator</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="radio" class="radio-success" name="OwnershipType" id="Freelancer" value="1">
                                                    <label>Freelancer</label>
                                                </div>
                                        </div>
                                        <input type="hidden" id="selectedOwnerType" name="selectedOwnerType" value="2">

                                        <div class="col-sm-3 error-box" id="companyname"></div>
                                    </div>


                                        <div class="form-group">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_SELECTCOMPANY; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                             
                                                <select id="company_select" name="company_id"  class="form-control error-box-class" >
                                                    <option value="">Select a Company  </option>


                                                    <?php
                                                    foreach ($Operators as $each) {
                                                        echo "<option value='" . $each['_id']['$oid'] . "' operator='".$each['operatorName']."'>" . $each['operatorName'].' - '.$each['email'].' - '.$each['mobile']. "</option>";
                                                    }
                                                    ?>

                                                </select>
                                                 <input type="hidden" id="operatorName" name="operatorName">
                                            </div>
                                            <div class="col-sm-3 error-box" id="ve_compan"></div>

                                        </div>
                                        
                                      
                                        
                                 <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Driver Name<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select id="selected_driver" name="selected_driver" class="form-control error-box-class">

                                               
                                            </select>
                                             <input type="hidden" id="driverName" name="driverName">
                                               <input type="hidden" id="driverMobile" name="driverMobile">
                                        </div>
                                        <div class="col-sm-3 error-box" id="driver"></div>
                                    </div>
                                    

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_VEHICLETYPE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
            
                                                <select id="getvechiletype" name="getvechiletype" class="form-control error-box-class">
                                                    <option value="">Select a vehicle type</option>
                                                    <?php
                                                    foreach ($vehicleTypes as $each) {
                                                        echo "<option value='" . $each['_id']['$oid'] . "' typeName='".$each['type_name']."'>". $each['type_name']."</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                          <input type="hidden" id="vehicleTypeName" name="vehicleTypeName">
                                            <div class="col-sm-3 error-box" id="ve_type"></div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                          <label for="address" class="col-sm-2 control-label">Good Types</label>
                                          <div class="col-sm-6">
                                              
                                              <div class="multiselect">
                                                <div class="selectBox " onclick="showCheckboxes()">
                                                    <select class="form-control">
                                                    <option>Select an option</option>
                                                  </select>
                                                  <div class="overSelect"></div>
                                                </div>
                                                <div id="checkboxes"> 
                                                   <?php
                                                  
                                                       foreach ($allVehicleTypeGoodTypes as $vType)
                                                       {
                                                          if(in_array($vType,$vehicleData['goodTypes']))
                                                          {
                                                              ?>
                                                        
                                                   <label for="<?php echo $vType;?>">
                                                      <input type="checkbox" class=" checkbox1" name="goodType[]" id="<?php echo $vType;?>" goodType="<?php echo $goodTypesAll[$vType];?>" checked value="<?php echo $vType;?>"/><?php echo $goodTypesAll[$vType];?>
                                                  </label>
                                                        <?php
                                                          }
                                                          else{
                                                              ?>
                                                 
                                             <label for="<?php echo $vType;?>">
                                                      <input type="checkbox" class=" checkbox1" name="goodType[]" id="<?php echo $vType;?>" goodType="<?php echo $goodTypesAll[$vType];?>"  value="<?php echo $vType;?>"/><?php echo $goodTypesAll[$vType];?>
                                                  </label>
                                            <?php
                                                          }
                                                       
                                                        }
                                                   ?>
                                            </div>
                                          </div>
                                         </div>

                                       </div> 
                                        
                                        <div class="form-group">
                                          <label for="address" class="col-sm-2 control-label"></label>
                                          <div class="col-sm-6">
                                              <div class="selectedGoodType" style="border-style:groove;min-height: 70px;padding: 6px;"></div>
                                          </div>
                                    </div>


                                        <div class="form-group">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_VEHICLEMAKE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">

                                                <select id="vehiclemake" name="title" class="form-control error-box-class">

                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($vehiclemake as $each) {
                                                    echo "<option value='" .$each['_id']['$oid']. "' id='" . $each['_id']['$oid'] . "' name='".$each['Name']."'>" . $each['Name'] . "</option>";
                                                }
                                                    ?>
                                                </select>
                                                <input type="hidden" id="vehicleMakeName" name="vehicleMakeName">
                                            </div>
                                           
                                            <div class="col-sm-3 error-box" id="ve_make"></div>
                                        </div>



                                        <div class="form-group">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_VEHICLEMODEL; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
           
                                                <select id="vehiclemodel" name="vehiclemodel" class="form-control error-box-class">

                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($modalData as $each) {
                                                    echo "<option value='" .$each['_id']['$oid']. "' id='" . $each['_id']['$oid'] . "'>" . $each['Name'] . "</option>";
                                                }
                                                    ?>
                                                   
                                                </select>
                                                 <input type="hidden" id="vehicleModelName" name="vehicleModelName">
                                            </div>
                                          
                                            <div class="col-sm-3 error-box" id="v_modal"></div>
                                        </div>


                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_IMAGE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-4">
                              
                                                <input type="file" class="form-control error-box-class" style="height: 37px;" name="imagefile" id="imagefiles">
                                                <input type="hidden" value="<?php echo $vehicleData['image']; ?>" id='viewimage_hidden'/>
                                                 <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="vehicleImage" id="vehicleImage">
                                                <?php
//                                                if ($vehicleData['image'] != '') {
                                                    ?>
                                                    <!--<a style="color:royalblue" target="_blank" href="<?php echo $vehicleData['image'];?>">view</a>--> 

                                                <?php // }
                                                ?>
                                            </div>
                                            
                                            <div class="col-sm-2">
                                                <img style="width:35px;height:35px;" src="<?php echo $vehicleData['image']; ?>" alt="" class="style_prevu_kit"></div>
                                     
                                            <div class="col-sm-3 error-box" id="v_image"></div>
                                        </div>
                                       
                                    </div>
                                </div>

                                <div class="tab-pane slide-left padding-20" id="tab2">
                                    <div class="row row-same-height">

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_REGNO; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="vechileregno" name="vechileregno" required="required"class="form-control" value="<?php echo $vehicleData['reg_number']; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="vehi_reg"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_PLATENO; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="licenceplaetno" name="licenceplaetno" required="required" class="form-control" placeholder="eg. KA-05/1800" value="<?php echo $vehicleData['platNo']; ?>">
                                            </div>
                                            <div class="col-sm-3 error-box" id="vehicl_plate"></div>
                                        </div>
                                        

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_INSURENCE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="Vehicle_Insurance_No" name="Vehicle_Insurance_No" required="required" placeholder="eg. PL-23111441" value="<?php echo $vehicleData['insurance_number']; ?>">
                                            </div>
                                            <div class="col-sm-3 error-box" id="ve_insurence"></div>
                                        </div>

                                    </div>
                                </div>



                                <div class="tab-pane slide-left padding-20" id="tab3">
                                    <div class="row row-same-height">

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_UPLOADCR; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-4">
                               
                                                <input type="file" class="form-control error-box-class" style="height: 37px;" name="certificate" id="regcertificate">
                                                <input type="hidden" value="<?php echo $vehicleData['regCertImage']; ?>" id='regcertificate_hidden'/>
                                                <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="registationCertificate" id="registationCertificate">
                                            </div>
                                            <div class="col-sm-2">
                                            <img style="width:35px;" src="<?php echo $vehicleData['regCertImage']; ?>" alt=""></div>
                                            <?php
//                                                if ($vehicleData['regCertImage'] != "") {
                                                    ?>
                                            <!--<a class="pull-left" style="color:royalblue" target='_blank' href="<?php echo $vehicleData['regCertImage']; ?>">view</a>--> 

                                                    <?php
//                                                }
                                                ?>
                                         
                                            <div class="col-sm-3 error-box" id="v_upload_cr"></div>
                                        </div>



                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_EXPIREDATE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-4">

                                                <input id="expirationrc" name="expirationrc" required="required"  type="" class="form-control error-box-class datepicker-component" value="<?php echo  $vehicleData['regCertExpr']; ?>">
                                            </div>
                                            <div class="col-sm-3 error-box" id="ve_expire"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_UPLOADMOTOR; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-4">
                                                <input type="file" class="form-control error-box-class" style="height: 37px;" name="insurcertificate" id="motorcertificate">
                                                 <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="motorCertificate" id="motorCertificate">
                                                <input type="hidden" value="<?php echo $vehicleData['motorInsuImage']; ?>" id='motorcertificate_hidden'/>
                                               
                                            </div>
                                            <div class="col-sm-2">
                                            <img style="width:35px;" src="<?php echo $vehicleData['motorInsuImage']; ?>" alt=""></div>
                                             <?php
//                                                if ($vehicleData['motorInsuImage'] != "") {
//                                                    ?>
                                                    <!--<a class="pull-left" style="color:royalblue" target='_blank' href="//<?php echo $vehicleData['motorInsuImage']; ?>">view</a>--> 

                                                    <?php
//                                                }
                                                ?>
                                           
                                            <div class="col-sm-3 error-box" id="vehicle_uploadmotor"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_EXPIREDATE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-4">

                                                <input id="expirationinsurance" name="expirationinsurance" required="required"  type=""class="form-control error-box-class datepicker-component" value="<?php echo $vehicleData['motorInsuExpr']; ?>" >
                                            </div>
                                   
                                            <div class="col-sm-3 error-box" id="expire_insurence_date"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_UPLOADCP; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-4">
                                                <input type="file" class="form-control error-box-class" name="carriagecertificate" id="contractpermit">
                                                <input type="hidden" value="<?php echo $vehicleData['permitImage']; ?>" id='carriagecertificate_hidden'/>
                                                <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="PermitCertificate" id="PermitCertificate">
                                                
                                            </div>
                                             <div class="col-sm-2">
                                            <img style="width:35px;" src="<?php echo $vehicleData['permitImage']; ?>" alt=""></div>
                                            <?php
//                                                if ($vehicleData['permitImage'] != "") {
//                                                    ?>
                                                <!--<a  class="pull-left" style="color:royalblue" target='_blank' href="//<?php echo $vehicleData['permitImage']; ?>">View</a>-->

                                                    <?php
//                                                }
                                                ?>
                                        
                                            <div class="col-sm-3 error-box" id="vehicle_up_carrp"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_EXPIREDATE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-4">

                                                <input type="" class="form-control error-box-class datepicker-component" style="height: 37px;" name="expirationpermit" id="edate" value="<?php echo $vehicleData['permitExpr']; ?>">
                                            </div>
                                
                                            <div class="col-sm-3 error-box" id="vehicle_expire_date"></div>
                                        </div>
                                        
                                       
                                </div>
                            </div>

                            <div class="padding-20 bg-white col-sm-10">
                                <ul class="pager wizard">
                                    <li class="next" id="nextbutton">
                                        <button class="btn btn-success  pull-right" type="button" onclick="movetonext()">
                                            <span>Next</span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-success  pull-right" type="button" onclick="submitform()" >
                                            <span>Finish</span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-info  pull-right" type="button" onclick="movetoprevious()">
                                            <span>Previous</span>
                                        </button>
                                    </li>
                                     <li class="" id="cancelbutton">
                                    
                                         <button  type="button" class="btn btn-default  pull-right" onclick = "cancel()" >
                                             <?php echo BUTTON_CANCEL; ?>
                                         </button>
                                        </li>
                                </ul>

                            </div>

                        </div>

                    </form>

                </div>


            </div>
            <!-- END PANEL -->
        </div>

    </div>

   
</div>
