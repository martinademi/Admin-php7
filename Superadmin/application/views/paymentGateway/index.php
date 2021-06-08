
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    .btn {
        border-radius: 25px !important;
    }
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }
    .pageAdj{
        margin-top: -35px;
        padding-top: 15px;
        margin-left: -50px;
        margin-right: -50px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .btnWidth{
        width: 35px;
    }

  /* The switch - the box around the slider */
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
    opacity: 0;
    width: 0;
    height: 0;
    }

    /* The slider */
    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }

</style>
<script src="<?php echo base_url(); ?>/css/loadingImage.css"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
var bankAccountlinking="false";
var iban="false";
var accNumber="false";

var editbankAccountlinking;
var editiban;
var editaccNumber;

        $(document).ready(function (){
            $(document).ajaxComplete(function () {
        // console.log("hsdfsdf");
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

// banking enabled check

            $('#bankAccountLinking').change(function () {
                    if( $(this). prop("checked") == true){
                        bankAccountlinking="enabled";
                        $('.linking').show();
                    }   else{
                        bankAccountlinking="disabled";
                        $('.linking').hide();
                    }                 
            });

            // iban number
            $('#iban').change(function () {
                    if( $(this). prop("checked") == true){
                        iban='true';
                    }   else{
                        iban='false';
                    }                 
            });

            // account number

            $('#accountNumber').change(function () {
                    if( $(this). prop("checked") == true){
                        accNumber='true';
                    }   else{
                        accNumber='false';
                    }                 
            });

            // for edit

            $('#editbankAccountLinking').change(function () {
                    if( $(this). prop("checked") == true){
                        editbankAccountlinking="enabled";
                        $('.editlinking').show();
                    }   else{
                        editbankAccountlinking="disabled";
                        $('.editlinking').hide();
                    }                 
            });

            // iban number
            $('#editiban').change(function () {
                    if( $(this). prop("checked") == true){
                        editiban='true';
                    }   else{
                        editiban='false';
                    }                 
            });

            // account number

            $('#editaccountNumber').change(function () {
                    if( $(this). prop("checked") == true){
                        editaccNumber='true';
                    }   else{
                        editaccNumber='false';
                    }                 
            });



        });
</script>
<script type="text/javascript">
    var currentTab = 1;
    $(document).ready(function () {


        $('#btnStickUpSizeToggler').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $('#addPaymentGateway').removeClass("hidden");
            $('#gatewayNameErr').text("");
            $('#commissionErr').text("");
            $('#fixedCommissionErr').text("")
            $('#gatewayName').val("");
            $('#commission').val("");
            $('#fixedCommission').val("");
            if (val.length == 0) {
                $('#addmodal').modal('show');
            } else {
                $('#displayData').modal('show');
                $('#display-data').text('Invalid selection');
            }
        });

        $('#gatewayName').keypress(function () {
            $('#gatewayNameErr').text("");
        });
        $('#commission').keypress(function () {
            $('#commissionErr').text("");
        });
        $('#fixedCommission').keypress(function () {
            $('#fixedCommissionErr').text("");
        });
        $('#addPaymentGateway').click(function () {

          


            var gatewayName = $('#gatewayName').val();
            var commission = $('#commission').val();
            var fixedCommission = $('#fixedCommission').val();
            var bankAccLinking=bankAccountlinking;
            var dataIban=iban;
            var dataAccNumber=accNumber;
          
          

            if (gatewayName == '' || gatewayName == null) {
                $('#gatewayNameErr').text("Please enter gateway name");

            } else if (commission == '' || commission == null) {
                $('#gatewayNameErr').text("");
                $('#commissionErr').text("Please enter % commission");
            }else if(!commission.match(/^\d+/)){
                $('#gatewayNameErr').text("");
                $('#commissionErr').text("Please enter Numaric Value");
            }
            else if(!fixedCommission.match(/^\d+/) && fixedCommission != ''){
                $('#fixedCommission').text("");
                $('#fixedCommissionErr').text("Please enter % Numaric Value");
            }else {
                $('#addPaymentGateway').addClass("hidden");
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php?/PaymentGateway/addPaymentGateway",
                    type: "POST",
                    data: {gatewayName: gatewayName, commission: commission, fixedCommission: fixedCommission,bankAccountLinking:bankAccLinking,iban:dataIban,accNum:dataAccNumber},
                    dataType: "JSON",
                    async: false,
                    success: function (result) {
                        if (result.flag == 1) {

                            $('#addmodal').modal('hide');
                            $('#display-data').text("Successfully added...");
                            $('#displayData').modal('show');
                            $('#big_table_processing').show();
                            var table = $('#big_table');
                            $('#big_table').fadeOut('slow');
                            $('.cs-loader').show();
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/PaymentGateway/datatablePaymentGateway/1',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                },
                                "fnInitComplete": function () {
                                    $('.cs-loader').hide();
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
                            table.dataTable(settings);
                        } else {
                            $('#addmodal').modal('hide');
                            $('#display-data').text("Tax with same name exist");
                            $('#displayData').modal('show');

                        }

                    }


                });
            }
        });

        $('#editGatewayName').keypress(function () {

            $('#editGatewayNameErr').text("");
        });
        $('#editCommission').keypress(function () {

            $('#editCommissionErr').text("");
        });
        $('#editFixedCommission').keypress(function () {

            $('#editFixedCommissionErr').text("");
        });

        $('#updatePaymentGateway').click(function () {

            var val = $(this).val();
            var gatewayName = $('#editGatewayName').val();
            var commission = $('#editCommission').val();
            var fixedCommission = $('#editFixedCommission').val();
            var editbankAccLinking=editbankAccountlinking;
            var editdataIban=editiban;
            var editdataAccNumber=editaccNumber;


            if (gatewayName == '' || gatewayName == null) {
                $('#editGatewayNameErr').text("Please enter gateway name");
            } else if (commission == '' || commission == null) {
                $('#editCommission').text("");
                $('#editCommissionErr').text("Please enter % commission");
            } else if(!commission.match(/^\d+/)){
                $('#editCommission').text("");
                $('#editCommissionErr').text("Please enter Numaric Value");
            }
            else if(!fixedCommission.match(/^\d+/) && fixedCommission != ''){
                $('#editFixedCommission').text("");
                $('#editFixedCommissionErr').text("Please enter % Numaric Value");
            }else {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php?/PaymentGateway/updatePaymentGateway",
                    type: "POST",
                    data: {val: val, gatewayName: gatewayName, commission: commission, fixedCommission: fixedCommission,editbankAccountLinking:editbankAccLinking,editiban:editdataIban,editaccNum:editdataAccNumber},
                    dataType: "JSON",
                    async: false,
                    success: function (result) {

                        if (result.flag == 1) {
                            $('#editModal').modal('hide');
                            $('#display-data').text("Successfully edited...")
                            $('#displayData').modal('show');
                            $('#big_table_processing').show();
                            var table = $('#big_table');
                            $('#big_table').fadeOut('slow');
                            $('.cs-loader').show();
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/PaymentGateway/datatablePaymentGateway/1',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                },
                                "fnInitComplete": function () {
                                    $('.cs-loader').hide()
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
                            table.dataTable(settings);
                        } else {
                            $('#editModal').modal('hide');
                            $('#display-data').text("Something went wrong");
                            $('#displayData').modal('show');

                        }

                    }


                });
            }
        });
        $(document).on('click', '.editPaymentGateway', function () {

            var val = $(this).val();
            $('#updatePaymentGateway').val(val);

            if (val) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php?/PaymentGateway/getOnePaymentGateway",
                    type: "POST",
                    data: {val: val},
                    dataType: "JSON",
                    async: false,
                    success: function (result) {
                        console.log('data---',result);
                        $('#editGatewayName').val(result.data.gatewayName);
                        $('#editCommission').val(result.data.percentageCommission);
                        $('#editFixedCommission').val(result.data.fixedCommission);
                        $('#editModal').modal('show');

                        // cool
                        // banking details
                        if(result.data.bankAccountingLinking==1){
                            
                            editbankAccountlinking="enabled";
                            $('#editbankAccountLinking').prop('checked', true);
                            $('.editlinking').show();
                        }else{
                            editbankAccountlinking="disabled";
                            $('#editbankAccountLinking').prop('checked', false);
                            $('.editlinking').hide();
                        }

                        // iban
                        if(result.data.iban==1){
                            $('#editiban').prop('checked', true);
                        }else{
                            $('#editiban').prop('checked', false);
                        }


                        // account number

                        if(result.data.accountNumber==1){
                            $('#editaccountNumber').prop('checked', true);
                        }else{
                            $('#editaccountNumber').prop('checked', false);
                        }


                    }
                });

            } else {
                $('#displayData').modal('show');
                $('#display-data').text('Invalid selection');
            }

        });
        $('#approveButtonPaymentGateway').click(function () {

//            var val =$(this).val();
//            $('#approvePaymentGateway').val(val);
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $('#displayData').modal('show');
                $('#display-data').text('Invalid selection');
            } else {
                $('#approveModel').modal('show');
                $('.modalPopUpText').text('Are you sure, you want to re-activate the payment gateway?');
            }


        });
        $('#approvePaymentGateway').click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/PaymentGateway/approvePaymentGateway",
                type: "POST",
                data: {val: val},
                dataType: "JSON",
                async: false,
                success: function (result) {

                    if (result.flag == 1) {

                        $('#approveModel').modal('hide');
                        $('#display-data').text("Successfully approved...")
                        $('#displayData').modal('show');
                        $('#big_table_processing').show();
                        var table = $('#big_table');
                        $('#big_table').fadeOut('slow');
                        $('.cs-loader').show();
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/PaymentGateway/datatablePaymentGateway/2',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                            },
                            "fnInitComplete": function () {
                                $('.cs-loader').hide()
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
                        table.dataTable(settings);
                    } else {

                        $('#editModal').modal('hide');
                        $('#display-data').text("Something went wrong");
                        $('#displayData').modal('show');

                    }

                }


            });

        });

        $('#delPaymentGateway').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {

                $('#displayData').modal('show');
                $('#display-data').text('Invalid selection');

            } else {
                $('.modalPopUpText').text('Are you sure you want to delete gateway?');
                $('#deleteModal').modal('show');
            }

        });

        $('#deletePaymentGateway').click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/PaymentGateway/deletePaymentGateway",
                type: "POST",
                data: {val: val},
                dataType: "JSON",
                async: false,
                success: function (result) {

                    if (result.flag == 1) {

                        $('#deleteModal').modal('hide');
                        $('#display-data').text("Successfully deleted...")
                        $('#displayData').modal('show');
                        $('#big_table_processing').show();
                        var table = $('#big_table');
                        $('#big_table').fadeOut('slow');
                        $('.cs-loader').show();
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/PaymentGateway/datatablePaymentGateway/1',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                            },
                            "fnInitComplete": function () {
                                $('.cs-loader').hide()
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
                        table.dataTable(settings);
                    } else {

                        $('#editModal').modal('hide');
                        $('#display-data').text("Something went wrong");
                        $('#displayData').modal('show');

                    }

                }


            });

        });
        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];

            if (status == 1) {
                $('#delPaymentGateway').show();
                $('#approveButtonPaymentGateway').hide();
                $('#big_table').dataTable().fnSetColumnVis([6], false);
            }

        });
        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');

            if (currentTab != tab_id)
            {
                $('#big_table').hide();
                $('#big_table').hide();
                $("#display-data").text("");

                console.log(currentTab);

                if ($(this).data('id') == 2) {
                    $("#display-data").text("");
                    $('#delPaymentGateway').hide();
                    $('#btnStickUpSizeToggler').hide();
                    $('#approveButtonPaymentGateway').show();

                }




                $('#big_table_processing').toggle();

                var table = $('#big_table');
                $('.cs-loader').show();
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
                        "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                    },
                    "fnInitComplete": function () {
                        $('.cs-loader').hide()
                        //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
                        $('#big_table').show();
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
                var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                var status = urlChunks[urlChunks.length - 1];


                switch (parseInt(status)) {

                    case 2:
                        $('#big_table').dataTable().fnSetColumnVis([4, 6], false);
                        $('#delPaymentGateway').hide();

                        break;

                }
            } else {
                $('#delPaymentGateway').show();
                $('#btnStickUpSizeToggler').show();
                $('#approveButtonPaymentGateway').hide();

                $('#big_table_processing').toggle();
                $('.cs-loader').show();
                var table = $('#big_table');

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
                        "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                    },
                    "fnInitComplete": function () {
                        $('.cs-loader').hide()
                        //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
                        $('#big_table').show();
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
                var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                var status = urlChunks[urlChunks.length - 1];


                switch (parseInt(status)) {
                    case 1:
                        $('#big_table').dataTable().fnSetColumnVis([6], false);

                        break;
                }

            }

        });


        $('#big_table_processing').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        $('.cs-loader').show();
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/PaymentGateway/datatablePaymentGateway/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null
            ],
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('.cs-loader').hide()
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
        table.dataTable(settings);
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
    });
    function isNumberKey(evt)
    {
        $("#mobify").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#mobify").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            $('#commission').val('');
            return false;

        }
        return true;
    }

// click
    
    

    

</script>

<style>
    .exportOptions{
        display: none;
    }
</style>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('PAYMENT_GATEWAYS'); ?></strong>
        </div>
        <!-- Nav tabs --> 

        <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

            <li id="1" data-id="1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/PaymentGateway/datatablePaymentGateway/1" data-id="1"><span><?php echo $this->lang->line('Active'); ?></span><span class="badge newDriverCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="2" data-id="2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/PaymentGateway/datatablePaymentGateway/2" data-id="2"><span><?php echo $this->lang->line('Deleted'); ?></span> <span class="badge acceptedDriverCount" style="background-color:#3CB371;"></span></a>
            </li>


            <div class="pull-right m-t-10 cls111"> <button class="btn btn-success cls111" id="approveButtonPaymentGateway" ><span><?php echo $this->lang->line('Activate'); ?></button></a></div>
            <div class="pull-right m-t-10 cls111"> <button class="btn btn-danger cls111" id="delPaymentGateway" ><span><?php echo $this->lang->line('Delete'); ?></button></a></div>

            <div class="pull-right m-t-10  cls110"> <button class="btn btn-primary cls110" id="btnStickUpSizeToggler"><span><?php echo $this->lang->line('Add'); ?></span></button></a></div>


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
                                    <div class="row">
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
                                    <div cass="col-sm-6">
                                        <div class="searchbtn row clearfix pull-right" >
                                            <div class="pull-right"><input type="text" id="search-table"  style="margin-right:0px !important;" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
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
    <!-- END FOOTER -->
</div>



<div class="modal fade" id="displayData" role="dialog">
    <div class="modal-dialog">                                        
        <!-- Modal content-->
        <div class="modal-content">   
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>  
                <span class="modal-title"><?php echo $this->lang->line('ALERT'); ?></span>

            </div>
            <div class="modal-body">
                <h5 class="error-box modalPopUpText" id="display-data" style="text-align:center"></h5>                                            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Ok'); ?></button>
            </div>
        </div>                                            
    </div>
</div> 

<div id="addmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Add_Payment_Gateway'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row row-same-height">
                    <div class="row">
                        <div class="col-sm-12">

                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('Gateway_Name'); ?><span
                                    class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-5">
                                <input type="text" id="gatewayName" name="gatewayName" class="gatewayName form-control">
                            </div>
                            <div class="col-sm-3" id="gatewayNameErr" style="color:red"></div>


                        </div>
                    </div>

                    <br/>


                    <div class="row">
                        <div class="col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('Commission'); ?><span
                                    class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-5">
                                <input type="text" id="commission"  name="commission" class="commission form-control" onkeypress="return isNumberKey(event)" >
                            </div>
                            <div class="col-sm-3" id="commissionErr" style="color:red;"></div>

                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('Fixed_Commission'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" id="fixedCommission" name="fixedCommission" class="fixedCommission form-control" onkeypress="return isNumberKey(event)">
                            </div>
                            <div class="col-sm-3" id="fixedCommissionErr" style="color:red;"></div>

                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('Bank_account_linking'); ?></label>
                            <div class="col-sm-5">
                                <label class="switch"> <input type="checkbox" id="bankAccountLinking" name="bankAccountLinking">  <span class="slider round"></span></label>
                            </div>
                            <div class="col-sm-3" id="fixedCommissionErr"></div>

                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"></label>
                            <div class="col-sm-5">
                                <input type="checkbox" class="linking" name="accLnk" value="IBAN" id="iban" style="display:none"><span class="linking" style="display:none" > IBAN<br>
                                <input type="checkbox" class="linking" name="accLnk" value="AccountNumber" id="accountNumber" style="display:none"><span class="linking" style="display:none"> Account Number<br>

                            </div>
                            <div class="col-sm-3" id="fixedCommissionErr"></div>

                        </div>
                    </div>
                    <br/>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-success" id="addPaymentGateway"><?php echo $this->lang->line('Add'); ?></button>
            </div>
        </div>

    </div>
</div>
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('EditPaymentGateway'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row row-same-height">
                    <div class="row">
                        <div class="col-sm-12">

                            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Gateway_Name'); ?><span
                                    class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text" id="editGatewayName" name="gatewayNameEdit" class="gatewayNameEdit form-control">
                            </div>
                            <div class="col-sm-3" id="editGatewayNameErr" style="color:red"></div>


                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Commission'); ?><span
                                    class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text" id="editCommission"  name="commission" class="commissionEdit form-control" onkeypress="return isNumberKey(event)">
                            </div>
                            <div class="col-sm-3" id="editCommissionErr" style="color:red"></div>

                        </div>
                    </div>

                    <br/>
                    <!-- cool -->
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Fixed_Commission'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" id="editFixedCommission" name="fixedCommission" class="fixedCommissionEdit form-control" onkeypress="return isNumberKey(event)">
                            </div>
                            <div class="col-sm-3" id="editFixedCommissionErr" style="color:red"></div>

                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('Bank_account_linking'); ?></label>
                            <div class="col-sm-5">
                                <label class="switch"> <input type="checkbox" id="editbankAccountLinking" name="bankAccountLinking">  <span class="slider round"></span></label>
                            </div>
                            <div class="col-sm-3" id="fixedCommissionErr"></div>

                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"></label>
                            <div class="col-sm-5">
                                <input type="checkbox" class="editlinking" name="accLnk" value="IBAN" id="editiban" style="display:none"><span class="editlinking" style="display:none" > IBAN<br>
                                <input type="checkbox" class="editlinking" name="accLnk" value="AccountNumber" id="editaccountNumber" style="display:none"><span class="editlinking" style="display:none"> Account Number<br>

                            </div>
                            <div class="col-sm-3" id="fixedCommissionErr"></div>

                        </div>
                    </div>
                    <br/>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-success" id="updatePaymentGateway"><?php echo $this->lang->line('Save'); ?></button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade stick-up" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?php echo $this->lang->line('ALERT'); ?></span>
            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="deleModalText" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>

                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <button type="button" class="btn btn-danger pull-right" id="deletePaymentGateway" ><?php echo $this->lang->line('Delete'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="approveModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?php echo $this->lang->line('Alert'); ?></span>
            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="approveModelText" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>

                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <button type="button" class="btn btn-success pull-right" id="approvePaymentGateway" ><?php echo $this->lang->line('Approve'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div id="wait" style="display:none;width:100px;height:100px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>pics/spinner.gif' width="64" height="64" /><br>Loading..</div>