<style>
    a.btn{
        text-decoration: none !important;
    }
</style>
<script type="text/javascript">
    var userID = '<?php echo $userData['_id']['$oid']; ?>';
    var userType = '<?php echo $userType; ?>';
    console.log(userType);
    var userTypeApiArray = {
        'customer' : 1,
        'provider' : 2,
        'operator' : 3,
        'app' : 4,
        'pg' : 5,
        'institutions' : 6,
        'institution_user' : 7
    };
    var stDate = "",endDate = "";
    $(document).ready(function () {
        var table = $('#big_table');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/wallet/datatable_details/',
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
                aoData.push({name: 'searchByPayment', value: $('#search_by_select').val()});
                aoData.push({name: 'searchByTrigger', value: $('#search_by_trigger').val()});
                aoData.push({name: 'searchByEndDate', value: endDate});
                aoData.push({name: 'searchByStartDate', value: stDate});
                
                aoData.push({name: 'userType', value: userType});
                aoData.push({name: 'userId', value: userID});
                aoData.push({name: 'isEntity', value: '<?= ($isEntity)?'true':'false'?>'});
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
                {"sWidth": "5%"},
                {"sWidth": "10%"},
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
    });
    $(document).ready(function(){
        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        $('.datepicker-component').datepicker({});
        $('#clearData').click(function (){
            $('#start').val('');
            $('#end').val('');
        });
        $('#searchData').click(function () {
            if ($("#start").val() && $("#end").val())
            {
                var dateObject = $("#start").datepicker("getDate"); // get the date object
                var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
                var dateObject = $("#end").datepicker("getDate"); // get the date object
                var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
                stDate = st;
                endDate = end;
            } else {
                stDate = "";
                endDate = "";
                $('#clearData').trigger('click');
            }
            $('#search-table').trigger('keyup');
        });
        
        $('.tableFilter').change(function(){
            $('#search-table').trigger('keyup');
        });
        
        $('#credit_debit_button').click(function () {
            $('#myModals').modal('show');
            
            $('#trigger_type').val('0');
            $('#amount').val('');
            $('#comment').val('');
        });
        
        $('#exportData').click(function(){
            var newForm = jQuery('<form>', {
                'action': '<?php echo base_url() ?>index.php?/wallet/exportAccData/true',
                'method': 'post'
            });
            newForm.append(jQuery('<input>', {name: 'searchByPayment', value: $('#search_by_select').val(), type: 'hidden'}));
            newForm.append(jQuery('<input>', {name: 'searchByTrigger', value: $('#search_by_trigger').val(), type: 'hidden'}));
            newForm.append(jQuery('<input>', {name: 'searchByEndDate', value: endDate, type: 'hidden'}));
            newForm.append(jQuery('<input>', {name: 'searchByStartDate', value: stDate, type: 'hidden'}));

            newForm.append(jQuery('<input>', {name: 'userType', value: userType, type: 'hidden'}));
            newForm.append(jQuery('<input>', {name: 'userId', value: userID, type: 'hidden'}));
            newForm.append(jQuery('<input>', {name: 'isEntity', value: '<?= ($isEntity)?'true':'false'?>', type: 'hidden'}));
            
            $('#dynamicFormExport').html(newForm);
            $('#dynamicFormExport').find('form').submit();
        });
       
        $("#trigger").click(function () {
            var users = [];
            users.push({
                userId:'<?php echo $userData['_id']['$oid']; ?>',
                currency:'<?php echo $userData['currency']; ?>',
                currencySymbol:'<?php echo $userData['currencySymbol']; ?>',
                cityName:'<?php echo $userData['cityName']; ?>',
                email:'<?php echo $userData['email']; ?>'
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
                        userType:userTypeApiArray[userType],
                        users: JSON.stringify(users),
                        txnType: txn_type,
                        trigger: triggerType,
                        paymentType: 'WALLET',
                        initiatedBy: '<?php echo $this->session->userdata('first_name'); ?>'
                    },
                    dataType: 'JSON',
                     beforeSend: function (xhr) {
                        /* Authorization header */
                        xhr.setRequestHeader("authorization",'<?php echo $this->session->userdata('apiToken')?>');
                        xhr.setRequestHeader("lan",'en');
                    },
                    success: function (response)
                    {

                        if (response.flag == 0)
                        {
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
    });
</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
    <div class="brand inline" style="  width: auto;">
        <?php echo $this->lang->line('heading_walletdetails'); ?> 
        </div>
        <!-- <ul class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php?/wallet/user/' . $userType) ?>">Wallet (<?= ucwords($userType)?>)</a>
            </li>
            <?php if(!$isEntity){ ?>
                <li>
                    <a href="#" class="active"><?php 
                switch($userType){
                case 'driver':echo $userData['firstName'];
                    break;
                case 'customer':echo $userData['name'];
                    break;
                case 'stores':echo $userData['name'][0];
                break;
                default:echo $userData['name'][0] ;
                    break;
                }
                ?></a>
                </li>
            <?php } ?> 
        </ul> -->
        <?php if($userType != 'store'){ ?>
        <ul class="breadcrumb">
            <li>
                <a href="<?= (($isEntity) ? "#" : base_url('index.php?/wallet/user/' . $userType)) ?>" class="<?= (($isEntity) ? "active" : "") ?>">Wallet (<?= ucwords($userType) ?>)</a>
            </li>
            <?php if (!$isEntity) { ?>
                <li>
                    <a href="#" class="active"><?php 
                switch($userType){
                case 'driver':echo $userData['firstName'];
                    break;
                case 'customer':echo $userData['name'];
                    break;
                case 'stores':echo $userData['name'][0];
                break;
                default:echo $userData['name'][0] ;
                    break;
                }
                ?></a>
                </li>
            <?php } ?>
        </ul>
            <?php } else{ ?>
                <ul class="breadcrumb">
                <li>
                <?php echo $this->lang->line('label_closingBalance'); ?> 
                </li>
               
                <li>
                <?php echo $closingBalance; ?> 
                </li>
                 </ul>
            <?php }?>
        <div class="">
            <ul class="nav nav-tabs nav-tabs-fillup bg-white" style="padding-top:10px;">
                <div class="col-sm-2">
                    <div class="form-group ">
                        <select id="search_by_select" class="form-control tableFilter" style="background-color:gainsboro;height:30px;font-size:12px;">
                            <option value="0" selected>Any</option>
                            <option value="CREDIT">MANUAL CREDIT</option>
                            <option value="DEBIT">MANUAL DEBIT</option>
                            <option value="DEBIT FOR COLLECTION">CREDIT AMOUNT COLLECTED</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group ">
                        <select id="search_by_trigger" class="form-control tableFilter" style="background-color:gainsboro;height:30px;font-size:12px;">
                            <option value="0" selected>Any</option>
                            <option value="MANUAL CREDIT">MANUAL CREDIT</option>
                            <option value="MANUAL DEBIT">MANUAL DEBIT</option>
                            <option value="MANUAL DEBIT FOR COLLECTION">CREDIT AMOUNT COLLECTED</option>
                            <option value="CREDIT BY PROMO CODE">CREDIT BY PROMO</option>
                            <option value="CREDIT BY REFERRAL CODE">CREDIT BY REFERRAL CODE</option>
                            <option value="DEBIT FOR BOOKING FEE">DEBIT FOR BOOKING FEE</option>
                            <option value="ADJUSTMENT">ADJUSTMENT</option>
                            <option value="CREDIT BY WALLET RECHARGE">CREDIT BY WALLET RECHARGE</option>
                        </select>
                    </div>
                </div>
                <?php if(!$isEntity){ ?>
                    <div class="pull-right cls110">
                        <?php if($userType != 'store') { ?>
                        <!-- <button style="width : 150px;font-size: 11px;" class="btn btn-danger" id="credit_debit_button">MANUAL CREDIT/DEBIT</button> -->
                        <?php } ?>
                    </div>
                <?php } ?>
            </ul>
            <ul class="nav nav-tabs nav-tabs-fillup bg-white">
                <div class="col-sm-4">
                    <div class="" aria-required="true">
                        <div class="input-daterange input-group">
                            <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">
                        </div>
                    </div>
                </div>
                <button style="width:94px;font-size: 11px;" class="btn btn-primary" type="button" id="searchData">Search</button>
                <button  style="width:94px;font-size: 11px;" class="btn btn-info" type="button" id="clearData">Clear</button>
                <div class="pull-right cls100">
                    <button  style="width:94px;font-size: 11px;" class="btn btn-info" type="button" id="exportData">
                        Export
                    </button>
                    <div id="dynamicFormExport"></div>
                </div>
            </ul>

            <div class="col-xs-12">
                <div class="row panel panel-transparent ">
                    <div class="col-xs-12 container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="row panel panel-transparent">
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
                                <div class="col-sm-4" style="margin-bottom:10px;">
                                    <div class="pull-right">
                                        <input type="text" id="search-table" class="form-control pull-right"  placeholder="Search"/> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 panel-body">
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
                                <option value="3">CREDIT AMOUNT COLLECTED<option>
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