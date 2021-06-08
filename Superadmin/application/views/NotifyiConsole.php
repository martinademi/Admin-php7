<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<style>
    #companyid{
        display: none;
    }
    .dataTables_filter{display: none;}
    .ui-autocomplete-input {
  border: none; 
  font-size: 14px;
  width: 300px;
  height: 24px;
  margin-bottom: 5px;
  padding-top: 2px;
  border: 1px solid #DDD !important;
  padding-top: 0px !important;
  z-index: 1511;
  position: relative;
}
.ui-menu .ui-menu-item a {
  font-size: 12px;
}
.ui-autocomplete {
  position: fixed;
  top: 100%;
  left: 0;
  z-index: 1051 !important;
  float: left;
  display: none;
  min-width: 160px;
  width: 160px;
  padding: 4px 0;
  margin: 2px 0 0 0;
  list-style: none;
  background-color: #ffffff;
  border-color: #ccc;
  border-color: rgba(0, 0, 0, 0.2);
  border-style: solid;
  border-width: 1px;
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  *border-right-width: 2px;
  *border-bottom-width: 2px;
}
.ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    text-decoration: none;
}
.ui-state-hover, .ui-state-active {
      color: #ffffff;
      text-decoration: none;
      background-color: #0088cc;
      border-radius: 0px;
      -webkit-border-radius: 0px;
      -moz-border-radius: 0px;
      background-image: none;
}
/*#show_email {
            width: 57%;
          min-height: 114px;
          max-height: 300px;
          border: 1px solid #ccc;
          padding: 5px;
          margin-left: 14.5%;

        }*/
</style>
<script>
var tab_id = 1;
var idNum = 0;
 var cityArray = [];
 var userIdArray = [];
 var isValid = false;
 var c_id;
 var user_id;
  var emails = [];
  
  
    $(document).ready(function (e) {
        
        refreshTableOnActualcitychagne();

        $('#document_data').click(function () {

        
            $('#myModal1_driverpass').modal('show');
            
        });
        
         $('#send_to_part').click(function () {
             //tab_id => 1 - Passenger
             //tab_id => 3 - Driver
             $('#show_email').empty();
    
            $('#sendTOspecific_modal').modal('show');
            
             var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            
            for(var i=0; i<val.length;i++)
            {
                
//                $('#show_email').append('<div class="col-sm-4"><input type="text" readonly class="form-control error-box-class class_emails" style="width: 223px;margin-left:8%;" value="' +val[i]+ '" name="all_emails[]"></div>');
                $('#show_email').append('<div class="row form-group" id="removeId' + idNum + '">\n<div class="col-sm-7"><input type="text" readonly class="form-control error-box-class class_emails" style="width: 223px;margin-left:8%;color:blue" value="' + val[i] + '" name="all_emails[]"></div><div class="col-sm-1"><input type="button" id=' + idNum + '  value="&#10008" style="height: 36px;"  onclick="Remove(' + idNum++ + ');"> </div></div>');
            }
//            
            
//             $('#show_email').append('<div class="row form-group" id="removeId'+idNum+'"><div class="col-sm-2"></div>\n<div class="col-sm-6"><input type="text" readonly class="form-control error-box-class class_emails" style="width: 223px;margin-left:8%;" value="' +email_id+ '" name="all_emails[]"></div><div class="col-sm-1"><input type="button" id='+ idNum +'  value="&#10008" style="height: 36px;"  onclick="Remove('+idNum+++');"> </div></div>');
//             $.ajax({
//            url: "<?php echo base_url('index.php?/superadmin') ?>/show_allEmails",
//            type: "POST",
//            data: {userType:tab_id},
//            dataType: 'JSON',
//            success: function (response)
//            {
//                $.each(response, function (key, value)
//                {
//                    var Email = {label: value.email};
//                    countryArray.push(Email);
//                });
//       
//                $("#search-box").autocomplete({
//                    source: countryArray,
//                    select: function (event, ui) {
//                        $('#search-box-hidden').val(ui.item);
//                       
//                    }
//                });
//            }
//        })
        });

        $("#sendPushToAll").click(function () {
           
            var message = $('#Message').val();
            var city = $('#citID').val();
          
            if (message == "")
            {
                alert('please provide Message.');
            }
            else if (city == '')
            {
                alert('please select Cities.');
            }
            else
            {

                $.ajax({
                    url: "<?php echo base_url() ?>../../services.php/PushFromAdminForAll",
                    type: 'POST',
                    data: {
                        city: city,
                        message: message,
                        usertype:tab_id
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.Count != 0) {
                            alert('Number of users Got The push =>  ' + response.Count);
                             refreshTableOnActualcitychagne();

                        }
                       else {
                            alert('No users found');
                        }
                        
                       $(".close").trigger('click');
                     

                    }

                });
            }

        });

   
        $("#sendPushToSpecific").click(function () {
        
       
        
       $(".class_emails").each(function() {
            var element = $(this).val();
            if (element != "" || element != null) {
                emails.push(element);
                isValid = true;
            }
         });
         
         var count_city = 1;
         $('input[name="checkbox"]:checked').each(function() {
            c_id = $(this).data('style');
            user_id = $(this).data('id');
            userIdArray.push(user_id);
            
            if(count_city == 1)
                 cityArray.push(c_id);
             else
             {
               
               var found = $.inArray(c_id, cityArray);
              
               if(found == -1)
               {
                   alert('Please choose only one cities users');
                   e.preventDefault();
               }
           }
           
           count_city++;
         });
         
            //Checking whether user has choosed emails or not
            if(isValid)
            {
        
            var message = $('#MessageForSpecific').val();
            if (message == "")
            {
                alert('please provide Message.');
                 e.preventDefault();
            }
            else
            {
//
                $.ajax({
                    url: "<?php echo base_url() ?>../../services.php/PushFromAdminForSpicific",
                    type: 'POST',
                    data: {
//                        emails: emails,
                        User_id: user_id,
                        city_id: c_id,
                        message: message,
                        usertype: tab_id
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                       
                      
                        if (response.Count != 0) {
                            alert('Number of users Got The push =>  ' + response.Count);

                        }
                       else {
                            alert('No users found');
                        }

                    }

                });
            }
           }
           else
             alert('Please choose at least one email id');

        });
        
        $('.tabClass').click(function ()
        {
            tab_id = $(this).data('id');
           
        });


        $('#addEmail').click(function ()
        {
            
            var email_id = $("#search-box").val();
            if(email_id != "" && email_id.indexOf('@') != -1)
            {
                    $('#show_email').append('<div class="row form-group" id="removeId'+idNum+'"><div class="col-sm-2"></div>\n<div class="col-sm-6"><input type="text" readonly class="form-control error-box-class class_emails" style="width: 223px;margin-left:8%;" value="' +email_id+ '" name="all_emails[]"></div><div class="col-sm-1"><input type="button" id='+ idNum +'  value="&#10008" style="height: 36px;"  onclick="Remove('+idNum+++');"> </div></div>');
            }
               $("#search-box").val('');            
        });
    });
    
   function Remove(id)
    {
 
            $('#removeId'+id).remove();
            $('#'+id).remove();
       
    }

  
  function refreshTableOnActualcitychagne() {
      
      var cityId = $('#selectedcity').val();
      
       if (cityId != '0')
            {

                $.ajax({
                    url: '<?php echo base_url('index.php?/superadmin') ?>/NotificationData',
                    data: {city_id:cityId},
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (response)
                    {
                       
                     
                          var table = $('#tableWithSearch').DataTable();
                          var table1 = $('#tableWithSearch1').DataTable();
                         table.clear().draw();
                         table1.clear().draw();
                        
                         
                                    $.each(response.Result, function (index, row) {
                                        
                                      
                                        
                                        if(row.user_type == 1)
                                        {
                                        
                                            table.row.add([
                                               index+1,
                                               row.city_name,
                                               row.dname,
                                               row.demail,
                                               row.dmobile,
                                               row.msg,
                                               row.ddate,
                                               '<input type="checkbox" class="checkbox class_emails" name="checkbox"  data-style='+  row.city_id +' data-id=' +  row.d_id +' value= ' +  row.demail +'>'
                                              ]).draw();
                                          }
                                          else
                                          {
                                                table1.row.add([
                                               index+1,
                                               row.city_name,
                                               row.dname,
                                               row.pemail,
                                               row.pmobile,
                                               row.msg,
                                               row.pdate,
                                               '<input type="checkbox" class="checkbox class_emails" name="checkbox"  data-style='+  row.city_id +' data-id=' +  row.p_id +' value= ' +  row.pemail +'>'
                                              ]).draw();
                                          }

                                           
                                         });
                                    
                         
                    }
                });
            } 
            else
            {
            
                $.ajax({
                    url: '<?php echo base_url('index.php?/superadmin') ?>/NotificationDataAll',
                    data: {city_id:cityId},
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (response)
                    {
                       
                         var table = $('#tableWithSearch').DataTable();
                          var table1 = $('#tableWithSearch1').DataTable();
                         table.clear().draw();
                         table1.clear().draw();
                         
                         console.log(response.Result);
                        
                            
                                     $.each(response.Result, function (index, row) {
                                        
                                       if(row.user_type == 1)
                                        {
                                        
                                            table.row.add([
                                               index+1,
                                               row.city_name,
                                               row.dname,
                                               row.demail,
                                               row.dmobile,
                                               row.msg,
                                               row.ddate,
                                               '<input type="checkbox" class="checkbox class_emails" name="checkbox"  data-style='+  row.city_id +' data-id=' +  row.d_id +' value= ' +  row.demail +'>'
                                              ]).draw();
                                          }
                                          else
                                          {
                                                table1.row.add([
                                               index+1,
                                               row.city_name,
                                               row.dname,
                                               row.pemail,
                                               row.pmobile,
                                               row.msg,
                                               row.pdate,
                                               '<input type="checkbox" class="checkbox class_emails" name="checkbox"  data-style='+  row.city_id +' data-id=' +  row.p_id +' value= ' +  row.pemail +'>'
                                              ]).draw();
                                          }

                                           
                                         });
                         
                    }
                });
            }
  }
  
</script>
<script>
$(document).ready(function()
{
     $('#tableWithSearch1').DataTable();
 
	$('#search-table1').keyup(function()
	{
            //alert($(this).val());
		searchTable($(this).val());
	});
       
});
function searchTable(inputVal)
{
	var table = $('#tableWithSearch1');
        //alert("Something");
	table.find('tr').each(function(index, row)
	{
		var allCells = $(row).find('td');
		if(allCells.length > 0)
		{
			var found = false;
			allCells.each(function(index, td)
			{
				var regExp = new RegExp(inputVal, 'i');
				if(regExp.test($(td).text()))
				{
					found = true;
					return false;
				}
			});
			if(found == true)$(row).show();else $(row).hide();
		}
	});
}
</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
    
        <div class="container-fluid container-fixed-lg bg-white">
            <!-- START PANEL -->
            <div class="panel panel-transparent">
                <div class="panel-heading">

                    <div class="pull-left">
                        <div class="col-xs-12">
                          
                            <ul class="breadcrumb" style="margin-left:-38px;color: #0090d9;">
                                    <li>
                                        <a href="#">SEND NOTIFICATION</a>
                                    </li>                    

                                </ul>

                            
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="col-xs-12">
<!--                            <input id="search-table" class="form-control pull-right" placeholder="Search" type="text" aria-controls="tableWithSearch">-->

                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>


                
                                       
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-fillup">
                    <li class="active">
                        <a data-toggle="tab" class="tabClass" href="#tab-fillup1" data-id="1"><span>DRIVERS</span></a>
                    </li>
                    <li>
                        <a data-toggle="tab" class="tabClass" href="#tab-fillup2" data-id="2"><span>PASSENGERS</span></a>
                    </li>
                    
                    <div class="pull-right m-t-10"> <button class="btn btn-primary pull-right m-t-10 " id="document_data"  style="margin-left:10px;margin-top: 5px">SEND TO ALL</button></div>
                        <div class="pull-right m-t-10"> <button class="btn btn-primary pull-right m-t-10 " id="send_to_part"  style="margin-left:10px;margin-top: 5px">SEND TO SPECIFIC</button></div>


                     

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                   
                    <div class="tab-pane active" id="tab-fillup1">
                        <div class="pull-right">
                        <div class="col-xs-12">
                            <input id="search-table" class="form-control pull-right" placeholder="Search" type="text" aria-controls="tableWithSearch">

                        </div>
                    </div>
                             

                        <div class="dataTables_wrapper form-inline no-footer" id="tableWithDynamicRows_wrapper">
                            <div class="table-responsive" style="overflow-x: hidden;">
                                <table aria-describedby="tableWithSearch_info" role="grid" class="table table-hover demo-table-dynamic dataTable no-footer" id="tableWithSearch" style="margin-top: 5%;">
                                    <thead>

                                       <tr>                                   
                                            <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 64px;">
                                                SL NO</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                               CITY</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                               DRIVER NAME</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                                 DRIVER EMAIL</th>

                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                               DRIVER PHONE</th>
                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                               MASSAGE</th>
                                             <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                               DATE</th>
                                             <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                               SELECT</th>
                                           
                                        </tr>


                                    </thead>
                                    <tbody>
                                        
                                         <?php
                                    $start = 1;
                                    
                                 
                                   
//                                    foreach($AllRecordsForDriver as  $row){
////                                        echo '<pre>';
////                                        print_r($row);
////                                        echo '</pre>';
////                                        break;
//                                      
//                                     ?>
<!--                                        <tr><td> <?php //echo $start; ?></td>
                                             <td><?php //echo $row['city'];?></td>
                                             <td><?php //echo $row['dname'];?></td>
                                             <td><?php //echo $row['demail'];?></td>
                                             <td><?php// echo $row['dmobile'];?></td>
                                             <td><?php //echo $row['msg'];?></td>
                                             <td><?php //echo $row['DateTime'];?></td>
                                             <td><input type="checkbox" class="checkbox" name="checkbox"  data-style="//<?php echo $row['city_id'];?>" data-id="<?php echo $row['mas_id'];?>" value= "<?php echo $row[3];?>"/></td>
                                        </tr>-->
                                        <?php
//                                         $start++; 
//                                       
//                                    }
                                    ?>       
                                        
                                    </tbody>
                                </table>
                            </div>



                        </div>
                                  </div>

                   


        


                    <div class="tab-pane" id="tab-fillup2">
                        <div class="pull-right">
                        <div class="col-xs-12">
                            <input id="search-table1" class="form-control pull-right" placeholder="Search" type="text" aria-controls="tableWithSearch1">

                        </div>
                    </div>
                     
                       <div class="dataTables_wrapper form-inline no-footer" id="tableWithDynamicRows_wrapper"><div class="table-responsive" style="overflow-x: hidden">
                               <table aria-describedby="tableWithSearch_info" role="grid" class="table table-hover demo-table-dynamic dataTable no-footer" id="tableWithSearch1" style="margin-top: 5%;">
                                    <thead>

                                         <tr>                                   
                                            <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 100px;">
                                                SL NO</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                               CITY</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                               PASSENGER NAME</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch1" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                                 PASSENGER EMAIL</th>

                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch1" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                               PASSENGER PHONE</th>
                                             <th class="sorting" tabindex="0" aria-controls="tableWithSearch1" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                               MASSAGE</th>
                                             <th class="sorting" tabindex="0" aria-controls="tableWithSearch1" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                               DATE</th>
                                              <th class="sorting" tabindex="0" aria-controls="tableWithSearch1" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                               SELECT</th>
                                           
                                        </tr>

                                    </thead>
                                    <tbody>
                                       
                                            
                                         <?php
                                    $start = 1;
                                   
                                    foreach($Passenger_data as  $row){
//                                        echo '<pre>';
//                                        print_r($row);
//                                        echo '</pre>';
//                                        break;
                                      
                                     ?>
                                        <tr><td> <?php echo $start; ?></td>
                                             <td><?php echo $row[1];?></td>
                                             <td><?php echo $row[2];?></td>
                                             <td><?php echo $row[3];?></td>
                                             <td><?php echo $row[4];?></td>
                                             <td><?php echo $row[5];?></td>
                                              <td><input type="checkbox" class="checkbox1" name="checkbox" value= "<?php echo $row[3];?>"/></td>
                                                                                               
                                        </tr>
                                        <?php
                                         $start++; 
                                       
                                    }
                                    ?>       
                                    </tbody>
                                </table>
                            </div>


</div>
                        </div>

                    </div>


                </div>
                </form>


            </div>

        </div>
    </div>



<div class="modal fade stick-up" id="myModal1_driverpass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <h3> Send Messages </h3>
                </div>


                <br>
                <br>

                <div class="modal-body">




                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"> Select City <span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <select name="cityID" id="citID" class="form-control">

                                <?php foreach ($citys as $res) { ?>
                                    <option  value="<?php echo $res->City_Lat; ?>-<?php echo $res->City_Long; ?>-<?php echo $res->City_Id; ?>"><?php echo $res->City_Name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label">Message<span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <textarea   id="Message" name="Message" class="confirmpass form-control" placeholder="type some..."></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="usertype">

                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4 error-box" id="errorpass_driversmsg"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="sendPushToAll" ><?php echo BUTTON_SUBMIT; ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>

<div class="modal fade stick-up" id="sendTOspecific_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <h3> Send Messages </h3>
                </div>


                <br>
                <br>

                <div class="modal-body">
               
                     <div class="form-group" class="formex">
                        <div class="frmSearch">
                            <label for="fname" class="col-sm-2 control-label">Email ID</label>
                            <div class="col-sm-8">
                                 <div id="show_email" class="row form-group" style="clear: both;"></div>
<!--                                <input type="text" id="search-box"  placeholder="Eneter email here..." style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>
                                <input type="hidden" id="search-box-hidden" class="form-control error-box-class" />
                                <div id="suggesstion-box"></div>-->
                            </div>
<!--                            <div class="col-sm-2">
                                <input type="button" id="addEmail" value="ADD">
                            </div>-->
                        </div>
                    </div>
                    <br>
                   
                   
                    <br>
                    <br>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-2 control-label">Message<span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <textarea   id="MessageForSpecific" name="MessageForSpecific" class="confirmpass form-control" placeholder="type some..."></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="usertype">

                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4 error-box" id="errorpass_driversmsg"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="sendPushToSpecific" ><?php echo BUTTON_SUBMIT; ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
