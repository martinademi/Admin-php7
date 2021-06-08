<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);
//
//if ($status == 1) {
//    $vehicle_status = 'New';
//    $new = "active";
//} else if ($status == 3 && $db == 'my') {
//    $vehicle_status = 'Accepted';
//    $accept = "active";
//} else if ($status == 3 && $db == 'mo') {
//    $vehicle_status = 'Online&Free';
//    $free = "active";
//} else if ($status == 4) {
//    $vehicle_status = 'Rejected';
//    $reject = 'active';
//}
//
//else if ($status == 30) {
//    $$vehicle_status = 'Offile';
//    $offline = 'active';
//} else if ($status == 567) {
//    $$vehicle_status = 'Booked';
//    $booked = 'active';
//}
?>
<style>

    .imageborder{
        border-radius: 50%;
    }

</style>

<script type="text/javascript">
    $(document).ready(function () {
        
         $('.drivers').addClass('active');
        $('.drivers').attr('src', "'<?php echo base_url(); ?>'/theme/icon/restaurant_on.png");
        
//        alert();
//        var status = '<?php // echo $status; ?>';
//        alert(status);
        $('#big_table_processing').show();

        var table = $('#big_table');

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "'<?php echo base_url() ?>'index.php/Admin/datatable_drivers",
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
                     "aoColumns": [
                                { "sWidth": "5%" }, // 1st column width 
                                { "sWidth": "10%" }, // 2nd column width 
                                { "sWidth": "10%" }, 
                                {"sWidth":  "10%" }, 
                                {"sWidth":  "15%" }, 
                                {"sWidth":  "15%" }, 
                                {"sWidth":  "13%" }, 
                                {"sWidth":  "7%" }, 
                                {"sWidth":  "5%" }, 
                               
                              ],  
            "fnInitComplete": function () {

                $('#big_table_processing').hide();
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
//        table.dataTable(settings);
//
        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
//        
 });
        
</script>


<script>
    $(document).ready(function () {

        $("#define_page").html("Drivers");

       
//        $('.driver_thumb').addClass("bg-success");

      $("#editdriver").click(function () {


                $("#display-data").text("");
                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();
                if (val.length == 0) {
                    //         alert("please select any one dispatcher");
                    $("#display-data").text("Please select any one driver");
                } 
                else if (val.length > 1)
                {
                //     alert("please select only one to edit");
                    $("#display-data").text("Please select only one driver to edit");
                }
                else
                {
                    window.location = "'<?php echo base_url('index.php/superadmin') ?>'/editdriver/" + val;
                }
            });

        $("#chekdel").click(function () {

           var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
           
             if (val.length < 0||val.length == 0) {
              $("#display-data").text("Select at least one driver");
            }
            else if (val.length == 1 || val.length > 1)
            {
                
                $("#display-data").text("");
                       var Id =  val;
//                       alert(Id); 
                 var size = $('input[name=stickup_toggler]:checked').val()
                    var modalElem = $('#deletedriver');
                    if (size == "mini") {
                        $('#modalStickUpSmall').modal('show')
                    } else {
                        $('#deletedriver').modal('show')
                        if (size == "default") {
                            modalElem.children('.modal-dialog').removeClass('modal-lg');
                        } else if (size == "full") {
                            modalElem.children('.modal-dialog').addClass('modal-lg');
                        }
                    }
                       $("#errorboxdata").text("Are you sure you want to delete the selected driver/drivers");
                
               $("#yesdelete").click(function (){

                          $.ajax({
                               url: "<?php echo base_url('index.php/superadmin') ?>/deleteDrivers",

                               type: "POST",
                                data: {val: Id},
                                dataType: 'json',
                               success: function (response)
                               {
//                                 alert(response);
                                $(".close").trigger("click");
                                $("#errorboxdata").text("Selected driver/drivers deleted successfully ");
                                
                                location.reload();
                               }
                           });
                           
                       });
              
                 }
        });

        $("#editdriver").click(function () {
//         var status = '<?php // echo $status; ?>';
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                //         alert("please select any one dispatcher");
                $("#display-data").text("Please select any one driver");

            } else if (val.length > 1)
            {
                //     alert("please select only one to edit");
                $("#display-data").text("Please select only one driver to edit");
            }
            else
            {
                window.location = "<?php echo base_url('../sadmin') ?>/index.php/superadmin/editdriver/" + val;

                $.ajax({
                    url: "<?php echo base_url('index.php/superadmin') ?>/editdriver",
                    type: "POST",
                    data: {val: val},
                    dataType: 'json',
                    success: function (result)
                    {
//                            $('#confirmmodels').modal('hide');
//
//                            $('.checkbox:checked').each(function (i) {
//                                $(this).closest('tr').remove();
//                            });

                    }
                });

            }
        });

    });

</script>


<script type="text/javascript">
    $(document).ready(function () {

        $('#joblogs').hide();
        $('#big_table_processing').hide();
//        alert('<?php // echo $status;            ?>');
//        var status = '<?php // echo $status; ?>';
//            alert(status);
            
            $('#chekdel').show();
            $('#add').show();
            $('#editdriver').show();
                
        var table = $('#big_table');
        $("#display-data").text("");

//        var settings = {
//            "autoWidth": false,
//            "sDom": "<'table-responsive't><'row'<p i>>",
//            "destroy": true,
//            "scrollCollapse": true,
//            "iDisplayLength": 20,
//            "bProcessing": true,
//            "bServerSide": true,
//            "sAjaxSource": '<?php // echo base_url() ?>index.php/superadmin/datatable_drivers/my/' + status,
//            "bJQueryUI": true,
//            "sPaginationType": "full_numbers",
//            "iDisplayStart ": 20,
//            "oLanguage": {
//                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
//            },
//            "fnInitComplete": function () {
//                //oTable.fnAdjustColumnSizing();
//            },
//            'fnServerData': function (sSource, aoData, fnCallback)
//            {
//                $.ajax
//                        ({
//                            'dataType': 'json',
//                            'type': 'POST',
//                            'url': sSource,
//                            'data': aoData,
//                            'success': fnCallback
//                        });
//            }
//        };
//
//        table.dataTable(settings);

        // search box for table
//        $('#search-table').keyup(function () {
//            table.fnFilter($(this).val());
//        });
        
       $('.whenclicked li').click(function () {
            if ($(this).attr('id') == "my1") {
                $('#add').show();
                $('#editdriver').show();
                $('#chekdel').show();
                   $('#search-table').val('');
                   
                   
        }
           else if ($(this).attr('id') == "my3") {
                $('#add').hide();
                $('#editdriver').show();
                $('#chekdel').show();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "my4") {
                $('#add').hide();
                $('#editdriver').show();
                $('#chekdel').show();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "mo3") {
                $('#add').hide();
                $('#editdriver').hide();
                $('#chekdel').hide();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "mo30") {
                $('#add').hide();
                $('#editdriver').hide();
                $('#chekdel').hide();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "mo567") {
                $('#add').hide();
                $('#editdriver').hide();
                $('#chekdel').hide();
                $('#search-table').val('');
        }
      });

        $('.changeMode').click(function () {

            $('#big_table_processing').toggle();

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
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
                    $('#big_table_processing').toggle();
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
//            table.dataTable(settings);

            // search box for table
//            $('#search-table').keyup(function () {
//              
//                table.fnFilter($(this).val());
//            });

        });

    });

    
</script>
<!--<script>
    $(document).ready(function()
{
      
  $('#big_table').DataTable();
	$('#search-table').keyup(function()
	{
		searchTable($(this).val());
	});
       
});

function searchTable(inputVal)
{
	var table = $('#big_table');
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
    
     
    </script>-->

<style>
    .exportOptions{
        display: none;
    }
    .btn-cons {
        margin-right: 5px;
        min-width: 102px;
    }
    .btn{
        font-size: 13px;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 0px">
    <!-- START PAGE CONTENT -->
    <div class="content" style="  margin-top: -40px;">


        <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color: gray;
             margin-left: 30px;padding-top: 0px;">
           <!--                    <img src="--><?php //echo base_url();             ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();             ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();             ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">DRIVERS</strong><!-- id="define_page"-->
        </div>
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
                        <!--<li id= "my1" class="tabs_active <?php // echo $new ?>" style="cursor:pointer">-->
                        <li id= "my1" class="tabs_active " style="cursor:pointer">
                            <a  class="changeMode New_" data="'<?php echo base_url(); ?>'index.php/admin/drivers"><span>New</span></a>
                        </li>
                        <!--<li id= "my3" class="tabs_active <?php // echo $accept ?>" style="cursor:pointer">-->
                        <li id= "my3" class="tabs_active " style="cursor:pointer">
                            <a  class="changeMode accepted_" data="'<?php echo base_url(); ?>'index.php/superadmin/datatable_drivers/my/3"><span>Accepted</span></a>
                        </li>
                        <!--<li id= "my4" class="tabs_active <?php // echo $reject ?>" style="cursor:pointer">-->
                        <li id= "my4" class="tabs_active " style="cursor:pointer">
                            <a  class="changeMode rejected_" data="'<?php echo base_url(); ?>'index.php/superadmin/datatable_drivers/my/4"><span>Rejected</span></a>
                        </li>
                        <!--<li id= "mo3" class="tabs_active <?php // echo $free ?>" style="cursor:pointer">-->
                        <li id= "mo3" class="tabs_active " style="cursor:pointer">
                            <a class="changeMode" data="'<?php echo base_url(); ?>'index.php/superadmin/datatable_drivers/mo/3"><span>Online</span></a>
                        </li>
                        <!--<li id= "mo30" class="tabs_active <?php // echo $offline ?>" style="cursor:pointer">-->
                        <li id= "mo30" class="tabs_active " style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php/superadmin/datatable_drivers/mo/30"><span>Offline</span></a>
                        </li>
                        <!--<li id= "mo567" class="tabs_active <?php // echo $booked ?>" style="cursor:pointer">-->
                        <li id= "mo567" class="tabs_active " style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php/superadmin/datatable_drivers/mo/567"><span>Booked</span></a>
                        </li>
                        
                            <div class=""><button class="btn btn-primary pull-right m-t-10" id="chekdel" style="margin-left:10px;margin-top: 5px">Delete</button></a></div>
                            <div class=""><button class="btn btn-primary pull-right m-t-10 " id="editdriver" style="margin-left:10px;margin-top: 5px">Edit</button></div>
                            <div class=""><a href="<?php echo base_url('../sadmin') ?>/index.php/superadmin/addnewdriver"> 
                                        <button class="btn btn-primary pull-right m-t-10" id="add" style="margin-left:10px;margin-top: 5px">Add</button></a></div>
                      
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="col-xs-12 container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                    <div class="error-box" id="display-data" style="text-align:center"></div>
                                    <div id="big_table_processing" class="dataTables_processing" style=""><img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif"></div>

                                    <div class="col-xs-12 searchbtn row clearfix pull-right" style=" padding-right: 18px;">
                                        <div class="pull-right">
                                            <input type="text" id="search-table" class="form-control pull-right" placeholder="Search"> </div>
                                   </div>




                                </div>
                                &nbsp;
                 <div class="panel-body">
                     
                     <?php echo $this->table->generate(); ?>
<!--                  <div class="dataTables_wrapper form-inline no-footer" id="tableWithDynamicRows_wrapper">
                    <div class="table-responsive" style="overflow-x: hidden">
                       
                        <table aria-describedby="tableWithSearch_info" role="grid" class="table table-hover demo-table-dynamic dataTable no-footer" id="tableWithSearch">
                                <thead>

                                    <tr>                                   
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            Slno</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            Driver Id</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            First Name</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            Last Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 0px;">
                                            Email</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 0px;">
                                            Phone</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 00px;">
                                            Current Status</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            Device Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 0px;">
                                            Select</th>

                                    </tr>

                                </thead>

                                <tbody>

                          <?php
//                          $start = 1;
                         
//                          foreach ($table as $result)
//                           {
                              ?>
                                    <tr>
                                        <td><?php // echo $start++;?></td>
                                        <td><?php // echo $result->mas_id;?></td>
                                        <td><?php // echo $result->first_name;?></td>
                                        <td><?php // echo $result->last_name;?></td>
                                        <td><?php // echo $result->email;?></td>
                                        <td><?php // echo $result->mobile;?></td>
                                      
                                        <td><?php // echo $result['Phone'];?></td>
                                        <td><?php // echo $status;?></td>
                                        <td><input type="checkbox" class="checkbox" value="<?php // echo $result->mas_id;?>"></td>
                                                                           
                                    </tr>
                                    
                               <?php
//                           }
                          ?>
                            </tbody>
                          </table>

                        </div>
                     </div>-->
                                    
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

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">

                <div class="form-group">
                    <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_VEHICLE_SELECTCOMPANY; ?><span style="color:red;font-size: 18px">*</span></label>
                    <div class="col-sm-6 error-box" >
                        <select class="form-control" id="company_select">
                            <option value="0">Select Company</option>
                            <?php
                            $this->load->database();
                            $query = $this->db->query('select * from  company_info WHERE  status = 3')->result();
                            foreach ($query as $result) {

                                echo '<option value="' . $result->company_id . '">' . $result->companyname . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>
                <br>

            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2" ></div>
                    <div class="col-sm-6 " id="ve_compan"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" ><?php echo BUTTON_YES; ?></button>
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

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo POPUP_DRIVERS_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
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

<div class="modal fade stick-up" id="confirmmodelss" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatass" style="font-size: large;text-align:center"><?php echo POPUP_DRIVERS_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmedss" ><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="deletedriver" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox" style="font-size: large;text-align:center"><?php echo POPUP_DRIVERS_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="yesdelete" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


</div>
</div>