<style>
    #companyid{
        display: none;
    }
</style>
<link href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
        function isNumberKey(evt)
        {
            $("#mobify").text("");
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 41 || charCode > 57 )) {
                //    alert("Only numbers are allowed");
                $("#mobify").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
                return false;
            }
            return true;
        }
    $(document).ready(function () {
        var status = '<?php echo $status; ?>';
        if (status == 1) {
            $('#btnStickUpSizeToggler').show();
            $('#btnStickUpSizeToggl').show();
            $('#inactive').show();
            $('#active').hide();
            $("#reset_password").show();
        }
        
        
    $(document).on("countrychange", function(e, countryData) {

        $("#coutry-code").val(countryData.dialCode);
       });
            $("#phone").on("countrychange", function(e, countryData) {
                $("#coutry-code").val(countryData.dialCode);
              });
            $("#phoneEdit").on("countrychange", function(e, countryData) {
                $("#coutry-codeEdit").val(countryData.dialCode);
              });

     $('.cs-loader').show();
     $('#selectedcity').hide();
   
     $('#companyid').hide();
     var table = $('#big_table');
     var searchInput = $('#search-table');
     searchInput.hide();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php/managers/datatable_managers',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
              
            },
            "fnInitComplete": function () {
                  table.show()
                   $('.cs-loader').hide()
                   searchInput.show()
                    $('#selectedcity').show()
                     $('#companyid').show()
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
         
         
         
         $('#add').click(function()
         {
             $('.errors').text('');
             $('#addManagerrForm')[0].reset();
             $('#addManagerPopUp').modal('show');
         });
         $('#insertManager').click(function ()
         {
             $('.errors').text('');
             if($('#first_name').val() == '')
                 $('#first_nameErr').text('Please enter first name');
             else if($('#email').val() == '')
                 $('#emailErr').text('Please enter email');
             else if($('#phone').val() == '')
                 $('#phoneErr').text('Please enter phone number');
             else
             {
                 $.ajax({
                    url: "<?php echo base_url('index.php/managers') ?>/managersAddEdit/add",
                    type: "POST",
                     async:false,
//                    data: {fname: $('#first_name').val(), lanme: $('#last_name').val(),
//                            email:$('#email').val(),phone:$('#phone').val()},
                    data: $('#addManagerrForm').serialize(),
                    dataType: 'json',
                    success: function (result)
                    {
                        $(".close").trigger("click");
                        var table = $('#big_table');

                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php/managers/datatable_managers',
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
                    }
                });
             }
            
         });
         
           $('#edit').click(function()
          {
              $('.errors').text('');
              var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select one manager to edit');

            } else if (val.length > 1) {

               $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select only one manager to edit');

            }
            else {
                $('#mongoIDToEdit').val($('.checkbox:checked').val());
                    $.ajax({
                           url: "<?php echo base_url('index.php/managers') ?>/managersAddEdit/get",
                           type: "POST",
                           data: {id:$('.checkbox:checked').val()},
                           dataType: 'json',
                           success: function (result)
                           {

                                    $('#first_nameEdit').val(result.data.fname);
                                    $('#last_nameEdit').val(result.data.lname);
                                    $('#emailEdit').val(result.data.email);
                                    var phoneNum = result.data.phone.split('-');
                                   $("#phoneEdit").intlTelInput("setNumber",phoneNum[0]+' '+phoneNum[1]);
                           }
                       });
                      $('#editManagerPopUp').modal('show');
                     
                   
             }
         });
         
          $('#updateManager').click(function ()
         {
             $('.error').text('');
             if($('#first_nameEdit').val() == '')
                 $('#first_nameEditErr').text('Please enter first name');
             else if($('#emailEdit').val() == '')
                 $('#emailEditErr').text('Please enter email');
             else if($('#phoneEdit').val() == '')
                 $('#phoneEditErr').text('Please enter phone number');
             else
             {
                 $.ajax({
                    url: "<?php echo base_url('index.php/managers') ?>/managersAddEdit/update",
                    type: "POST",
                    data: $('#editManagerForm').serialize(),
                    dataType: 'json',
                    success: function (result)
                    {
                        $(".close").trigger("click");
                        var table = $('#big_table');

                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php/managers/datatable_managers',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                               
                            },
                            "fnInitComplete": function () {
                   
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
                    }
                });
             }
            
         });
         
         $("#delete").click(function () {
          
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length > 0) {
                $('#deleteManagerPopUP').modal('show');
                $("#deleteManager").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php/managers') ?>/managersAddEdit/delete",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });

                            $(".close").trigger('click');
                        }
                    });


                });
            }
            else
            {
               $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select atleast one manager to delete');
            }

        });
    });
    
    

</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">

            <strong>MANAGERS</strong>
        </div>
         <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
                                
                        <div class="pull-right m-t-10"> <button class="btn btn-danger btn-cons" id="delete"><?php echo BUTTON_DELETE; ?></button></a></div>

                        <div class="pull-right m-t-10"> <button class="btn btn-info btn-cons" id="edit"><?php echo BUTTON_EDIT; ?></button></a></div>


                        <div class="pull-right m-t-10" > <button class="btn btn-primary btn-cons" id="add" ><?php echo BUTTON_ADD; ?></button></div>
                        </div>
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

                                    <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                    
                            </div>
                            </div>
                            <div class="panel-body">
                                <?php
                                            echo $this->table->generate();
                                            ?>
                              </div>
                            </div>
                        </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="container-fluid container-fixed-lg">
      
    </div>
    <!-- END CONTAINER FLUID -->

</div>



<div class="modal fade stick-up" id="addManagerPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


                <div class="modal-header">
                    <span class="modal-title">ADD</span>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>


                <div class="modal-body">
                     <form action="" method="post" id="addManagerrForm" data-parsley-validate="" class="form-horizontal form-label-left">
              
                     <input type="hidden" id="coutry-code" name="coutry-code" value="">
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">First Name<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="first_name" name="first_name"  class="form-control">
                        </div>
                        <div class="col-sm-3 errors" id="first_nameErr"></div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-6">
                            <input type="text"  id="last_name" name="last_name"  class="form-control">
                        </div>
                        <div class="col-sm-3 errors" id="last_nameErr"></div>
                    </div>

              
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Email<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="email" name="email" class="form-control" >
                        </div>
                        <div class="col-sm-3 errors" id="emailErr"></div>
                        
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Phone<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="phone" name="phone" class="form-control" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-sm-3 errors" id="phoneErr"></div>
                        
                    </div>
                
                     </form>
            </div>
                <div class="modal-footer">

                   <div class="col-sm-4 error-box" id="errorpass"></div>
                   <div class="col-sm-8" >
                       <div class="pull-right m-t-10"><button type="button" class="btn btn-primary pull-right" id="insertManager">Add</button></div>
                         <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                   </div>
               </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    
</div>
</div>

<div class="modal fade stick-up" id="editManagerPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">

                    <span class="modal-title">EDIT</span>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>


                <div class="modal-body">
                    
                    <form action="" id="editManagerForm" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                     <input type="hidden" id="mongoIDToEdit" name="mongoIDToEdit" value="">
                     <input type="hidden" id="coutry-codeEdit" name="coutry-codeEdit" value="">
                        <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">First Name<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="first_nameEdit" name="first_nameEdit"  class="form-control">
                        </div>
                        <div class="col-sm-3 errors" id="first_nameEditErr"></div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-6">
                            <input type="text"  id="last_nameEdit" name="last_nameEdit"  class="form-control" >
                        </div>
                        <div class="col-sm-3 errors" id="last_nameEditErr"></div>
                    </div>

              
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Email<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="emailEdit" name="emailEdit" class="form-control">
                        </div>
                        <div class="col-sm-3 errors" id="emailEditErr"></div>
                        
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Phone<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="phoneEdit" name="phoneEdit" class="form-control">
                        </div>
                        <div class="col-sm-3 errors" id="phoneEditErr"></div>
                        
                    </div>
                  
                    
                    </form>
                    </div>

                    <div class="modal-footer">
                      
                        <div class="col-sm-4 error-box" id="errorpass"></div>
                        <div class="col-sm-8" >
                            <div class="pull-right m-t-10"><button type="button" class="btn btn-success pull-right" id="updateManager">Update</button></div>
                              <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        </div>
                    </div>
       
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>


<div class="modal fade stick-up" id="deleteManagerPopUP" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <span class="modal-title">DELETE</span>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>

                <div class="modal-body">
                    <form action="" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                 
                    
                      <div class="modal-body">
                        <div class="error-box" id="" style="text-align:center">Do you want to delete manager/s</div>

                        </div>
                   
                      
                    </form>
                   </div>

                    <div class="modal-footer">
                        <div class="col-sm-4 error-box errors" id="errormsg"></div>
                        <div class="col-sm-8" >
                             <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="deleteManager" >Delete</button></div>
                             <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" >Cancel</button></div>
                        </div>
                    </div>
            
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>




  <script src="<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>
  
   

<script>
      var countryData = $.fn.intlTelInput.getCountryData();
$.each(countryData, function(i, country) {
   
  country.name = country.name.replace(/.+\((.+)\)/,"$1");
});
    $("#phone,#phoneEdit").intlTelInput({
//       allowDropdown: false,
       autoHideDialCode: false,
       autoPlaceholder: "off",
       dropdownContainer: "body",
//       excludeCountries: ["us"],
       formatOnDisplay: false,
       geoIpLookup: function(callback) {
         $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
           var countryCode = (resp && resp.country) ? resp.country : "";
           callback(countryCode);
         });
       },
       initialCountry: "auto",
       nationalMode: false,
//       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
       placeholderNumberType: "MOBILE",
//       preferredCountries: ['srilanka'],
       separateDialCode: true,
      utilsScript: "<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/utils.js",
      
    });
     
  </script>