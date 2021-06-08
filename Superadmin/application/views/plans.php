<style>
    .ui-datepicker{ z-index: 9999 !important;}
    input[type=checkbox]{
        margin: 4px 4px 0px 0px;
        margin-top: 1px\9;
        line-height: normal;
    }
    span.unit_tag {
        position: absolute;
        right: 10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    span.unit_tag1 {
        position: absolute;
        right: 10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .btn{
        border-radius: 25px !important;
    }
</style>
<script>
$(document).ready(function (){
    $(document).ajaxComplete(function () {
        console.log("hsdfsdf");
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

    $(document).on('click','.fg-button',function(){
        $("#select_all").prop("checked", false);
    });  

      $("body").on('click','#select_all',function(){ 
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    

       $("body").on('click','.checkbox',function(){ 
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }   
       });

});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        
        $('.changeMode').click(function () {

            var table = $('#big_table');
            $('#big_table').fadeOut('slow');
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
                    $('#big_table').fadeIn('slow');
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
                },
                "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],

            };
            $('.tabs_active').removeClass('active');
            $(this).parent().addClass('active');
            table.dataTable(settings);
        });
        
        $('.whenclicked li').click(function () {
            if ($(this).attr('id') == 1) {
                $('#checkdel').show();
               
            } else if ($(this).attr('id') == 2) {

               $('#checkdel').hide();
            }
        });


        var table = $('#big_table');

        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_driverPlans/1',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
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
                        },
                "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],
            };

            table.dataTable(settings);
        }, 1000);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        var date = new Date();
        $('.datepicker-component').datepicker({
            startDate: date
        });

        $('#add').click(function ()
        {
            $('#defaultplan').attr('checked', false);
            $('.referrerCommDiv').show();
            $('#addModal').modal('show');
            $('#membershipPaid').attr('disabled', false);

        });

        $('.PlansRadioButton').click(function ()
        {
            if ($(this).val() == 'Paid')
            {
                $('.membershipType').show();
                $('#membershipFreeEdit').attr('checked', false);
            } else
            {
                $('.membershipType').hide();
                $('#membershipPaidEdit').attr('checked', false);
            }

        });
        $('.unit_tag1ADD').text("%");
        $('#commissionPercentage').click(function(){
            $('.unit_tag1ADD').text($('#commissionPercentage').val());
        });
        $('#commissionFixed').click(function(){
            $('.unit_tag1ADD').text($('#city_select option:selected').attr('currencySymbol'));
            
        });
        
        

//        $('.defaultplancheckbox').click(function ()
//        {
//            if($('.defaultplancheckbox').is(':checked'))
//            {
//                $('.membershipFeeDiv').hide();
//                $('#membershipFree').attr('checked',true);
//                $('.referrerCommDiv').hide();
//                $('#membershipPaid').attr('disabled',true);
//                
//            }
//            else{
//                 $('#membershipPaid').attr('disabled',false);
//                 $('.referrerCommDiv').show();
//            }
//        });

        $('.membershiptTypeEdit').click(function ()
        {
            if ($('#membershipFreeEdit').is(':checked'))
                $('.membershipType').hide();
            else
                $('.membershipType').show();
        });

//        $('#edit').click(function ()
         $(document).on('click', '.editICON', function () {
//        {

            $(".errors").text("");
            var val = $(this).val();
            if(val){

                $('#idToEdit').val( $(this).val());
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getplans",
                    data: {val: val},
                    dataType: 'JSON',
                    success: function (response)
                    {
						console.log(response);
                        $('#custmemfeeEdit').val('');
                        $('#editCity').val(response.cityName);
                        if (response.commissionType == 1)
                        {
                            $('#commissionFixed').attr('checked', true);
                           
                        } else
                        {
                            
                            $('#commissionPercentage').attr('checked', true);
                          
                        }

                        $('#editplan_name').val(response.planName);
                        $('#editdescrip').val(response.description);
                        $('#editappCommission').val(response.appCommissionValue);
                        $('#editreferEarning').val(response.referEarnings);

                    },
                });
                $('#editModal').modal('show');
            }else{
            $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Something went wrong, please try again..");
            }
        });


        $('#insert').click(function ()
        {
            $('#cityName').val($('#city_select option:selected').attr('city'));
            $('#currency').val($('#city_select option:selected').attr('currency'));
            $('#currencySymbol').val($('#city_select option:selected').attr('currencySymbol'));
            $('.errors').text('');
            if($('#city_select option:selected').val() == '' || $('#city_select option:selected').val() == null){
                $('#cityErr').text("Please select city");
            }
            else if ($('#plan_name').val() == '' || $('#plan_name').val() == null)
            {
                $('#cityErr').text("");
                $('#plan_nameErr').text('Please Enter the plan name');
            } else if ($('#descrip').val() == '' || $('#descrip').val() == null)
            {   $('#plan_nameErr').text("");
                $('#descripErr').text('Please enter description');
            } else if ($('#custmemfee').val() == '' && $('#membershipPaid').is(':checked'))
            {
                $('#descripErr').text("");
                $('#memfeeErr').text('Please enter membership fee');
            } else if ($('#appCommission').val() == '' || $('#appCommission').val() == null)
            {
                 $('#memfeeErr').text("");
                $('#appCommissionErr').text('Please enter app commission');
            } else {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addPlans",
                    type: "POST",
                    data: $("#addform").serialize(),
                    dataType: 'json',
                    success: function (result)
                    {

                        if (result.flag == 0)
                        {
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_driverPlans/1',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                                },
                                "fnInitComplete": function () {
                                    $('.cs-loader').hide();
                                    table.show()
                                    searchInput.show()
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
                                        },
                "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],
                            };

                            table.dataTable(settings);
                        } else {
                            $('.ResponseErr').text(result.msg);
                        }

                    }
                });
                $("#addModal").modal('hide');
                $("#addform")[0].reset();
            }
        });

        $('.membershiptType').click(function () {

            if (($('#membershipFree').is(':checked')))
                $('.membershipFeeDiv').hide();
            else
                $('.membershipFeeDiv').show();
        });

        $('#update').click(function ()
        {

            var plan_name = $('#editplan_name').val();
            var description = $('#editdescrip').val();
            var memberfee = $('#editmemfee').val();
            var appCommission = $('#editappCommission').val();
            var referEarnings = $('#editreferEarning').val();

            if ($('#editplan_name').val() == '' || $('#editplan_name').val() == null)
            {
                $('#plan_nameErr').text('Please Enter the plan name');
            } else if ($('#editdescrip').val() == '' || $('#editdescrip').val() == null)
            {
                $('#editdescripErr').text('Please enter description');
            } else if ($('#editappCommission').val() == '' || $('#editappCommission').val() == null)
            {
                $('#editappCommissionErr').text('Please enter app commission');
            }
//            else if ($('#editreferEarning').val() == '' || $('#editreferEarning').val() == null)
//            {
//                $('#editreferEarningErr').text('Please enter refer earnings');
//            } 
            else {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/updatePLans",
                    type: "POST",
                    data: $('#updateDriverPlans').serialize(),
                    dataType: 'json',
                    success: function (result)
                    {

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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_driverPlans/1',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                                "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                            },
                            "fnInitComplete": function () {
                                $('.cs-loader').hide();
                                table.show()
                                searchInput.show()
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
                                    },
                "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],
                        };

                        table.dataTable(settings);

                    }
                });
            }
        });



        $('#checkdel').click(function ()
        {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select any one row to delete");
            } else {

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getAllUsersForPlan",
                    type: "POST",
                    data: {id: val},
                    dataType: 'json',
                    success: function (result)
                    {
                        if (result.driversCount > 0)
                        {
                            $('.okButton').show();
                            $('.badge').show();
                            $('#delete').hide();
                            $('.cancel').hide();
                            $('.badge').text(result.driversCount);
                            $('.deletePopUpText').text('Drivers are currently active on this plan. Please move them to a different plan before deleting this plan.');
                        } else
                        {
                            $('.okButton').hide();
                            $('.badge').hide();
                            $('#delete').show();
                            $('.cancel').show();
                            $('.deletePopUpText').text('Do want to delete the plan');
                        }
                    }
                });
                $('#deleteModal').modal('show');
            }
        });

        $('#delete').click(function ()
        {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/deletePlans",
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
        });

        //validate the integer or double value
        $('.number').keypress(function (event) {
            var $this = $(this);
            if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
                    ((event.which < 48 || event.which > 57) &&
                            (event.which != 0 && event.which != 8))) {
                event.preventDefault();
            }

            var text = $(this).val();
            if ((event.which == 46) && (text.indexOf('.') == -1)) {
                setTimeout(function () {
                    if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                        $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                    }
                }, 1);
            }

            if ((text.indexOf('.') != -1) &&
                    (text.substring(text.indexOf('.')).length > 2) &&
                    (event.which != 0 && event.which != 8) &&
                    ($(this)[0].selectionStart >= text.length - 2)) {
                event.preventDefault();
            }
        });

        $('.number').bind("paste", function (e) {
            var text = e.originalEvent.clipboardData.getData('Text');
            if ($.isNumeric(text)) {
                if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
                    e.preventDefault();
                    $(this).val(text.substring(0, text.indexOf('.') + 3));
                }
            } else {
                e.preventDefault();
            }
        });

    });

</script>
<script>

    $(document).on('click', '.dtdescriptionplan', function () {
        $('#modaldescription').empty();
        var val = $(this).val();
//             var ID = $(this).attr('id');


        $.ajax({
            url: "<?php echo base_url('index.php?/superadmin') ?>/getplandata",
            type: "POST",
            data: {val: val},
            dataType: 'json',
            success: function (result)
            {
                $('#modaldescription').append(result);
                $('#myModal').modal('show');
            }
        });

    });

</script>

<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;

             color: gray;
             margin-left: 30px;padding-top: 20px;">

            <strong style="color:#0090d9;">DRIVER PLANS</strong>
        </div>

        <div class="">

            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">


                <div class="panel panel-transparent ">
                    <ul class="nav nav-tabs nav-tabs-fillup bg-white" style="padding: 0.5%;">
                        <li id="1" data-id="1" class="whenclicked tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode " data="<?php echo base_url(); ?>index.php?/superadmin/datatable_driverPlans/1
" data-id="1"><span>Active</span><span class=" newDriverCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="2" data-id="2" class="whenclicked tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode " data="<?php echo base_url(); ?>index.php?/superadmin/datatable_driverPlans/0" data-id="2"><span>Deleted</span> <span class=" acceptedDriverCount" style="background-color:#3CB371;"></span></a>
            </li>
                        <div class="pull-right m-t-10 cls111" style="margin-right: 1%;"> <button class="btn btn-danger cls111" id="checkdel"><?php echo BUTTON_DELETE; ?></button></a></div>

                        <!--<div class="pull-right m-t-10 cls111"><button class="btn btn-info " id="edit"><?php echo BUTTON_EDIT; ?></button></div>-->
                        <div  class="pull-right m-t-10 cls110" ><button class="btn btn-primary cls110" id="add"><?php echo BUTTON_ADD; ?></button></div>

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


                                    <div class="row clearfix pull-right" >
                                        <div class="col-sm-12">
                                            <div class="searchbtn" >

                                                <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
                                            </div>

                                        </div>
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


<div class="modal fade stick-up in" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title">ADD</span>

            </div>

            <div class="modal-body">
                <form action="" id="addform" method="post" data-parsley-validate="" class="form-horizontal form-label-left">

                    <!--                            <div class="form-group">
                                                            <label for="address" class="col-sm-3 control-label"></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                  <label for="bookNow">
                                                                            <input type="checkbox" class="defaultplancheckbox" name="defaultplan" id="defaultplan"  value="1"/><span>Default</span>
                                                                   </label>
                                                            </div>
                                                            <input type="hidden" name="defaultplanSelected" id="defaultplanSelected">
                                                            <div class="col-sm-3 error-box" id="defaultplancheckboxErr"></div>
                    
                                                        </div>-->
                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">City<span style="" class="MandatoryMarker"> *</span>
                                        </label>
                                        <div class="col-sm-6">
                                            <select id="city_select" name="cityId"
                                                    class="form-control error-box-class">
                                                <option value="">Select a city</option>
                                                <?php
                                        foreach ($cities as $city) {
                                            foreach ($city['cities'] as $data) {
                                                if ($data['isDeleted'] == FALSE) {
                                                    ?>
                                                    <option value="<?php echo $data['cityId']['$oid']; ?>" city="<?php echo $data['cityName']; ?>" lat="" lng="" currency="<?php echo $data['currency']; ?>" currencySymbol="<?php echo $data['currencySymbol']; ?>" weightMetric="<?php echo $data['weightMetric']; ?>" mileageMetric="<?php echo $data['mileageMetric']; ?>"><?php echo $data['cityName']; ?></option>    
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                            </select> 
                                            <input type="hidden" id="cityName" name="cityName" required="required" class="form-control">
                                            <input type="hidden" id="currency" name="currency" required="required" class="form-control">
                                            <input type="hidden" id="currencySymbol" name="currencySymbol" required="required" class="form-control">
                                        </div>
                                        <div class="col-sm-3 error-box errors" id="cityErr"></div>

                                    </div>
                    
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">Plan Name<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="plan_name" name="plan_name" class="form-control error-box-class " placeholder="Enter Plan Name">

                        </div>
                        <div class="col-sm-3 error-box errors" id="plan_nameErr">

                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">Description<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <textarea class="form-control" rows="5" id="descrip" name="descrip" placeholder="Enter Description"></textarea>

                        </div>
                        <div class="col-sm-3 error-box errors" id="descripErr">

                        </div>

                    </div>

                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Commission Type</label>
                        <div class="col-sm-6">
                            <div class="col-sm-6">
                                <input type="radio" class="radio-success commissionType" id="commissionPercentage" name="memfee" value="%" checked>
                                <label for="membershipFree">%</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" class="radio-success commissionType" id="commissionFixed" name="memfee" value="fixed">
                                <label for="membershipPaid">Fixed</label>
                            </div>
                        </div>

                    </div> <!--


                    <div class="form-group membershipFeeDiv" style="display:none;">
                        <label for="fname" class="col-sm-3 control-label">Membership Fee</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="custmemfee" name="custmemfee" class="form-control error-box-class radio1 number" pattern="\d+" placeholder="Enter amount">
                            <span class="unit_tag"><?php echo $appCofig['currencySymbol']; ?></span>
                        </div>
                        <div class="col-sm-3 error-box errors" id="memfeeErr">
                        </div> 
                    </div>-->

                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">App Commission<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="appCommission" name="appCommission" class="form-control error-box-class number" placeholder="Enter commission">
                            <span class="unit_tag1 unit_tag1ADD"></span>

                        </div>
                        <div class="col-sm-3 error-box errors" id="appCommissionErr">

                        </div> 
                    </div>
<!--                    <div class="form-group referrerCommDiv">
                        <label for="fname" class="col-sm-3 control-label">Referrer Commission<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="referEarning" name="referEarning" class="form-control error-box-class number" placeholder="Enter amount">
                            <span class="unit_tag1">%</span>

                        </div>
                        <div class="col-sm-3 error-box errors" id="referEarningErr">

                        </div> 

                    </div>-->

                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box ResponseErr errors"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="insert">Add </button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade stick-up in" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title">EDIT</span>

            </div>

            <div class="modal-body">
                <form id="updateDriverPlans" action="" method="post" data-parsley-validate="" class="form-horizontal form-label-left">

                    <input type="hidden" id="idToEdit" name="idToEdit">

                    <!--                          <div class="form-group defaultplandiv">
                                                            <label for="address" class="col-sm-3 control-label"></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                  <label for="bookNow">
                                                                            <input type="checkbox" class="defaultEditplancheckbox" name="defaulEdittplan" id="defaulEdittplan"  value="1"/><span>Default</span>
                                                                   </label>
                                                            </div>
                                                            <input type="hidden" name="defaultplanSelected" id="defaultplanSelected">
                                                            <div class="col-sm-3 error-box" id="defaultplancheckboxErr"></div>
                    
                                                        </div>-->
                    
                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">City<span style="" class="MandatoryMarker"> *</span>
                                        </label>
                                        <div class="col-sm-6">
                                            <input disabled="disabled" type="text" name="editCity" id="editCity" class="form-control error-box-class"/>
                                            <input type="hidden" id="cityName" name="cityName" required="required" class="form-control">
                                            <input type="hidden" id="currency" name="currency" required="required" class="form-control">
                                            <input type="hidden" id="currencySymbol" name="currencySymbol" required="required" class="form-control">
                                        </div>
                                        <div class="col-sm-3 error-box errors" id="editCityErr"></div>

                                    </div>
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">Plan Name<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="editplan_name" name="editplan_name" class="form-control error-box-class" placeholder="Enter Plan Name">

                        </div>
                        <div class="col-sm-3 error-box errors" id="editplan_nameErr">

                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">Description<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <textarea class="form-control" rows="5" id="editdescrip" name="editdescrip" placeholder="Enter Description"></textarea>

                        </div>
                        <div class="col-sm-3 error-box errors" id="editdescripErr">

                        </div>
                    </div>


<!--                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Membership Type<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <div class="col-sm-6">
                                <input type="radio" class="radio-success membershiptTypeEdit" id="membershipFreeEdit" name="membershipEdit" value="Free"  value="Free" checked>
                                <label for="membershipFreeEdit">Free</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" class="radio-success membershiptTypeEdit" id="membershipPaidEdit" name="membershipEdit" value="Paid">
                                <label for="membershipPaidEdit">Paid</label>
                            </div>
                        </div>

                    </div> 


                    <div class="form-group membershipType" style="display:none;">
                        <label for="fname" class="col-sm-3 control-label">Membership Fee</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="custmemfeeEdit" name="custmemfeeEdit" class="form-control error-box-class radio1 number" pattern="\d+" placeholder="Enter price">
                            <span class="unit_tag"><?php echo $appCofig['currencySymbol']; ?></span>
                        </div>
                        <div class="col-sm-3 error-box errors" id="custmemfeeEditErr">
                        </div> 
                    </div>-->
<div class="form-group">
                        <label for="" class="control-label col-md-3">Commission Type</label>
                        <div class="col-sm-6">
                            <div class="col-sm-6">
                                <input type="radio" class="radio-success commissionType" id="commissionPercentage" name="memfee" value="%" checked>
                                <label for="membershipFree">%</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="radio" class="radio-success commissionType" id="commissionFixed" name="memfee" value="fixed">
                                <label for="membershipPaid">Fixed</label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">App Commission<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="editappCommission" name="editappCommission" class="form-control error-box-class" placeholder="Enter commission">
                            <span class="unit_tag1">%</span>

                        </div>
                        <div class="col-sm-3 error-box errors" id="editappCommissionErr">

                        </div> 
                    </div>
<!--                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">Referrer Commission<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="editreferEarning" name="editreferEarning" class="form-control error-box-class" placeholder="Enter amount">
                            <span class="unit_tag1">%</span>

                        </div>
                        <div class="col-sm-3 error-box errors" id="editreferEarningErr">

                        </div> 
                    </div>-->
                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box " id=""></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="update">Update</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">DESCRIPTION</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="fname" class="col-sm-12 control-label"> <p id="modaldescription"></p></label>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<div class="modal fade stick-up" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" >DELETE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <div class="row">
                    <span class="badge  badge bg-green"></span>
                    <span class="error-box deletePopUpText" id="errorboxdata" style="text-align:center">Do want to delete the plan</span>

                </div>
            </div>


            <div class="modal-footer">

                <div class="col-sm-4" ></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right okButton" data-dismiss="modal" style="display:none;">Ok</button></div>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="delete" >Delete</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons cancel" id="cancel">Cancel</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div> 




