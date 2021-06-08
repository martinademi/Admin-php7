<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);

if ($status == 1) {
    $passenger_status = 'active';
    $active = "active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
} else if ($status == 2) {
    $passenger_status = 'deactive';
    $deactive = "active";
}
?>
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    
    /*.ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}*/
</style>
<script type="text/javascript">
     var currentTab = '<?php echo $status; ?>';
    $(document).ready(function () {
            var table = $('#big_table');
            var searchInput = $('#search-table');
           searchInput.hide();
            table.hide();
        setTimeout(function() {
        
         var status = '<?php echo $status; ?>';
      
      
       if(status == 1){
                $('#delete').show();
                 $('#btnStickUpSizeToggler').show();
                 $('#deletes').hide();
                 
                  $('#vehiclemodal_addbutton').hide();
                  

              }
              
              

        
          var settings = {
              "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_vehiclemodels/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ":20,
            "oLanguage": {
//                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function() {
                //oTable.fnAdjustColumnSizing();
//                 $('#big_table_processing').hide();
                  table.show()
                   $('.cs-loader').hide()
                   searchInput.show()
            },
            'fnServerData': function(sSource, aoData, fnCallback)
            {
                $.ajax
                ({
                    'dataType': 'json',
                    'type'    : 'POST',
                    'url'     : sSource,
                    'data'    : aoData,
                    'success' : fnCallback
                });
            }
        };



        
        table.dataTable(settings);
        }, 1000);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

    
        
        $('.changeMode').click(function () {

            var table = $('#big_table');
            
            var tab_id =  $(this).attr('data-id');
            
           
            
            if(tab_id != currentTab)
            {
                 table.hide();
                currentTab = tab_id;

                 if($(this).attr('id') == 1){
                     $('#delete').show();
                      $('#btnStickUpSizeToggler').show();
                      $('#deletes').hide();
                       $('#vehiclemodal_addbutton').hide();

     //                   $('#big_table').find('td:eq(2),th:eq(2)').hide();
     //            $('#big_table').find('td:eq(3),th:eq(3)').hide();
                 }
                 else if($(this).attr('id') == 2){
                       $('#delete').hide();
                      $('#btnStickUpSizeToggler').hide();
                      $('#deletes').show();
                       $('#vehiclemodal_addbutton').show();
     //                  
     //                    $('#big_table').find('td:eq(1),th:eq(1)').hide();
     //                   $('#big_table').find('td:eq(2),th:eq(2)').show();
     //            $('#big_table').find('td:eq(3),th:eq(3)').show();
                  }

                   

                 location.href =  $(this).attr('data');
            }
           

        });
    });
</script>


<script>
    $(document).ready(function () {
          $("#define_page").html("Vehicle Model");
          
           $('.vehicle_models').addClass('active');
           $('.vehicle_models').attr('src',"<?php echo base_url();?>/theme/icon/vehicele model_on.png");
//        $('.vehicle_models_thumb').addClass("bg-success");
          
// 

$('#typeid').change(function ()
{
    $('#makeName').val($('#typeid option:selected').attr('make'));
});
        
        
        $('#btnStickUpSizeToggler').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if(val.length == 0){
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModal');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#myModal').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
        }else{
            $('#alertForNoneSelected').modal('show');
                 $("#display-data").text("Invalid Selection");
        }
        });
        
           $('.error-box-class').keypress(function(){
            $('.error-box').text('');
        });

        
        
        
        $('#vehiclemodal_addbutton').click(function () {
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModals');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#myModals').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
            
            $('#typeid').val('0');
            $('#modalname').val('');
        });
        
        
        $('#searchData').click(function () {


            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

            $('#createcontrollerurl').attr('href', '<?php echo base_url() ?>index.php?/superadmin/Get_dataformdate/' + st + '/' + end);

        });

        $('#search_by_select').change(function () {


            $('#atag').attr('href', '<?php echo base_url() ?>index.php?/superadmin/search_by_select/' + $('#search_by_select').val());

            $("#callone").trigger("click");
        });
        
        
        //EDIT MAKE
        $('#editMake').click(function ()
        {
              $(".errors").text("");
             $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            
            
             if (val.length == 0) {
                 $('#alertForNoneSelected').modal('show');
                 $("#display-data").text("Please select any one brand name to edit");
             }
             else  if (val.length > 1) {
                 $('#alertForNoneSelected').modal('show');
                 $("#display-data").text("Please select only one brand name to edit");
             }
             else{
                  
                 $('#typename_e').val($('.checkbox:checked').parent().prev().text());
                 $('#typename_id_e').val($('.checkbox:checked').val());
                 $('#editMakeModal').modal('show');
                 
             }
        });
        //EDIT MODEL
        $('#editModel').click(function ()
        {
            
            console.log($('.checkbox:checked').val());
             $("#display-data").text("");
             $(".errors").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            
            
             if (val.length == 0) {
                 $('#alertForNoneSelected').modal('show');
                 $("#display-data").text("Please select any one brand name to edit");
             }
             else  if (val.length > 1) {
                
                 $('#alertForNoneSelected').modal('show');
                 $("#display-data").text("Please select only one brand name to edit");
             }
             else{
                 
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/getMakeDetails",
                        type: "POST",
                        data: {id: $('.checkbox:checked').val()},
                        dataType: 'json',
                        success: function (result) {
                            $.each(result.data,function (index,row)
                            {
                                 $('#select_make_edit').val(row.Makeid.$oid);
                                 $('#makeEdit').val(row.makeName);
                                 $('#modalname_e').val(row.Name);
                                 $('#model_id').val(row._id.$oid);
                            });
                            
                            
                        }
                    });
                    $('#editModelModal').modal('show');
                 
             }
        });
        
        $('#select_make_edit').change(function ()
        {
            $('#makeEdit').val($('#select_make_edit option:selected').attr('make'));
        });
        


        $("#chekdel").click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length > 0) {
                if (confirm("Are you sure to Delete " + val.length + " Vehicle")) {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deleteVehicles",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result) {
                            alert(result.affectedRows)

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });
                        }
                    });
                }

            } else {
                alert("Please mark any one of options");
            }

        });
        
        $("#delete").click(function(){
                     $("#display-data").text("");
         
                    var val = $('.checkbox:checked').map(function () {
                       return this.value;
                   }).get();
            
                        if (val.length > 0) {
                
                   
                         $('#deleteMake').modal('show');
                         
                       $("#errorboxdata").text(<?php echo json_encode(POPUP_VEHICLE_MAKE);?>);
                       
                     

                       $("#confirmed").click(function(){
                       

                           $.ajax({
                               url: "<?php echo base_url('index.php?/superadmin') ?>/addEditVehicleMake/delete",
                               type: "POST",
                               data: {val: val},
                               dataType: 'json',
                               success: function (result)
                               {
                                   $(".close").trigger('click');
                                   $('.checkbox:checked').each(function (i) {
                                       $(this).closest('tr').remove();
                                   });
                                    
                               }
                           });
                       //}

                   });
            }
            else
            {
                  $('#alertForNoneSelected').modal('show');
                 $("#display-data").text("Please select atleast one brand name to delete");
          }
           
        });
        
        
         $("#deletes").click(function(){
         
          $("#display-data").text("");
         
             var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).
                    get();
                    
            if (val.length > 0) {
                
                
                            var size = $('input[name=stickup_toggler]:checked').val()
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
                  $("#errorboxdatas").text(<?php echo json_encode(POPUP_VEHICLETYPE);?>);

              $("#confirmeds").click(function(){
                {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/addEditVehicleModel/delete",
                       type: "POST",
                        data: {id: val},
                        dataType: 'json',
                        success: function (result)
                        {
                             $(".close").trigger('click');
                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });
                             
                        }
                    });
                }

            });
            }
            else
            {
                  $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select atleast one brand name to delete");
            }

        });
        
        
        
        $("#insert").click(function () {
        $("#insert_data").text("");
           var text = /^[a-zA-Z ]*$/;
           var typename = $("#typename").val();

            if (typename == "" || typename == null)
            {
                $("#insert_data").text(<?php echo json_encode(VEHICLE_MAKE_ERR); ?>);
            }
//            else if (!text.test(typename))
//            {
////                alert("please enter type name as text");
//                $("#insert_data").text(<?php echo json_encode(POPUP_VEHICLEMODEL_TEXT); ?>);
//            }
           
            else
            {



                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addEditVehicleMake/add",
                    type: 'POST',
                    data: {
                       typename:typename
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if(response.flag == 0)
                        {
                                $("#typename").val('');
                                $(".close").trigger('click');
                                 var table = $('#big_table');
                                   var settings = {
                                       "autoWidth": false,
                                     "sDom": "<'table-responsive't><'row'<p i>>",
                                     "destroy": true,
                                     "scrollCollapse": true,
                                     "iDisplayLength": 20,
                                     "bProcessing": true,
                                     "bServerSide": true,
                                     "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_vehiclemodels/1',
                                     "bJQueryUI": true,
                                     "sPaginationType": "full_numbers",
                                     "iDisplayStart ":20,
                                     "oLanguage": {

                                     },
                                     "fnInitComplete": function() {
                                         //oTable.fnAdjustColumnSizing();
                                          $('#big_table_processing').hide();
                                     },
                                     'fnServerData': function(sSource, aoData, fnCallback)
                                     {
                                         $.ajax
                                         ({
                                             'dataType': 'json',
                                             'type'    : 'POST',
                                             'url'     : sSource,
                                             'data'    : aoData,
                                             'success' : fnCallback
                                         });
                                     }
                                 };

                                 table.dataTable(settings);
                          }
                          else{
                            $('.responseErr').text(response.msg);
                          }
                    }
                   
                    

                });
            }
       });
        $("#updateMake").click(function () {
          
           var m_name = $("#typename_e").val();

            if (m_name == "" || m_name == null)
            {
                $("#errorMakeEdit").text('<?php echo VEHICLE_MAKE_ERR;?>');
            }else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addEditVehicleMake/edit",
                    type: 'POST',
                    data: {
                    m_name:m_name,id:$('#typename_id_e').val()},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        console.log(response);
                        $("#typename").val('');
                        $(".close").trigger('click');
                         
                          var table = $('#big_table');
                            var settings = {
                                "autoWidth": false,
                              "sDom": "<'table-responsive't><'row'<p i>>",
                              "destroy": true,
                              "scrollCollapse": true,
                              "iDisplayLength": 20,
                              "bProcessing": true,
                              "bServerSide": true,
                              "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_vehiclemodels/1',
                              "bJQueryUI": true,
                              "sPaginationType": "full_numbers",
                              "iDisplayStart ":20,
                              "oLanguage": {
                  
                              },
                              "fnInitComplete": function() {
                                  //oTable.fnAdjustColumnSizing();
                                   $('#big_table_processing').hide();
                              },
                              'fnServerData': function(sSource, aoData, fnCallback)
                              {
                                  $.ajax
                                  ({
                                      'dataType': 'json',
                                      'type'    : 'POST',
                                      'url'     : sSource,
                                      'data'    : aoData,
                                      'success' : fnCallback
                                  });
                              }
                          };

                          table.dataTable(settings);
                    }
                });
            }
       });
        $("#updateModel").click(function () {
        
            $('.errors').text('');
           var makeID = $("#select_make_edit").val();
           var model_name = $("#modalname_e").val();
           var model_id = $("#model_id").val();

            if (makeID == "0")
            {
                $("#selectMake_e_Error").text('Please select brand name');
            }
            else if (model_name == "" || model_name == null)
            {
                $("#model_e_Error").text('Please enter brand name');
            }
            else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addEditVehicleModel/edit",
                    type: 'POST',
                    data: {makeID:makeID,model_id:model_id,model_name:model_name,makeName:$('makeEdit').val()},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $("#typename").val('');
                        $(".close").trigger('click');
                         
                          var table = $('#big_table');
                            var settings = {
                                "autoWidth": false,
                              "sDom": "<'table-responsive't><'row'<p i>>",
                              "destroy": true,
                              "scrollCollapse": true,
                              "iDisplayLength": 20,
                              "bProcessing": true,
                              "bServerSide": true,
                              "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_vehiclemodels/2',
                              "bJQueryUI": true,
                              "sPaginationType": "full_numbers",
                              "iDisplayStart ":20,
                              "oLanguage": {
                  
                              },
                              "fnInitComplete": function() {
                                  //oTable.fnAdjustColumnSizing();
                                   $('#big_table_processing').hide();
                              },
                              'fnServerData': function(sSource, aoData, fnCallback)
                              {
                                  $.ajax
                                  ({
                                      'dataType': 'json',
                                      'type'    : 'POST',
                                      'url'     : sSource,
                                      'data'    : aoData,
                                      'success' : fnCallback
                                  });
                              }
                          };

                          table.dataTable(settings);
                       
                    }
                   
                    

                });
            }
       });
        
        $("#inserts").click(function () {
        $(".errors").text("");

           var text = /^[a-zA-Z ]*$/;
           var typeid = $("#typeid").val();
           var modal = $("#modalname").val();

            if (typeid == "0")
            {

                 $("#make_name_Error").text(<?php echo json_encode(POPUP_VEHICLEMODEL_TYPENAME); ?>);
            }

            else if (modal =="" || modal== null)
            {

                 $("#model_name_Error").text(<?php echo json_encode(POPUP_VEHICLEMODEL_MODELNAME); ?>);
            }
           
            else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addEditVehicleModel/add",
                    type: 'POST',
                    data: {
                       typeid:typeid,
                       modal:modal,
                       makeName:$('#makeName').val()
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {

                         if(response.flag == 0)
                        {
                                    $("#typeid").val('');
                                     $("#modalname").val('');

                                  $(".close").trigger('click');

                                  var table = $('#big_table');
                                    var settings = {
                                        "autoWidth": false,
                                      "sDom": "<'table-responsive't><'row'<p i>>",
                                      "destroy": true,
                                      "scrollCollapse": true,
                                      "iDisplayLength": 20,
                                      "bProcessing": true,
                                      "bServerSide": true,
                                      "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_vehiclemodels/2',
                                      "bJQueryUI": true,
                                      "sPaginationType": "full_numbers",
                                      "iDisplayStart ":20,
                                      "oLanguage": {

                                      },
                                      "fnInitComplete": function() {
                                          //oTable.fnAdjustColumnSizing();
                                           $('#big_table_processing').hide();
                                      },
                                      'fnServerData': function(sSource, aoData, fnCallback)
                                      {
                                          $.ajax
                                          ({
                                              'dataType': 'json',
                                              'type'    : 'POST',
                                              'url'     : sSource,
                                              'data'    : aoData,
                                              'success' : fnCallback
                                          });
                                      }
                                  };
                                  table.dataTable(settings);
                          }
                          else{
                           $('.responseErr1').text(response.msg);
                          }
                    }
//                     $(".close").trigger('click');

                });
            }

        });

        
        

    });

</script>

<style>
    .exportOptions{
        display: none;
    }
</style>

<div class="page-content-wrapper"style="">
    <!-- START PAGE CONTENT -->
    <div class="content">
        
        <div class="brand inline" style="  width: auto;">
       

           <strong>VEHICLE MODELS</strong>
        </div>
        <!-- START JUMBOTRON -->
          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">


                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked">
                        <li id="1" class="tabs_active  <?php echo ($status == 1 ? "active" : ""); ?>">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/vehicle_models/1" data-id="1"><span><?php echo LIST_VEHICLEMAKE;?></span></a>
                        </li>
                        <li id="2" class="tabs_active  <?php echo ($status == 2 ? "active" : ""); ?>">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/vehicle_models/2" data-id="2"><span><?php echo LIST_VEHICLEMODELS;?> </span></a>
                        </li>

                                            
                                        

                        <?php if($status == 1){?>
                             <div class="pull-right m-t-10 lastButton cls111"><button class="btn btn-danger btn-cons " id="delete"><?php echo BUTTON_DELETE;?></button></div>
                             <div class="pull-right m-t-10 cls111"><button class="btn btn-info btn-cons " id="editMake">Edit</button></div>
                             <div class="pull-right m-t-10 cls110"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler" ><?php echo BUTTON_ADD;?></button></div>
                           
                        <?php } ?>
                           

                      <?php if($status == 2){?>
                             <div class="pull-right m-t-10 lastButton cls111"><button class="btn btn-danger btn-cons" id="deletes"><?php echo BUTTON_DELETE;?></button></div>
                             <div class="pull-right m-t-10 cls111"><button class="btn btn-info btn-cons " id="editModel">Edit</button></div>
                              <div class="pull-right m-t-10 cls110"> <button class="btn btn-primary btn-cons" id="vehiclemodal_addbutton" ><?php echo BUTTON_ADD;?></button></div>
                        

                        <?php } ?>
                       
 
                    </ul>
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
                                       
                                       <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search "> </div>
                                               
                                </div>
                               &nbsp;
                                <div class="panel-body">
                                     <?php echo $this->table->generate(); ?>
                               </div>
                            </div>
<!--                             END PANEL -->
                        </div>
                    </div>
                </div>
              </div>


        </div>
    
</div>
</div>
 

<div class="modal fade stick-up" id="deleteMake" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
                <div class="modal-content">
                     <div class="modal-header">
                             <span class="modal-title" >DELETE</span>
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                     
                        </div>
                   
                     <div class="modal-body">
                             <div class="row">
                             
                                <div class="error-box" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE;?></div>
                               
                            </div>
                        </div>
                  

                    <div class="modal-footer">
                           
                                 <div class="col-sm-4" ></div>
                                <div class="col-sm-8" >
                                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="confirmed" >Delete</button></div>
                                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                                </div>
                           
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
    </div> 
 
            
  
<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
             <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <span class="modal-title" >ADD BRAND NAME</span>
                   
                </div>

            <div class="modal-body">
                 <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
              
                            <div class="form-group" class="formex">
                                  <label for="fname" class="col-sm-3 control-label">Brand Name<span style="color:red;font-size: 12px"> *</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text"  id="typename" name="typename"  class="form-control error-box-class" placeholder="">

                                    </div>
                                    <div class="col-sm-3 error-box errors" id="insert_data">
                                        
                                    </div>
                                        
                                </div>
                 </form>

                   
                </div>
              <div class="modal-footer">
                  
                        <div class="col-sm-4 error-box errors responseErr"></div>
                        <div class="col-sm-8" >
                            <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="insert" ><?php echo BUTTON_ADD;?></button></div>
                            <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        </div>
              </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<div class="modal fade stick-up" id="editMakeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
             <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <span class="modal-title" >EDIT</span>
                   
                </div>

            <div class="modal-body">
                 <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
              
                            <div class="form-group" class="formex">
                                  <label for="fname" class="col-sm-3 control-label">Brand Name<span style="color:red;font-size: 12px"> *</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text"  id="typename_e" name="typename_e"  class="form-control error-box-class" placeholder="" value="">
                                        <input type="hidden"  id="typename_id_e">

                                    </div>
                                    <div class="col-sm-3 error-box errors" id="errorMakeEdit">
                                        
                                    </div>
                                        
                                </div>
                 </form>

                   
                </div>
              <div class="modal-footer">
                  
                        <div class="col-sm-4 error-box errors" id="insert_data" ></div>
                        <div class="col-sm-8" >
                            <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="updateMake" >Update</button></div>
                            <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        </div>
              </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

        
        
        <div class="modal fade stick-up" id="myModals" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <span class="modal-title" >ADD MODEL</span> 
                    </div>
                     <div class="modal-body">
                          <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                     <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label" id="">Brand Name<span style="color:red;font-size: 12px"> *</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="typeid" name="country_select"  class="form-control error-box-class" >
                                    <option value="0">Select vehicle type</option>
                                    <?php
                                    foreach ($vehiclemake as $each) {

                                        echo "<option value=" . $each['_id']['$oid']. " make='".$each['Name']."'>" . $each['Name']. "</option>";
                                    }
                                    ?>

                                </select>
                                <input type="hidden" id="makeName" name="makeName">
                            </div>
                          <div class="col-sm-3 error-box errors" id="make_name_Error" ></div>
                       </div>
                              
                         <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_VEHICLEMODEL_MODAL;?><span style="color:red;font-size: 12px"> *</span></label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                     <input type="text"  id="modalname" name="typename"  class="form-control" placeholder="">
                                  </div>
                                   <div class="col-sm-3 error-box errors" id="model_name_Error" ></div>
                            </div>
                          
                   
                    </form>
                </div>
                    <div class="modal-footer">
                        <div class="col-sm-4 errors responseErr1" ></div>
                      
                        <div class="col-sm-8">
                            <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="inserts" ><?php echo BUTTON_ADD;?></button></div>
                             <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        </div>
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
        <div class="modal fade stick-up" id="editModelModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <span class="modal-title" >EDIT</span> 
                    </div>
                     <div class="modal-body">
                          <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                     <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label" id=""><?php echo FIELD_VEHICLEMODEL_SELECTTYPE;?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <select id="select_make_edit" name="select_make_edit"  class="form-control error-box-class" >
                                <option value="0">Select vehicle type</option>
                                <?php
                               foreach ($vehiclemake as $each) {

                                        echo "<option value=" . $each['_id']['$oid']. " make ='".$each['Name']."'>" . $each['Name']. "</option>";
                                    }
                                ?>

                            </select>
                            <input type="hidden" id="makeEdit" name="makeEdit">
                        </div>
                         <div class="col-sm-3 error-box errors" id="selectMake_e_Error"></div>
                     </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_VEHICLEMODEL_MODAL;?><span style="color:red;font-size: 12px"> *</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text"  id="modalname_e" name="modalname_e"  class="form-control" placeholder="">
                                <input type="hidden"  id="model_id" name="model_id">
                            </div>
                         <div class="col-sm-3 error-box errors" id="model_e_Error">
                        </div>
                   </div>
                          
                   
                    </form>
                </div>
                    <div class="modal-footer">
                       
                        <div class="col-sm-4 error-box errors" id="inserts-data" ></div>
                        <div class="col-sm-8" >
                            <div class="pull-right m-t-10"><button type="button" class="btn btn-success pull-right" id="updateModel" >Update</button></div>
                            <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        </div>
                    </div>
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
                                <span class="modal-title"> DELETE</span>
                     
                        </div>
                    <br>
                     <div class="modal-body">
                             <div class="row">
                             
                                <div class="error-box" id="errorboxdatas" style="text-align:center"><?php echo VEHICLEMODEL_DELETE;?></div>
                               
                            </div>
                        </div>
                    
                    <br>

                    <div class="modal-footer">
                             <div class="row">
                                
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8" >
                                    
                                     <div class="pull-right m-t-10"><button type="button" class="btn btn-danger pull-right" id="confirmeds" >Delete</button> <div class="pull-right m-t-10">
                                     <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            </div>
            </div>

   