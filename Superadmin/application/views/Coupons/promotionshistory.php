<?php
if ($actionFor == 2) {
    $wallet = "active";
} else
    $trip = "active";
?>
<script src="<?= base_url() ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js" type="text/javascript"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js" type="text/javascript"></script>
<script>
    var settings = {
        "autoWidth": false,
//        "sDom": "<'table-responsive't><'row'<p i>>",
        "destroy": true,
        "scrollCollapse": true,
        "iDisplayLength": 20,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": '<?php echo base_url() ?>index.php/coupons/datatable_promoused/<?= $promoId?>',
        "bJQueryUI": true,
        "ordering" : false,
        "oLanguage": {
            "sLengthMenu": "_MENU_ ",
            "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
        },
        "fnInitComplete": function () {
        },
        'fnServerData': function (sSource, aoData, fnCallback)
        {
              // csrf protection
                aoData.push({name:'<?php echo $this->security->get_csrf_token_name(); ?>' ,  value:'<?php echo $this->security->get_csrf_hash(); ?>'});
            $.ajax
            ({
                'dataType': 'json',
                'type': 'POST',
                'url': sSource,
                'data': aoData,
                'success': fnCallback
            });
        },
                "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
          
            "bProcessing": true,
             "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "autoWidth": true,
            "sDom": "<'table-responsive't><'row'<p i>>",
          "columnDefs": [
                { "width": "18%", "targets": 0 }
              ],
        buttons: [
            'excel'
        ]
    };
    $(document).ready(function () {
        var his_tbl = $('#big_table');
        his_tbl.dataTable(settings);
        $('.buttons-excel').addClass('btn btn-success m-l-30');
        $('#search-table').keyup(function () {
            his_tbl.fnFilter($(this).val());
        });
    });
</script>
<style>
    #selectedcity,#companyid{
        display: none;
    }
    .aligntext{
     margin-top:12px; 
      font-size: 12px;
      padding-bottom: 10px;
}
input#search-table {
    margin-right: 0px;
    margin-bottom: 15px;
    margin-top: 25px;
}
.dtgen{
    padding: 15px 15px 15px 15px;
}
</style>
<div class="content">
    
    <div class="container-fluid container-fixed-lg"><br/>

        <div class="container-md-height m-b-20">
            <div class="panel panel-transparent">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url() . 'index.php/coupons/promotion/1';?>">TRIP PROMO</a>
                    </li>
                    <li><a href="#" class="active">Promo History</a></li>

                </ul>
                <!--<div class="panel-group visible-xs" id="LaCQy-accordion"></div>-->
                <div class="tab-content">
                    <div class="tab-pane slide-right active" id="tab_user">
                       
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Promo Code : <?= $promotions['code']?>
                                    </div>
                                    <div class="pull-right referlabel">
                                        <input type="text" id="search-table" class="form-control pull-right aligntext"  placeholder="<?php echo SEARCH; ?> ">
                                    </div>
                                </div>
                                
                                <div class="panel-body dtgen">
                                    <?= $this->table->generate() ?>
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


