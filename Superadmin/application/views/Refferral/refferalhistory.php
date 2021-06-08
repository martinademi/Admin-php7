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
    var table = $('#big_table');       
        var settings = {
            "autoWidth": true,
         "sDom": "<'table-responsive't><'row'<p i>>",
         "destroy": true,
         "scrollCollapse": true,
         "iDisplayLength": 20,
         "bProcessing": true,
         "bServerSide": true,
         "sAjaxSource": <?php echo base_url() ?>index.php/Referral/datatable_refferalHistory/<?= $referralId?>',
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
  $('.buttons-excel').addClass('btn btn-success m-l-30');
  $('#search-table').keyup(function () {
    his_tbl.fnFilter($(this).val());
  });

  $('#searchData').click(function(){
            if ($("#start").val() && $("#end").val())
            {
                $('#big_table_processing').show();
                var dateObject = $("#start").datepicker("getDate"); // get the date object
                var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
                var dateObject = $("#end").datepicker("getDate"); // get the date object
                var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
                settings.sAjaxSource = '<?php echo base_url() ?>index.php/Referral/datatable_refferalHistory/<?= $referralId?>/'+ st + '/' + end;
                his_tbl.dataTable(settings);
            }else{
                swal({
                    title: "Error",
                    text: 'Please Provide Date Range',
                    type: "error",
                    showCancelButton: false,
                    confirmButtonText: "ok",
                    cancelButtonText: "No",
                });
            }
        });

});
</script>
<style>
  #selectedcity,#companyid{
    display: none;
  }
  #big_table_filter{
    display: none;
  }
  input#search-table {
    margin-right: 25px;
}
</style>
<div class="content">
<!--  <div class="jumbotron  no-margin" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
      <div class="inner" style="transform: translateY(0px); opacity: 1;">
        <h3 class="">Page Title</h3>
      </div>
    </div>
  </div>-->
  <div class="container-fluid container-fixed-lg">

    <div class="container-md-height m-b-20">
      <div class="panel panel-transparent">
        <ul class="breadcrumb" style="">
          <li>
            <a href="<?php echo base_url() . 'index.php/Referral/refferal';?>">Referrals</a>
          </li>
          <li><a href="#" class="active">Referral History</a></li>

        </ul>
        <div class="panel-group visible-xs" id="LaCQy-accordion"></div>
        <div class="tab-content">
          <div class="tab-pane slide-right active" id="tab_user">
            <div class="row">
              <div class="panel panel-default">
                <div class="panel-heading">
                    


                </div>
                  <div class="panel-body" style="padding: 15px 15px 15px 15px;">
                    
                  <div class="pull-right">
                    <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?> ">
                  </div>

                  <div class="pull-right m-r-50">
                    <div class='row'>
                      <div class="col-sm-8 pull-left ">
                        <div class="input-daterange input-group" id="datepicker-component">
                          <input type="text" class="input-sm form-control " name="start" id="start" placeholder="From">
                          <span class="input-group-addon">to</span>
                          <input type="text" class="input-sm form-control" name="end" id="end" placeholder="To">
                        </div>
                      </div>
                      <div class="col-sm-4 pull-left">
                        <button class="btn btn-primary" type="button" id="searchData">Search</button>
                      </div>
                    </div>
                  </div>
                  </div>
                  <?= $this->table->generate() ?>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



