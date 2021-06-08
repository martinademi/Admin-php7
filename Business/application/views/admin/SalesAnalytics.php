<script>
    $("#HeaderSalesAnalytics").addClass("active");

</script>
<script>
    $(document).ready(function()
{
      
       $('.HeaderSalesAnalytics').addClass('active');
//        $('.icon-thumbnail').attr('<?php echo base_url(); ?>assets/dash_board_on.png"');
        $('.sales_thumb').attr('src', "<?php echo base_url(); ?>assets/icn_salesanalytics_on.png");
        
        
      
  $('#tableWithSearch').DataTable();
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
    
     
    </script>
    <style>
    .span6{
        display:none;
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

                    <li><a href="#" class="active">Sales Analytics</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>



            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="panel-heading">
<!--                        <div class="panel-title"><a href="<?php echo base_url(); ?>index.php/Admin/NewProduct"><button type="button" class="btn btn-default"> Add new</button></a>
-->                            
<!--                            <div class="pull-right">
                                <div class="col-xs-12">
                                    <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                                </div>
                            </div>-->

<!--
                            <div class="clearfix"></div>
                        </div>-->
                            
                                        <div class="error-box" id="display-data" style="text-align:center"></div>

                                
                                            <div class="searchbtn row clearfix pull-right" style="" >

                                                <div class="pull-right">
                                                    <div class="col-xs-12" style="margin: 10px 0px;">
                                                        <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dltbtn">

                                        
                                    </div>




                                </div>
                        <div class="panel-body" style='height: auto;'>
                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                        <thead>

                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 57px;">
                                                    Slno</th>

                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 400px;">
                                                    Product Name(Portion)</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 400px;">
                                                    Portion Price</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 400px;">
                                                    Total Item Sold</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 400px;">
                                                    Total(<?PHP echo $this->session->userdata('badmin')['Currency']; ?>)</th>

                                            </tr>

                                        </thead>
                                        <tbody>

                                            <?php
                                            $count = 1;

                                            foreach ($entitylist as $result) {
                                                ?>
                                                <tr role="row" class="odd" id='<?PHP echo (string) $result['_id'] ?>'>
                                                    <td class="sorting_1"> <?php echo $count ?></td>
                                                    <td class=""> <?php echo $result["ItemName"] ?></td>
                                                    <td class=""> <?php echo $result["PortionPrice"] ?></td>
                                                    <td class=""><?php echo $result["Total"] ?></td>
                                                    <td class=""> <?php
                                                            $rev = $result["PortionPrice"] * $result["Total"];
                                                            $revenue =  number_format((float) $rev, 2, '.', '');
                                                             echo $revenue;
                                                            ?></td>


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



