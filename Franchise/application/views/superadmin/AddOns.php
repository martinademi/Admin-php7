<?PHP error_reporting(false); ?>
<script>
    $("#HeaderMenu").addClass("active");
    $("#HeaderMenu3").addClass("active");
    $(document).ready(function () {
        
         $('.HeaderMenu3').addClass('active');
//        $('.icon-thumbnail').attr('<?php echo base_url(); ?>assets/dash_board_on.png"');
        $('.menu2_thumb').attr('src', "<?php echo base_url(); ?>assets/addons_on.png");
        
        $('#callM').click(function () {

            $('#NewCat').modal('show');
        });
    });
    //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function Delservice(thisval) {
        $('#deletemodal').modal('show');
        var entityidid = thisval.id;
        $("#deletelink").attr('href', "<?php echo base_url() ?>index.php/superadmin/DeleteAddOnCat/" + entityidid);
    }

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
			if(found == true)$(row).show();
                        else $(row).hide();
		}
	});
        
}
    
     
</script>

 <style>
          #selectedcity,#companyid,#tableWithSearch_length,#tableWithSearch_filter{
        display: none;
    }
 </style>


<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="">
                    <!--                    <li>
                                            <a href="<?php echo base_url() ?>index.php/superadmin/loadDashbord">DASHBOARD</a>
                                        </li>-->
                    <li>
                        <a href="#" class="active">MENU</a>
                    </li>
                    <li><a href="#" class="active">ADD-ONS</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>
            <div class="add_new">
                <a href="<?php echo base_url(); ?>index.php/superadmin/AddNewAddOns"><button type="button" class="btn btn-primary" style="margin:0px;"> Add</button></a>               
            </div>


            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="pull-right">
                                <div class="col-xs-12" style="margin: 10px 0px;padding:0px;">
                                    <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                        <thead>
                                            <tr role="row">
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Slno</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Category</th>

                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                                    Description</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                    Option</th>
                                            </tr>

                                        </thead>
                                        <tbody>

                                            <?php
                                            $count = 1;

                                            foreach ($entitylist as $result) {
                                                ?>
                                                <tr role="row" class="odd">
                                                    <td id = "d_no" class="v-align-middle sorting_1"> <?php echo $count ?></td>
                                                    <td id = "fname_" class="v-align-middle sorting_1"> <?php  if(is_array($result["Category"] ))
                                                                                                                    {
                                                                                                                    echo implode($result["Category"] , ',');
                                                                                                                    }
                                                                                                                    else
                                                                                                                    { 
                                                                                                                        echo $result["Category"] ; 
                                                                                                                    } 
                                                                                                         ?></td>
                                                    <td id = "lname_" class="v-align-middle"> <?php if(is_array( $result["Description"]))
                                                                                                       {
                                                                                                        echo implode( $result["Description"] , ',');
                                                                                                       }
                                                                                                     else
                                                                                                     { 
                                                                                                          echo  $result["Description"] ; 
                                                                                                     } 
                                                                                              ?> </td>

                                                    <td  class="v-align-middle">
                                                        <div class="btn-group">
                                                            <a href="<?php echo base_url() . 'index.php/superadmin/EditAddon/' . $result['_id']; ?>"><button id="<?php echo $result['_id'] ?>" type="button" style="color: #ffffff !important;background-color: #5bc0de;border: 1px solid #5bc0de;" class="btn btn-success"><i class="fa fa-pencil"></i>
                                                                </button></a>

                                                            <a><button type="button" onclick="Delservice(this)" id="<?php echo $result['_id'] ?>" class="btn btn-success" style="color: #ffffff !important;background-color: #d9534f;border: 1px solid #d9534f;"><i class="fa fa-trash-o"></i>
                                                                </button></a>

                                                        </div>
                                                    </td>

                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </tbody>
                                    </table></div></div></div>
                    </div>
                </div>
                <!-- END PANEL -->
            </div>
        </div>
        <!-- END JUMBOTRON -->

        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->

            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->

    </div>
    <!-- END PAGE CONTENT -->
    <!-- START FOOTER -->
    <div class="container-fluid container-fixed-lg footer">
        <?PHP include 'FooterPage.php' ?>
    </div>
    <!-- END FOOTER -->


    <div class="modal fade stick-up in" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content" style="padding: 0% 5%;">
                    <div class="modal-header clearfix text-left" style="padding: 10px 5px 5px 0px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5 style="text-align: center;color: #0090d9;font-weight: bold;">Delete </h5>                        
                    </div>
                    <div class="modal-body">
                        <h5 style="text-align: center;line-height:22px;">Are You Sure To Delete This Broker ? </h5>
                    </div>

                    <div class="modal-footer" style="padding: 10px 5px 5px 0px;">
                        <a href="" id="deletelink"><button type="buttuon" class="btn btn-primary btn-cons inline">Continue</button></a>
                        <button type="button" class="btn btn-danger btn-cons no-margin inline" data-dismiss="modal">Cancel</button>

                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade in" id="NewCat" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
        <div class="modal-dialog modal-md" style="padding: 0% 5%;">

            <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCategory" method= "post" onsubmit="return validateForm();">
                <div class="modal-content" style="padding: 0% 4%;">
                    <div class="modal-header" style="padding-top: 18px;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity: initial;">&times;</button>
                        <h4 class="modal-title">Add New Category</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" class="form-control" placeholder="Category" id="Category" name="FData[Category]">
                        </div>
                        <div class="form-group" >
                            <label>Description</label>
                            <input type="text" class="form-control" placeholder="Description" id="Description" name="FData[Description]">
                        </div>
                        <input type="hidden" id="BusinessId" name="FData[BusinessId]" value="<?PHP echo $BizId; ?>">


                        <label id = "errorbox" style="color: red; font-size: 15px;"></label>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input type="Submit" class="btn btn-primary" value="Add">

                    </div>
                </div>
            </form>
            </form>

        </div>

    </div>