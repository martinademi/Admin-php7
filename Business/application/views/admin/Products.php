
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .imageborder{
        border-radius: 50%;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>


<script type="text/javascript">
    $(document).ready(function () {

        $("#define_page").html("Passengers");

        $('.passengers').addClass('active');
        $('.passengers').attr('src', "<?php echo base_url(); ?>/theme/icon/passanger_on.png");

        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {
            $('#big_table_processing').show();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 50,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/Business/datatablePoducts',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 50,
                "oLanguage": {

                },
                "fnInitComplete": function () {
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
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
        }, 1000);

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
<div class="page-content-wrapper"style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content" >

        <!-- <div class="brand inline" style="  width: auto;            
             color: gray;
             font-size: 16px;
             margin-left: 30px;padding-top: 20px;">

            <strong style="color:#0090d9;">STORE PRODUCTS</strong>
        </div> -->
        <!-- id="define_page"-->
        <div class="brand inline" style="  width: auto;">
            store products        
        </div>
        <div id="test"></div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">


        </ul>
        <div class="parallax" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?> "> </div>
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
