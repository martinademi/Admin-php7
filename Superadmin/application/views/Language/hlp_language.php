
<script>
    $(document).ready(function () {
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Language/datatable_language',
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
            
            
        $('#search-table').keyup(function () {
            lan_tbl.fnFilter($(this).val());
        });
        
        
        $('#add_new_lan').click(function () {
            $('#lan_title').html('ADD');
            $('#add_lan').html('ADD');
            $('#lan_edit').val('');
            $('#lan_name').val('');
            $('#lan_msg').val('');
               $('#errorboxADD').text('');
            $('#modal-lan').modal('show');
        });


$('#add_lan').click(function(){
    $('#errorboxADD').text('');
        if ($('#lan_name').val() == '') {
            $('#lan_name').closest('.form-group').addClass('has-error');
           
            return;
        }
        if($('#lan_name').val() == 'english'||  $('#lan_name').val() == 'English' || $('#lan_name').val() == 'ENGLISH' ) {
                    $('#errorboxADD').text("English is default language.. Please enter another Language");
            return;
        }

        $('#lan_name').closest('.form-group').removeClass('has-error');
//        $('#lan_msg').closest('.form-group').removeClass('has-error');
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Language/lan_action",
            type: "POST",
            data: $('#lan_form').serialize(),
            dataType: "JSON",
            success: function (result) {
                if (result.msg == '1') {
                    
                    $('#modal-lan').modal('hide');
                  
                } else {
                    alert('Problem occurred please try agin.');
                }
                var table = $('#big_table');
        setTimeout(function() {
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Language/datatable_language',
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
            },
            error: function () {
                alert('Problem occurred please try agin.');
            },
            timeout: 30000
        });
    });
    
    
$(document).on('click','.btnedit',function(){
$('#errorboxADD').text('');
$('#lan_name'). val('');
    var rowid = $(this).val();
    console.log(rowid);
    $.ajax({
            url: "<?php echo base_url() ?>index.php?/Language/get_lan_hlpTextone/"+rowid,
            type: "POST",
            dataType: "JSON",
            success: function (result) {
                console.log(result);
                $('#lan_name').val(result.lan_name);
                $('#lan_edit').val(result.lan_id);
            }
    }); 
     $('#lan_title').html('UpdateLanguage');
            $('#add_lan').html('Update');
        $('#modal-lan').modal('show');     
});
    
$(document).on('click','.btndelete',function(){
           var size = $('input[name=stickup_toggler]:checked').val();
          var id = $(this).val();
          $('#confirmeds2').attr('data-id',id);
              var modalElem = $('#confirmmodels2');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                }
                else
                {
                    $('#confirmmodels2').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    }
                    else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas2").text( "Are you sure you want to Delete this language ?");
      
    });
    
      $('#confirmeds2').click(function(){
          var ids =  $('#confirmeds2').attr('data-id');
          var del = "del";
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Language/lan_action/"+del,
            type: "POST",
            data: {id: ids},
            dataType: "JSON",
            success: function (result) {
                if (result.msg == '1') {
                    $('#confirmmodels2').modal('hide');
                    setTimeout(function() {
                    $('#success').modal('show');
                     }, 500);
                     var table = $('#big_table');
        setTimeout(function() {
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Language/datatable_language',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url()?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                table.show()
                   $('.cs-loader').hide()
                      
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
                    
                    
                } else {
                    alert('Problem in Deleting language please try agin.');
                }
            },
            error: function () {
                alert('Problem in Deleting language please try agin.');
            },
            timeout: 30000
        });
        });
    
    
    
  
  
$(document).on('click','#btnenable',function(){
  

        var size = $('input[name=stickup_toggler]:checked').val();
              
        var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                }
                else
                {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    }
                    else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text( "Are you sure to enable this language ?");

    
 });   
  $("#confirmeds").click(function () {
var id = $('#btnenable').val();
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Language') ?>/enable_lang",
                        type: 'POST',
                        data: {id: id},
                        dataType: 'json',
                        success: function (result)
                        {
//                            console.log(result);
                           if(result == '1'){
                               $('#confirmmodels').modal('hide');
                                  var table = $('#big_table');

                                var settings = {
                                    "autoWidth": false,
                                    "sDom": "<'table-responsive't><'row'<p i>>",
                                    "destroy": true,
                                    "scrollCollapse": true,
                                    "iDisplayLength": 20,
                                    "bProcessing": true,
                                    "bServerSide": true,
                                    "sAjaxSource": '<?php echo base_url() ?>index.php?/Language/datatable_language',
                                    "bJQueryUI": true,
                                    "sPaginationType": "full_numbers",
                                    "iDisplayStart ": 20,
                                    "oLanguage": {
                                        "sProcessing": "<img src='<?php echo base_url()?>theme/assets/img/ajax-loader_dark.gif'>"
                                    },
                                    "fnInitComplete": function () {
                                        table.show()
                                           $('.cs-loader').hide()                      
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

                              
                            } 
                        }
                    });
                });
 
$(document).on('click','#btndisable',function(){
     

        var size = $('input[name=stickup_toggler]:checked').val()
              
        var modalElem = $('#confirmmodels1');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                }
                else
                {
                    $('#confirmmodels1').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    }
                    else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas1").text( "Are you sure to disable this language ?");
 }); 
      $("#confirmeds1").click(function () {
var id =$('#btndisable').val();
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Language') ?>/disable_lang",
                        type: 'POST',
                        data: {id: id},
                        dataType: 'JSON',
                        success: function (result)
                        {
//                            console.log(result);
                           if(result == '1'){
                                  var table = $('#big_table');
                                    setTimeout(function() {
                                    var settings = {
                                        "autoWidth": false,
                                        "sDom": "<'table-responsive't><'row'<p i>>",
                                        "destroy": true,
                                        "scrollCollapse": true,
                                        "iDisplayLength": 20,
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url() ?>index.php?/Language/datatable_language',
                                        "bJQueryUI": true,
                                        "sPaginationType": "full_numbers",
                                        "iDisplayStart ": 20,
                                        "oLanguage": {
                                            "sProcessing": "<img src='<?php echo base_url()?>theme/assets/img/ajax-loader_dark.gif'>"
                                        },
                                        "fnInitComplete": function () {
                                            table.show()
                                               $('.cs-loader').hide()
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
                              $('#confirmmodels1').modal('hide');
                            } 
                        }
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
    #selectedcity,#companyid{
        display: none;
    }
    
</style>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;">
         
            <strong >LANGUAGE</strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">



                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    
                   
                       <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                          <div class='pull-right'>
                                        <button class='btn btn-primary cls110' id='add_new_lan' style="margin: 10px 5px;">
                                            Add 
                                        </button>
                                    </div>
                           </div>
                    <!-- Tab panes -->
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
      
<div class="modal fade slide-up disable-scroll" id="modal-lan" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id='lan_form' onsubmit='return false;'>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                    <i class="pg-close"></i>
                </button>
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id='lan_title'></h4>
                </div>
                <div class="modal-body m-t-50">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default required">
                                    <label>Language</label>
                                    <input type="text" required name='lan_name' id="lan_name" class="form-control">
                                    <input type="hidden" name='edit_id' id='lan_edit'>
                                </div>
                                <div class="error-box" id="errorboxADD" style="font-size: 14px;text-align:center"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right">
                            <button type='button' class="btn btn-primary btn-block m-t-5" id="add_lan">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo POPUP_DRIVERS_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" style="margin:0;"><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="confirmmodels2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas2" style="font-size: large;text-align:center"><?php echo POPUP_DRIVERS_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" data-id="" class="btn btn-primary pull-right" id="confirmeds2" style="margin:0;"><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="confirmmodels1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas1" style="font-size: large;text-align:center"><?php echo POPUP_DRIVERS_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds1" style="margin:0;"><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="dellan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <span class="modal-title">DELETE LANGUAGE</span>
            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox_logout" style="text-align:center">Are you sure?You want to delete this language.!! ?</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="ok_to_logout" ><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="success" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <span class="modal-title"></span>
            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox_logout" style="text-align:center">Successfully Deleted..!!!</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="ok" data-dismiss="modal" ><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

