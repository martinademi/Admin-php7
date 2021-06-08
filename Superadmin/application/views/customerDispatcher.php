
<style>
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

    .exportOptions{
        display: none;
    }
</style>
<script>
            var custID = '<?php echo $custID; ?>';
    $(document).ready(function () {
      
        $('#delete').click(function () {
         $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
            } else if (val.length == 1 || val.length > 1)
            {              
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }



                $("#del").click(function () {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deleteDispatch",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
                                      
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/dt_customerDispatch/<?php echo $custID;?>',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                  
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
                                $('#confirmmodel').modal('hide');
                                                }
                                            });
                });
//                $("#display-data").text(<?php // echo json_encode(POPUP_DELETE_DELETE_FRANCHISE);                                                   ?>);
            }

        });
        
        
        $('#inactive').click(function () {
         $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
            } else if (val.length == 1 || val.length > 1)
            {              
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#banmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#banmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#ban").click(function () {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/banDispatch",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
                                      
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/dt_customerDispatch/<?php echo $custID;?>',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                               
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
                                $('#banmodel').modal('hide');
                                                }
                        });
                });

            }

        });
        
        $('#active').click(function () {
         $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
            } else if (val.length == 1 || val.length > 1)
            {              
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#banmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#banmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#ban").click(function () {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/activeDispatch",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
                                      
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/dt_customerDispatch/<?php echo $custID;?>',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                               
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
                                $('#banmodel').modal('hide');
                                                }
                        });
                });

            }

        });
        
        
        
        
        $('#resetpassword').click(function () {
          $('.errors').text('');
         $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
           
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
            } else if (val.length == 1 || val.length > 1)
            {              
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#resetpass');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#resetpass').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#reset").click(function () {
                    $('.errors').text('');
                     var newpass = $('#password').val();
                     if(newpass == '')
                     {
                         $('#newpasswordErr').text('Please enter the password');
                     }
                   else{
                       
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/resetpassDispatch",
                        type: 'POST',
                        data: {val: val,newpass:newpass},
                        dataType: 'json',
                        success: function (response)
                        {
                                      
                         $('#big_table_processing').show();
                         
                         $('.close').trigger('click');
         
                            var table = $('#big_table');

                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/dt_customerDispatch/<?php echo $custID;?>',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                               
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
                                $('#banmodel').modal('hide');
                            }
                           
                        });
                        }
                });

            }

        });
        
        $('#add').click(function ()
        {
             $('.errors').text('');
            $('#addDispatcherForm')[0].reset();
            $('#addModal').modal('show');
        });
          
         $('#insert').click(function () {
          $('.errors').text('');
          var name = $('#dispname').val();
          var email = $('#dispemail').val();
          var pass = $('#disppass').val();
          var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; 
          
          if(name == ''){
              $('#errname').text('Please enter the name ');
          }
          else if(email == ''){
              $('#erremail').text('Please enter the email');
          }
          else if(!emails.test(email)){
              $('#erremail').text(<?php echo json_encode(POPUP_DRIVER_DRIVER_YOUREMAIL); ?>);
          }
          else if(pass == ''){
               $('#errpass').text('Please enter the password');
          }
          else{
               $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/insertDispatch",
                    type: 'POST',
                    data: {
                       name:name,
                        email: email,
                        password: pass,
                        custID:'<?php echo $custID;?>'
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        
                        $('.close').trigger('click');
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
                                        "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/dt_customerDispatch/<?php echo $custID;?>',
                                        "bJQueryUI": true,
                                        "sPaginationType": "full_numbers",
                                        "iDisplayStart ": 20,
                                        "oLanguage": {

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

                                },

                       });
          }
            
             
        });
    });

</script>


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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/dt_customerDispatch/<?php echo $custID?>',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
           
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
<div class="page-content-wrapper"style="padding-top: 20px">
              
    <!-- START PAGE CONTENT -->
    <div class="content" >
  

        <div class="brand inline" style="  width: auto;            
             color: gray;
             margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;"></strong><!-- id="define_page"-->
        </div>
        <div id="test"></div>
        <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%; ">
                    <li><a href="<?php echo base_url('index.php?/superadmin') ?>/customers/3" class="">CUSTOMER</a>
                    </li>

                    <li ><a href="#" class="active">BUSINESS (<?php echo strtoupper($customerName);?>)</a>
                    </li>
                    <li ><a href="#" class="active">DISPATCHERS</a>
                    </li>
                </ul>
         <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
                        <div class="pull-right m-t-10 new_button"> <button class="btn btn-primary btn-cons" id="resetpassword" style="width:125px;">Reset Password</button></div>
                        <div class="pull-right m-t-10 new_button" > <button class="btn btn-danger btn-cons" id="delete" >Delete</button></div>
                         <div class="pull-right m-t-10 new_button" > <button class="btn btn-warning btn-cons" id="inactive">Ban</button></div>
                         <div class="pull-right m-t-10 new_button" > <button class="btn btn-success btn-cons" id="active">Active</button></div>
                        <div class="pull-right m-t-10 new_button"> <button class="btn btn-primary btn-cons" id="add">Add</button></div>
                        

                    </ul>
                    
              
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">
                   
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
<!--                                    
                                        <div class="cs-loader">
                                                <div class="cs-loader-inner" >
                                                    <label class="loaderPoint" style="color:#10cfbd">●</label>
                                                    <label class="loaderPoint" style="color:red">●</label>
                                                    <label class="loaderPoint" style="color:#FFD119">●</label>
                                                    <label class="loaderPoint" style="color:#4d90fe">●</label>
                                                    <label class="loaderPoint" style="color:palevioletred">●</label>
                                                </div>
                                          </div>-->
                     
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


<div class="modal fade stick-up" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
<form id="addDispatcherForm" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <span class="modal-title">ADD</span>
                </div>

                <div class="modal-body">
                  
                    <div class="form-group">
                        <label for="fname" class="col-sm-4 control-label">Name <span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="dispname" name="dispname"  class="newpass form-control error-box-class" placeholder="Enter Name">
                            
                        </div>
                        <div id="errname" class="col-sm-2 error-box errors"></div>
                    </div>

                    
                     <div class="form-group">
                        <label for="fname" class="col-sm-4 control-label"> Email <span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="dispemail" name="dispemail"  class="newpass form-control error-box-class" placeholder="Enter Email">
                           
                        </div>
                         <div id="erremail" class="col-sm-2 error-box errors"></div>
                    </div>

                    
                     <div class="form-group">
                        <label for="fname" class="col-sm-4 control-label">Password <span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="password"  id="disppass" name="disppass"  class="newpass form-control error-box-class" placeholder="Enter Password">
                        </div>
                        <div id="errpass" class="col-sm-2 error-box errors"></div>
                    </div>
                  
                </div>
                <div class="modal-footer">
               
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4 error-box"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="insert" >Add</button>
                        </div>
                   
                    </div>
</form>
          
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>

<div class="modal fade stick-up" id="banmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <span class="modal-title">BAN</span>
            <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata1" style="text-align:center">Are you sure you want to ban this dispatcher</div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="ban" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
</button>
<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="">
            <span class="modal-title">DELETE</span>
            <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center">Are you sure you want to delete this dispatcher</div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-danger pull-right" id="del" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
</button>


<div class="modal fade stick-up" id="displayData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center">Please select atleast one dispatcher</div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" data-dismiss="modal" ><?php echo "OK";?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="resetpass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <span class="modal-title">RESET PASSWORD</span>
                   <button type="button" class="close" data-dismiss="modal">×</button>

                </div>

            </div>
           
            <div class="modal-body">
                
               <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
               <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">New Password<span class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                           <input type="text" id="password" name="password"  class="form-control error-box-class" placeholder="Enter new password"/>
                           
                        </div>
                        
                         <div id="newpasswordErr" class="col-sm-2 error-box errors"></div>
                </div>
               </form>
                
               
            </div>
             <div class="modal-footer">
               
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4 error-box"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-success pull-right" id="reset">Update</button>
                        </div>
                   
                    </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>





