<?php
if ($actionFor == 2) {
    $wallet = "active";
} else
    $trip = "active";
?>
<script src="<?= base_url() ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
         var table = $('#big_table');       
        var settings = {
            "autoWidth": true,
         "sDom": "<'table-responsive't><'row'<p i>>",
         "destroy": true,
         "scrollCollapse": true,
         "iDisplayLength": 20,
         "bProcessing": true,
         "bServerSide": true,
         "sAjaxSource": '<?php echo base_url() ?>index.php?/coupons/datatable_refererHistory/<?= $refId?>',
         "bJQueryUI": true,
         "sPaginationType": "full_numbers",
         "iDisplayStart ": 20,
         "oLanguage": {
             "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
         },
         "fnInitComplete": function () {
             //oTable.fnAdjustColumnSizing();
              $('.cs-loader').hide();

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

     table.dataTable(settings);
  
    $(document).ready(function () {
        var his_tbl = $('#big_table');
        his_tbl.dataTable(settings);

        $('#search-table').keyup(function () {
            his_tbl.fnFilter($(this).val());
        });
    });
</script>
<style>
    #selectedcity,#companyid{
        display: none;
    }
</style>
<div class="content">
  
    <div class="container-fluid container-fixed-lg">

        <!--<div class="container-md-height m-b-20">-->
            <div class="panel panel-transparent">
                <ul class="breadcrumb" style="">
                    <li>
                        <a href="<?php echo base_url() . 'index.php?/coupons/refferal';?>">Referrals</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() . 'index.php?/coupons/refferalHistory/' . $refData['campainId'];?>">Referral History</a>
                    </li>
                    <li><a href="#" class="active"><?= $refData['UserName']?></a></li>

                </ul>
                <div class="panel-group visible-xs" id="LaCQy-accordion"></div>
                <div class="tab-content">
                    <div class="tab-pane slide-right active" id="tab_user">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Referral Code : <?= $refData['Coupon_code']?>
                                    </div>
                                    <div class="pull-right">
                                        <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?> ">
                                    </div>
                                </div>
                                <div class="panel-body no-padding">
                                    <?= $this->table->generate() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--</div>-->
    </div>
</div>


