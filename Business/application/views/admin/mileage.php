<?php
$this->load->database();
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);
?>

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid,#tableWithSearch_length,#tableWithSearch_filter{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>

<script type="text/javascript">
 $(document).ready(function () {
        $('#Drivertype').change(function(){
            
            var type = $(this).children('option:selected').data('id');
//            console.log(type ); // 0 - jaiecom, 1 - srote, 2 - offline
        var cityid = "<?php echo $cityId; ?>";    
        if(type == 0){
            $("#basefare").attr("readonly", "readonly"); 
            $("#range").attr("readonly", "readonly"); 
            $("#priceperkm").attr("readonly", "readonly"); 
//               console.log('jaiecom',type ); 
//               console.log("<?php echo $cityId; ?>" ); 
                  $.ajax({
                        url: "<?php echo base_url('index.php/Admin') ?>/getjaiecom_details",
                        type: "POST",
                            data: {cityid: cityid},
                            dataType: "JSON",
                            success: function (result) {
//                            console.log(result);
                                $.each(result, function (index, row) {
//                                     console.log(row.Basefare);
                                    $('#basefare').val(row.Basefare);
                                    $('#range').val(row.Range);
                                    $('#priceperkm').val(row.Pricepermile);

                                });

                            }
                        });
                    } else if (type == 1) {
                        console.log('srote', type);
                        $("#basefare").removeAttr("readonly");
                        $("#range").removeAttr("readonly");
                        $("#priceperkm").removeAttr("readonly");
                        $('#basefare').val('')
                        $('#range').val('')
                        $('#priceperkm').val('')

                    } else if (type == 2) {
                        console.log('offline', type);
                          $("#basefare").removeAttr("readonly");
                        $("#range").removeAttr("readonly");
                        $("#priceperkm").removeAttr("readonly");
                        $('#basefare').val('')
                        $('#range').val('')
                        $('#priceperkm').val('')
                    }
            
            
          });
          
        $('#edit_Drivertype').change(function(){
            var type = $(this).children('option:selected').data('id');
//            console.log(type ); // 0 - jaiecom, 1 - srote, 2 - offline
        var cityid = "<?php echo $cityId; ?>";    
        if(type == 0){
            $("#edit_basefare").attr("readonly", "readonly"); 
            $("#edit_range").attr("readonly", "readonly"); 
            $("#edit_priceperkm").attr("readonly", "readonly"); 
//               console.log('jaiecom',type ); 
//               console.log("<?php echo $cityId; ?>" ); 
                        $.ajax({
                            url: "<?php echo base_url('index.php/Admin') ?>/getjaiecom_details",
                            type: "POST",
                            data: {cityid: cityid},
                            dataType: "JSON",
                            success: function (result) {
//                            console.log(result);
                                $.each(result, function (index, row) {
//                                     console.log(row.Basefare);
                                    $('#edit_basefare').val(row.Basefare);
                                    $('#edit_range').val(row.Range);
                                    $('#edit_priceperkm').val(row.Pricepermile);

                                });

                            }
                        });
                    } else if (type == 1) {
                        console.log('srote', type);
                        $("#edit_basefare").removeAttr("readonly");
                        $("#edit_range").removeAttr("readonly");
                        $("#edit_priceperkm").removeAttr("readonly");
                        

                    } else if (type == 2) {
                        console.log('offline', type);
                         $("#edit_basefare").removeAttr("readonly");
                        $("#edit_range").removeAttr("readonly");
                        $("#edit_priceperkm").removeAttr("readonly");
                       
                    }


                });
 });

</script>

<script>
$(document).ready(function()
{
  $('#tableWithSearch').DataTable();
	$('#search-table').keyup(function()
	{
		searchTable($(this).val());
	});
});

function searchTable(inputVal)
{
	var table = $('#tableWithSearch');
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

<script>
    
    $(document).ready(function () {

        $('#insert').click(function () {
            $('.clearerror').text("");
          
            var Drivertype = $("#Drivertype").val();
            var basefare = $("#basefare").val();
            var range = $("#range").val();
            var priceperkm = $("#priceperkm").val();
//            var miniorder = $("#miniorder").val();
//            var freeorder = $("#freeorder").val();
          
           if (Drivertype == "" || Drivertype == null)
            {
                $("#clearerror").text("Please select the driver type");
            } 
           else if (basefare == "" || basefare == null)
            {
                $("#clearerror").text("Please enter the base fare");
            } 
            else if (range == "" || range == null)
            {
                $("#clearerror").text("Please enter the range");
            }
           else if (priceperkm == "" || priceperkm == null)
            {
                $("#clearerror").text("Please enter the price/km ");
            }
//           else if (miniorder == "" || miniorder == null)
//            {
//                $("#clearerror").text("Please enter the minimum order value ");
//            }
//           else if (freeorder == "" || freeorder == null)
//            {
//                $("#clearerror").text("Please enter the free order value ");
//            }
             
            else { 
                $('#addentity').submit();
                
                $("#Drivertype").val('');
                $("#basefare").val('');
                $("#range").val('');
                $("#priceperkm").val('');
                
                   
                 }
        });
        
        $('#useredit').click(function () {
            $('.clearerror').text("");
//            var providername = $("#businessname").val();
            var Drivertype = $("#edit_Drivertype").val();
            var basefare = $("#edit_basefare").val();
            var range = $("#edit_range").val();
            var priceperkm = $("#edit_priceperkm").val();
//            var miniorder = $("#edit_miniorder").val();
//            var freeorder = $("#edit_freeorder").val();
//         
           if (Drivertype == "" || Drivertype == null)
            {
                $("#clearerror").text("Please select the driver type");
            } 
           else if (basefare == "" || basefare == null)
            {
                $("#clearerror").text("Please enter the base fare");
            } 
            else if (range == "" || range == null)
            {
                $("#clearerror").text("Please enter the range");
            }
           else if (priceperkm == "" || priceperkm == null)
            {
                $("#clearerror").text("Please enter the price/km ");
            }
//           else if (miniorder == "" || miniorder == null)
//            {
//                $("#clearerror").text("Please enter the minimum order value ");
//            }
//           else if (freeorder == "" || freeorder == null)
//            {
//                $("#clearerror").text("Please enter the free order value ");
//            }
           else
           {
                    $('#editentity').submit();
            }
        });
  

        $('#btnStickUpSizeToggler').click(function () {
            
            $('#Default').prop('checked', false);
            $("#display-data").text("");
            
             $.ajax({
                               url: "<?php echo base_url('index.php/Admin') ?>/get_mileagealldata",
                               type: "POST",
                                data: {},
                                dataType: 'json',
                               success: function (response)
                               {
                                
                                  $.each(response, function(index, row){
                                       console.log(row.count);
                                       if(row.count < "3"){
                                            $('#modalHeading').html(<?php echo json_encode(SELECT_COUNTRY_ANDBUSINESS_COMMISSION); ?>);
                                            var size = $('input[name=stickup_toggler]:checked').val()
                                            var modalElem = $('#myModal');
                                            if (size == "mini") {
                                                $('#modalStickUpSmall').modal('show')
                                            } else {
                                //                alert('else');
                                                $('#myModal').modal('show')
                                                if (size == "default") {
                                                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                                                } else if (size == "full") {
                                                    modalElem.children('.modal-dialog').addClass('modal-lg');
                                                }
                                            }
                                       }else{
                                             $('#displayData').modal('show');
                                             $("#display-data").text("can not add more mileage settings");
                                       }
                                  });
////                                alert(response.length);
                                
                             }
                         });
            
           
        });
//       
        $('#edit').click(function () {
           
            $('#modalHeading').html("Edit User");
           
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
//            alert(val);
            
           $('#user_id').val(val);

            if (val.length < 1) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select any one Driver to edit");
            } 
            else if (val.length == 1)
            {
//                 alert(val);
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#editModal');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                }
                else {
                    
                      $.ajax({
                               url: "<?php echo base_url('index.php/Admin') ?>/get_mileagedata",
                               type: "POST",
                                data: {val: val},
                                dataType: 'json',
                               success: function (response)
                               {
                                 console.log(response);
////                                alert(response.length);
                                  $.each(response, function(index, row){
//                                      alert(row.Email);
                                                
                                                $('#edit_Drivertype').val(row.DriverType);
                                                $('#edit_basefare').val(row.Basefare);
                                                $('#edit_range').val(row.Range);
                                                $('#edit_priceperkm').val(row.Priceperkm);
//                                                $('#edit_miniorder').val(row.Miniorder);
//                                                $('#edit_freeorder').val(row.Freeorder);
                                                if(row.Default == 1){
                                                       $('#edit_Default').prop('checked', true);
                                                }
                                                
//                                                $('#edit_Default').val(row.Default);
//                                                $('.edit_accepts').val(row.Accepts);
//                                                    alert($('#edit_Drivertype').val());
                                                if($('#edit_Drivertype').val() == 0)
                                                {
                                                    $("#edit_basefare").attr("readonly", "readonly"); 
                                                    $("#edit_range").attr("readonly", "readonly"); 
                                                    $("#edit_priceperkm").attr("readonly", "readonly"); 
                                                }else{
                                                     $("#edit_basefare").removeAttr("readonly");
                                                     $("#edit_range").removeAttr("readonly");
                                                     $("#edit_priceperkm").removeAttr("readonly");
                                                }
                                        
                                  });
                               }
                           });
                    
                            $('#editModal').modal('show')
                        
                            if (size == "default") {
                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                            } else if (size == "full") {
                                modalElem.children('.modal-dialog').addClass('modal-lg');
                            }
                           
                     }
                     
              
             } 
             else if (val.length > 1)
                {
                //      alert("select atleast one passenger");
                $('#displayData').modal('show');
                    $("#display-data").text("Please select only one Driver to edit" );
                }   
        });

        $('#fdelete').click(function (e) {
//            $("#display-data").text("");
               var val = $('.checkbox:checked').map(function () {
                           return this.value;
                        }).get();

                   if (val.length < 0||val.length == 0) {
                       $('#displayData').modal('show');
                            $("#display-data").text("Please select any one  to delete");
                        }
                   else if (val.length == 1)
                        {
                          $("#display-data").text("");
                          var id =  val; 
            //                       alert(id);
            //                    alert(BusinessId);
                          var size = $('input[name=stickup_toggler]:checked').val()
                          var modalElem = $('#confirmmodel');
                          if (size == "mini") {
                             $('#modalStickUpSmall').modal('show')
                          } 
                          else 
                          {
                            $('#confirmmodel').modal('show')
                            if (size == "default") {
                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                            }
                            else if (size == "full") 
                            {
                                modalElem.children('.modal-dialog').addClass('modal-lg');
                            }
                          }

                            $("#confirmed").click(function(){
            //                        else if (confirm("Are you sure to Delete this company")) {

                                      $.ajax({
                                           url: "<?php echo base_url('index.php/Admin') ?>/delete_mileage",

                                         type: "POST",
                                                data: {
                                                id: id,
                                                },

                                            dataType: 'json',
                                           success: function (response)
                                           {
            //                                   alert(id);
                                            $(".close").trigger("click");
                                            location.reload();
                                           }
                                       });

                                   });             
                         }

                        else if (val.length > 1)
                        {
                            $('#displayData').modal('show');
                            $("#display-data").text("Please select only one  to delete");
                        }

               });

    });
    
 
</script>

<style>
    #active{
        display:none;
    }
    .exportOptions{
        display: none;
    }
</style>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content" style="  padding-top: 30px;">

        <div class="brand inline breadcrumb" style="">
            <strong>MILEAGE PRICING</strong><!-- id="define_page"-->
        </div>
        
        <div class="add_new">
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="fdelete" style="margin-bottom:0px;background: #d9534f !important;border-color: #d9534f !important;">Delete</button></a></div>
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="edit" style="margin-bottom:0px;background: #5bc0de !important;border-color: #5bc0de !important;">Edit</button></div>
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler" style="margin-bottom:0px;background: #337ab7 !important;border-color: #337ab7 !important;"><span>Add</button></a></div>
        </div>
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax" style="padding:0px;">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="padding:0px;">

                <div class="panel panel-transparent ">
                   
                    <div class="tab-content">
                        
                        <div class="container-fluid container-fixed-lg bg-white">
                             <!--START PANEL--> 
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
                                    <!--<div id="big_table_processing" class="dataTables_processing" style=""><img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif"></div>-->
                                    <div class="searchbtn row clearfix pull-right" >
                                    <div class="pull-right">
                                        <div class="col-xs-12" style="margin: 10px 0px;">
                                            <input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>">
                                        </div>
                                    </div>                                        
                                    </div>
                                </div>
                                <br>
                                <div class="panel-body">
                                 
                                    
                                    
                <div class="dataTables_wrapper form-inline no-footer" id="tableWithDynamicRows_wrapper">
                    <div class="table-responsive" style="overflow-x: hidden">
                        
                        <table aria-describedby="tableWithSearch_info" role="grid" class="table table-striped table-bordered table-hover demo-table-dynamic dataTable no-footer" id="tableWithSearch">
                                <thead>

                                    <tr>                                   
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            Slno</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            Driver Type</th>
<!--                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            City</th>-->
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 0px;">
                                            Base fare</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 0px;">
                                            Range(km)</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 00px;">
                                            Price/km</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            Default</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 0px;">
                                            Select</th>

                                    </tr>

                                </thead>

                                <tbody>

                          <?php
                          $start = 1;
                         $dev = [];
                           foreach ($table as $result)
                           {
                             ?>
                                    <tr>
                                        <td><?php echo $start++;?></td>
                                        <td><?php if($result['DriverType'] == 0){
                                                        echo 'Jaiecom Driver';
                                                    }else if($result['DriverType'] == 1){
                                                        echo 'Store Driver';
                                                    }else if($result['DriverType'] == 2){
                                                         echo 'Offline Driver';
                                                    }  
                                        ?></td>
                                        <!--<td><?php // echo implode($city_list['name'],',') ?></td>-->
                                        <td><?php echo $result['Basefare'];?></td>
                                        <td><?php echo $result['Range'];?></td>
                                        <td><?php echo $result['Priceperkm'];?></td>
                                        <td><?php if($result['Default'] == "1"){
                                            echo 'Default';
                                        }else {
                                            echo '-';
                                        };?></td>
                                        
                                        <td><input type="checkbox" class="checkbox" value="<?php echo (string)$result['_id'];?>"></td>
                                                                           
                                    </tr>
                                    
                               <?php
                            
                           }
                          ?>
                            </tbody>
                          </table>

                        </div>
                     </div>
                      <!--END PANEL--> 
                   </div>
                 </div>
              </div>

             </div>

        </div>
        <!-- END JUMBOTRON -->
    </div>
    <!-- END PAGE CONTENT -->

</div>

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center">Are you sure to delete</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" >yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
                    </div>
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
                    <div class=" clearfix text-left">                        
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Add Mileage</h3>
                </div>

                <div class="modal-body">                  
                    
                    <form id="addentity" method="post" class="" role="form" action="<?php echo base_url('index.php/Admin') ?>/insertmileageset"  method="post" enctype="multipart/form-data">
                    
                        <div class="form-group formex">
                            <?php //   foreach ($Drivertype as $result) {print_r($Drivertype['zonalprice']);} ?>
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-4 control-label">DRIVER TYPE<span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-8">
                                    <select id='Drivertype' name='Drivertype'  class='form-control'  <?PHP echo $enable; ?>>
                                        <option value="0">Select Driver Type</option>
                                        <?php
//                                        foreach ($Drivertype as $result) {
                                            if ($Drivertype['Jaiecomdriver'] == "1")
                                                echo "<option value='0' data-id='0'>Jaiecom Driver</option>";
                                            if ($Drivertype['Storedriver'] == "1")
                                                echo "<option value='1' data-id='1'>Store Driver</option>";
                                            if ($Drivertype['Offlinedriver'] == "1")
                                                echo "<option value='2' data-id='2'>Offline Driver</option>";
////                                           echo "<option value=" . $result['_id'] . ">" . implode($result['name'],',') . "</option>";
//                                        }
                                        ?>
                                    </select>
                                    <div id="suggesstion-box"></div>
                                </div>
                                <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                            </div>
                        </div>
                        <br>
                        <br>
                     <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">BASE FARE<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="basefare" name="basefare" style="" class="basefare form-control error-box-class"/>

                                <div id="suggesstion-box"></div>
                            </div>
                        <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                        </div>
                    </div>
                        <br>
                        <br>
                     <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">RANGE<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="range" name="range" style="" class="range form-control error-box-class"/>

                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                        <br>
                        <br>
                  <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">PRICE/KM<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="priceperkm" name="priceperkm"  style="" class="form-control error-box-class" />

                                <div id="suggesstion-box"></div>
                            </div>
                        
                        <span id="editerrorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                       </div>
                    </div>
                     <br>
                     <br>
<!--                   <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">MINIMUM ORDER<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="miniorder" name="miniorder" style="" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                     <br>
                     <br>
                    <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">FREE ORDER<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="freeorder" name="freeorder" style="" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                     <br>
                     <br>-->
                     <div class="form-group">   
                         <div class="frmSearch">
                             <label for="fname" class="col-sm-4 control-label">MAKE THIS AS DEFAULT</label>
                             <div class="col-sm-2">
                                 <input type="checkbox" class="checkbox-inline col-sm-4" id="Default" name="Default"  value="1"  style="margin:0px;"> 
                             </div>
                         </div>
                     </div>


                    </form>
                </div>
            
                    <div class="modal-footer">
                        <div class="col-sm-6 error-box" style="color:red;" id="clearerror"></div>
                        <div class="col-sm-4" ></div>                        
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="insert" >Add</button>
                        </div>
                    </div>
                   
                
                </div>            
    </div>

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
    </button>
</div>
   
<div class="modal fade stick-up" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Edit Mileage</h3>
                </div>

            <div class="modal-body">

            <form id="editentity" method="post" class="" role="form" action="<?php echo base_url('index.php/Admin') ?>/editmileageset"  method="post" enctype="multipart/form-data">
                <input type="hidden" id="user_id" name="user_id">
                 
                <div class="form-group formex">
                            <?php //   foreach ($Drivertype as $result) {print_r($Drivertype['zonalprice']);} ?>
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-4 control-label">DRIVER TYPE<span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-8">
                                    <select id='edit_Drivertype' name='Drivertype'  class='form-control'  <?PHP echo $enable; ?>>
                                        <option value="0">Select Driver Type</option>
                                        <?php
//                                        foreach ($Drivertype as $result) {
                                            if ($Drivertype['Jaiecomdriver'] == "1")
                                                echo "<option value='0' data-id='0'>Jaiecom Driver</option>";
                                            if ($Drivertype['Storedriver'] == "1")
                                                echo "<option value='1' data-id='1'>Store Driver</option>";
                                            if ($Drivertype['Offlinedriver'] == "1")
                                                echo "<option value='2' data-id='2'>Offline Driver</option>";
////                                           echo "<option value=" . $result['_id'] . ">" . implode($result['name'],',') . "</option>";
//                                        }
                                        ?>
                                    </select>
                                    <div id="suggesstion-box"></div>
                                </div>
                                <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                            </div>
                        </div>
                        <br>
                        <br>
                     <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">BASE FARE<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="edit_basefare" name="basefare" style="" class="basefare form-control error-box-class"/>

                                <div id="suggesstion-box"></div>
                            </div>
                        <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                        </div>
                    </div>
                        <br>
                        <br>
                     <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">RANGE<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="edit_range" name="range" style="" class="range form-control error-box-class"/>

                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                        <br>
                        <br>
                  <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">PRICE/KM<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="edit_priceperkm" name="priceperkm"  style="" class="form-control error-box-class" />

                                <div id="suggesstion-box"></div>
                            </div>
                        
                        <span id="editerrorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                       </div>
                    </div>
                     <br>
                     <br>
<!--                   <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">MINIMUM ORDER<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="edit_miniorder" name="miniorder" style="" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                     <br>
                     <br>
                    <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">FREE ORDER<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="edit_freeorder" name="freeorder" style="" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                     <br>
                     <br>-->
                     <div class="form-group">   
                         <div class="frmSearch">
                             <label for="fname" class="col-sm-4 control-label">MAKE THIS AS DEFAULT</label>
                             <div class="col-sm-2">
                                 <input type="checkbox" class="checkbox-inline col-sm-4" id="edit_Default" name="Default"  value="1"  style="margin:0px;"> 
                             </div>
                         </div>
                     </div>
                    </form>
                  </div>
                    <div class="modal-footer">
                         <div class="col-sm-6 error-box" style="color:red;" id="clearerror1"></div>
                        <div class="col-sm-4" ></div>                       
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="useredit" >Save</button>
                        </div>
                    </div>
            
                </div>
            
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
        
        
<div class="modal fade stick-up" id="ChangeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Change Password</h3>
                </div>
                <div class="modal-body">
            <form id="changepassword" method="post" class="" role="form" action="<?php echo base_url('index.php/Admin') ?>/change_password"  method="post" enctype="multipart/form-data">
                <input type="hidden" id="user_id1" name="user_id1">
                 <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">New Password<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" id="newPwd" name="newpassword" placeholder="New Password" style="" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                <br>
                <br>
                 <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">Re-Type New Password<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" id="reNewPwd" placeholder="Re-Type New Password" name="renewpassword"  style="" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
              </div>
                    <div class="modal-footer">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-6 error-box" style="color:red;" id="clearerror2"></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="changepass" >Save</button>
                        </div>
                    </div>
            </form>
                </div>
          
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
    </button>
</div>
        
</div>
