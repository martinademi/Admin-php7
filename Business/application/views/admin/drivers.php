<?php
date_default_timezone_set('UTC');
$rupee = "$";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//error_reporting(0);
//error_reporting(E_ALL);

?>
<style>

    .imageborder{
        border-radius: 50%;
    }
  
    .exportOptions{
        display: none;
    }
    .btn-cons {
        margin-right: 5px;
        min-width: 102px;
    }
    .btn{
        font-size: 13px;
    }
    .table {
        width: 100% !important;
        max-width: 100% !important;
        margin-bottom: 20px !important; 
        border-collapse: collapse !important;
      }
      
      table.dataTable {
        /*width: 100% !important;*/
        margin: 0 auto !important;
        clear: both !important;
         border-collapse: collapse !important; 
        border-spacing: 0 !important;
      }
      
      .ui-state-default{
                   /*background: #f6f6f6 url(images/ui-bg_glass_100_f6f6f6_1x400.png) 50% 50% repeat-x !important;*/
                     border: 1px solid #cccccc;
                    font-weight: bold;
                  color: #1c94c4;
      }
                 
     .dataTables_paginate{
                    float: left !important;
                    /*text-align: left !important;*/
                    padding-top: 2.25em !important;
                    margin-left: 15px !important;
              }
             .ui-buttonset .ui-button {
                    margin-left: 0;
                    margin-right: 0.3em;
                  }
              .ui-state-disabled {
                opacity: .35;
                filter: Alpha(Opacity=35);
                background-image: none;
              }

</style>

<script type="text/javascript">
    $(document).ready(function () {
        
        $('.drivers').addClass('active');
        $('.drivers').attr('src', "'<?php echo base_url(); ?>'/theme/icon/restaurant_on.png");
        
        $('#big_table_processing').hide();
 
            $('#chekdel').show();
            $('#add').show();
            $('#editdriver').show();
                
//        alert();
        var status = '0';
//        alert(status);
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
            "sAjaxSource": "<?php echo base_url() ?>index.php/Admin/datatable_drivers/"+status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
//                     "aoColumns": [
//                                { "sWidth": "5%" }, // 1st column width 
//                                { "sWidth": "10%" }, // 2nd column width 
//                                { "sWidth": "10%" }, 
//                                {"sWidth":  "10%" }, 
//                                {"sWidth":  "15%" }, 
//                                {"sWidth":  "15%" }, 
//                                {"sWidth":  "13%" }, 
//                                {"sWidth":  "7%" }, 
//                                {"sWidth":  "5%" }, 
//                               
//                              ],  
            "fnInitComplete": function () {

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
//
        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
//        
 });
        
</script>

<script>
    $(document).ready(function () {
        
         $("#editdriver").click(function () {
//         var status = '<?php // echo $status; ?>';
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                //         alert("please select any one dispatcher");
                 $('#displayData').modal('show');
                $("#display-data").text("Please select any one driver");

            } else if (val.length > 1)
            {
                //     alert("please select only one to edit");
                 $('#displayData').modal('show');
                $("#display-data").text("Please select only one driver to edit");
            }
            else
            {
                window.location = "<?php echo base_url() ?>index.php/Admin/editdriver/" + val;

                $.ajax({
                    url: "<?php echo base_url() ?>index.php/Admin/editdriver",
                    type: "POST",
                    data: {val: val},
                    dataType: 'json',
                    success: function (result)
                    {
//                            $('#confirmmodels').modal('hide');
//
//                            $('.checkbox:checked').each(function (i) {
//                                $(this).closest('tr').remove();
//                            });

                    }
                });

            }
        });
        
        
      $("#chekdel").click(function () {
          
          
           var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
           
//           console.log(val);
//           console.log(val.length);
           
//            alert(val);
           
             if (val.length < 0||val.length == 0) {
                  $('#displayData').modal('show');
              $("#display-data").text("Select at least one driver");
            }
            else if (val.length == 1 || val.length > 1)
            {
//                alert(val);
                $("#display-data").text("");
                       var Id =  val;
//                       alert(Id); 
                 var size = $('input[name=stickup_toggler]:checked').val()
                    var modalElem = $('#deletedriver');
                    if (size == "mini") {
                        $('#modalStickUpSmall').modal('show')
                    } else {
                        $('#deletedriver').modal('show')
                        if (size == "default") {
                            modalElem.children('.modal-dialog').removeClass('modal-lg');
                        } else if (size == "full") {
                            modalElem.children('.modal-dialog').addClass('modal-lg');
                        }
                    }
                       $("#errorboxdata").text("Are you sure you want to delete the selected driver/drivers");
                
               $("#yesdelete").click(function (){

                          $.ajax({
                               url: "<?php echo base_url() ?>index.php/Admin/delete_Drivers",

                               type: "POST",
                                data: {val: Id},
                                dataType: 'json',
                               success: function (response)
                               {
//                                 alert(response);
                                $(".close").trigger("click");
//                                $("#errorboxdata").text("Selected driver/drivers deleted successfully ");
                                
                                location.reload();
                               }
                           });
                           
                       });
              
                 }
            });
        });
    
</script>

<script type="text/javascript">
    $(document).ready(function () {
        
       
       $('.whenclicked li').click(function () {
            if ($(this).attr('id') == "my1") {
                $('#add').show();
                $('#editdriver').show();
                $('#chekdel').show();
                $('#search-table').val('');
        }
           else if ($(this).attr('id') == "my3") {
                $('#add').hide();
                $('#editdriver').show();
                $('#chekdel').show();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "my4") {
                $('#add').hide();
                $('#editdriver').show();
                $('#chekdel').show();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "mo3") {
                $('#add').hide();
                $('#editdriver').hide();
                $('#chekdel').hide();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "mo30") {
                $('#add').hide();
                $('#editdriver').hide();
                $('#chekdel').hide();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "mo567") {
                $('#add').hide();
                $('#editdriver').hide();
                $('#chekdel').hide();
                $('#search-table').val('');
        }
      });

     $('.changeMode').click(function () {

            $('#big_table_processing').toggle();
//            alert($(this).attr('data'));
            var table = $('#big_table');
            $("#display-data").text("");

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
//                    "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
                    $('#big_table_processing').toggle();
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

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');
            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
              
                table.fnFilter($(this).val());
            });

        });

    });

    
</script>

<div class="page-content-wrapper"style="padding-top: 0px">
    
    <div class="content" style="  margin-top: -20px;">
        
        <div class="brand inline" style="  width: auto;
             font-size: 14px;
             color: gray;
             padding-top: 0px;">
          <strong style="color:#0090d9;">DRIVERS</strong>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked" style="margin: 1% 0%;">
            <!--<li id= "my1" class="tabs_active <?php // echo $new ?>" style="cursor:pointer">-->
            <li id= "my0" class="tabs_active active" style="cursor:pointer">
                <a  class="changeMode New_" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/0"><span>New</span></a>
            </li>
            <!--<li id= "my3" class="tabs_active <?php // echo $accept ?>" style="cursor:pointer">-->
            <li id= "my1" class="tabs_active " style="cursor:pointer">
                <a  class="changeMode accepted_" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/1"><span>Accepted</span></a>
            </li>
            <!--<li id= "my4" class="tabs_active <?php // echo $reject ?>" style="cursor:pointer">-->
            <li id= "my2" class="tabs_active " style="cursor:pointer">
                <a  class="changeMode rejected_" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/2"><span>Rejected</span></a>
            </li>
            <!--<li id= "mo3" class="tabs_active <?php // echo $free ?>" style="cursor:pointer">-->
            <li id= "mo3" class="tabs_active " style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/3"><span>Online</span></a>
            </li>
            <!--<li id= "mo30" class="tabs_active <?php // echo $offline ?>" style="cursor:pointer">-->
            <li id= "mo4" class="tabs_active " style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/4"><span>Offline</span></a>
            </li>
            <!--<li id= "mo567" class="tabs_active <?php // echo $booked ?>" style="cursor:pointer">-->
            <li id= "mo5" class="tabs_active " style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/5"><span>Booked</span></a>
            </li>
            
                <div class=""><button class="btn btn-primary pull-right m-t-10" id="chekdel" style="margin-left:10px;margin-top: 5px;background: #d9534f !important;border-color: #d9534f !important;">Delete</button></a></div>
                <div class=""><button class="btn btn-primary pull-right m-t-10 " id="editdriver" style="margin-left:10px;margin-top: 5px;background: #5bc0de !important;border-color: #5bc0de !important;">Edit</button></div>
                <div class=""><a href="<?php echo base_url() ?>index.php/Admin/addnewdriver"> 
                            <button class="btn btn-primary pull-right m-t-10" id="add" style="margin-left:10px;margin-top: 5px;background: #337ab7 !important;border-color: #337ab7 !important;">Add</button></a></div>
            
        </ul>
        
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="padding:0;">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <!--<ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">-->
                        <!--<li id= "my1" class="tabs_active <?php // echo $new ?>" style="cursor:pointer">-->
                        <!--<li id= "my0" class="tabs_active " style="cursor:pointer">
                            <a  class="changeMode New_" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/0"><span>New</span></a>
                        </li>-->
                        <!--<li id= "my3" class="tabs_active <?php // echo $accept ?>" style="cursor:pointer">-->
                        <!--<li id= "my1" class="tabs_active " style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/1"><span>Accepted</span></a>
                        </li>-->
                        <!--<li id= "my4" class="tabs_active <?php // echo $reject ?>" style="cursor:pointer">-->
                        <!--<li id= "my2" class="tabs_active " style="cursor:pointer">
                            <a  class="changeMode rejected_" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/2"><span>Rejected</span></a>
                        </li>-->
                        <!--<li id= "mo3" class="tabs_active <?php // echo $free ?>" style="cursor:pointer">-->
                        <!--<li id= "mo3" class="tabs_active " style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/3"><span>Online</span></a>
                        </li>-->
                        <!--<li id= "mo30" class="tabs_active <?php // echo $offline ?>" style="cursor:pointer">-->
                        <!--<li id= "mo4" class="tabs_active " style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/4"><span>Offline</span></a>
                        </li>-->
                        <!--<li id= "mo567" class="tabs_active <?php // echo $booked ?>" style="cursor:pointer">-->
                        <!--<li id= "mo5" class="tabs_active " style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url() ?>index.php/Admin/datatable_drivers/5"><span>Booked</span></a>
                        </li>
                        
                            <div class=""><button class="btn btn-primary pull-right m-t-10" id="chekdel" style="margin-left:10px;margin-top: 5px">Delete</button></a></div>
                            <div class=""><button class="btn btn-primary pull-right m-t-10 " id="editdriver" style="margin-left:10px;margin-top: 5px">Edit</button></div>
                            <div class=""><a href="<?php echo base_url() ?>index.php/Admin/addnewdriver"> 
                                        <button class="btn btn-primary pull-right m-t-10" id="add" style="margin-left:10px;margin-top: 5px">Add</button></a></div>
                      
                    </ul>-->
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                   <!--<div class="error-box" id="display-data" style="text-align:center"></div>-->
                                   <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog modal-sm">                                        
                                        <!-- Modal content-->
                                            <div class="modal-content">                                            
                                                <div class="modal-body">
                                                <h5 class="error-box" id="display-data" style="text-align:center"></h5>                                            
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>  
                                    <!--<div id="big_table_processing" class="dataTables_processing" style="">
                                        <img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif">
                                    </div>-->

                                    <div class="" style="">
                                        <div class="pull-right" style="margin: 1% 0%;">
                                            <input type="text" id="search-table" class="form-control pull-right" placeholder="Search"> 
                                        </div>
                                   </div>
                                </div> 
                                &nbsp;
                        
                                <div class="panel-body">
                     
                                        <?php echo $this->table->generate(); ?>
                                 <!-- END PANEL -->
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
        <!-- END JUMBOTRON -->
        </div>
    <!-- END PAGE CONTENT -->

    </div>

       <div class="modal fade stick-up" id="deletedriver" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorbox" style="font-size: large;text-align:center">Are you sure you want to delete the selected driver/drivers</div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="yesdelete" >Yes</button>
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