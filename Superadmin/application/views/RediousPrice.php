
<style>
 
    .form-horizontal .form-group
    {
        margin-left: 13px;
    }
    .add_way_point {
        font-size: 16px;
        background-image: url(http://app.bringg.com/images/860876be.add_driver_icon.png);
        background-position: center left;
        background-repeat: no-repeat;
        padding-left: 22px;
        cursor: pointer;
    }
    .pg-close{

        /*background: red;*/
        border-radius: 29%;
        margin-top: -1px;
    }
    .delbtn{
        margin-top: -22px;
        cursor: pointer;
    }
    .myheight
    {
        height: 300px;
    }

    .checkbox1 label{
        width: 100%;
    }
    .hide_form_css{
        display: none;
    }
</style>

    
<script type="text/javascript">
    $(document).ready(function () {

     $('.cs-loader').show();
     $('#selectedcity').hide();
   
     $('#companyid').hide();
     var table = $('#big_table');
    $('.hide_show').hide();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_RediousPrice',
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
                     $('.hide_show').show()
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
   });

    
       function refreshTableOnActualcitychagne()
        {
           
            var table = $('#big_table');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_RediousPrice',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
//                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
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


    $(document).ready(function (e) {
        
     
        //called when key is pressed in textbox
        $("#from_,#to_,#price,#from_e,#to_e,#price_e").keypress(function (e) {
           //if the letter is not digit then display error and don't type anything
           if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              //display error message
              $(".errmsgMsg").html("Numbers Only").show().fadeOut("slow");
                     return false;
          }
         });
         
        

 
        $('#addPrice').click(function () {
                  $('.errors').text('');

            $('#modal-container-18669944').modal('show');

        });


        if (parseInt($('#tableWithSearch tr:last td:first').html()) > 0)
            var loc_id = parseInt($('#tableWithSearch tr:last td:first').text()) + parseInt(1);
        else
            loc_id = 1;
        
        
        $('#addloctodb').click(function () {
             $('.errors').text('');
                
            var from = $('#from_').val();
            var to = $('#to_').val();
            var price = $('#price').val();
            var cityid = $('#cityid_').val();

            var cityName = $('#cityid_ option:selected').html();
           
            if(cityid == '0')
            {
                $('.errorCity').text('Please select city');
                e.preventDefault();
            }
            else if(from == '' || from == null)
            {
                $('.errorFrom').text('Please enter range from');
                e.preventDefault();
            }
            else if(to == '' || to == null)
            {
                $('.errorTo').text('Please enter range to');
                e.preventDefault();
            }
            else if(price == '' || price == null)
            {
                $('.errorComm').text('Please enter commission value');
                e.preventDefault();
            }
            else if(price > 99)
            {
                $('.errorComm').text('Commission should not be more than 100');
                e.preventDefault();
            }
            else if(from != '' && to != '' && price != '')
            {
                
                if(parseInt(from) >= parseInt(to))
                     $('.errmsgMsg').text('FROM value must be less than TO value');
                else {
                    var TRole = $('#big_table').DataTable();
                
                $.ajax({
                    url: '<?php echo base_url() ?>index.php?/superadmin/addRediousPrice',
                    type: 'POST',
                    data: {from_: from, to_: to, price: price, cityid: cityid},
                    dataType: "JSON",
                    success: function (data)
                    {
                        if (data.flag == 1) {
                             $('.errmsgMsg').text(data.error);
                        } else {
                            
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
                                            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_RediousPrice',
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

                    }

                });

                }
            
            }
        });

        $(document).on('click','.editPrice',function () {
        
         var currentRow = $(this).closest('tr');
            $('#from_e').val(currentRow.find('td').eq(2).text());
            $('#to_e').val(currentRow.find('td').eq(3).text());
            $('#price_e').val(currentRow.find('td').eq(4).text());
            
            $("select[name='cityid_e']").val($(this).attr('city-id'));
            $('#mongoid').val($(this).attr('id'));

            $('#model-edit_commission').modal('show');
        });

        $('#edit_paln').click(function () {
            
           $('.errors').text('');
           
            
            var from = $('#from_e').val();
            var to = $('#to_e').val();
            var price = $('#price_e').val();
            var cityid = $('#cityid_e').val();
          

            if (cityid == '0' || cityid == '')
            {
               $('.errorCity_Edit').text('Please select city');
               
            }
            else if (from == '' || from == null)
            {
               
               $('.errorFrom_Edit').text('Please enter from value');
               
            }
            else if (to == '' || to == null)
            {
               $('.errorTo_Edit').text('Please enter to value');
               
            }
            else if (price == '' || price == null)
            {
               $('.errorComm_Edit').text('Please enter commission value');
                
            }
            else if (parseInt(from) > parseInt(to) || parseInt(from) > parseInt(to))
            {
                alert();
               $('.errorFrom_Edit').text('FROM value must be less than TO value');
                
            }
            else if (price > 99)
            {
               $('.errorComm_Edit').text('Commission should not be more than 100');
                
            }
            else {
                 $(".close").trigger('click');

                $.ajax({
                    url: '<?php echo base_url() ?>index.php?/superadmin/editRediousPrice',
                    type: 'POST',
                    data: {from: from, to: to, price: price, mid: $('#mongoid').val(), cityid: cityid},
                    dataType: "JSON",
                    success: function (data)
                    {
                        
//                        $('#deletePopUpResponse').modal('show');
//                        $('.responseHTML').text(data.error);
                          $('.close').trigger('click');
                        
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
                                            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_RediousPrice',
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
                    error: function (e) {

                        alert('Select One Entity !');
                    }

                });

            }

        });

    });
    
     $(document).on('click','.deletePrice',function () {
            
            var currentRow = $(this).closest('tr');
            var from = currentRow.find('td').eq(2).text();
            var to = currentRow.find('td').eq(3).text()
            var mid = $(this).attr('id');
            
             $('#deletePopUp').modal('show');
             $('.popUpContentMsg').text('Do you wish to delete this commissiom set up');
           
           $('#confirmToDelete').click(function () {
                $(".close").trigger('click');

                $.ajax({
                    url: '<?php echo base_url() ?>index.php?/superadmin/editRediousPrice',
                    type: 'POST',
                    data: {mid: mid, status: 'del'},
                    dataType: "JSON",
                    success: function (data)
                    {
                        $('#deletePopUpResponse').modal('show');
                        $('.responseHTML').text(data.error);
                        currentRow.remove();
                    },
                    error: function (e) {

                        alert('Select One Entity !');
                    }

                });
            });
            
        });




</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content" >

        <div class="brand inline" style="  width: auto;">
          

            <strong >SET APP COMMISSION</strong>
        </div>
   
        <!-- START JUMBOTRON -->
         <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                    
                       <ul class="nav nav-tabs  bg-white ">
                           <div class="pull-right m-t-10" style="margin-right:1.9%;"> <button class="btn btn-primary btn-cons" id="addPrice">Add</button></div>

                    </ul>
                 
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top:1%;">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                  <div class="error-box" id="display-data" style="text-align:center"></div>
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
                                    
                                   
                <div>
                   
                            <div class="form-group " >
                             
                                <div class="col-sm-8" style="width: auto;
                                     paddingng: 0px;
                                     margin-bottom: 10px;margin-left: -0.7%;" >

                                    <select id="selectedcity" name="company_select" class="form-control"  onchange="loadcompay()" style="background-color:gainsboro;height:30px;font-size:12px;">
                                        <!--<option value="0">Select city</option>-->
                                        <?php $city = $this->db->query("select * from city_available ORDER BY City_Name ASC")->result(); ?>
                                        <option value="0">Select City</option>
                                        <?php
                                        foreach ($city as $result) {

                                           echo '<option value="' . $result->City_Id . '">' . ucfirst(strtolower($result->City_Name)) . '</option>';
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>

                </div>

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?> "> </div>
                                    </div>

                                </div>
                                 &nbsp;
                                 <div class="panel-body" style="margin-top:-1.6%;">


                                    <?php echo $this->table->generate(); ?>

                                </div>
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="container-fluid container-fixed-lg footer">
        <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
                  <span class="copy-right"></span>

            </p>

            <div class="clearfix"></div>
        </div>
    </div>
    <!-- END FOOTER -->
</div>
    <div class="modal in" id="modal-container-18669944" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <span class="modal-title">ADD APP COMMISSION</span>
                </div>
                <form action="" method="post" id="location_form" data-parsley-validate="" class="form-horizontal form-label-left">
                    <div class="modal-body clearfix fetch_results">


                        <div class="form-group " >
                            <label for="fname" class="col-sm-3 control-label" >Select City<span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">

                                <select id="cityid_" name="cityid_" class="form-control">
                                    <!--<option value="0">Select city</option>-->
                                    <?php $city = $this->db->query("select * from city_available ORDER BY City_Name ASC")->result(); ?>
                                    <option value="0">None</option>
                                    <?php
                                    foreach ($city as $result) {

                                        echo '<option value="' . $result->City_Id . '">' . $result->City_Name . '</option>';
                                    }
                                    ?>   
                                </select>

                            </div>
                             <div class="col-sm-3 errors errorCity"></div>

                        </div>


                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">From<span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="from_" > 
                            </div>
                             <div class="col-sm-3 errors errorFrom"></div>
                        </div>
                      
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">To<span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="to_" > 
                            </div>
                             <div class="col-sm-3 errors errorTo"></div>
                        </div>
                      
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">Commission (%)<span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="price" > 
                            </div>
                             <div class="col-sm-3 errors  errorComm"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left"><span class="errmsgMsg errors"></span></div>
                        <button type="button" class="btn btn-default btn-clean" data-dismiss="modal" id="close_location_popup_first">Close</button>
                        <button type="button" class="btn btn-primary btn-clean" id="addloctodb">Add </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div class="modal in" id="model-edit_commission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">EDIT COMMISSION</h4>
                </div>
                <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">

                    <div class="modal-body clearfix fetch_results">


                        <div class="form-group " >
                            <label for="fname" class="col-sm-3 control-label" >Select City <span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <select id="cityid_e" name="cityid_e" class="form-control">
                                    <!--<option value="0">Select city</option>-->
                                    <?php $city = $this->db->query("select * from city_available ORDER BY City_Name ASC")->result(); ?>
                                    <option value="0">None</option>
                                    <?php
                                    foreach ($city as $result) {

                                        echo '<option value="' . $result->City_Id . '">' . $result->City_Name . '</option>';
                                    }
                                    ?>   
                                </select>

                            </div>
                             <div class="col-sm-3 errors  errorCity_Edit"></div>

                        </div>


                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">From<span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" class="form-control" id="from_e" > 
                            </div>
                             <div class="col-sm-3 errors  errorFrom_Edit"></div>
                        </div>
                       
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">To<span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" class="form-control" id="to_e" > 
                            </div>
                             <div class="col-sm-3 errors  errorTo_Edit"></div>
                        </div>
                       
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">Commission (%)<span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" class="form-control" id="price_e" > 
                            </div>
                        </div>
                        <input type="hidden" id="mongoid">
                         <div class="col-sm-3 errors  errorComm_Edit"></div>



                    </div>



                    <div class="modal-footer">
                          <div class="pull-left"><span class="errmsgMsg errors"></span></div>
                        <button type="button" class="btn btn-default btn-clean" data-dismiss="modal" id="close_location_popup">Close</button>
                        <button type="button" class="btn btn-success btn-clean" id="edit_paln">Save </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<!--Delete pop up Response-->
   <div id="deletePopUpResponse" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
             <p class="responseHTML"></p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
           
          </div>
        </div>
      </div>
    </div>

<!--Delete pop up confirmation-->
   <div id="deletePopUp" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
             <p class="popUpContentMsg"></p>
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-danger pull-right" id="confirmToDelete" ><?php echo 'Delete'; ?></button>
             <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                 
           
          </div>
        </div>
      </div>
    </div>

  


