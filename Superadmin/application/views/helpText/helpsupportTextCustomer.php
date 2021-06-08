<style>
							.btn {
    border-radius: 25px !important;
    width:70px;
}
</style>
<script src="<?= base_url() ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>

<script>
    $('.sm-table').find('.header-inner').html('<div class="brand inline" style="  width: auto;\
                     font-size: 27px;\
                     color: gray;\
                     margin-left: 100px;margin-right: 20px;margin-bottom: 12px; margin-top: 10px;">\
                    <strong><?= Appname ?> Super Admin Console</strong>\
                </div>');

    $(document).ready(function () {
        var help_tbl = $('#help_table');
        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
               "bJQueryUI": true,
               "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 20
        };
        help_tbl.DataTable(settings);
        $('#search-table2').keyup(function () {
            help_tbl.fnFilter($(this).val());
        });
        var sabcat_tbl = $('#subcat_table');
        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 20
        };
        help_tbl.DataTable(settings);
        $('#search-table3').keyup(function () {
            sabcat_tbl.fnFilter($(this).val());
        });
        
        
        
        $(document).on('click', '.customerSupport', function ()
        {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php?/helpText') ?>/getCustomerSupportLanguage",
                data: {supportId: $(this).data('id')},
                dataType: "JSON",
                success: function (result) {
                    $('#supportTableBody').html('');
                   
                    var html = "<tr><td style='text-align: center;'>English</td>";
                    html += "<td style='text-align: center;'>" + result.data.name.en + "</td></tr>";

                    $.each(result.lang, function (i, res) {
                        if (result.data.name[res.langCode]) {
                            html += "<tr><td style='text-align: center;text-transform: capitalize;'>"+res.lan_name+"</td>";
                            html += "<td style='text-align: center;'>" + result.data.name[res.langCode] + "</td></tr>";
                        }
                    })

                    $('#supportTableBody').append(html);
//                          
                    $('#supportModel').modal('show');
                }
            });

           


        });
    });
    var settings = {
        "sDom": "<'table-responsive't><'row'<p i>>",
        "destroy": true,
        "scrollCollapse": true,
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayStart ": 5,
        "oLanguage": {
            "sLengthMenu": "_MENU_ ",
            "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
        },
        
    };
    function viewsub_cat(cat_id) {
        
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/utilities/get_subcat_support",
            type: 'POST',
            data: {cat_id: cat_id},
            dataType: 'JSON',
            success: function (result) {
                
                var scat_tbl = $('#subcat_table').DataTable(settings);
                scat_tbl.clear().draw();
                var i = 1;
                var j = 0;
                $.each(result.data.sub_cat, function (ind, val) {
                    var lan = ['en'];
                    $.each(result.langauge, function (index, value) {
                        lan.push(value.code);
                    });
                    var name = [];
                    $.map(Object.keys(val.name), function (v) {
                        if (lan.indexOf(v) != -1) {
                            name.push(val.name[v]);
                            return true;
                        } else
                            return true;
                    });
                    var desc = $.map( result.data.sub_cat, function (v) {
                        return v;
                    });
                    
                    scat_tbl.row.add([
                        i,
                        name,
                        
                        "<a class='btn btn-default' href='<?= base_url()?>index.php?/utilities/getsubDescription/"+result.data.cat_id+"/"+val.id.$oid+"' style='background: #0090d9;border-color: #0090d9;color: white;font-size: 10px;'><i class='fa fa-eye'></i>View</a>\
                            <a style='background: #5bc0de;border-color: #5bc0de;color: white;font-size: 10px;' class='btn btn-default cls111' href='<?= base_url()?>index.php?/utilities/Subcat_editCustomer/"+result.data._id.$oid+"/"+val.id.$oid+"'   data-id=''><i class='fa fa-edit '></i> Edit</a>\
                            <a style='background: #d9534f;border-color: #d9534f;color: white;font-size: 10px;' class='btn btn-default cls111 delchk' onclick='delscat(this)' data-oid='"+val.id.$oid+"'>\
                                <i class='fa fa-trash '></i> Delete\
                            </a>"
                    ]).draw();
                    
                    i++;
                    j++;
                });
                       
                $('#modal-subcat').modal('show');
            },
            error: function () {
                alert('Problem occurred please try agin.');
            },
            timeout: 30000
        });
    }
    
    
    function viewdesc(cat_id){
//       window.location.href="<?php echo base_url() ?>index.php?/utilities/getDescription/"+cat_id;
       window.open('<?php echo base_url() ?>index.php?/utilities/getDescription/'+cat_id);
    }
    
    
    
    
    function delcat(rowid){

         $('#deleteModal').modal('show');


        $('#yesConfirmDelete').click(function(){
        
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/helpText/support_actionCustomer/del",
                type: "POST",
                data: {id: $(rowid).attr('data-id')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        var hlp_tbl = $('#help_table').DataTable();
                        hlp_tbl.row($(rowid).closest('tr'))
                                .remove()
                                .draw();
                           var help_tbl = $('#help_table');
                            var settings = {
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                   "bJQueryUI": true,
                                   "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                    "sLengthMenu": "_MENU_ ",
                                    "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
                                },
                                "iDisplayLength": 20
                            };
                            help_tbl.DataTable(settings);
                            $('#deleteModal').modal('hide');
                    } else {
                        alert('Problem in Deleting Group please try agin.');
                    }
                },
                error: function () {
                    alert('Problem in Deleting Group please try agin.');
                },
                timeout: 30000
            });

        });
 
  }

    function delscat(rowid){
        if (confirm("Are you sure you want to Delete?")) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/utilities/support_actionCustomer/subdel",
                type: "POST",
                data: {id: $(rowid).attr('data-oid')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        var scat_tbl = $('#subcat_table').DataTable();
                        scat_tbl.row($(rowid).closest('tr'))
                                .remove()
                                .draw();
                    } else {
                        alert('Problem in Deleting Group please try agin.');
                    }
                },
                error: function () {
                    alert('Problem in Deleting Group please try agin.');
                },
                timeout: 30000
            });
        }
    }
</script>

<style>
    .header{
        height:60px !important;
    }
    .header h3{
        margin:10px 0 !important;
    }
    .rating>.rated {
        color: #10cfbd;
    }
    .social-user-profile {
        width: 83px;
    }
    .table > thead > tr > th{
        font-size: 14px;
    }
     .row {
    margin-right: -5px !important;
    margin-left: -10px;
}
</style>

<div class="content">
    <div class="" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            <div class="inner" style="transform: translateY(0px); opacity: 1;">
                <strong class="" style="color: #0090d9;">Help Text Customer</strong>
            </div>
        </div>
    </div>
    <div class="container-fluid container-fixed-lg">

        <div class="container-md-height m-b-20">
            <div class="panel panel-transparent">
                <div class="panel-group visible-xs" id="LaCQy-accordion"></div>
                <div class="tab-content">
                    <div class="tab-pane active" id="hlp_txt">
                        <div class="row panel panel-default" style="border: 0;">
                            <div class="panel-heading" style="background:white;">
                                <!--<div class="panel-title">Help Text</div>-->
                                <div class='pull-right'>
                                    <a href='<?= base_url() ?>index.php?/helpText/support_catCustomer'>
                                        <button class='btn btn-primary cls110' id='add_new_cat' style="margin: 10px 0px;">
                                             <?= ucwords('add');?>
                                        </button>
                                    </a>
                                </div>
                                
                                <div class="panel-body no-padding">
                                    <table class="table table-striped table-bordered table-hover demo-table-search" id="help_table">
                                        <thead>
                                            <tr>
                                               <th style="width:10%;">SL No.</th>
                                                <th style="width:30%;">SUPPORT TEXT</th>
                                                <th style="width:10%;">SUB CATEGORY</th>
                                                <th style="width:30%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $l = 1;
                                            foreach ($suppTextCustomer as $val) {
                                                ?>
                                                <tr>
                                                    <td class="semi-bold" style="text-align:left">
                                                        <?= $l++ ?>
                                                    </td>
                                                    <td style="text-align:left">
                                                    <a class="customerSupport"  style="cursor: pointer" data-id="<?php echo $val['_id']['$oid'];?>"> <?php echo implode($val['name'],','); ?> </a>
                                                    </td>
                                                    <td style="text-align:left">
                                                        <?php
                                                        if($val['has_scat'])
                                                        {
                                                            $count=count($val['sub_cat']);
                                                            if ($count!=0)
                                                            {
                                                                echo "<a href='" . base_url() . "index.php?/helpText/supportTextCustomerSubCategory/" . $val['cat_id'] . "'>
                                                                            <button class='btn btn-default cls110' id='add_new_cat' style='background: #2196f3;border-color: #2196f3;color: white;font-size: 10px;'>
                                                                                 " . $count . "
                                                                            </button>
                                                                        </a>";
                                                            }
                                                            else {
                                                                echo "<a href='" . base_url() . "index.php?/helpText/supportTextCustomerSubCategory/" . $val['cat_id'] . "'>
                                                                            <button class='btn btn-default cls110' id='add_new_cat' style='background: #2196f3;border-color: #2196f3;color: white;font-size: 10px;'>
                                                                                 Add Subcat 
                                                                            </button>
                                                                        </a>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "N/A";
                                                        }
                                                        
                                                        ?>
                                                    </td>
                                                     <td class="" style="text-align:left;">
                                                        <?php
//                                                        if ($val['has_scat'])
//                                                        {   echo "<button class='btn btn-default' onclick='viewsub_cat(" . $val['cat_id'] . ")' style='background: #0090d9;border-color: #0090d9;color: white;font-size: 10px;'>
//                                                                        <i class='fa fa-eye'></i> View
//                                                                    </button><br/>";
//                                                        }
//                                                        else
//                                                        {
//
//                                                           echo "<a><button class='btn btn-default' onclick='viewdesc(" . $val['cat_id'] . ")' style='background: #0090d9;border-color: #0090d9;color: white;font-size: 10px;'>
//                                                                        <i class='fa fa-eye'></i> View
//                                                                    </button></a><br/>" ;
//                                                        } 
                                                        ?>
                                                  
                                                   
                                                   
                                                        <?php
//                                                        if ($val['has_scat'])
//                                                            echo "<a href='" . base_url() . "index.php?/utilities/support_catCustomer/0/" . $val['cat_id'] . "'>
//                                                                        <button class='btn btn-default cls110' id='add_new_cat' style='background: #2196f3;border-color: #2196f3;color: white;font-size: 10px;'>
//                                                                             Add Subcat 
//                                                                        </button>
//                                                                    </a><br/>";
                                                        ?>
                                                        <a class='btn btn-default cls111' style="background: #5bc0de;border-color: #5bc0de;color: white;font-size: 10px;" href='<?= base_url()?>index.php?/helpText/support_editCustomer/<?= (String)$val['_id']['$oid']?>' data-id='<?= $val['cat_id'] ?>'>
                                                            <i class="fa fa-edit"></i> 
                                                        </a> 
                                                         <a class='btn btn-default cls111' style="background: #d9534f;border-color: #d9534f;color: white;font-size: 10px;" onclick='delcat(this)' data-id='<?= $val['cat_id'] ?>'>
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade slide-up" id="modal-subcat" tabindex="-1" role="dialog" aria-hidden="false" style>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id='grp_form' action=''>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                    <i class="pg-close"></i>
                </button>
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Sub Categories</h4>
                </div>
                <div class="modal-body m-t-50">
                    <div class="form-group-attached">
                        <div class="row">
                            <table class="table table-striped table-bordered table-hover demo-table-search" id="subcat_table" style="margin-bottom: 20px;">
                                <thead>
                                    <tr>
                                        <th style="width:3%;">SL No.</th>
                                        <th style="width:12%;">Sub-Category</th>
                                        <th style="width:10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="container">
  

  <!-- Modal -->
  <div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">View Description</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                <div class="col-md-4"> </div>
                <div class="col-md-8">
                     <a href="<?php echo base_url();?>index.php?/Supporttext/viewDescription/592c0ed225489626f2698b26/<?php echo $val['sub_cat.id']['$oid']?>" style="text-decoration: underline;color: blue;">View Description in <?php echo "English";?></a>
                </div>
               
                 </div><br/><br/>
                <div class="col-sm-12">
                <div class="col-md-4"></div>
                <div class="col-md-6">
                    
                    <a href="<?php echo base_url();?>index.php?/Supporttext/" style="text-decoration: underline;color: blue;">View Description in  <?php echo $val1;?></a>
                </div>
                
                 </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<div class="modal fade" id="supportModel" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">CUSTOMER SUPPORT TEXT</span> 
            </div>
            <div class="modal-body">
                <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                <table class="table table-bordered">
                    <thead>
                        <tr>

                            <th style="width:10%;text-align: center;">LANGUAGE</th>
                            <th style="width:10%;text-align: center;">CUSTOMER SUPPORT TEXT</th>
                        </tr>
                    </thead>
                    <tbody id="supportTableBody">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--          <button type="button" class="btn btn-success" id="save_image">SAVE</button>-->
            </div>
        </div>

    </div>
</div>

<!-- deletet model -->
				  <!-- Modal -->
                  <div class="modal fade" id="deleteModal" role="dialog">
						<div class="modal-dialog">
						
						
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Confirmation</h4>
							</div>
							<div class="modal-body">
							<p>Are you sure you want to delete it?</p>
							</div>
							<div class="modal-footer">
							<button type="button" class="btn btn-default" id="yesConfirmDelete"  >Yes</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
						
						</div>
					</div>
		<!-- end delete -->