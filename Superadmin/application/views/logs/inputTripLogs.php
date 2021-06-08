
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
</style>
<script src="<?php echo base_url(); ?>/css/loadingImage.css"></script>
<script>
    $(document).ready(function () {
        
        $('.businesscat').addClass('active');
        $('.businesscat').attr('src', "<?php echo base_url(); ?>/theme/icon/business_mgt_on.png");
        $('.businesscat_thumb').addClass("bg-success");

    });



    function moveUp(id) {
       
        
        var row = $(id).closest('tr');
        var prev_id = row.prev('tr').find('.moveUp').attr('id')
        var curr_id = row.find('.moveUp').attr('id');

        $.ajax({
            url: "<?php echo base_url() ?>index.php?/logs/getInputTripLogs",
            type: "POST",
            data: {kliye: 'interchange', curr_id: curr_id, prev_id: prev_id},
            success: function (result) {

            }
        });
        row.prev().insertAfter(row);
        $('#saveOrder').trigger('click');
//        });
    }
    function moveDown(id) {

        var row = $(id).closest('tr');
        var prev_id = row.find('.moveDown').attr('id');
        var curr_id = row.next('tr').find('.moveDown').attr('id');

        $.ajax({
            url: "<?php echo base_url() ?>index.php?/logs/getInputTripLogs",
            type: "POST",
            data: {kliye: 'interchange', prev_id: prev_id, curr_id: curr_id},
            success: function (result) {

//                    alert("intercange done" + result);

            }
        });
        row.insertAfter(row.next());
        $('#saveOrder').trigger('click');
//        });
    }

    function validatecat() {
      
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/logs/getInputTripLogs",
            type: "POST",
            data: {catname: $('#catname_0').val()},
            dataType: "JSON",
            success: function (result) {

                // alert();
//                alert(result.count);
                console.log(result.count);
                $('#catname_0').attr('data', result.msg);

                if (result.count == true) {

                    $("#clearerror").html("Category name already exists.");
                    $('#catname_0').focus();
                    return false;
                } else if (result.count != true) {
                    $("#clearerror").html("");

                }
            }
        });
    }


</script>

<script type="text/javascript">
    $(document).ready(function () {


$(document).on('click','.inputTripLogs',function ()
   {
    var userId = $(this).attr('userId');

        $.ajax({
                    url: "<?php echo APILink ?>" + "customerDetailsById/" + userId,
                    type: 'GET',
                    dataType: 'json',
                    headers:{
                            language: 0
                            },
                    data: {                  
                            },
                    }).done(function(json) {
                        console.log(json)
                        console.log(json.data.length);
                        $("#modalData").html('');
                        if (json.data.length == 0) {
                            $("#modalData").append('<span style="font-size: 15px !important; text-align: center !important; color: coral !important;">User not found</span>');
                            $("#userDetails").modal();
                        }else{
                            var tableData = 
                            '<table class="table table-bordered" id="tableData">' +
                                  '<tr>' +
                                    '<th>Name</th>'+
                                    '<td id="modalUserName">' + json.data[0].name + '</td>' +
                                  '</tr>' + 
                                  '<tr>' + 
                                    '<th> Telephone</th>'+
                                    '<td id="modalContactNumber">' + json.data[0].phone+'</td>' +
                                  '</tr>' + 
                                  '<tr>' +
                                    '<th>Email</th>' +
                                    '<td id="modalEmail">'+json.data[0].email +'</td>' +
                                  '</tr>' +
                              '</table>';
                            $("#modalData").append(tableData);
                            $("#userDetails").modal();
                            
                        }

                        
                });
        });
        /*changes*/
        $('#big_table_processing').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
    
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/logs/getInputTripLogs',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
            "columns": [
                null,
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
            }
        };
        table.dataTable(settings);
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });


        $('.whenclicked li').click(function () {
            if ($(this).attr('id') == 1) {

                $('#btnStickUpSizeToggler').show();
                $('#edit').show();
                $('#bdelete').show();
                $('#Sedit').hide();
                $('#SbtnStickUpSizeToggler').hide();
                $('#Sdelete').hide();
            } else if ($(this).attr('id') == 2) {

                $('#btnStickUpSizeToggler').hide();
                $('#edit').hide();
                $('#bdelete').hide();
                $('#Sedit').show();
                $('#SbtnStickUpSizeToggler').show();
                $('#Sdelete').show();
            }
        });
        $('.changeMode').click(function () {

            var table = $('#big_table');
            $('#big_table').fadeOut('slow');
            $('#big_table_processing').show();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 10,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "columns": [
                    null,
                    null,
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
                }
            };
            $('.tabs_active').removeClass('active');
            $(this).parent().addClass('active');
            table.dataTable(settings);
        });

        $("#refreshButton").click(function(){
            $('#big_table_processing').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
    
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/logs/getInputTripLogs',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
            "columns": [
                null,
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
            }
        };
        table.dataTable(settings);





        });



    });
    function refreshTableOnCityChange() {

        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        $('#big_table_processing').show();
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": $(".whenclicked li.active").children('a').attr('data'),
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
            "columns": [
                null,
                null,
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
            }
        };
        table.dataTable(settings);
    }
</script>
<script>
    $('.changeMode').click(function () {

        $('#big_table_processing').toggle();

        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": $(this).attr('data'),
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
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

    });



</script>
<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong>INPUT TRIP LOGS</strong>

        </div>
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent pageAdj">
                   

                    <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
                        <div class="pull-right m-t-10 cls111" > <button class="btn btn-info " id="refreshButton">Refresh</button></div>
                        
                    </ul>
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                    <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog">                                        
                                            <!-- Modal content-->
                                            <div class="modal-content">   
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                                    <span class="modal-title">ALERT</span>

                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="error-box modalPopUpText" id="display-data" style="text-align:center"></h5>                                            
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>     

                                    <div class="searchbtn row clearfix pull-right" style="">

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search"> </div>
                                    </div>

                                </div>
                                <br>
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
        <!-- END JUMBOTRON -->

    </div>
    <!-- END PAGE CONTENT -->

</div>



<div id="wait" style="display:none;width:100px;height:100px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
    <img src='<?php echo base_url(); ?>pics/spinner.gif' width="64" height="64" /><br>Loading..</div>


<div class="modal fade stick-up" id="userDetails" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="margin-left: -80%; margin-right: -80%">
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <P style="font-size: 15px; font-weight: bold;">USER DETAILS</P>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>
            </div>
            <br>
            <div class="modal-body" id="modalData">
                
                
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" id="modalFooter">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>