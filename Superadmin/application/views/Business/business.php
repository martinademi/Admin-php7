<?php
date_default_timezone_set('UTC');
$rupee = "$";
$status = 1;
?>
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
        margin-left: 10px!important;
    }
    .badge {
        font-size: 9px;
        margin-left: 4px;
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

});
</script>
<script>
    var st = 1;
    $(document).ready(function () {
        $("#define_page").html("Driver Review");
        $('.businessmgt').addClass('active');

        $('#search_by_select').change(function () {
            $('#atag').attr('href', '<?php echo base_url() ?>index.php?/Business/search_by_select/' + $('#search_by_select').val());
            $("#callone").trigger("click");
        });

        $("#changetype").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length > 0) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdata").text('Are you sure you wish to activate the selected business as test ?');

                $("#confirmed").click(function () {

                    $.ajax({
//                        url: "<?php echo base_url('index.php?/Business') ?>/changetestbusinessmgt",
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
            } else
            {
                $('#displayData').modal('show');
                $("#display-data").text("<?php echo $this->lang->line('error_SelectStore'); ?>");
            }

        });
        $("#inactive").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 0) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdata").text("Are you sure you want to deactivate the store?");

                $("#confirmed").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/Business') ?>/inactivebusinessmgt",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {
                            console.log('deactivated');
                            $('.cs-loader').show();
                            $('#1').removeClass('active');
                            $('#6').removeClass('active');
                            $('#5').addClass('active');
                            $('#inactive').hide();
                            $('#active').show();
                            
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
                                "sAjaxSource": '<?php echo base_url(); ?>index.php?/Business/operationBusiness/table/5',
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
                            $('#confirmmodel').modal('hide')
                        }
                    });


                });
            } else
            {
                $('#displayData').modal('show');
                $("#display-data").text("<?php echo $this->lang->line('error_SelectStore'); ?>");
            }

        });


        $("#active").click(function () {
            $("input[name='mode']").prop('checked', false);
            $("#display-data").text("");
            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var st = urlChunks[urlChunks.length - 1];

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (st == 1) {
                $('.test').show();
                $('.live').hide();
            } else if (st == 6) {
                $('.live').show();
                $('.test').hide();
            } else {
                $('.live').show();
                $('.test').show();
                $('.activ').show();
            }
            if (val.length >= 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_BUSINESS_ACTIVATE); ?>);

                $("#confirmeds").click(function () {
                    {
                        var radioValue = $("input[name='mode']:checked").val();
                        $.ajax({
                            url: "<?php echo base_url('index.php?/Business') ?>/activebusinessmgt",
                            type: "POST",
                            data: {val: val},// mode: radioValue
                            dataType: 'json',
                            success: function (result)
                            {
                                window.location.reload('');

                            }
                        });
                    }

                });

            } else
            {
                //      alert("select atleast one passenger");
                $('#displayData').modal('show');
                $("#display-data").text("<?php echo $this->lang->line('error_SelectStore'); ?>");
            }

        });

        $("#delete").click(function () {

            var status = '<?php echo $status; ?>';

            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                //         alert("please select atleast one company");
                $('#displayData').modal('show');
                $("#display-data").text("Please select the store");
            } else if (val.length >= 1)
            {
//                 if(confirm("Are you sure to Delete " +val.length + " companys")){
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmode1');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmode1').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdat1").text("Are you sure you want to delete the store?");
            }

        });

        $("#confirme1").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            var id = $('.checkbox:checked').attr('data-id');

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('index.php?/Business/') ?>deleteStore",
                data: {val: val, id: id},
                dataType: 'JSON',
                success: function (response)
                {
                    $('#confirmmode1').modal('hide');
                    $('#1').addClass('active');
                    $('#3').removeClass('active');
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
                        "sAjaxSource": '<?php echo base_url(); ?>index.php?/Business/operationBusiness/table/1',
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "iDisplayStart ": 20,
                        "oLanguage": {
//                                    "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
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


            });


        });
        $("#viewnote").click(function () {

            $("#display-data").text("");
            $("#errorboxdat").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

//            alert(val);

            if (val.length == 1)
            {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('index.php?/Business') ?>/viewnote_businessmgt",
                    data: {val: val},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        //      alert(response.msg);
                        console.log(response.data.Notes)
                        var size = $('input[name=stickup_toggler]:checked').val()
                        var modalElem = $('#confirmmode');
                        if (size == "mini") {
                            $('#modalStickUpSmall').modal('show')
                        } else {
                            $('#confirmmode').modal('show')
                            if (size == "default") {
                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                            } else if (size == "full") {
                                modalElem.children('.modal-dialog').addClass('modal-lg');
                            }
                        }
                        $('#confirme').hide();
                        $("#errorboxdat").text(response.data.Notes);
                    }


                });

                $("#confirme").click(function () {

                });
            } else {
                $('#displayData').modal('show');
                $("#display-data").text("<?php echo $this->lang->line('error_SelectStore'); ?>");
            }

        });

    });

</script>
<style>
    #active{
        display:none;
    }
</style>
<script>
$(document).ready(function () {

    getOrdersCount();

    function getOrdersCount()
    {
        console.log('val*****')
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Business/getStoresCount",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
                console.log('reponse--',response);
                $('.pendingCount').text(response.data.Pending);
                $('.activeCount').text(response.data.Active);
                $('.inactiveCount').text(response.data.Inactive);
                $('.deletedCount').text(response.data.deleted);
				
                
            }
        });
    }

    
});

</script>
<script type="text/javascript">
    $(document).ready(function () {
        var status = '<?php echo $status; ?>';

        if (status == 1) {
            $('#inactive').show();
            $('#active').hide();
            $('#editDispensary').show();
            $('#btnStickUpSizeToggler').hide();
            $('#search-table').val('');
        }
        $('#btnStickUpSizeToggler').click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            
            if (val.length == 0) {
                window.location.href = "<?php echo base_url() ?>index.php?/Business/addnewbusiness";
            } else {
                $('#display-data').text('<?php echo $this->lang->line('error_Invalid'); ?>');
                $('#displayData').modal('show');
            }

        });
        
//        $('#editDispensary').click(function () {
        $(document).on('click','#btnEdit',function () {

            var val = $(this).val();
            window.location.href = "<?php echo base_url() ?>index.php?/Business/editbusiness/" + val;
            

        });

        $('.cs-loader').show();
        $('#big_table_processing').show();

        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        $('#1').addClass('active');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url(); ?>index.php?/Business/operationBusiness/table/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
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
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('#cityFilter').change(function(){
			
			var city=$('#cityFilter option:selected').attr('cityName');
			var cityId=$('#cityFilter option:selected').val();
			
			table.fnFilter(city);
			
		});


        $('.whenclicked li').click(function () {

            if ($(this).attr('id') == 1) {
                st = 1;
                $('#inactive').show();
                $('#active').hide();
                $('#editDispensary').show();
                $('#delete').show();
                $('#btnStickUpSizeToggler').hide();
                $('#search-table').val('');

            } else if ($(this).attr('id') == 5) {
                st = 5;
                $('#active').show();
                $('#delete').show();
                $('#inactive').hide();
                $('#editDispensary').hide();
                $('#btnStickUpSizeToggler').hide();
                $('#search-table').val('');

            } else if ($(this).attr('id') == 3) {
                st = 3;
                $('#active').show();
                $('#inactive').show();
                $('#editDispensary').show();
                $('#delete').show();
                $('#btnStickUpSizeToggler').show();
                $('#search-table').val('');

            } else if ($(this).attr('id') == 6) {
                st = 6;
                $('#inactive').show();
                $('#active').show();
                $('#delete').show();
                $('#editDispensary').hide();
                
                $('#btnStickUpSizeToggler').hide();
                $('#search-table').val('');

            } else if ($(this).attr('id') == 7) {
                st = 7;
                $('#inactive').hide();
                $('#active').hide();
                $('#editDispensary').hide();
                $('#delete').hide();
                
                $('#btnStickUpSizeToggler').hide();
                $('#search-table').val('');

            }
        });

        $('.changeMode').click(function () {

            var table = $('#big_table');
            $('.cs-loader').show();
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
                "oLanguage": {

                },
                "fnInitComplete": function () {
                    $('#big_table').fadeIn('slow');
                    //oTable.fnAdjustColumnSizing();
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

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');

            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

            $('#cityFilter').change(function(){
			
			var city=$('#cityFilter option:selected').attr('cityName');
			var cityId=$('#cityFilter option:selected').val();
			
			table.fnFilter(city);
			
		});

        });
        
         $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
                if (status == 7)
                    $('#big_table').dataTable().fnSetColumnVis([6,7], false);
            
        });

    });

    $(document).ready(function () {
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

  

    });

   

   

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
            <strong style="color:#0090d9;"><?php echo $this->lang->line('heading_Dispensaries'); ?></strong>
        </div>
        <!-- Nav tabs -->

        <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

            <li id= "3" class="tabs_active " style="cursor:pointer">
                <a  class="changeMode" data="index.php?/Business/operationBusiness/table/3"><span><?php echo $this->lang->line('heading_New'); ?></span><span class="badge pendingCount" style="background-color:#5bc0de;"></span></a>
            </li>
            <li id= "1" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/Business/operationBusiness/table/1"><span><?php echo $this->lang->line('heading_Live'); ?></span><span class="badge activeCount" style="background-color:#3CB371;"></span></a>
            </li>
<!--            <li id= "6" class="tabs_active " style="cursor:pointer">
                <a   class="changeMode" data="index.php?/Business/operationBusiness/table/6"><span><?php echo $this->lang->line('heading_Test'); ?></span></a>
            </li>-->
            <li id= "5" class="tabs_active" style="cursor:pointer">
                <a   class="changeMode" data="index.php?/Business/operationBusiness/table/5"><span><?php echo $this->lang->line('heading_Inactive'); ?></span><span class="badge inactiveCount" style="background-color:#f0ad4e;"></span></a>
            </li>
            <li id= "7" class="tabs_active" style="cursor:pointer">
                <a   class="changeMode" data="index.php?/Business/operationBusiness/table/7"><span><?php echo $this->lang->line('heading_Deleted'); ?></span><span class="badge deletedCount" style="background-color:#B22222;"></span></a>
            </li>

            <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons" id="delete" style="background: #d9534f;border-color: #d9534f;margin: 0;"><?php echo $this->lang->line('button_delete'); ?></button></div>
            <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons options_btns" id="inactive" style="background: #f0ad4e;border-color: #f0ad4e;"><?php echo $this->lang->line('button_deactivate'); ?></button></div>
            <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons options_btns" id="active"><?php echo $this->lang->line('button_activate'); ?></button></div>
            <!--<div class="pull-right m-t-10 cls110"> <button class="btn btn-primary btn-cons" id="editDispensary" style=" background: rgba(136, 135, 156, 0.81);border-color: rgb(141, 140, 160);"><?php echo $this->lang->line('button_edit'); ?></button></div>-->
            <div class="pull-right m-t-10 cls110"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler" style="background: #337ab7;border-color: #337ab7;"><?php echo $this->lang->line('button_add'); ?></button></div>

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

                                    <div class="cs-loader">
                                        <div class="cs-loader-inner" >
                                            <label class="loaderPoint" style="color:#10cfbd">●</label>
                                            <label class="loaderPoint" style="color:red">●</label>
                                            <label class="loaderPoint" style="color:#FFD119">●</label>
                                            <label class="loaderPoint" style="color:#4d90fe">●</label>
                                            <label class="loaderPoint" style="color:palevioletred">●</label>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">  
                                                <div class="modal-header">
                                                    <sapn  class="modal-title">Alert</sapn>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>    
                                                </div>
                                                <div class="modal-body">
                                                    <div class="error-box modalPopUpText" id="display-data"></div>                                            
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="margin-left: -40px;">

                                        <div class="row clearfix pull-left" style="margin-left:25px;">

                                                    <div class="pull-left">
                                                    <select class="form-control pull-left" id="cityFilter">
                                                
                                                    </select> 
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


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Dispensary Deactivation</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" style="font-size: large;text-align:center">Are you sure you wish to de-activate the selected business ?</div>

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



<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">

                <span class="modal-title">Dispensary Activation</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="form-group formex activ" style="margin-left: 0%;">
                <div class="row">

                    <div class="error-box" id="errorboxaddmodals" style="font-size: large;text-align:center"><?php echo $this->lang->line('alert_forActivate'); ?></div>

                </div>
                    <!--<label for="fname" class="control-label col-sm-5" style="font-size: 14px;">Activate as</label>-->

<!--                    <div class="live">
                        <input type="radio" name="mode" value="1">&nbsp;&nbsp;&nbsp;&nbsp; Live  &emsp;&emsp;&emsp;&emsp;
                    </div>
                    <div class="test">
                        <input type="radio" name="mode" value="6">&nbsp;&nbsp;&nbsp;&nbsp; Test<br>
                    </div>-->
                </div>
            </div>

            <br>

            <div class="modal-footer" style="    padding: 5px;">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" >Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxaddmodal" style="font-size: large;text-align:center"><?php echo POPUP_BUSINESS_ACTIVATE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds1" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3> <?php echo SELECT_COUNTRY_ANDBUSINESS; ?></h3>
            </div>

            <div class="modal-body">

                <div class="form-group" class="formex">
                    <label for="fname" class="col-sm-4 control-label" ><?php echo FIELD_BUSINESSNAME; ?></label>
                    <div class="col-sm-6">

                        <select id="BizId" name="country_select"  class="form-control error-box-class">
                            <option value="0">Select Business</option>

                            <?php
                            foreach ($business as $result) {
                                echo "<option value=" . $result['masterid'] . ">" . $result['businessname'] . "</option>";
                            }
                            ?>

                        </select>
                    </div>
                </div>

                <br>
                <br>
                <div class="form-group" class="formex">
                    <div class="frmSearch">
                        <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_BUSINESSNAME_NAME; ?><span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" id="businessname" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>

                            <div id="suggesstion-box"></div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="form-group" class="formex">
                    <div class="frmSearch">
                        <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_BUSINESSNAME_CAT; ?><span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <select multiple id="CatId" name="cat_select[]"  class="form-control error-box-class" >
                                <option value="">Select Cuisines</option>


                                <?php
                                foreach ($category as $result) {
                                    echo "<option value=" . $result['Categoryid'] . ">" . $result['Categoryname'] . "</option>";
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                </div>


                <br>
                <br>

                <div class="form-group" class="formex">
                    <label for="fname" class="col-sm-4 control-label">    <?php echo FIELD_OWNERNAME; ?><span style="color:red;font-size: 18px">*</span></label>
                    <div class="col-sm-6">
                        <input type="text"  id="ownername" name="latitude"  class="form-control error-box-class" >
                    </div>
                </div>

                <br>
                <br>

                <div class="form-group" class="formex">
                    <label for="fname" class="col-sm-4 control-label">    <?php echo FIELD_VEHICLETYPE_EMAIL; ?><span style="color:red;font-size: 18px">*</span></label>
                    <div class="col-sm-6">
                        <input type="text"  id="email" name="latitude"  class="form-control error-box-class" >
                    </div>
                </div>

                <br>
                <br>

                <div class="form-group" class="formex">
                    <label for="fname" class="col-sm-4 control-label">    <?php echo FIELD_VEHICLETYPE_PASSWORD; ?><span style="color:red;font-size: 18px">*</span></label>
                    <div class="col-sm-6">
                        <input type="text"  id="password" name="latitude"  class="form-control error-box-class" >
                    </div>
                </div>

                <br>
                <br>
                <!--                    <div class="form-group" class="formex">
                                        <div class="frmSearch">
                                            <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_PAYMENT; ?><span style="color:red;font-size: 18px">*</span></label>
                                            <div class="col-sm-6">
                                                 1 - cash,2 - credit card,3 - sadad
                                                <select id="PayId" name="pay_select"  class="form-control error-box-class">
                                                    <option value="0">Select Payment Method</option>
                                                    <option value="1">Cash</option>
                                                    <option value="2">Credit Card</option>
                                                    <option value="3">SADAD</option>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                
                
                                    <br>
                                    <br>-->

                <div class="form-group" class="formex">
                    <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_DRIVER_PRESENT; ?><span style="color:red;font-size: 18px">*</span></label>
                    <div class="col-sm-6">
                        <input type="checkbox" class="checkbox_" name="drivers" id="yes" value="1" /> 
                    </div>
                </div>

                <br>
                <br> 

                <div class="form-group" class="formex">
                    <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_PRICE1; ?></label>
                    <div class="col-sm-2">
                        <input type="radio" class="" name="pricing" id="yes1" value="1" /> 
                    </div>

                    <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_PRICE2; ?></label>
                    <div class="col-sm-2">
                        <input type="radio" class="" name="pricing" id="yes1" value="2" /> 
                    </div>
                </div>
                <br>
                <br>

                <div class="form-group" class="formex">
                    <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_PAYMENT; ?><span style="color:red;font-size: 18px">*</span></label>
                    <div class="col-sm-6">
                        <input type="checkbox" class="checkbox_" name="payment[]" id="cash" value="1" >&nbsp;&nbsp;<label>Cash</label> 
                        <br>
                        <input type="checkbox" class="checkbox_" name="payment[]" id="credit_card" value="1" >&nbsp;&nbsp;<label>Credit Card</label> 
                        <br>
                        <input type="checkbox" class="checkbox_" name="payment[]" id="SADAD" value="1" >&nbsp;&nbsp;<label>SADAD</label> 
                    </div>
                </div>

                <br>
                <br>
            </div>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-4 error-box" id="clearerror"></div>
                <div class="col-sm-4" >
                    <button type="button" class="btn btn-primary pull-right" id="insert" ><?php echo BUTTON_ADD; ?></button>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
</button>
</div>



<div class="modal fade stick-up" id="confirmmode" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdat"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >

                        <button type="button" class="btn btn-primary pull-right" id="confirme" >Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>  

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="confirmmode1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdat1"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >

                        <button type="button" class="btn btn-primary pull-right" id="confirme1" >Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>  

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

