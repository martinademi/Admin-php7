<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<style>


    .paging_full_numbers{
        margin-right: 1%;
    }
    .dataTables_info {
        margin-left: 1%;
    }
    .table-responsive{
        overflow-x:hidden;
        overflow-y:hidden;
    }
    .radio input[type=radio], .radio-inline input[type=radio] {
        margin-left: 0px; 
    }
    .lastButton{
        margin-right:1.8%;
    }
    .btn{
        border-radius: 25px !important
    }

    /*    .page-sidebar
        {
           display: none; 
        }*/

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}

    #addZoneModal .modal-dialog,
    #map_display .modal-dialog,
    #editZoneModal .modal-dialog {
        width: 90%;
    }

    /*    .modal-header,
        .modal-footer {
            color: white;
            background-color: grey;
        }*/

    /*    .modal-header,
        .modal-footer button {
            color: white;
            background-color: grey;
        }*/

    #addmodalmap,
    #mapPolygon,
    #editmodalmap {
        /*height: 600px;*/
        height: 80vh;
    }

    #zoneform label {
        margin-left: 12px;
    }

    /*    #zoneform .pointscontrols {
            width: 35%;
            margin: 5px;
            margin-top: 2px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }*/

    .btncontrols {
        margin: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        color: white;
        background-color: cornflowerblue;
    }

    /*#cities,*/
    #editnow {
        border: 1px solid transparent;
        border-radius: 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        color: white;
        background-color: darkgray;
    }

    .success {
        color: springgreen;
    }

    .error {
        color: red;
    }

    .waitmsg {
        display: inline;
        margin-left: 50%;

    }

    .modal .modal-body p {
        color: aliceblue;
    }

    .displayinline {
        display: inline;
    }


    /*------------for auto complete search box---------------------*/

    .controls {
        margin: 10px 0;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        border-radius: 5px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #pac-input1 {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        border-radius: 5px;
    }

    #pac-input1:focus {
        border-color: #4d90fe;
        display: none;
    }


    .pac-container,.select2-drop {
        font-family: Roboto;
        z-index: 99999 !important;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #target {
        width: 345px;
    }
</style>
<style>
    .header{
        height:60px !important;
    }
    .header h3{
        margin:10px 0 !important;
    }
    .rating>.rated {
        color: #10cfbd;
    }
    .social-user-profile {
        width: 83px;
    }
    td a:before{
        color:transparent;
    }
    .DataTables_sort_wrapper {
        text-align: center;
    }

    /* select wit serch */
    .custom_select_btn button {
        border-radius: 0px !important;
    }
    .dropdown-menu.inner.selectpicker {
        max-height: 175px !important;
    }
</style>
<!--<script src="<?= base_url() ?>theme/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?v=3&libraries=drawing,places&key=<?= GOOGLE_MAP_API_KEY ?>"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3&libraries=drawing,places&key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE"></script>-->
<script src="<?= base_url() ?>/theme/ZoneMapAssets/javascript.util.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/jsts.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket-gmap3.js"></script>
<script>
$(document).ready(function (){
    $(document).ajaxComplete(function () {
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
    //Surge Price should be either in decimal/Number


    var mapedit;
    var cities = <?= json_encode($cities); ?>;
    $(document).ready(function () {

        var table = $('#big_table1').dataTable();
        $('.zones').addClass('active');
        $('.zones').attr('src', '<?php echo base_url(); ?>/theme/icon/campaigns_on.png');
        $('#editzonesurge_price,#zonesurge_price').keypress('click', function (event) {

            return isNumber(event, this)

        });
//        $('#s2id_city_select').removeClass('full-width');

       


    });
    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
                (charCode != 45 || $(element).val().indexOf('-') != -1) && // “-” CHECK MINUS, AND ONLY ONE.
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

  
    
    function loadExistingZones() {

        var selectedZone1 = $(this).attr('data-id')

        var docId1 = $(this).val();
        alert(docId);
        alert(selectedZone);
        alert('sdljfhsjkhdfhsd'+docId1);
        alert('sdkbskdjfskadhfksahd'+selectedZone1);
        if (selectedZone.length == 0)
        {
            $('#alertForNoneSelected').modal('show');
            $("#err").text('<?php echo $this->lang->line('zone_edit_popup'); ?>');
            return false;
        } else if (selectedZone.length > 1)
        {
            $('#alertForNoneSelected').modal('show');
            $("#err").text('<?php echo $this->lang->line('zone_edit_popup'); ?>');
            return false;
        } else {
            window.location.href="<?php echo base_url();?>index.php?/Zones_Controller/editZone/"+docId+"/"+selectedZone
                }

    }
     $(document).on('click', '.deliverySchedule', function () {
      // var zoneId = $(this).val();
       var cityId = $(this).attr('data-id');
       var zoneId = $(this).attr('data-zone');
      
       
        window.location.href="<?php echo base_url();?>index.php?/Deliveryschduled/slots/"+zoneId+"/"+cityId
       
   });

//    shift timimgs
   $(document).on('click', '.setShiftTimings', function () {
      
   
       var cityId = $(this).attr('data-id');
       var zoneId = $(this).attr('data-zone');
      
       
        window.location.href="<?php echo base_url();?>index.php?/ShiftTimings/slots/"+zoneId+"/"+cityId
       
   });

   $(document).on('click', '.deliverySlots', function () {
       var zoneId = $(this).attr('data-zoneid');
       var cityId = $(this).attr('data-id');
      
        window.location.href="<?php echo base_url();?>index.php?/Deliveryslots/slots/"+zoneId+"/"+cityId
       
   });

   $(document).on('click', '.editTurfZone', function () {
       var docId = $(this).val();
       var selectedZone = $(this).attr('data-id');
       
        window.location.href="<?php echo base_url();?>index.php?/Zones_Controller/editZone/"+docId+"/"+selectedZone
       
   });

    $(document).ready(function () {
     
        $('#big_table_processing').show();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Zones_Controller/datatable_zones/1',
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


            $('#search-table').keyup(function () {

                table.fnFilter($(this).val());
            });
             $('#city_select').change(function () {

            table.fnFilter($("#city_select option:selected").attr('city'));
        });


   
        $('#cancel_delete').click(function ()
        {
            $('.close').trigger('click');
            $('.checkbox:checked').each(function (i) {
                $(this).removeAttr('checked');
            });
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

        //Delete zones
        $("#chekdel").click(function () {

            $("#err").text("");
            var val = [];
            $('.checkbox:checked').each(function () {
                val.push($(this).val());
            })

            if (val.length > 0) {

                var size = $('input[name=stickup_toggler]:checked').val()

                $('#deleteZone').modal('show')

                $(".error-box").text('<?php echo $this->lang->line('delete_zone'); ?>');

                $("#yesdelete").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/Zones_Controller') ?>/deleteZone",
                        type: "POST",
                        data: {zone_id: val},
                        success: function (result) {

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });

                            $(".close").trigger('click');
                        }
                    });
                });
            } else {
                $('#alertForNoneSelected').modal('show');
                $("#err").text('<?php echo $this->lang->line('zone_to_delete'); ?>');
            }

        });
        $('#add').click(function(){
         var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if(val.length == 0){
        window.location.href="<?php echo base_url();?>index.php?/Zones_Controller/ceateZone";
    }else{
        $('#alertForNoneSelected1').modal('show')
        $('#errZone').text("Invalid Selection")
    }
        
        });



         $('.whenclicked li').click(function(){

          if ($(this).attr('data-id') == "2") {
              console.log('delete')
              
              $("#chekdel").hide();
              $("#add").hide();
              $("#city_select").val("");
              
          }else{
            console.log('active');
            $("#chekdel").show();
            $("#add").show();
          }

        });   

        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            var forwhat = urlChunks[urlChunks.length - 2];
            
            if (status == 1) {
               
                // $('#big_table').dataTable().fnSetColumnVis([6,15,16,17,18], false);
				// getOrdersCount();
                }
            if (status == 0) {
               
                 $('#big_table').dataTable().fnSetColumnVis([3,4,5,6,7,8], false);
				 //getOrdersCount();
                
            }
           
		 });

     



    });
</script> 



<div class="page-content-wrapper"style="">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong><?php echo $this->lang->line('zone'); ?></strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">


                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked">
                         <li id="1" data-id="1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Zones_Controller/datatable_zones/1
" data-id="1"><span><?php echo $this->lang->line('Active'); ?></span><span class="badge newDriverCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="2" data-id="2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/Zones_Controller/datatable_zones/0" data-id="2"><span><?php echo $this->lang->line('Deleted'); ?></span> <span class="badge acceptedDriverCount" style="background-color:#3CB371;"></span></a>
            </li>

                        <!--<div class="pull-right m-t-10 lastButton"><button data-toggle="modal" class="btn btn-warning btn-cons" data-target="#map_display" onclick="viewzones()">--> 
                                <!--View </button></div>-->  
                        <div class="pull-right m-t-10"><button  class="btn btn-danger cls111" id="chekdel"> 
                                <?php echo $this->lang->line('Deleted'); ?></button></div>
<!--                        <div class="pull-right m-t-10"><button data-toggle="modal" class="btn btn-info" onclick="loadExistingZones()"> 
                                Edit</button></div>-->
                        <button data-toggle="modal" class="btn btn-primary" data-target="#editZoneModal" style="display:none;" id="editZoneModal1"> 
                        </button>
                                <div class="pull-right m-t-10 "><button data-toggle="modal" class="btn btn-primary btn-cons cls110"  id="add" onclick="addNewZone(12.972442010578353, 77.5909423828125)"> 
                                <?php echo $this->lang->line('Add'); ?></button></div>
                        <!--                        <div class="pull-right m-t-10"><button data-toggle="modal" class="btn btn-success btn-cons" id="addPreferredZone" > 
                                                        Preferred Store</button></div>-->



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

                                    <div>

                                        <!-- <div class="form-group" style="display:none" >

                                            <div class="col-sm-8" style="width: auto; paddingng: 0px; margin-bottom: 10px;margin-left: -0.7%">
                                                <select class="form-control" id="city_select" style="background-color:gainsboro;height:30px;font-size:11px;" >
                                                    <option value="" city="">Select City</option>
                                                    <?php
                                                    foreach ($allcities as $city) {
                                                        if($city['isDeleted'] == FALSE){
                                                        ?>
                                                        <option value="<?php echo $city['cityId']; ?>" city="<?php echo $city['cityName']; ?>" data-id="" lat="" lng=""><?php echo $city['cityName']; ?></option>    
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div> -->


                                        <!-- new strt -->
                                        <div class="form-group"   >
                                            <div class="col-sm-8" style="width: 17%; paddingng: 0px; margin-bottom: 10px;margin-left: -0.7%">                                          
                                            <select class="selectpicker form-control custom_select_btn" id="city_select" style="background-color:gainsboro;height:30px;font-size:11px;" data-show-subtext="false" data-live-search="true">
                                                    <option value="" city=""><?php echo $this->lang->line('select_city'); ?></option>
                                                    <?php
                                                    foreach ($allcities as $city) {
                                                        if($city['isDeleted'] == FALSE){
                                                        ?>
                                                        <option value="<?php echo $city['cityId']; ?>" city="<?php echo $city['cityName']; ?>" data-id="" lat="" lng=""><?php echo $city['cityName']; ?></option>    
                                                        <?php
                                                        }
                                                    }
                                                    ?>                                                                        
                                            </select>
                                            </div>
                                        </div>

                                        <!-- new strrt ned -->


                                    </div>

                                    <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>" > </div>

                                </div>
                                &nbsp;
                                <div class="panel-body">
                                    <?php echo $this->table->generate(); ?>
                                </div>
<!--                                <div class="panel-body" >
                                    <div id="tableWithSearch_wrapper1" class="dataTables_wrapper no-footer" style="display: none;">
                                        <div class="table-responsive">
                                            <table id="big_table1" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="big_table_info" style="">
                                                <thead>
                                                    <tr style= "font-size:10px"role="row">
                                                        <th class="sorting ui-state-default sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 8%;" aria-sort="ascending">
                                                            <div class="DataTables_sort_wrapper">Sl No.<span class="DataTables_sort_icon css_right ui-icon ui-icon-triangle-1-n"></span></div>
                                                        </th><th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width:5%;"><div class="DataTables_sort_wrapper">CITY<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 5%;"><div class="DataTables_sort_wrapper">TITLE<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 13px;"><div class="DataTables_sort_wrapper">CHARGE TYPE<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 10%;"><div class="DataTables_sort_wrapper">SURGE FACTOR<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 85%;"><div class="DataTables_sort_wrapper">POLYGON POINTS<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 5%;"><div class="DataTables_sort_wrapper">ZONAL PRICE<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 5%;"><div class="DataTables_sort_wrapper">PREFERRED STORE<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 5%;"><div class="DataTables_sort_wrapper">ACTION<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 5%;"><div class="DataTables_sort_wrapper">SELECT<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_zone">
                                                    <?php
//                                                    $start = 1;
//                                                    foreach ($zones_data as $data) {
                                                        ?>

                                                        <tr role="row" class="odd">
                                                            <td><?php // echo $start++; ?></td>
                                                            <td><?php // echo $data['city']; ?></td>
                                                            <td><?php // echo $data['title']; ?></td>
                                                            <td><button style="width:35px;" class="btn btn-primary btnWidth editTurfZone"  data-id="<?php echo $data['city_ID'] ?>" value="<?php echo $data['_id']['$oid']?>"><i class="fa fa-edit"></i></button></td>

                                                            <td><?php
//                                                                $count = 1;
//                                                                foreach ($data['polygonProps']['paths'] as $points) {
//
//                                                                    echo 'P' . $count . "(" . ucwords($points['lat']) . "," . ucwords($points['lng']) . ")";
//                                                                    echo " ";
//                                                                    if (($count % 2) == 0)
//                                                                        echo ' <br>';
//                                                                    $count++;
//                                                                }
                                                                ?>
                                                                <input type="hidden" id="zone_<?php//$data['_id']['$oid'] ?>"/>
                                                            </td>
                                                            <td><a href="<?php // echo base_url() . 'index.php?/superadmin/zone_pricing/' . $data['city_ID'] . '/' . $data['_id']['$oid']; ?>" class="btn btn-info btn-cons btn-animated from-top fa fa-dollar" id="zone_585cd4a65b45401325268a88" style="padding: 0px 10px;font-family: sans-serif;font-size: 10px;color: #fff;text-decoration: none;width: 108px;text-align:center;"><span>SET PRICE</span></a></td>

                                                                    <td><?php // echo $data['preferredStoreName'];   ?></td>
                                                            <td><input style=""type="checkbox" class="checkbox zonesCheckBox" name="checkbox" data-id="<?php echo $data['_id']['$oid'] ?>" value="<?php echo $data['city_ID'] ?>"/></td>
                                                    <input type="hidden" id="selected_zone">

                                                    </tr>
                                                    <?php
//                                                }
                                                ?>
                                                </tbody>  
                                            </table>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                            <!--                             END PANEL -->
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<!--Add Zone Modal -->
<div class="modal fade fill-in" id="addZoneModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >ADD</span> 
            </div>
            <div class="modal-body">

                <div class="container-fluid bg-white">
                    <div class="row">
                        <input id="pac-input" class="controls" type="text" placeholder="Search Location"  style="position: absolute;width: 15.5em;margin-left: 130px;z-index: 1050;">
                        <!--onfocus="initAutocomplete(1)"-->
                        <div id="addmodalmap" class="col-md-8 col-sm-12">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <form id="zoneform" data-parsley-validate="" class="form-horizontal form-label-left">

                                <div class="form-group">
                                    <label for="zonecity" class="control-label col-md-3 col-sm-3">City</label>
                                    <div class="col-md-6 col-sm-6"> 

                                        <select  class="form-control" id="city_selection_add" >
                                            <option value="#">Select</option>
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
                                    </div>
                                    <div class="col-sm-2 errors" id="cityErr"> </div>
                                </div>



                                <div class="form-group">
                                    <label for="zonetitle" class="control-label col-md-3 col-sm-3">Title</label>
                                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                                        <input type="text" id="zonetitle" placeholder="Enter zone title"  class="form-control col-md-7">
                                    </div>
                                    <div class="col-sm-2 errors" id="titleErr"> </div>
                                </div>


                                <!--                                <div class="form-group">
                                                                    <label for="zonetitle" class="control-label col-md-3 col-sm-3">Preferred Store</label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                                        <select  id='preferredStore' name='preferredStore' class='errr11 form-control'>
                                                                            <option value=''>Select Stores</option>
                                <?PHP
//foreach ($stores as $dat) {
//    echo "<option data-name = " . implode(',', $dat['name']) . "value='" . $dat['_id']['$oid'] . "' data-id='" . $dat['_id']['$oid'] . "'>" . implode(',', $dat['name']) . "</option>";
//}
                                ?>
                                                                        </select>
                                
                                                                    </div>
                                                                    <div class="col-sm-2 errors" id="preferredStoreErr"> </div>
                                                                </div>-->


                            </form>
                            <div class="form-group" style="margin-left: 12%;">
                                <div id="info">

                                </div>
                            </div>
                            <div class="form-group">
                                <button id="savezone" class="btn btn-success" style="margin-left: 10%;">Save</button>
                                <button id="clearzone"  class="btn btn-default">Clear</button><br/>
                                <p id="addmsg" class="waitmsg"></p>


                            </div>

                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

<!--Edit Zone Modal -->
<div class="modal fade fill-in" id="editZoneModal" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">EDIT</span> 

            </div>
            <div class="modal-body">
                <div class="container-fluid bg-white">
                    <div class="row">

                        <!--onfocus="initAutocomplete(2)"--> 
                        <div id="editmodalmap" class="col-md-8 col-sm-12"></div>
                        <div class="col-md-4 col-sm-12">
                            <form id="zoneform" data-parsley-validate="" class="form-horizontal form-label-left">

                                <div class="form-group">
                                    <label for="editzonecity" class="control-label col-md-3 col-sm-3">City</label>
                                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                                        <select  class="form-control" id="cities" disabled></select>
                                    </div>
                                    <div class="col-sm-2 errors" id="city_e_Err"> </div>
                                </div>


                                <div class="form-group">
                                    <label for="editzonetitle" class="control-label col-md-3 col-sm-3">Title</label>
                                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                                        <input class="form-control" type="text" id="editzonetitle" placeholder="Enter zone title"  class="form-control col-md-7">
                                    </div>
                                    <div class="col-sm-2 errors" id="title_e_Err"> </div>
                                </div>


                                <div class="form-group" style="margin-left: 8%;">
                                    <div id="pointsinfo"></div>
                                </div>
                                <div class="form-group">
                                    <button id='saveeditzone' style="margin-left:6.5%;" class="btn btn-success">Save</button>
                                    <!--<button id="deletezone"  class="btn btn-danger">Delete</button>-->
                                    <button type="button" id="cancelEditZoneModal" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button><br>
                                    <p id="editmsg" class="waitmsg"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade fill-in" id="map_display" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">ALL ZONES</span> 
            </div>
            <div class="modal-body" style="margin-top: -1%;">
                <input id="pac-input2" class="controls" type="text" placeholder="Search Location" style="position: absolute;width: 15.5em;margin-left: 130px;z-index: 1050;margin-top: 24px;padding:10px;">
                <!--onfocus="initAutocomplete(3)"-->
                <select  class="form-control" id="city_selection_view" style="position: absolute;width: 15.5em;margin-left: 359px;z-index: 1050;margin-top: 24px;background-color:gainsboro;font-size:11px;">

                    <?php
                    foreach ($cities as $city) {
                        ?>
                        <option value="<?php echo $city['_id']['$oid']; ?>" city="<?php echo $city['city']; ?>" lat="" lng=""><?php echo $city['city']; ?></option>    
                        <?php
                    }
                    ?>
                </select>
                <div class="container-fluid bg-white" style="padding-top: 1%;padding-bottom: 1%;">
                    <!--                        <div id='viewmaploader' style="display:none;position: relative;z-index: 1500;background-color: white;height: 90vh;width: 100%;">
                                                <img src="<?= base_url() ?>/../../../images/loading.gif" style="position: absolute;left: 0;right: 0;top: 0;bottom: 0;margin: auto;"/>
                                            </div>-->
                    <div id='viewmap' class="row">
                        <div id="mapPolygon"  class="col-sm-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade stick-up" id="deleteZone" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">Delete</span> 
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="error-box"  style="text-align:center"></div>
                </div>
            </div>



            <div class="modal-footer">
                <div class="col-sm-4"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger" id="yesdelete" >Delete</button></div>
                    <div class="pull-right m-t-10"><button type="button" class="btn btn-default" id="cancel_delete" >Cancel</button></div>

                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="preferredZoneModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Preferred Store</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>


            </div>
            <br>
            <div class="modal-body">
                <div class="">

                    <label>Preferred Store</label>

                    <div class="">
                        <select class="form-control" id="preferredStoreList">
                            <option value="" >Select Stores</option>
                        </select>
                    </div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">

                    <div class="col-sm-4"></div>
                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-success pull-right" id="setZone" >Save</button>
                        <button type="button"  class="btn btn-default pull-right" data-dismiss="modal" >Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="alertForNoneSelected1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line('alert'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>


            </div>
            <br>
            <div class="modal-body">
                <div class="modalPopUpText" id="errZone"></div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">

                    <div class="col-sm-4"></div>
                    <div class="col-sm-8" >

                        <button type="button"  class="btn btn-default pull-right" data-dismiss="modal" ><?php echo $this->lang->line('ok'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
