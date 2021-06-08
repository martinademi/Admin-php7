<link href="application/views/wallet/styles.css" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="<?= base_url() ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<style>
    label.error{
        color: red;
    }
    .form-group.required .control-label:after{
        content: " *";
        color: red;
    }
    .select2-container{
        width: 100% !important;
    }
    .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
    position: absolute;
    margin-left: -21px;
    }
</style>


<script type="text/javascript">
    var userType = '<?php echo $userType; ?>';
    var userTypeApiArray = {
        'customer': 1,
        'driver': 2,
        'store': 3,
        'app': 4,
        'pg': 5,
        
    };

    function getBadgeCount() {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/wallet/getBadgeCount",
            type: "POST",
            data: {'userType': userType},
            dataType: 'json',
            async: true,
            success: function (response)
            {
                $('.walletCount').text(response.data.walletCount);
                $('.softLimitCount').text(response.data.softLimitCount);
                $('.hardLimitCount').text(response.data.hardLimitCount);
            }
        });
    }
    $(document).ready(function () {

         citiesList();

         function citiesList(){
        $.ajax({
               url: "<?php echo APILink ?>" + "admin/city",
              //url:"https://api.flexyapp.com/admin/city",
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 0
                },
                data: {                  
                },
            }).done(function(json) {
                
                $("#citiesList").html('');
                
                 for (var i = 0; i< json.data.length; i++) {
                
                    var citiesList = "<option value="+ json.data[i].id + ">"+  json.data[i].cityName +"</option>";
                    $("#citiesList").append(citiesList);  
                }

                $('#citiesList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '100%',
                    maxHeight: 300,
                });
        });
     }
        
        var table = $('#big_table');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/wallet/datatable_user/',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "ordering": false,
            "drawCallback": function () {
                $('#big_table').show();
                $('.cs-loader').hide();
            },
            "iDisplayStart ": 20,
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                $('#big_table').show();
                $('.cs-loader').hide();
            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                // csrf protection
                var tab_id = $("li.active").find('.changeMode').attr('data-id');
                aoData.push({name: 'userType', value: userType});
                aoData.push({name: 'tabType', value: tab_id});
                aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                $.ajax({
                    'dataType': 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            },
            "aoColumns": [
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"}
            ]
        };
        table.dataTable(settings);

        // search box for table
        $('#search-table').keyup(function () {
            $('.cs-loader').show();
            table.fnFilter($(this).val());
        });

        $('#cityFilter').change(function(){
			
			var city=$('#cityFilter option:selected').attr('cityName');
			var cityId=$('#cityFilter option:selected').val();
			
			table.fnFilter(city);
			
		});
    });
    $(document).ready(function () {
        getBadgeCount();
        $('.changeMode').click(function () {
            var currentTab = $("li.active").find('.changeMode').attr('data-id');
            var tab_id = $(this).attr('data-id');
            if (tab_id != currentTab)
            {
                $('#big_table').hide();
                $('.tabs_active').removeClass('active');
                $(this).parent().addClass('active');
                $('#search-table').trigger('keyup');
            }
        });

        $('#credit_debit_button').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 0) {
                $('#myModals').modal('show');
            } else {

                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select one or more user to credit or debit');

            }
            $('#trigger_type').val('0');
            $('#amount').val('');
            $('#comment').val('');
        });

        $("#trigger").click(function () {
            var users = [];
            $('.checkbox:checked').each(function (i) {
                users.push({
                    userId: $(this).val(),
                    currency: $(this).attr('data-currency'),
                    currencySymbol: $(this).attr('data-currencySymbol'),
                    cityName: $(this).attr('data-cityName'),
                    email: $(this).attr('data-email'),
                });
            });
            $(".errors").text("");
            var txn_type = $("#trigger_type").val();

            var amount = $("#amount").val();
            var comment = $("#comment").val();
            if (txn_type == "0")
            {
                $("#make_name_Error").text("SELECT TRIGGER TYPE");
            } else if (amount == "" || amount == null)
            {

                $("#model_name_Error").text("ENTER AMOUNT");
            } else if (users.length <= 0) {
                alert("SELECT ONE OR MORE CUSTOMER PLEASE");
            } else
            {
                var triggerType = "";
                switch (parseInt(txn_type))
                {
                    case 1:
                        triggerType = "MANUAL CREDIT";
                        break;
                    case 2:
                        triggerType = "MANUAL DEBIT";
                        break;
                    case 3:
                        triggerType = "CREDIT AMOUNT COLLECTED";
                        break;
                }
                $.ajax({
                    url: "<?php echo wallet_api_url ?>walletTransction",
                    type: 'POST',
                    data: {
                        amount: amount,
                        comment: comment,
                        userType: userTypeApiArray[userType],
                        users: JSON.stringify(users),
                        txnType: txn_type,
                        trigger: triggerType,
                        paymentType: 'WALLET',
                        initiatedBy: '<?php echo $this->session->userdata('first_name'); ?>'
                    },
                    dataType: 'JSON',
                    beforeSend: function (xhr) {
                        /* Authorization header */
                        xhr.setRequestHeader("authorization", '<?php echo $this->session->userdata('apiToken') ?>');
                        xhr.setRequestHeader("lan", 'en');
                    },
                    success: function (response)
                    {
                        if (response.flag == 0)
                        {
                            getBadgeCount();
                            $("#amount").val('');
                            $("#comment").val('');
                            $('#myModals').modal('hide');
                            $('#search-table').trigger('keyup');
                        } else {
                            $('.responseErr1').text(response.msg);
                        }
                    }
                });
            }
        });

        //  $.ajax({
        //     url: "<?= base_url() ?>index.php?/wallet/getCitydata",
        //     type: 'GET',
        //     dataType: 'JSON',
        //     success: function (response) {
        //         console.log('response city------',response);
        //         $('#citySelect').html('');
        //         $.each(response.data, function (ind, val) {
        //             $('#citySelect').append('<option value="' + val._id + '">' + val.city + '</option>');
        //         });
        //         $('#citySelect').select2({
        //             'closeOnSelect': false
        //         });
        //     }
        // });
        $('#payoffUserType').val(userTypeApiArray[userType]);
        $('#payoffBtn').click(function () {
            
            $('#citySelect').find('option').prop('selected', false);
            $('#citySelect').select2({
                'closeOnSelect': false
            });
            $('#modalPayoff').modal('show');
        });

        $('#formPayoff').validate({
            
            submitHandler: function (form) {
                $.ajax({
                    url: '<?= base_url() ?>index.php?/payoff/payoff',
                    type: 'POST',
                    dataType: "JSON",
                    data: $(form).serialize(),
                    success: function (response) {
                       if (response.error == 0) {
                           console.log('success');
                            getPayoffReport(response.data);
                            swal("", response.msg, "success");
                            $('#modalPayoff').modal('hide');
                        } else {
                            swal("", response.msg, "error");
                        }
                    },
                    error: function (jqXHR, status, err) {
                        swal("", 'Something Went Wrong', "error");
                    }
                });
                // return false;
            }
        });

     function getPayoffReport(cities) {
         console.log('next page');
        var cityList = cities || [];
        $.each(cityList, function (ind, city) {
            window.open('<?= base_url() ?>index.php?/payoff/payoffReport/<?= $userType ?>' + '/' + city, '_blank');
                    });
                }
    });

    $(document).ready(function(){
        $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Orders/getCities",
                type: "POST",
                data: {},
                dataType: "JSON",
                
                success: function (result) {
                     $('#cityFilter').empty();
                   
                    if(result.data){
                         
                          var html5 = '';
				   var html5 = '<option cityName="" value="" >Select city</option>';
                          $.each(result.data, function (index, row) {
                              
                               html5 += '<option value="'+row.cityId.$oid+'" cityName="'+row.cityName+'">'+row.cityName+'</option>';

                             
                          });
                            $('#cityFilter').append(html5);    
                    }

                     
                }
            });

    //date picker
    $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        var date = new Date();
        $('.datepicker-component').datepicker({
        });
        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
        });


        $('#datepicker-component').on('changeDate', function () {

            $('.datepicker').hide();
        });


        $('#cityFilter').change(function(){

            var cityID=$(this).attr('value');
         
           $('#zoneFilter').load("<?php echo base_url('index.php?/Wallet')?>/getZone",{cityID:cityID});


        });

            //alpha
           $('#searchData').click(function () {
            if ($("#start").val() && $("#end").val())
            {


                var st = $("#start").datepicker().val();
                var startDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1];

                var end = $("#end").datepicker().val();
                var endDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];

                var table = $('#big_table');

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "autoWidth": false,
                            "iDisplayLength": 20,
                    "bProcessing": true,               
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo base_url() ?>index.php?/Wallet/transection_data_form_date/' + startDate + '/' + endDate + '/' + $('#search_by_select').val(),
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 20,
                    "oLanguage": {
                        "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                    },
                    "fnInitComplete": function () {
                        //oTable.fnAdjustColumnSizing();
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


            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_DEACTIVAT_DATEOFBOOKING); ?>);

            }

        });


    });
</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
    <ul class="breadcrumb">
            <li>
                <a class="active">WALLET</a>
            </li>
            <li>
                <a href="#"><?= strtoupper(str_replace('_', ' ', $userType)) ?></a>
            </li>
        </ul>
        <div class="row">
            <ul class="nav nav-tabs nav-tabs-fillup bg-white">
                <li id="1" class="tabs_active active">
                    <a class="changeMode" data-id="1">
                        <span>WALLETS</span>
                        <span class="badge bg-green walletCount"></span>
                    </a>
                </li>
                <li id="2" class="tabs_active">
                    <a class="changeMode" data-id="2">
                        <span>SOFT LIMIT HIT</span>
                        <span class="badge bg-orange softLimitCount"></span>
                    </a>
                </li>
                <li id="3" class="tabs_active">
                    <a class="changeMode" data-id="3">
                        <span>HARD LIMIT HIT</span>
                        <span class="badge bg-red hardLimitCount"></span>
                    </a>
                </li>
                <?php
                if ($userType == 'driver'  || $userType=='store') {
                    ?>
                    <div class="pull-right cls110" style="padding:7px;">
                        <button style="width : 100px" class="btn btn-info btn-cons" id="payoffBtn">Payoff</button>
                    </div>
                    <?php
                }
                ?>
                <div class="pull-right cls110" style="padding:7px;">
                    <button style="width : 150px" class="btn btn-danger btn-cons" id="credit_debit_button">MANUAL CREDIT/DEBIT</button>
                </div>

            </ul>

            <div class="row">

                        <div class="col-sm-2">
                                <div class="row clearfix pull-left" style="margin-left:25px;">
                                        <div class="pull-left">
                                            <select class="form-control pull-left" id="cityFilter">
                                            </select> 
                                        </div>
                                </div>
                        </div>

                        <!-- zone display -->
                         <div class="col-sm-2" style="display:none">
                                <div class="row clearfix pull-left" style="margin-left:25px;">
                                        <div class="pull-left">
                                        <select class="form-control pull-left" id="zoneFilter" style="max-width:100%;">
                                        <option selected="selected" value="">Select Zone</option>
                                            </select> 
                                        </div>
                                </div>
                        </div>

                        
                       <!-- <div class="col-sm-2">
                            <div class="" aria-required="true">
                                <div class="input-daterange input-group">
                                        <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-1">
                                <div class="">
                                     <button class="btn btn-primary" type="button" id="searchData">Search</button>
                                 </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="">
                                <button class="btn btn-info" type="button" id="clearData">Clear</button>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group ">
                                <button class="btn btn-info cls100" type="submit" style="background-color: #3e4165;border-color:#3e4165" name="" id=""><a style="color: white;" class="exportAccData" href="<?php echo base_url() ?>index.php?/Wallet/exportAccData/<?php echo $paymentCycleDetails['_id']; ?>">Export</a></button>
                            </div>
                        </div> -->

                         <div class="pull-right" style="margin-right: 21px;">
                             <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo $this->lang->line('search'); ?>"/> 
                        </div>






             </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-transparent ">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="col-sm-8">
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
                               
                            </div>
                            <div class="panel-body" style="padding: 0px; margin-top: 2%;">
                                <?php echo $this->table->generate(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>


<div class="modal fade stick-up" id="myModals" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >MANUAL CREDIT/DEBIT</span> 
            </div>
            <div class="modal-body">
                <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label" id="">Trigger Type<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="trigger_type" name="trigger_type"  class="form-control error-box-class" >
                                <option value="0">Select Transaction Type</option>
                                <option value="1">MANUAL CREDIT</option>
                                <option value="2">MANUAL DEBIT</option>
                                <option value="3">CREDIT AMOUNT COLLECTED</option>
                            </select>
                        </div>
                        <div class="col-sm-3 error-box errors" id="make_name_Error" ></div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Amount<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text"  id="amount" name="amount"  class="form-control autonumeric" data-a-sep="." data-m-dec="2" placeholder="">
                        </div>
                        <div class="col-sm-3 error-box errors" id="model_name_Error" ></div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Comment<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text"  id="comment" name="comment"  class="form-control" placeholder="">
                        </div>
                        <div class="col-sm-3 error-box errors" id="comment_name_Error" ></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="col-sm-4 errors responseErr1" ></div>

                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="trigger" >TRIGGER</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">CLOSE</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="modalPayoff" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?= ucwords(str_replace('_', ' ', $userType)) ?> Payoff</span> 
            </div>
            <form action="" method="post" data-parsley-validate="" class="form-horizontal form-label-left" id="formPayoff">
                <div class="modal-body">
                    <div class="form-group required" class="formex">
                        <span for="citiesList" class="col-sm-2 control-label">Select City</span>
                        <div class="col-sm-10">
                            <!-- <select id="citySelect" name="city[]" class="form-control" required multiple data-placeholder="Select City" >
                                
                            </select> -->

                             <select id="citiesList" name="city[]" class="form-control" style="width: 55% !important" multiple="multiple">
                                                 
                                                 </select>
                        </div>
                    </div>
                    <input type="hidden" name="userType" id="payoffUserType" value=""/>
                    <input type="hidden" name="initiatedBy" value="<?php echo $this->session->userdata('emailid'); ?>"/>
                </div>
                <div class="modal-footer">
                    <div class="pull-right m-t-10"> 
                        <button type="submit" class="btn btn-success">Payoff</button>
                    </div>
                    <div class="pull-right m-t-10"> 
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons">CLOSE</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
