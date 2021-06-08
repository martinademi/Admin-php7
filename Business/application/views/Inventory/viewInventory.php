
<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<link href="<?php echo base_url(); ?>css/products.css" rel="stylesheet">
<style>
    /* .btn{
        font-size: 5px !important;
    } */
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }
    .textDec{
        text-decoration: underline !important;  
    }
    .dataTables_scrollBody{
        height:100%!important;
        min-height:100%!important;
    }
</style>
<script>
    $(document).ready(function () {
        var offset = new Date().getTimezoneOffset();
       $('.products').addClass('active');
      
        $('#big_table_processing').show();

        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        var settings = {
            "scrollX": true,
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Inventory/InventoryProductDetails/<?php echo $productId?>/<?php echo $unitId?>/'+offset,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,

            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
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
            },
            
        };
        table.dataTable(settings);
        // search box for table

        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $(document).on("click", '.addUnitsData', function () {           
        productId = $(this).attr('data-id');
        unitId=$(this).attr('data-unitid');
           $.ajax({
               url: '<?php echo base_url() ?>index.php?/Inventory/getUnitsForItem/' + productId + '/' + unitId ,
               type: "POST",
               data: {id: productId,unitId:unitId},
               dataType: "JSON",
               success: function (result) {
                   $('#unitQuantityData').val(result.data);
                   avalabelQty = result.data;
                   $('#addUnitModal').modal('show');
               }

           });
       });
       //confirmation delete
			 $('#addQuantity').click(function(){
                 $("#addUnitModal").modal('hide');
                var updateQuantity=$('#unitQuantityData').val();

                $.ajax({
                //chnages
                    url:'<?php echo base_url();?>index.php?/Inventory/addProductQuantity',
                    type:'POST',
                    dataType: 'json',
                    data:{productId :productId,unitId:unitId,quantity:updateQuantity},
                    success: function (result) {
                        $('#big_table').DataTable().ajax.reload();
                }

                });

                });

                //remove units modal
                $(document).on("click", '.removeUnitsData', function () {           


                productId = $(this).attr('data-id');
                unitId=$(this).attr('data-unitid');

                $.ajax({
                url: '<?php echo base_url() ?>index.php?/Inventory/getUnitsForItem/' + productId + '/' + unitId ,
                type: "POST",
                data: {id: productId,unitId:unitId},
                dataType: "JSON",
                success: function (result) {

                $('#removeQuantityData').val(result.data);

                $('#removeUnitModal').modal('show');
                }

                });
                });

                //    remove quantity

                $('#removeQuantity').click(function(){
                    $("#removeUnitModal").modal('hide');

                var removeQuantity=$('#removeQuantityData').val();

                $.ajax({
                //chnages
                url:'<?php echo base_url();?>index.php?/Inventory/removeProductQuantity',
                type:'POST',
                dataType: 'json',
                data:{productId :productId,unitId:unitId,quantity:removeQuantity},
                success: function (result) {
                console.log(result);
                $('#big_table').DataTable().ajax.reload();
                }

                });

                });




    });

    
</script>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <!-- <div class="brand inline" style="  width: auto; margin-left: 8px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 16px;">Inventory</strong>
        </div> -->
        <div class="brand inline" style="  width: auto;">
        <?php echo $this->lang->line('heading_inventoryDetils'); ?>
        </div>
        <!-- Nav tabs -->
        <ul class="breadcrumb" style="">
                        
            <li class="breadClass"><a href="<?php echo base_url(); ?>index.php?/Inventory" class="active"><?php echo $this->lang->line('heading_inventory'); ?></a>&nbsp>&nbsp<a href="#" style="color: #0090d9 !important; font-size: 11px !important"><?php echo $this->lang->line('heading_inventoryDetils'); ?></a>
            </li>
            
            <div class="pull-right m-t-10">
            
             <button class="btn btn-primary btnedit cls111 addUnitsData" id="editinventory" data-id="<?php echo $productId; ?>" data-unitId="<?php echo $unitId; ?>" style="font-size:10px !important"><?php echo $this->lang->line('button_add'); ?></button>
            
             </div>
            <div class=" pull-right m-t-10">
            <button class="btn btn-primary removeUnitsData" id="remove" data-id="<?php echo $productId; ?>" data-unitId="<?php echo $unitId; ?>" style="font-size:10px !important"><?php echo $this->lang->line('button_remove'); ?></button>
             </div>

        </ul>
        <!-- Tab panes -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent " style="margin-left: -15px;margin-right: -20px;">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="error-box" id="display-data" style="text-align:center; color: red;"></div>
                                    <div class="searchbtn row clearfix pull-right" style="margin-right: 0%;">

                                        <div class=""><input type="text" id="search-table" class="form-control pull-right" style="text-transform: capitalize;" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>
                                    <div class="dltbtn">
                                    </div>
                                </div>
                                &nbsp;

                                <div class="container">
                                    <div class="row clearfix">
                                        <div class="col-md-12 column">
                                            <?php echo $this->table->generate(); ?>
                                        </div>
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

        <!-- END PAGE CONTENT -->
    </div>


 <div class="modal fade" id="addUnitModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $this->lang->line('heading_addQuantity'); ?></h4>
        </div>
        <div class="modal-body">
            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_quantity'); ?></label>
                <div class="col-sm-9 pos_relative2">

                    <input type="text" id="unitQuantityData" name="unitQuantityData"
                            required="required" class="error-box-class  form-control">

                </div>
                                       
        </div>
        <br> <br> <br>
        <div class="modal-footer">
          <button type="button" class="btn btn-success"  id="addQuantity" style="font-size:12px;"   ><?php echo $this->lang->line('button_add'); ?></button>
        </div>
      </div>
    </div>
  </div>

  <!-- //remove units -->
  <div class="modal fade" id="removeUnitModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $this->lang->line('heading_removeQuantity'); ?></h4>
        </div>
        <div class="modal-body">
            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_quantity'); ?></label>
                <div class="col-sm-9 pos_relative2">

                    <input type="text" id="removeQuantityData" name="removeQuantityData"
                            required="required" class="error-box-class  form-control">

                </div>
                                       
        </div>
        <br> <br> <br>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button> -->
          <button type="button" class="btn btn-success" id="removeQuantity" style="font-size:12px;"><?php echo $this->lang->line('button_remove'); ?></button>
        </div>
      </div>
    </div>
  </div>
  

