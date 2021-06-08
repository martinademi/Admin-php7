<script>
    $("#HeaderMenu").addClass("active");
    $("#HeaderMenu2").addClass("active");
    $(document).ready(function () {
        
        $('.HeaderMenu2').addClass('active');
//        $('.icon-thumbnail').attr('<?php echo base_url(); ?>assets/dash_board_on.png"');
        $('.menu1_thumb').attr('src', "<?php echo base_url(); ?>assets/sub_categories_on.png");
        
        
        
        $('#callM').click(function () {
                  $('#submitButton').prop('disabled', false);
            $('#CategoryId').val('');
            $('.Description').val('');
            $('.Category').val('');
            $('.modal-header').html('<h4>Add New Sub-category</h4>');
            $('#submitButton').val('Add');
            $('#NewCat').modal('show');
        });
    });
    
     function editsubcat(id){
//        alert();
//        console.log(id.id);
        var cid= id.id;
         $.ajax({
                url: "<?PHP echo AjaxUrl; ?>getsubcatdetails",
                type: "POST",
                data: {id:cid},
                dataType: 'json',
                     success: function (response)
                      {
//                         console.log(response);
////                      alert(response.length);
                         $.each(response, function(index, row){
                            console.log(row._id.$id);
                            $('#NewCat').modal('show');
                            $('.Category0').val(row.SubCategory[0]);
                            for(var i=0;i<row.SubCategory.length;i++){
//                                console.log(row.Category[i]);
//                                   var j = i+1;
                                 $('.Category1').val(row.SubCategory[i]);
                                 $('.Description1').val(row.Description[i]);
                                }
                            $('.Description0').val(row.Description[0]);
                            $('#submitButton').val('Save');
                            $('.modal-header').html('<h4>Edit New Sub-category</h4>');
                            $('#EditCategoryId').val(row._id.$id);
                                     
//                           $('#Username').val(row.ManagerName);
//                           $('#Phone').val(row.Phone);
//                           $('#Email').val(row.Email);
//                      $('.edit_accepts').val(row.Accepts);
                        });
                    }
            });
    }
    //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function Delservice(thisval) {
        $('#deletemodal').modal('show');
        var entityidid = thisval.id;
        $("#deletelink").attr('href', "<?php echo base_url() ?>index.php/Admin/DeleteSubCat/" + entityidid);
    }


    $(document).ready(function () {
        $('.edit_class').click(function () {
            var EditCat = $(this).closest("tr").find(".EditCat").val();
            var EditDesc = $(this).closest("tr").find(".EditDesc").text();
            var EditSubCat = $(this).closest("tr").find(".EditSubCat").text();
//            alert(EditCat);
            $('#NewCat').modal('show');
            $('#CategoryId').val(EditCat);
            $('#Description').val(EditDesc);
            $('#Sub-Category').val(EditSubCat);
            $('#submitButton').val('Update');
            $('#SubCategoryId').val(this.id);


        });
        
         $('.error-box-class').keypress(function(){
           $('#errorbox').text(""); 
        });
        
        $('#submitButton').click(function(){
            var cat = new Array();
              $(".Category").each(function (){
                    if($(this).val() != '')
                        cat.push($(this).val());
                    
                });
//            var cat = $('.Category').val();
              <?php foreach ($language as $val){} ?>
            var count = '<?php echo $val['lan_id']?>';
//            var desc = $('.Category').val();
            if(cat.length <= count){
                 $('#submitButton').prop('disabled', false);
                $('#errorbox').text("Please enter the sub-category")
            }else{
                $('#submitButton').prop('disabled', true);
                $('#addnewsubcat').submit();
            }
//           alert(); 
        });
        

        $(".moveUp").click(function (e) {
            var event = e || window.event;
            event.preventDefault();
            var row = $(this).closest('tr');

//            alert(1);

            $.ajax({
                url: "<?PHP echo AjaxUrl; ?>changeSubCatOrder",
                type: "POST",
                data: {kliye: 'interchange', curr_id: row.attr('id'), prev_id: row.prev().attr('id'), b_id: '<?php echo $BizId; ?>'},
                success: function (result) {

                }
            });
            row.prev().insertAfter(row);
            $('#saveOrder').trigger('click');
        });

        $(".moveDown").click(function (e) {
            var event = e || window.event;
            event.preventDefault();
            var row = $(this).closest('tr');
//            alert(row.attr('id'));
//            alert(row.next().attr('id'));
            $.ajax({
                url: "<?PHP echo AjaxUrl; ?>changeSubCatOrder",
                type: "POST",
                data: {kliye: 'interchange', prev_id: row.attr('id'), curr_id: row.next().attr('id'), b_id: '<?php echo $BizId; ?>'},
                success: function (result) {

//                    alert("intercange done" + result);

                }
            });
            row.insertAfter(row.next());
            $('#saveOrder').trigger('click');
        });

    });


</script>
<style>
          #selectedcity,#companyid,#tableWithSearch_length,#tableWithSearch_filter{
        display: none;
    }
</style>
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



<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="">
                    <li>
                        <a href="#" class="active">MENU</a>
                    </li>
                    <li><a href="#" class="active">SUB-CATEGORIES</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>

            <div class="add_new">
               <button type="button" class="btn btn-primary" id="callM" style="margin:0px;">Add</button>
            </div>

            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <!-- <button type="button" class="btn btn-default" id="callM">Add new</button> -->
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
                                            <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                Sub-Category</th>
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
                                            <tr role="row" class="odd" id='<?PHP echo (string) $result['_id'] ?>'>
                                                <td id = "d_no" class="v-align-middle sorting_1"> <?php echo $count ?></td>
                                                <td id = "fname_" class=" v-align-middle sorting_1"> <?php if(is_array($result["Category"] ))
                                                                                                                            {
                                                                                                                              echo implode($result["Category"], ',');
                                                                                                                            }
                                                                                                                         else
                                                                                                                            { 
                                                                                                                             echo $result["Category"]; 
                                                                                                                           } 
                                                                                                          ?></td>
                                                <td id = "fname_" class="EditSubCat v-align-middle sorting_1"> <?php  if(is_array($result["SubCategory"] ))
                                                                                                                            {
                                                                                                                              echo implode($result["SubCategory"] , ',');
                                                                                                                            }
                                                                                                                         else
                                                                                                                            { 
                                                                                                                             echo $result["SubCategory"] ; 
                                                                                                                           } 
                                                                                                               ?></td>
                                                <td id = "lname_" class="EditDesc v-align-middle"> <?php  if(is_array($result["Description"] ))
                                                                                                               {
                                                                                                                 echo implode($result["Description"], ',');
                                                                                                               }
                                                                                                          else
                                                                                                               { 
                                                                                                                 echo $result["Description"]; 
                                                                                                               } 
                                                                                                     ?> </td>
                                        <input type='hidden' class='EditCat' value='<?PHP echo $result["CategoryId"]; ?>'>
                                        <td  class="v-align-middle">
                                            <div class="btn-group">
                                                <a class="moveDown btn-padding" id='<?php echo $result['_id'] ?>'><button id="<?php echo $result['_id'] ?>" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;" class="btn btn-success"><i class="fa fa-arrow-down"></i>
                                                    </button></a>
                                                <a class="moveUp btn-padding" id='<?php echo $result['_id'] ?>'><button id="<?php echo $result['_id'] ?>" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;" class="btn btn-success"><i class="fa fa-arrow-up"></i>
                                                    </button></a>
                                                <a class="edit_class btn-padding" id='<?php echo $result['_id'] ?>'><button  onclick="editsubcat(this)" id="<?php echo $result['_id'] ?>" type="button" style="color: #ffffff !important;background-color: #5bc0de;border: 1px solid #5bc0de;" class="btn btn-success"><i class="fa fa-pencil"></i>
                                                    </button></a>

                                                <a class="btn-padding"><button type="button" onclick="Delservice(this)" id="<?php echo $result['_id'] ?>" class="btn btn-success" style="color: #ffffff !important;background-color: #d9534f;border: 1px solid #d9534f;"><i class="fa fa-trash-o"></i>
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
                    <h5 style="text-align: center;line-height:22px;">Are you sure you want to remove this sub-category? </h5>
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

        <form  id="addnewsubcat" role='form' action = "<?php echo base_url(); ?>index.php/Admin/AddNewSubCategory" method="post" enctype="multipart/form-data"">
            <div class="modal-content" style="padding: 0% 4%;">
                <div class="modal-header" style="padding-top: 18px;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity: initial;">&times;</button>
                    <h4 class="modal-title">Add New Sub-category</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>

                        <select class="form-control" id="CategoryId" name="FData[CategoryId]" required>
                            <option value="">Select Category</option>
                            <?PHP
                            foreach ($AllCats as $Cats) {
                                echo '<option value = "' . (string) $Cats['_id'] . '">' . implode($Cats['Category'],',') . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div id="Category_txt">
                            <div class="form-group ">
                                <label> Sub-Category (English)</label>
                             
                                <input type="text"   id="Sub-Category_0" name="FData[SubCategory][0]" required class=" Category Category0 form-control error-box-class" >
                           
                             </div>
                            
                                    <?php
                                     foreach ($language as $val) {
//                                         print_r($val);
                                    ?>
                            <div class="form-group" >
                                   <label> Sub-Category (<?php echo $val['lan_name'];?>)</label>
                               
                                     <input type="text"  id="Sub-Category_<?= $val['lan_id'] ?>" name="FData[SubCategory][<?= $val['lan_id'] ?>]" required class=" Category Category1 form-control error-box-class" >
                               
                            </div>
                                  
                           <?php } ?>
                            
                    </div>
                    
<!--                    <div class="form-group" >
                        <label>Sub-Category</label>
                        <input type="text" class="form-control" placeholder="Sub-Category" id="Sub-Category" name="FData[SubCategory]" required>
                    </div>-->

                    <div id="Description_txt">
                            <div class="form-group ">
                                <label > Description (English) </label>
                                 
                                  <textarea type="text"   id="Description_0" placeholder="Description" name="FData[Description][0]"  class=" Description Description0 form-control error-box-class" ></textarea>
                                 
                             </div>
                            
                                    <?php
                                     foreach ($language as $val) {
//                                         print_r($val);
                                    ?>
                            <div class="form-group" >
                                   <label for="fname" > Description (<?php echo $val['lan_name'];?>) </label>
                                   
                                   <textarea type="text"  id="Description_<?= $val['lan_id'] ?>" placeholder="Description" name="FData[Description][<?= $val['lan_id'] ?>]"  class=" Description Description1 form-control error-box-class" ></textarea>
                             
                            </div>
                                  
                           <?php } ?>
                             
                    </div>

<!--                    <div class="form-group" >
                        <label>Description</label>
                        <textarea rows="4" cols="50" type="text" class="form-control" placeholder="Description" id="Description" name="FData[Description]"></textarea>
                    </div>-->
                    <input type="hidden" id="BusinessId" name="FData[BusinessId]" value="<?PHP echo $BizId; ?>">
                    <input type="hidden" id="BusinessId" name="count" value="<?PHP echo $count; ?>">
                    <input type="hidden" id="SubCategoryId" name="SubCategoryId" >
                    <label id = "errorbox" style="color: red; font-size: 15px;"></label>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="button" id="submitButton" class="btn btn-primary" value="Add">

                </div>
            </div>
        </form>
        </form>

    </div>

</div>