
<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<style>
    .btn{
        border-radius: 25px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }

    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        width: 70%;
        margin: auto;
    }

  .bootstrap-timepicker-widget table td input{
        width: 60px !important;

    }

</style>
<script>
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


    //    add schedule cool
       $("#AddSchedule").click(function () {
            $('#insert_cat_group').prop('disabled',false);
            //$("#shiftTime").trigger('reset');

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length >= 1) {
                $("#msgpara").text("Invalid Selection");
                $("#msg_model").modal('show');
            } else
            {
                $('#myModal').modal('show');
                
            }


        });


        function callDataTable(status){
            $('#big_table_processing').show();
        $('.cs-loader').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/shiftsController/colors_details/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
                $('.cs-loader').hide();
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


        // insert shift timings
        $("#insert_cat_group").click(function () {

            console.log('insert')
            //get current time
            var offset = new Date().getTimezoneOffset();
           
            // var d = new Date();
            //     d.setMinutes(d.getMinutes() + offset);
            //         dformat = [(d.getFullYear()),
            //         (d.getMonth() + 1).padLeft(),
            //             d.getDate().padLeft()].join('-') +
            //         ' ' +
            //     [d.getHours().padLeft(),
            //             d.getMinutes().padLeft(),
            //             d.getSeconds().padLeft()].join(':');

           // var deviceTime = dformat;

            //end   
            var noofdelivery = $('#noofdelivery').val();
            // fields required strt
            var startTime = $('#starttime').val();
            var endTime = $('#endtime').val();
            var stTime = startTime+":00";
            var enTime = endTime+":00";
            var shiftName=$('#shiftName').val()
            // fields required end

            var dateObject = $("#startt").datepicker("getDate");
            var startDate = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject.getDate()).slice(-2)+' '+stTime;            
            var dateObject = $("#endd").datepicker("getDate"); // get the date object
            var endDate = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject.getDate()).slice(-2)+' '+enTime;            
            var repeatDay = parseInt($("#repeatDay").val());
            var duration = $('#duration').val();
            //zone Id
            var zoneId = '<?php echo $zoneId; ?>';          
            var catStatus = true;
         

            if(shiftName =='' || parseInt(shiftName) == 0){
                catStatus = false;
                $("#shiftErr").text("Please Enter shift Name");
            }

            if(startTime >= endTime){
                catStatus = false;
                $("#startTimeErr").text("Start time and end time is not correct");

            }
                       
             
            if (catStatus)
            {
                $("#insert_cat_group").prop("disabled",true);
        
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/ShiftsController/addSchduled/<?php echo $zoneId;?>/<?php echo $cityId;?>",
                    type: "POST",
                    data: {
                        //BusinessId:fid,
                        stTime:stTime,
                        enTime:enTime,
                        startTime: startTime,
                        endTime: endTime,
                        shiftName:shiftName,
                        status: 1,                        

                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        console.log(response);
                        $("#insert_cat_group").prop("disabled",false);
                        if (response.flag == 1)
                        {
                            
                            $(".close").trigger('click');
                            $("#repeatDay").val("0");
                            $("#duration").val("0");
                             // rload datatable

                             location.reload();

                           // callDataTable(1);                                                               


                          
                        }
                        else if(response.flag == 2){
                            
                           $(".close").trigger('click');
                           $("#myModal").modal('hide');
                            $("#repeatDay").val("0");
                            $("#duration").val("0");
                            $("#msgpara").text(response.msg);
                            $("#msg_model").modal('show');

                        }
                    }
                });
            }

        });


        $(document).on('click','.btndelete',function () {
            var valid = $(this).attr('data-id');
            $('#msg_data').text("Are you sure you want to delete the slot?");
            $('#msgid').val(valid);
            $('#confirmModal').modal('show');            
           
        });

        $('#yes').click(function(){
            var val = $('#msgid').val();
            if(val!=0 || val !='' || val!=null){
             //  console.log("val",val);
             var zoneId = '<?php echo $zoneId; ?>';
             $.ajax({
                    url: "<?php echo base_url() ?>index.php?/ShiftsController/deleteSchduled",
                    type: "POST",
                    data: {
                        whId:val
                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        $('#confirmModal').modal('hide');
                        callDataTable(zoneId,1);
                        $('#showMsg').text('Slot Deleted Successfully');
                        $('#afterDelete').modal('show');
                    }
                    })

           }
        });


        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            var forwhat = urlChunks[urlChunks.length - 2];

            if (status == 2) {
                console.log('in')
                $('#big_table').dataTable().fnSetColumnVis([4], false); 

            }
           
          
           
        });

});
</script>
<script>
    var currentTab = 1;
    $(document).ready(function () {

        $('#big_table_processing').show();
        $('.cs-loader').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/shiftsController/colors_details/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
                $('.cs-loader').hide();
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
        // search box for table

        $('#add').show();
        $('#edit').show();
        $('#activate').hide();
        $('#deactivate').show();

        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class').change(function () {
            $('.error-box').text('');
        });

        $('#add').click(function () {
             $(".error-box").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                tabURL = $('li.active').children("a").attr('data');

                $("#display-data").text("");
                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();

                if (val.length == 0) {
                    $('#addColor').modal('show');
                } else {
                    $('#alertForNoneSelected').modal('show');
                    $("#display-data").text("Invalid Selection");

                }
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Invalid Selection...');
            }
        });

        $("#yesAdd").click(function () {

            $(".error-box").text("");

            $('#yesAdd').prop('disabled', false);

            var colorName = new Array();
            $(".colorsname").each(function () {
                colorName.push($(this).val());
            });
            
            var cName = $('#name_0').val();
            if (cName == '' || cName == null)
            {
                $('#name_0').focus();
                $(".error-box").text('<?php echo $this->lang->line('error_name'); ?>');
            } else {

                $('#yesAdd').prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/shiftController') ?>/addColors",
                    type: "POST",
                    dataType: 'json',
                    data: {colorName: colorName},
                    success: function (result) {
                        console.log(result)
                        if (result.flag == 1) {
                            $('#addColor').modal('hide');
                            window.location.reload();
                        } else if (result.flag == 0) {

                            $('#errorModal').modal('show')
                            $(".modalPopUpText").text('Color Name is already exist');
                            $('#yesAdd').prop('disabled', false);
                        }
                    }
                });
            }
            $(".error-box-class").val("");
        });

//        $('#edit').click(function () {
        var editval = '';
        $(document).on('click', '#btnedit', function () {
         $(".error-box").text("");
            editval = $(this).val();

            $.ajax({
                url: "<?php echo base_url('index.php?/shiftController') ?>/getColor",
                type: "POST",
                dataType: 'json',
                data: {colorId: editval},
                success: function (result) {
                    $('#editname_0').val(result.data.colorName['en']);
<?php foreach ($language as $val) { ?>
                        $('#editname_<?= $val['lan_id'] ?>').val(result.data.colorName['<?= $val['langCode'] ?>']);
<?php } ?>
                    $('#editColorModal').modal('show');

                }
            });


        });

        $("#yesEdit").click(function () {
            $(".error-box").text("");

            $(this).prop('disabled', false);

            var colorName = new Array();
            $(".editcolorsname").each(function () {
                colorName.push($(this).val());
            });
            // if (colorName.length <= 0)
            // {
            //     $('#name_0').focus();
            //     $(".error-box").text('<?php echo $this->lang->line('error_name'); ?>');
            // } else {

           var cName = $('#editname_0').val();
            if (cName == '' || cName == null)
            {
                $('#editname_0').focus();
                $(".error-box").text('<?php echo $this->lang->line('error_name'); ?>');
            } else {


                $(this).prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/shiftController') ?>/editColor",
                    type: "POST",
                    data: {colorId: editval, colorName: colorName},
                    success: function (result) {
                        console.log(result);
                        if (result == "true") {
                            $('#editColorModal').modal('hide');
                            window.location.reload();
                        }

                    }
                });
            }

        });

        $("#activate").click(function () {
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length >= 1) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#activateColor');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#activateColor').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxactivateColor").text('<?php echo $this->lang->line('alert_activate'); ?>');

            } else if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_select'); ?>');
            }

        });




        $("#yesActivate").click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            $.ajax({
                url: "<?php echo base_url('index.php?/shiftController') ?>/activateColor",
                type: "POST",
                data: {colorId: val},
                success: function (result) {

                    var res = JSON.parse(result)
                    $('#activateColor').modal('hide');
                    if (res.flag == 0) {
                        var table = $('#big_table');
                        $('#big_table').fadeOut('slow');
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/shiftController/colors_details/2',
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

                        table.dataTable(settings);
                    } else {
                        $('#errorModal').modal('show')
                        $(".modalPopUpText").text('Selected color has not been activated');
                    }
                }
            });
        });


        $("#deactivate").click(function () {
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length >= 1) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#deactivateColor');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#deactivateColor').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdeactivate").text('<?php echo $this->lang->line('alert_deactivate'); ?>');

            } else if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_oneselect'); ?>');
            }

        });

        $('#yesdeactivate').click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            $.ajax({
                url: "<?php echo base_url('index.php?/shiftController') ?>/deactivateColor",
                type: "POST",
                data: {colorId: val},
                success: function (result) {
                    console.log(JSON.parse(result));
                    var res = JSON.parse(result)
                    $('#deactivateColor').modal('hide');
                    if (res.flag == 0) {
                        var table = $('#big_table');
                        $('#big_table').fadeOut('slow');
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/shiftController/colors_details/1',
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

                        table.dataTable(settings);
                    } else {
                        $('#errorModal').modal('show')
                        $(".modalPopUpText").text('Selected color has not been deactivated');
                    }


                }
            })
        });

        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');

            if (currentTab != tab_id)
            {
//                console.log(tab_id);
                $('#big_table').hide();
                $("#display-data").text("");

                if ($(this).data('id') == 2) {
                    $("#display-data").text("");
                    $('#add').hide();
                    $('#edit').show();
                    $('#activate').show();
                    $('#deactivate').hide();
                }

                $('#big_table_processing').toggle();

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
                    },
                    "fnInitComplete": function () {
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

            } else {

                $('#add').show();
                $('#edit').show();
                $('#activate').hide();
                $('#deactivate').show();

                $('#big_table_processing').toggle();

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

            }

        });

    });

</script>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('heading_page'); ?></strong>
        </div>
        <!-- Nav tabs -->
        <div class="panel panel-transparent ">
            <!-- Nav tabs -->

            <ul class="nav nav-tabs  bg-white whenclicked">
                <li id= "my1" class="tabs_active active" style="cursor:pointer">
                    <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/shiftsController/colors_details/1" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                </li>

                <li id= "my2" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/shiftsController/colors_details/2" data-id="2"><span><?php echo $this->lang->line('heading_deactive'); ?></span> <span class="badge bg-red"></span></a>
                </li>

                <!-- <div class="pull-right m-t-10"> <button class="btn btn-info cls111" id="deactivate"><?php echo $this->lang->line('button_deactivate'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-info cls111" id="activate"><?php echo $this->lang->line('button_activate'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10 cls110" id="add"><?php echo $this->lang->line('button_add'); ?> </button></a></div> -->

                <div class="">
                         <button class="btn btn-info" type="button" id="AddSchedule" style="float:right;margin-top: 10px;">Add</button>
                </div>   

            </ul>
            
        </div>
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
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

                                    <div cass="col-sm-6">
                                        <div class="searchbtn row clearfix pull-right" >
                                            <div class="pull-right"><input type="text" id="search-table"  style="margin-right:0px !important;" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
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

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h4 id="modalTitle"></h4>
                </div>
            </div>

            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText modalTitleText " id="errorboxdata" ></div>
                </div>
            </div>
            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>

                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" >Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="addColor" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_add'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="colorsname form-control error-box-class" id="name_0" name="colorName[0]"  minlength="3" placeholder="Enter color name" required="">  

                        </div>
                        <div class="col-sm-4 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-5 pos_relative2">

                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="colorName[<?= $val['lan_id'] ?>]"  placeholder="Enter color name" class="colorsname error-box-class  form-control">

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-5 pos_relative2">

                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="colorName[<?= $val['lan_id'] ?>]"  placeholder="Enter color name" class="colorsname error-box-class  form-control">

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel6"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesAdd" ><?php echo $this->lang->line('button_add'); ?></button></div>
                </div>

            </div>
        </div>


    </div>
</div>
<div id="editColorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_edit'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="editcolorsname form-control error-box-class" id="editname_0" name="colorName[0]"  minlength="3" placeholder="Enter color name" required="">  

                        </div>
                        <div class="col-sm-4 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-5 pos_relative2">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="colorName[<?= $val['lan_id'] ?>]"  placeholder="Enter color name" class="editcolorsname error-box-class  form-control">

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-5 pos_relative2">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="colorName[<?= $val['lan_id'] ?>]"  placeholder="Enter color name" class="editcolorsname error-box-class  form-control">

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel6"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesEdit" ><?php echo $this->lang->line('button_save'); ?></button></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade stick-up" id="activateColor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxactivateColor" style="text-align:center">Activate</div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel5"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="yesActivate" ><?php echo $this->lang->line('button_activate'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="deactivateColor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DEACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxdeactivate" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel51"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdeactivate" ><?php echo $this->lang->line('button_deactivate'); ?></button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="errorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p class="error-box modalPopUpText"></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>


<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >ADD SHIFT TIMINGS</span>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="shiftTime" data-parsley-validate="" class="form-horizontal form-label-left">


                    <div class="form-group" class="formex" style="display: none">
                        <label for="fname" class="col-sm-4 control-label">Repeat Schedule<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select onchange="checkDays(this)" id="repeatDay" name="repeatDay"  class="form-control error-box-class">
                                <option value=0>Select Schedule</option>
                                <option value=1>Every-Day</option>
                                <option value=2>Week-Day</option>
                                <option value=3>Week-End</option>
                                <option value=4>Select Days</option>
                            </select>
                        </div>
                        <div class="col-sm-3 error-box errors" id="RepeatScheduleError">
                        </div>
                    </div>


                    <div class="form-group" class="formex" id='bTypeBlock' style="display: none">
                        <label for="fname" class="col-sm-4 control-label ">Days<span style="color:red;font-size: 12px"></span></label>
                        <div class="col-md-6 col-sm-5 col-xs-12">
                            <label><input type="checkbox" class="messageCheckbox" id="Mon"  value="Mon" name="schedule[]"> Mon</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Tue"  value="Tue" name="schedule[]"> Tue</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Wed"  value="Wed" name="schedule[]"> Wed</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Thu"  value="Thu" name="schedule[]"> Thu</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Fri"  value="Fri" name="schedule[]"> Fri</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Sat"  value="Sat" name="schedule[]"> Sat</label>  &nbsp;
                            <label><input type="checkbox" class="messageCheckbox" id="Sun"  value="Sun" name="schedule[]"> Sun</label>  &nbsp;
                        </div>
                        <div class="col-sm-3 error-box errors" id="DaysErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex" style="display: none">
                        <label for="fname" class="col-sm-4 control-label">Duration<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select onchange="checkDuration(this)" id="duration" name="duration"  class="form-control error-box-class">
                                <option value=0>Select Duration</option>
                                <option value=1>This Month</option>
                                <option value=2>2 Months</option>
                                <option value=3>3 Months</option>
                                <option value=4>4 Months</option>
                                <option value=5>Custom</option>
                            </select>
                        </div>
                        <div class="col-sm-3 error-box errors" id="durationErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex" id='startDateBlock' style="display: none">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Start Date"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control datepicker-component" name="startt" id="startt" placeholder="From Date">
                        </div>
                        <div class="col-sm-3 error-box errors" id="startDateErr">
                        </div>
                    </div>
                    <div class="form-group" class="formex" id='endDateBlock' style="display: none">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "End Date"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control datepicker-component" name="endd" id="endd" placeholder="To Date">
                        </div>
                        <div class="col-sm-3 error-box errors" id="endDateErr">
                        </div>
                    </div>

                    <div class="form-group" id="notesId">
                        <label for="fname" class="col-sm-4 control-label">Shift Name</label>
                        <div class="col-md-6 col-sm-5 col-xs-12">
                            <input type="text" class="input-sm form-control" name="shiftName" id="shiftName" placeholder="Enter Name">
                        </div>   
                        <div class="col-sm-3 error-box errors" id="shiftErr">
                        </div>                    
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Start Time"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">                       


                            <input type="text" name="timepicker" class="form-control timepicker" id="starttime"/>


                        </div>

                    
                        <div class="col-sm-3 error-box errors" id="startTimeErr">
                        </div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo "End Time"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12  bootstrap-timepicker" >


                            <input type="text" name="timepicker" class="form-control timepicker" id="endtime"/>
                        </div>

                     


                        <div class="col-sm-3 error-box errors" id="startTimeErr">
                        </div>
                    </div>
                   



                </form>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box errors responseErr"></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="insert_cat_group" ><?php echo "Add"; ?></button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="confirmModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >Alert</span>
            </div>
            <div class="modal-body">
                <h5 id="msg_data"></h5>
                <input type="hidden" id="msgid" value=''>
            </div>
            <div class="modal-footer">
               
                    <button type="button"  class="btn btn-primary btn-cons" id="yes" style>Delete</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons " id="cancel">Close</button></div>
                
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>