<!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>-->

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<link rel="stylesheet" type="text/css" href="http://104.131.66.74/Grocer/sadmin/application/views/sweetalert/dist/sweetalert.css">
<style>
    
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    
    select#tslot {
    position: relative;
    margin-top: 7px;
}
 input#perslotperdriver {
    position: relative;
    margin-top: 7px;
    font-size: 14px !important;
}
.row{
    margin-left: 10px;
    padding: 10px;
}
.bendtime {
    font-size: 14px;
    margin-left: 45px;
}
</style>

<script>
    function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        alert('Please Enter only numbers')
        theEvent.returnValue = false;
        if (theEvent.preventDefault)
            theEvent.preventDefault();

    }
}
</script>
<script>
    $(document).ready(function () {
        
        $('#tslot').val('<?php echo $storedriverconfig['tslot'];?>');
        $('#start_time').val('<?php echo $storedriverconfig['startTime'];?>');
        $('#end_time').val('<?php echo $storedriverconfig['endTime'];?>');
        var dispmthd = '<?php echo $storedriverconfig['dispatchMethod'];?>';
       if( dispmthd == '' || dispmthd == "On Demand")
       {
          
           $('#dispatch_method').attr('checked',true);
           $('#selecteddispatch').val('On Demand');
       }
       else
       {
           $('#dispatch_method1').attr('checked',true);
        $('#selecteddispatch').val('Slot Dispatch');
    }
      
        $('.disp').click(function(){
        
        $('#selecteddispatch').val($(this).val());
        });
        
        



            $('#update').click(function () {
        
            var tslot = $("#tslot").val();
            var perslotperdriver = $("#perslotperdriver").val();
            var selecteddispatch = $("#selecteddispatch").val();
            var start_time = $("#start_time").val();
            var end_time = $("#end_time").val();
            var businessId = '<?php echo $BizId; ?>';
            
            var form_data = new FormData();
            form_data.append('tslot', tslot);
            form_data.append('perslotperdriver', perslotperdriver);
            form_data.append('selecteddispatch', selecteddispatch);
            form_data.append('start_time', start_time);
            form_data.append('end_time', end_time);
            form_data.append('businessId', businessId);
           console.log(form_data);

            
            if (tslot == "" || tslot == null )
            {
                swal("Please select the Delivery Slot !");
             
            }
            else if (start_time == "" || start_time == null)
            {
                swal(" Please select the business start time !");
               
            }
             else if (end_time == "" || end_time == null)
            {
                swal(" Please select the business end time !");
               
            }
            else if (perslotperdriver == "" || perslotperdriver == null)
            {
                swal("Number of orders per slot per driver is empty : Please enter the value !");
                
            }
          
            
           
            else {
            
                $.ajax({
                    
                    url: "<?php echo base_url('index.php/Admin') ?>/update_storetimeslots",
                    type: 'POST',
                    data: form_data,//{tslot:tslot,perslotperdriver:perslotperdriver,businessId:businessId,selecteddispatch:selecteddispatch,start_time:start_time,end_time:end_time},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        swal("Good job!", "Config Added Successfully!", "success");
                        
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php/Admin/storedriver_config',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {

                            }
                          
                        };


                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
              
            }
        });
       
      
  });
</script>



<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color:#0090d9;
             padding-top: 45px;
            padding-bottom: 20px;">
           <!--                    <img src="--><?php //echo base_url();                                                               ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();                                                               ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();                                                               ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->
            <strong>Store Driver Time Configuration</strong>
             </div>
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">
          
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <!--<div class="error-box" id="display-data" style="text-align:center"></div>-->
                                    <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog modal-sm">                                        
                                        <!-- Modal content-->
                                            <div class="modal-content">                                            
                                                <div class="modal-body">
                                                <h5 class="error-box" id="display-data" style="text-align:center"></h5>                                            
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>     

                                <br>
                                <div class="panel-body" >
                                    <div class="row col-sm-12">
                                        
                                                <div class="col-sm-2 success-box success-box-class" >                                               
                                                    <h4 >Delivery Slot Duration</h4></div>
                                                <div class=" col-sm-2">
                                                  <select class="form-control company_select" id="tslot">
                                                    <option value="">Select</option>
                                                    <?php
                                                    for($hours=1; $hours<=24; $hours++)
                                                    echo '<option value="'.$hours.'">'.$hours.' Hours</option>'
                                                    
                                                    ?>
                                                  </select>
                                                 </div>
                                   
                                    </div>
                                    <div class="row col-sm-12">
                                        
                                        <div class="col-sm-2 success-box success-box-class" >                                               
                                                    <h4>Business Start Time</h4>
                                         </div>
                                        <div class=" col-sm-2">
                                                  <select class="form-control company_select" id="start_time">
                                                       <option value="">Select</option>
                                                    <?php
                                                    for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
                                                         for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
                                                                  echo '<option value ="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                                                                 .str_pad($mins,2,'0',STR_PAD_LEFT).'">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                                                                 .str_pad($mins,2,'0',STR_PAD_LEFT).' Hour</option>';
                                                    ?> 
                                                         </select>
                                        </div>
                                        
                                        
                                    </div>
                                     <div class="row col-sm-12">
                                        
                                        <div class="col-sm-2 success-box success-box-class" >                                               
                                            <h4>Business End Time</h4>
                                         </div>
                                        <div class=" col-sm-2">
                                                  <select class="form-control company_select" id="end_time">
                                                    <option value="">Select</option>
                                                     <?php
                                                    for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
                                                         for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
                                                                  echo '<option value ="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                                                                 .str_pad($mins,2,'0',STR_PAD_LEFT).'">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                                                                 .str_pad($mins,2,'0',STR_PAD_LEFT).' Hour</option>';
                                                    ?> 
                                                  </select>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="row col-sm-12">
                                               <div class="col-sm-2 success-box success-box-class" >                                               
                                                   <h4 >Number of orders per<br/> slot per driver</h4>
                                               </div>
                                                    <div class=" col-sm-2">

                                                        <input type="text" id="perslotperdriver" name="perslotperdriver" onkeypress="validate(event)" class="form-control company_select " value="<?php echo $storedriverconfig['perslotperdriver']?>"/>
                                               
                                                    </div>
                                        
                                    </div>
                                

                                    
                                  
                                    
                                     <div class="row col-sm-12">
                                              <div class="col-sm-2 success-box success-box-class" >
                                                  <h4>Dispatch Methods</h4>
                                              </div>
                                                <div class="col-sm-2">
                                                    <h5>
                                                        <input type="radio" id="dispatch_method" name="dispatch" class="disp" value="On Demand">On Demand &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="dispatch" id="dispatch_method1"  class="disp" value="Slot Dispatch" >Slot Dispatch
                                                    
                                                    </h5>
                                                           
                                                </div>
                                     </div>   
                                               <input type="hidden" id="selecteddispatch">
                                    </div>
                                    <br/>
                                     <br/>
                                     <div>
                                         <div id="clearerror" style="color: red; font: 14px; margin-left: 20px;"></div>
                                        <button class="btn btn-success" id="update" style="margin-left: 35px">Save</button>
                                </div>
                                </div>
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- END JUMBOTRON -->

    </div>
    <!-- END PAGE CONTENT -->
 
</div>

   
<!--<script  src="<?php echo base_url() ?>application/views/sweetalert/dist/sweetalert.js"></script>-->
<script  src="http://104.131.66.74/Grocer/sadmin/application/views/sweetalert/dist/sweetalert.min.js"></script>
