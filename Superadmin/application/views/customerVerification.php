<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);


?>

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    
    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
  .txtaln{padding-top: 13px;}
</style>



<script type="text/javascript">
    $(document).ready(function () {

           
        $('#big_table_processing').show();
   
        var table = $('#big_table');

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/dt_customerVerification',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
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
            }
        };




        table.dataTable(settings);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

       

    });

    
</script>


<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">
        
        <div class="brand inline" style="  width: auto;
           
             color:#0090d9;
             margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();  ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();  ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();  ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong>CUSTOMER VERIFICATION</strong><!-- id="define_page"-->
        </div>

        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
               



                <div class="panel panel-transparent ">
                    
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                      <!--   <div class="error-box" id="display-data" style="text-align:center"></div> -->
                                        <!-- <div id="big_table_processing" class="dataTables_processing" style=""><img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif"></div> -->

                                
                                            <div class="searchbtn row clearfix pull-right" >

                                                <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH;?>"> </div>
                                            </div>
                                            <div class="dltbtn">

                                        
                                    </div>
                                </div>
                                 &nbsp;
                                <div class="panel-body">
                                     <?php echo $this->table->generate(); ?>
                                    

                                </div>
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>

            </div>


        </div>
       
    </div>
</div>