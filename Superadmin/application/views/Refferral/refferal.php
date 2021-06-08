<script src="<?= base_url() ?>theme/assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url() ?>theme/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<link href="<?= base_url() ?>theme/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" media="screen">
<script src="<?= base_url() ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script>

       
 
    $(document).ready(function () {
          $('#activate').hide();
        var table = $('#big_table');
          table.hide();
        setTimeout(function() {
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Referral/datatable_Refferral/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url()?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                table.show()
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

        // search box for table
        $('#search-table').keyup(function () {
       
            table.fnFilter($(this).val());
        });
        
            }, 1000);
            
           var currentTab = 1; 
            
            
            
   $('.changeMode').click(function () {
        

        var tab_bar = $(this).attr('data-id');
        if(tab_bar == 1){
            $('#activate').hide();
            $('#deactivate').show();
        }else{
            $('#deactivate').hide();
             $('#activate').show();
        }        
        if(tab_bar != currentTab)
        {
            currentTab = tab_bar;

            var table = $('#big_table');
             table.hide();

              $('#big_table_processing').show();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                  
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
                     table.show()
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

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');



            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });
            }

        });
        
        $('#activate').click(function(){
         var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
              if (val.length == 0) {
                //  alert("please select atleast one company");
                $("#generalPopup").modal("show");
            }
             else if (val.length > 0) {
               $('.hitTosure').attr('data-id',val);
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#modalSlideUpSmall');
                if (size == "mini") {
                    $('#modalSlideUpSmall').modal('show')
                } else {
                    $('#modalSlideUpSmall').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_REJECTED); ?>);

             
            }
        });
        $('#deactivate').click(function(){
        var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
              if (val.length == 0) {
                //  alert("please select atleast one company");
                $("#generalPopup").modal("show");
            }
             else if (val.length > 0) {
               $('.deactivate').attr('data-id',val);
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#modalSlideUpSmallone');
                if (size == "mini") {
                    $('#modalSlideUpSmallone').modal('show')
                } else {
                    $('#modalSlideUpSmallone').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
              }
        });
        
        
        $('#view').click(function(){
             var val = $('.checkbox:checked').attr('data-id');
              if (val.length == 0) {
                //  alert("please select atleast one company");
                $("#generalPopup").modal("show");
                                
            }else if(val.length > 0) {
                window.location.href ='<?php echo base_url()?>index.php?/Referral/viewrefferal/'+val;
            }
            
        });
        
        
        $('.deactivate').click(function(){
            var mongoid = $('#btndeactivate').attr('data-id');
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Referral/inactiveReferral",
                type: "POST",
                data: {'mongoid': mongoid},
                dataType: "JSON",
                success: function (result) {
                    if(result.msg == 1) {
                       var table = $('#big_table');
          table.hide();
        setTimeout(function() {
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Referral/datatable_Refferral/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url()?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                table.show()
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

        // search box for table
        $('#search-table').keyup(function () {
       
            table.fnFilter($(this).val());
        });
        
            }, 1000);
                   }
//                      $( "#refid" ).load(window.location.href + " #refid" );
                },
                error: function () {
                    alertMessage('Problem occurred please try agin.');
                    $('.submitDataOnserver').prop("disabled", false);
                    $('.content').waitMe('hide');
                },
                timeout: 30000
            });
        });
   
        $('.hitTosure').click(function () {
         var mongoid = $('#hittosure').attr('data-id');
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Referral/activeReferral",
                type: "POST",
                data: {'mongoid': mongoid},
                dataType: "JSON",
                success: function (result) {
                    if(result.msg == 0) {
                       var table = $('#big_table');
          table.hide();
        setTimeout(function() {
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Referral/datatable_Refferral/2',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url()?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                table.show()
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

        // search box for table
        $('#search-table').keyup(function () {
       
            table.fnFilter($(this).val());
        });
        
            }, 1000);
                   }
//                      $( "#refid" ).load(window.location.href + " #refid" );
                },
                error: function () {
                    alertMessage('Problem occurred please try agin.');
                    $('.submitDataOnserver').prop("disabled", false);
                    $('.content').waitMe('hide');
                },
                timeout: 30000
            });
        });

        
    });
    
   

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
    .dropdown-menu{
        z-index: 1100 !important;
    }
    .clickable_but {
    background: #7dc1fb;
    padding: 10px 11px;
    border-radius: 5px;
    color: #fff;
    margin-top: 10px;
    margin-left: 12px;
}
#refid{
    padding: 15px 15px 15px 15px;
}
.btncls{
    color: #fff;
}
.btn {
    border-radius: 25px !important;
}
</style>

<div class="content">
    <div class="container-fluid container-fixed-lg">
        <div class="container-md-height m-b-20">
            <div class="panel panel-transparent">
                <ul class="nav nav-tabs nav-tabs-simple bg-white m-t-20" role="tablist" data-init-reponsive-tabs="collapse">
                    <li class="active">
                        <a><strong style="font-size: 14px;color:#0090d9;">REFERRALS</strong></a>
                    </li>
                </ul>
                    <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

                    <li id="1" class="tabs_active active" style="cursor:pointer;text-transform:uppercase;">
                        <a  class="changeMode"   data="<?php echo base_url(); ?>index.php/Referral/datatable_Refferral/1" data-id="1"><span><?php echo LIST_ACCEPTED; ?> </span></a>
                    </li>
                    <li id="2" class="tabs_active" style="cursor:pointer;text-transform:uppercase;">
                        <a  class="changeMode"   data="<?php echo base_url(); ?>index.php/Referral/datatable_Refferral/2" data-id="2"><span><?php echo LIST_REJECTED; ?></span></a>
                    </li>
                
                           <!--<div id="add" class="pull-right m-t-10"><a href="<?php echo base_url() ?>index.php?/Referral/createReferal"><button id="show-modal" class="btn btn-primary btn-cons m-t-10" ><i class="fa fa-plus"></i> VIEW </button></a></div>-->
                        <div class="pull-right m-t-10"> <button class="btn btn-primary  " id="view" >VIEW</button></div>
                        <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons action_buttons" id="deactivate"><?php echo BUTTON_REJECT; ?></button></div>

                        <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons action_buttons" id="activate" ><?php echo BUTTON_ACTIVATE; ?></button></div>


                        <div id="add" class="pull-right m-t-10"><a href="<?php echo base_url() ?>index.php?/Referral/createReferal"><button id="show-modal" class="btn btn-info  btn-cons m-t-10" ><i class="fa fa-plus"></i> CREATE </button></a></div>



                </ul>

            
                <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
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
                             
                                <div class="panel-body" style="margin-top: 1%;">

                                    <?php

                                    echo $this->table->generate();
                                    ?>

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

<div class="modal fade slide-up disable-scroll in" id="generalPopup" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                 <div class="modal-header">

               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <span class="modal-title"></span>
            </div>
                <div class="modal-body text-center m-t-20">
                    <h4 class="no-margin p-b-10">Please select any of the promocode,to perform the action...!!</h4>
                    <button type="button" class="btn btn-primary btn-cons " data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<div class="modal fade slide-up disable-scroll in" id="modalSlideUpSmall" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                 <div class="modal-header">

               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <span class="modal-title"></span>
            </div>
                <div class="modal-body text-center m-t-20">
                    <h4 class="no-margin p-b-10">Are you sure want to Activate the Referral Code ?</h4>
                    <button type="button" class="btn btn-primary btn-cons hitTosure" id="hittosure" data-id="" data-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div class="modal fade slide-up disable-scroll in" id="modalSlideUpSmallone" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                 <div class="modal-header">

               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <span class="modal-title"></span>
            </div>
                <div class="modal-body text-center m-t-20">
                    <h4 class="no-margin p-b-10">Are you sure want to Inactive the Referral Code ?</h4>
                    <button type="button" id="btndeactivate" class="btn btn-primary btn-cons deactivate" data-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>