<script src="//admin.uberforall.com/supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="//admin.uberforall.com/supportFiles/sweetalert.css">

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid,#account_type{
        display: none;
    }
    .btnWidth{
        width: 124px;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    
    .btn{
        border-radius: 25px !important
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {

        $(document).ajaxComplete(function () {
      
        var access_right_pg = '<?= $access_right_pg ?>';
        if (access_right_pg == 000) {
    //   base_url().'index.php?/superadmin/access_denied';
        } else if (access_right_pg == 100) {
            $('.cls110').remove();
            $('.cls111').remove();
        } else if (access_right_pg == 110) {
            $('.cls111').remove();
        } 
    });


        var table = $('#big_table');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/city/datatable_cities',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "ordering": false,
            "drawCallback": function () {
                $('#big_table_processing').hide();
            },
            "iDisplayStart ": 0,
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                $('.cs-loader').hide();
            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                // csrf protection
                aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                $.ajax
                        ({
                            'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        });
            },
            "aoColumns": [
                {"sWidth": "3%"},
                {"sWidth": "3%"},
                {"sWidth": "3%"},
                {"sWidth": "1%", "sClass": "text-center"},
                {"sWidth": "1%", "sClass": "text-center"},
                {"sWidth": "1%", "sClass": "text-center"},
                {"sWidth": "1%", "sClass": "text-center"},
               // {"sWidth": "1%", "sClass": "text-center"},
                // {"sWidth": "2%", "sClass": "text-center"},
                // {"sWidth": "3%", "sClass": "text-center"},
                {"sWidth": "3%", "sClass": "text-center"}
            ]
        };
        table.dataTable(settings);
        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
        $('.buttonSave').click(function(){
            var Id = $(this).val(); 
            alert(Id);

        });
        $(document).on('click', '.laundryPopUp', function () {
            var cityId = $(this).attr('data-id');  
            $('.buttonSave').val(cityId);
            var weightMetric = $(this).attr('data-weightmetrictext');
            var currencySymbol = $(this).attr('data-currencySymbol');
            $('.weightMetric').text(weightMetric);
            $('.currencySymbol').text(currencySymbol);
            $('#LaundryModal').modal('show');
        });
        $(document).on('click', '.deleteCity', function () {
            var city_id = $(this).attr('data-id');
            swal({
                title: "Delete",
                text: 'Are you sure want to delete?',
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    url: '<?= base_url('index.php?/city') ?>/del_city',
                    type: "POST",
                    data: {
<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
                        del_id: city_id
                    },
                    dataType: "JSON",
                    success: function (result) {
                        
                        console.log(result);
                        if (result.error == '0') {
                            swal("City Deleted!");
                            var table = $('#big_table');
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/city/datatable_cities',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "ordering": false,
                                "drawCallback": function () {
                                    $('#big_table_processing').hide();
                                },
                                "iDisplayStart ": 0,
                                "fnInitComplete": function () {
                                    //oTable.fnAdjustColumnSizing();
                                    $('.cs-loader').hide();
                                },
                                'fnServerData': function (sSource, aoData, fnCallback)
                                {
                                    // csrf protection
                                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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
                        } else {
                            swal("", result.msg, "error");
                        }
                    },
                    error: function () {
                        swal("", 'Problem During Adding Deleting please try agin.', "error");
                    },
                    timeout: 30000
                });
            });

        });


        // area name modal popup

        $('#big_table').on("click", '.cityAreaName', function () {

            $('#areaListData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/City/getAreaForCity/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    console.log('area details*******',result);

                    var html = '';
                    var k = 1;

                    html = '<tr style="font-size:14px; "><td style="text-align:center;width:250px;border-style: ridge;">Sl No.</td><td style="border-style: ridge;width:250px;text-align:center;">Area Name</td></tr>';
                    $('#areaListData').append(html);

                    // $.each(result.data, function (i, row) {
                    //     html = '<tr style="font-size:14px; "><td style="text-align:center;width:250px;border-style: ridge;">' + row.title + '</td><td style="border-style: ridge;width:250px;text-align:center;">' + row.value + '</td></tr>';

                    //     $('#areaListData').append(html);
                    // });


                    $('#areaListModal').modal('show');
                }

            });
        });




    });
</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="brand inline" style="  width: auto;">
            <strong><?php echo $this->lang->line('CITIES'); ?></strong>
        </div>
        <div class="row">
            <ul class="nav nav-tabs nav-tabs-fillup  new_class bg-white" style="margin: 1% 0.8%;padding: 0.5% 2% 0% 1%">
                <div class="pull-right m-t-10 cls110">
                    <a href="<?php echo base_url() ?>index.php?/city/addnewcity"> 
                        <button class="btn btn-primary btn-cons btnWidth"><?php echo $this->lang->line('Create_City'); ?></button>
                    </a>
                </div>
            </ul>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-transparent ">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="col-sm-8">
                                    <div class="cs-loader">
                                        <div class="cs-loader-inner" >
                                            <label class="loaderPoint" style="color:#10cfbd">●</label>
                                            <label class="loaderPoint" style="color:red">●</label>
                                            <label class="loaderPoint" style="color:#FFD119">●</label>
                                            <label class="loaderPoint" style="color:#4d90fe">●</label>
                                            <label class="loaderPoint" style="color:palevioletred">●</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="pull-right">
                                        <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo $this->lang->line('search'); ?>"/> 
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="padding: 0px; margin-top: 2%;">
                                <?php echo $this->table->generate(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $this->lang->line('LAUNDRY_BY_WEIGHT_FEE');?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label"><?php echo $this->lang->line('Lower_weight_limit'); echo '  ( '; ?><span class="weightMetric"></span><?php echo ' )';?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">  
                                            <input type="text" class="form-control error-box-class" id="name" minlength="3" placeholder="Enter your name" required="">  

                                        </div>
                                        <div class="col-sm-2 error-box" id="text_name" style="color:red"></div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label"><?php echo $this->lang->line('Upper_weight_limit');echo '  ( '; ?><span class="weightMetric"></span><?php echo ' )';?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control error-box-class" id="name" minlength="3" placeholder="Enter your name" required="">  

                                        </div>
                                        <div class="col-sm-2 error-box" id="text_name" style="color:red"></div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label"><?php echo $this->lang->line('Price');echo '  ( '; ?><span class="currencySymbol"></span><?php echo ' )';?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control error-box-class" id="name" minlength="3" placeholder="Enter your name" required="">  

                                        </div>
                                        <div class="col-sm-2 error-box" id="text_name" style="color:red"></div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label"><?php echo $this->lang->line('Extra_Fee_forexpress_delivery'); echo '  ( '; ?><span class="currencySymbol"></span><?php echo ' )';?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control error-box-class" id="name" minlength="3" placeholder="Enter your name" required="">  

                                        </div>
                                        <div class="col-sm-2 error-box" id="text_name" style="color:red"></div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-4 control-label"><?php echo $this->lang->line('Taxes_applicable'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control error-box-class" id="name" minlength="3" placeholder="Enter your name" required="">  

                                        </div>
                                        <div class="col-sm-2 error-box" id="text_name" style="color:red"></div>
                                    </div>
                    
                    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
                                    <div class="col-sm-4" >
                                    </div>
                                    <div class="col-sm-4">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('btn_close'); ?></button>
                                    </div>
                                    <div class="col-sm-4" >
                                    <button type="button" class="btn btn-success buttonSave" data-dismiss="modal"><?php echo $this->lang->line('button_save'); ?></button>
                                    </div>
                    </div>

    </div>
  </div>
</div>


<div class="modal fade stick-up" id="areaListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:100%;margin-left:0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><?php echo $this->lang->line('area_name'); ?></h4>
            </div>
            <div class="modal-body form-horizontal" style="margin-left: 27px;">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    
                        
                      
                    
                    </thead>
                    <tbody >
                    <div class="container" id="areaListData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
  

                    