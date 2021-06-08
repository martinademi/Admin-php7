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
            url: "<?php echo base_url() ?>index.php?/Utilities/get_subcat_support",
            type: 'POST',
            data: {cat_id: cat_id},
            dataType: 'JSON',
            success: function (result) {
                var scat_tbl = $('#subcat_table').DataTable(settings);
                scat_tbl.clear().draw();
                var i = 1;
                var j = 0;
                $.each(result.sub_cat, function (ind, val) {
                    
                    console.log(val.cat_id);
                    var name = $.map(result.sub_cat, function (v) {
                        return v;
                    });
                    
                    var desc = $.map( result.sub_cat, function (v) {
                        return v;
                    });
                    
                    scat_tbl.row.add([
                        i,
                        val.name.join(),
                        
                        "<a class='btn btn-default' href='<?= base_url()?>index.php?/utilities/getsubDescription/"+result.cat_id+"/"+val.id.$oid+"' style='background: #0090d9;border-color: #0090d9;color: white;font-size: 10px;'><i class='fa fa-eye'></i>View</a>\
                            <a style='background: #5bc0de;border-color: #5bc0de;color: white;font-size: 10px;' class='btn btn-default cls111' href='<?= base_url()?>index.php?/utilities/support_edit'   data-id=''><i class='fa fa-edit '></i> Edit</a>\
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
        if (confirm("Are you sure you want to Delete?")) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/utilities/support_action/del",
                type: "POST",
                data: {id: $(rowid).attr('data-id')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        var hlp_tbl = $('#help_table').DataTable();
                        hlp_tbl.row($(rowid).closest('tr'))
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
    function delscat(rowid){
        if (confirm("Are you sure you want to Delete?")) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/utilities/support_action/subdel",
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
</style>

<div class="content">
    <div class="" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            <div class="inner" style="transform: translateY(0px); opacity: 1;">
                <h3 class="" style="color: #0090d9;">Support Text</h3>
            </div>
        </div>
    </div>
    <!--<ul class="nav nav-tabs nav-tabs-simple bg-white" role="tablist" data-init-reponsive-tabs="collapse" style="margin: 0% 0.5% 1% 0.5%">
        <li class="active">
            <a href="#hlp_txt" data-toggle="tab" role="tab" aria-expanded="false">Support Text</a>
        </li>
    </ul>-->
    <div class="container-fluid container-fixed-lg">
        <!--<ul class="breadcrumb">-->
            <!--<li>
                <a href="#" class="active">Support Text</a>
            </li>-->
            <!--            <li>
                            <a href="#" class="active">Job Details - <?php echo $data['appt_data']->appointment_id; ?></a>
                        </li>-->
        <!--</ul>-->
        <div class="container-md-height m-b-20">
            <div class="panel panel-transparent">
                <!--<ul class="nav nav-tabs nav-tabs-simple bg-white" role="tablist" data-init-reponsive-tabs="collapse">
                    <li class="active">
                        <a href="#hlp_txt" data-toggle="tab" role="tab" aria-expanded="false">Support Text</a>
                    </li>
                </ul>-->
                <div class="panel-group visible-xs" id="LaCQy-accordion"></div>
                <div class="tab-content">
                    <div class="tab-pane active" id="hlp_txt">
                        <div class="row panel panel-default" style="border: 0;">
                            <div class="panel-heading" style="background:white;">
                                <!--<div class="panel-title">Help Text</div>-->
                                <div class='pull-right'>
                                    <a href='<?= base_url() ?>index.php?/utilities/support_cat'>
                                        <button class='btn btn-primary cls110' id='add_new_cat' style="margin: 10px 0px;">
                                             Add
                                        </button>
                                    </a>
                                </div>
                                <div class="panel-body no-padding">
                                    <table class="table table-striped table-bordered table-hover demo-table-search" id="help_table">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">SL No.</th>
                                                <th style="width:20%;">Category</th>
                                                <th style="width:35%;">Languages</th>
<!--                                                <th style="width:20%;">Description</th>-->
                                                <!--<th style="width:20%;">Has Form</th>-->
                                                <th style="width:30%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $l = 1;
                                            foreach ($suppText as $val) {
                                                ?>
                                                <tr>
                                                    <td class="v-align-middle semi-bold">
                                                        <?= $l++ ?>
                                                    </td>
                                                    <td><?= implode(", ", $val['name']) ?></td>
                                                    <td><?php
                                                        $elan = array();
                                                        $elang = array('English');
                                                        foreach($val['name'] as $ind => $val1)
                                                            array_push($elan, $ind);
                                                        foreach ($language as $val2) 
                                                            if(array_search($val2['lan_id'], $elan) != false)
                                                                array_push($elang,$val2['lan_name']);
                                                        echo implode(", ", $elang);
                                                    ?></td>
                                                     <td class="v-align-middle">
                                                        <?php
                                                        if ($val['has_scat'])
                                                        {   echo "<button class='btn btn-default' onclick='viewsub_cat(" . $val['cat_id'] . ")' style='background: #0090d9;border-color: #0090d9;color: white;font-size: 10px;'>
                                                                        <i class='fa fa-eye'></i> View
                                                                    </button><br/>";
                                                        }
                                                        else
                                                        {
////                                                            $var = implode(",",$val['desc']);
////                                                            echo $var;
                                                           echo "<a><button class='btn btn-default' onclick='viewdesc(" . $val['cat_id'] . ")' style='background: #0090d9;border-color: #0090d9;color: white;font-size: 10px;'>
                                                                        <i class='fa fa-eye'></i> View
                                                                    </button></a><br/>" ;
                                                        } 
                                                        ?>
                                                  
                                                   
                                                   
                                                        <?php
                                                        if ($val['has_scat'])
                                                            echo "<a href='" . base_url() . "index.php?/utilities/support_cat/0/" . $val['cat_id'] . "'>
                                                                        <button class='btn btn-default cls110' id='add_new_cat' style='background: #2196f3;border-color: #2196f3;color: white;font-size: 10px;'>
                                                                             Add Subcat 
                                                                        </button>
                                                                    </a><br/>";
                                                        ?>
                                                        <a class='btn btn-default cls111' style="background: #5bc0de;border-color: #5bc0de;color: white;font-size: 10px;" href='<?= base_url()?>index.php?/utilities/support_edit/<?= (String)$val['_id']['$oid']?>' data-id='<?= $val['cat_id'] ?>'>
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a> <br/>     
                                                         <a class='btn btn-default cls111' style="background: #d9534f;border-color: #d9534f;color: white;font-size: 10px;" onclick='delcat(this)' data-id='<?= $val['cat_id'] ?>'>
                                                            <i class="fa fa-trash"></i> Delete
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