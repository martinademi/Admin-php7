<?php

date_default_timezone_set('UTC');
$rupee = "$";

if ($status == 1) {
    $vehicle_status = 'New';
    $new = "active";
} else if ($status == 3 && $db == 'my') {
    $vehicle_status = 'Accepted';
    $accept = "active";
} else if ($status == 3 && $db == 'mo') {
    $vehicle_status = 'Online&Free';
    $free = "active";
} else if ($status == 4) {
    $vehicle_status = 'Rejected';
    $reject = 'active';
}
else if ($status == 30) {
    $$vehicle_status = 'Offile';
    $offline = 'active';
} else if ($status == 567) {
    $$vehicle_status = 'Booked';
    $booked = 'active';
}
?>
<style>

    .imageborder{
        border-radius: 50%;
    }
     .td1
        {
            word-wrap: break-word;
            width: 286px !important;
            display: block;
            overflow: hidden;
        }

</style>

<script>
    $(document).ready(function () {
  //datatables start  
     $('#book-table').DataTable({
     "pageLength" : 10,
     "sPaginationType" : "full_numbers",
     "aaSorting": [],
     "bDestroy" : true,
     "bScrollCollapse" : true,
     "bSort" : true,
     "fnInitComplete": function() {
      $("#gif").fadeOut(1000);
     },
     "language": {
      "emptyTable": "No schedule available in table"
     },
     "ajax": {
      url : "<?php echo base_url('index.php?/Coupons/promoCampaignsListData');?>",
      type : 'POST'
    },
  });
    //datatables end

        $("#editdriver").click(function () {

                $("#display-data").text("");
                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();
                if (val.length == 0) {
                    //         alert("please select any one dispatcher");
                    $('#displayData').modal('show');
                    $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_EDIT); ?>);
                } else if (val.length > 1)
                {
                    $('#displayData').modal('show');
                    $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_ONLYEDIT); ?>);
                }
                else
                {
                    window.location = "<?php echo base_url('index.php?/superadmin') ?>/editdriver/" + val;
                }
            });

        $("#chekdel").click(function () {
                $('#modalBodyText').text('');
                $('#confirmeds').attr('data_id', '');
                $('#confirmeds').attr('status', '');
                $('#confirmeds').attr('updateType', '');
                var couponId = $(".checkbox1:checked").val();

                var modalText = 'Do you want to continue to delete ' +  $(".checkbox1:checked").attr('coupon');
                alert(modalText);

                $.ajax({
                url: 'https://offersapi.uberfortruck.com/api/v1/couponCode/'+couponId,
                type: 'DELETE',
                dataType: 'json',
                data: { 
                                                  
                },
            }).done(function(json) {
                 if (json.errFlag === 0) {
                    alert('Successfully deleted');
                     location.reload(true);
                }
                else{
                    alert('Error while deleting data.');
                }
        }); 

                // $('#modalBodyText').text(modalText);
                // $('#confirmeds').attr('data_id', $(".checkbox1:checked").val());
                // $("#confirmmodels").modal();

        
        });
                  
               $("#yesdelete").click(function (){

                        var id = $('.checkbox:checked').map(function () {
                                    return this.value;
                                }).get();
//                                console.log(id);
                          $.ajax({
                               url: "<?php echo base_url('index.php?/superadmin') ?>/deletedriver",
                               type: "POST",
                                data: {id: id},
                                dataType: 'json',
                               success: function (response)
                               {
                                  window.location.reload()
                               }
                           });
                     });
                
        $("#accept").click(function () {
        
        $('input[name=radio]:checked').prop('checked', false);
        $("#driver_type").hide();
        $("#operator_type").hide();
        
         $("#ve_compan").text('');
             $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
                    var bid = '';
                if (val.length == 1) {
                    
                     $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/getdrivdata",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {
                            if(result.msg.businessid === undefined){
                                bid = ''; 
                            }
                            else{
                                bid = result.msg.businessid;
                            }
                                {
                                 var size = $('input[name=stickup_toggler]:checked').val()
                                    var modalElem = $('#confirmmodel');
                                    if (size == "mini")
                                    {
                                        $('#modalStickUpSmall').modal('show')
                                    }
                                    else
                                    {
                                        $('#confirmmodel').modal('show')
                                        if (size == "default") {
                                            modalElem.children('.modal-dialog').removeClass('modal-lg');
                                        }
                                        else if (size == "full") {
                                            modalElem.children('.modal-dialog').addClass('modal-lg');
                                        }
                                    }
                                    $("#errorboxdatas").text(<?php echo json_encode(POPUP_DRIVERS_ACTIVAT); ?>);

                                    $("#confirmed").click(function () {
                                         var val = $('.checkbox:checked').map(function () {
                                            return this.value;
                                        }).get();

                                        $("#ve_compan").text('');

                                        var store = '';
                                        var driv = $('input[name=radio]:checked').val();
                                        if(driv == 'Jaiecom'){
                                         var store =  $("#driver_type0").val();;
                                        }else{
                                          var store = $("#driver_type1").val();
                                        }
                                        if(store == ''){
                                          $("#ve_compan").text("Please select any one driver type");
                                        }
                                        else {
                                        $.ajax({
                                            url: "<?php echo base_url('index.php?/superadmin') ?>/acceptdrivers",
                                            type: "POST",
                                            data: {val: val,store:store},
                                            dataType: 'json',
                                            success: function (result)
                                            {
                                                $('#confirmmodel').modal('hide');

                                               var modalElem = $('#acceptdrivermsg');
                                                if (size == "mini")
                                                    {
                                                        $('#modalStickUpSmall').modal('show')
                                                    }
                                                    else
                                                    {
                                                        $('#acceptdrivermsg').modal('show')
                                                        if (size == "default") {
                                                            modalElem.children('.modal-dialog').removeClass('modal-lg');
                                                        }
                                                        else if (size == "full") {
                                                            modalElem.children('.modal-dialog').addClass('modal-lg');
                                                        }
                                                    }
                                                    $("#errorbox_accept").text(<?php echo json_encode(POPUP_MSG_ACCEPTED); ?>);

                                                    $("#accepted_msg").click(function(){
                                                        $('.close').trigger('click');
                                                    });
                                                $('.checkbox:checked').each(function (i) {
                                                    $(this).closest('tr').remove();
                                                });

                                            }

                                        });
                                      }

                                    });
                            }
                        }
                    });
               
            }
             else  if (val.length < 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST); ?>);
            }
            else {
                $('#displayData').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ONLY); ?>);
            }
                
        });
        
        var device_settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 20,
           "aoColumns": [
                {"sWidth": "220%","sClass" : "text-center td2"},
                {"sWidth": "100%","sClass" : "text-center td2"},
                {"sWidth": "150%","sClass" : "text-center td2"},
                {"sWidth": "0%","sClass" : "text-center td1"},
                {"sWidth": "230%","sClass" : "text-center td2"}
            ]
        };
     
     // Update status click function
      
     $("#confirmeds").click(function(){

        $.ajax({
                url: 'https://offersapi.uberfortruck.com/api/v1/updateofferStatus',
                type: 'PATCH',
                dataType: 'json',
                data: { 
                        couponId: $("#confirmeds").attr('data_id'),
                        status: parseInt($("#confirmeds").attr('status'))                        
                },
            }).done(function(json) {
                console.log(json);
                $("#confirmmodels").modal('hide');
                if (json.errFlag === 0) {
                    alert('Successfully Updated');
                }
                else{
                    alert('Error while updating data.');
                }
        }); 
     });
      

       

   
               
        $("#editdriver").click(function () {
//         var status = '<?php // echo $status; ?>';
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            
            if (val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_EDIT); ?>);

            } else if (val.length > 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_ONLYEDIT); ?>);
            }
            else
            {
                window.location = "<?php echo base_url() ?>index.php?/superadmin/editdriver/" + val;

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/editdriver/",
                    type: "POST",
                    data: {val: val},
                    dataType: 'json',
                    success: function (result)
                    {
                    }
                });

            }
        });
    
    function drivertype(){
    var value = $('input[name=radio]:checked').val();
//    console.log(value);
    if(value == 'Store'){
         $("#driver_type").show();
         $("#operator_type").hide();
    }else{
         $("#driver_type").hide();
         $("#operator_type").show();
    }
    }
});

</script>


<script type="text/javascript">
    

function changeApproveStatus(dropID){
    var dataId = $(dropID).attr('data_id');
    var couponCode = $(dropID).attr('data');
    var id = $(dropID).attr('id'); 
    var val = $('#'+id).val();
    if (val == 1) {
        var aprv = 'approved';
    }else if(val == 2){
        var aprv = 'pending';        
    }else{
        var aprv = 'rejected';       
    }
    var modalText = 'Do you want to change the approve status of '+ couponCode + " to " + aprv;
    // Empty all the contents
    $('#modalBodyText').text('');
    $('#confirmeds').attr('data_id', '');
    $('#confirmeds').attr('status', '');
    $('#confirmeds').attr('updateType', '');




    $('#modalBodyText').text(modalText);
    $('#confirmeds').attr('data_id', id);
    $('#confirmeds').attr('status', val);
    $('#confirmeds').attr('updateType', 1);
    $("#confirmmodels").modal();



}

function changeStatus(dropID){
    var dataId = $(dropID).attr('data_id');
    var couponCode = $(dropID).attr('data');
    var id = $(dropID).attr('id'); 
    var val = $('#'+id).val();
    if (val == 1) {
        var aprv = 'approved';
    }else if(val == 2){
        var aprv = 'pending';        
    }else{
        var aprv = 'deactivate';        

    }
    var modalText = 'Do you want to change the status of '+ couponCode + " to " + aprv;

    // Empty all the contents
    $('#modalBodyText').text('');
    $('#confirmeds').attr('data_id', '');
    $('#confirmeds').attr('status', '');
    $('#confirmeds').attr('updateType', '');



    $('#modalBodyText').text(modalText);
    $('#confirmeds').attr('data_id', dataId);
    $('#confirmeds').attr('status', val);
    $('#confirmeds').attr('updateType', 0);
    $("#confirmmodels").modal();

}


    $(document).ready(function () {


        $('#joblogs').hide();
        $('#big_table_processing').hide();
        var status = '<?php echo $status; ?>';
        if (status == 1) {
            $('#resetpassword').show();
            $('#btn_device_logs').hide();
            $('#chekdel').show();
            $('#reject').show();
            $('#accept').show();
            $('#add').show();
            $('#selectedcity').hide();
                $('#companyid').hide();
                $('#logout').hide();

        }
          
        var table = $('#big_table');
         $('#big_table').fadeOut('slow');

        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_drivers/my/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
//                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                    $('#big_table').fadeIn('slow');

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
        
        $('#big_table').on('init.dt', function () {
            $("#display-data").text("");

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            var forwhat = urlChunks[urlChunks.length - 2];
          
             if (forwhat == 'mo') {
                if (status == 30 ) {
                    $('#big_table').dataTable().fnSetColumnVis([4], false);
                    $('#big_table').dataTable().fnSetColumnVis([5], false);
                    $('#big_table').dataTable().fnSetColumnVis([6], false);
                    $('#big_table').dataTable().fnSetColumnVis([7], false);
                    $('#big_table').dataTable().fnSetColumnVis([9], false);
                    $('#big_table').dataTable().fnSetColumnVis([10], false);
                    $('#big_table').dataTable().fnSetColumnVis([12], false);
                }
                if(status == 567){
                     $('#big_table').dataTable().fnSetColumnVis([4], false); 
                     $('#big_table').dataTable().fnSetColumnVis([5], false); 
                     $('#big_table').dataTable().fnSetColumnVis([7], false); 
                     $('#big_table').dataTable().fnSetColumnVis([8], false); 
                     $('#big_table').dataTable().fnSetColumnVis([9], false);
                     $('#big_table').dataTable().fnSetColumnVis([10], false); 
                     $('#big_table').dataTable().fnSetColumnVis([12], false); 
                    
                }
                if(status == 3){
                      $('#big_table').dataTable().fnSetColumnVis([4], false);
                      $('#big_table').dataTable().fnSetColumnVis([5], false);
                      $('#big_table').dataTable().fnSetColumnVis([6], false);
                      $('#big_table').dataTable().fnSetColumnVis([8], false);
                      $('#big_table').dataTable().fnSetColumnVis([10], false);
                      $('#big_table').dataTable().fnSetColumnVis([12], false);
                }
            }
            else if(forwhat == 'my'){
                if(status == 1){
                     $('#big_table').dataTable().fnSetColumnVis([5], false);
                     $('#big_table').dataTable().fnSetColumnVis([6], false);
                     $('#big_table').dataTable().fnSetColumnVis([7], false);
                     $('#big_table').dataTable().fnSetColumnVis([8], false);
                     $('#big_table').dataTable().fnSetColumnVis([9], false);
                     $('#big_table').dataTable().fnSetColumnVis([10], false);
                     $('#big_table').dataTable().fnSetColumnVis([12], false);
    
                }
                if(status == 4 || status == 3){
                     $('#big_table').dataTable().fnSetColumnVis([6], false);
                     $('#big_table').dataTable().fnSetColumnVis([7], false);
                     $('#big_table').dataTable().fnSetColumnVis([8], false);
                     $('#big_table').dataTable().fnSetColumnVis([9], false);
                     $('#big_table').dataTable().fnSetColumnVis([12], false);
                }
            }

        });
        
       $('.whenclicked li').click(function () {
            if ($(this).attr('id') == "my1") {
                $('#add').show();
                $('#accept').show();
                $('#reject').show();
                $('#joblogs').hide();
                $('#editdriver').show();
                $('#chekdel').show();
                $('#resetpassword').show();
                $('#document_data').show();
                  $('#btn_device_logs').hide();
                $('#selectedcity').hide();
                $('#companyid').hide();
                 $('#logout').hide();
                   $('#search-table').val('');
        }
           else if ($(this).attr('id') == "my3") {
                $('#add').hide();
                $('#accept').hide();
                $('#reject').show();
                $('#joblogs').show();
                $('#editdriver').show();
                $('#chekdel').show();
                $('#resetpassword').show();
                $('#document_data').show();
                  $('#btn_device_logs').show();
                
                  $('#selectedcity').show();
                $('#companyid').show();
                 $('#logout').hide();
                 $('#search-table').val('');

               
        }
            if ($(this).attr('id') == "my4") {
                $('#add').hide();
                $('#accept').show();
                $('#reject').hide();
                $('#joblogs').show();
                $('#editdriver').show();
                $('#chekdel').show();
                $('#resetpassword').show();
                $('#document_data').show();
                  $('#selectedcity').show();
                    $('#btn_device_logs').show();
                $('#companyid').show();
                 $('#logout').hide();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "mo3") {
                $('#add').hide();
                $('#accept').hide();
                $('#reject').hide();
                $('#joblogs').hide();
                $('#editdriver').hide();
                $('#chekdel').hide();
                $('#resetpassword').hide();
                $('#document_data').hide();
                  $('#btn_device_logs').show();
                  $('#selectedcity').show();
                $('#companyid').show();
                 $('#logout').show();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "mo30") {
                $('#add').hide();
                $('#accept').hide();
                $('#reject').hide();
                $('#joblogs').hide();
                $('#editdriver').hide();
                $('#chekdel').hide();
                $('#resetpassword').hide();
                $('#document_data').hide();
                  $('#btn_device_logs').hide();
                  $('#selectedcity').show();
                $('#companyid').show();
                 $('#logout').hide();
                 $('#search-table').val('');
        }
            if ($(this).attr('id') == "mo567") {
                 $('#add').hide();
                $('#accept').hide();
                $('#reject').hide();
                $('#joblogs').hide();
                $('#editdriver').hide();
                $('#chekdel').hide();
                $('#resetpassword').hide();
                $('#document_data').hide();
                  $('#selectedcity').show();
                    $('#btn_device_logs').hide();
                $('#companyid').show();
                 $('#logout').hide();
                 $('#search-table').val('');
        }
            });

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
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
//                    "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
                    $('#big_table').fadeIn('slow');
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

    });

    function refreshTableOnCityChange() {

        var table = $('#big_table');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": $(".whenclicked li.active").children('a').attr('data'),
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
//                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
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
    }
    function refreshTableOnActualcitychagne() {

        var table = $('#big_table');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": $(".whenclicked li.active").children('a').attr('data'),
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
//                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
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

    }
</script>

<style>
    .exportOptions{
        display: none;
    }
    .btn-cons {
        margin-right: 5px;
        min-width: 102px;
    }
    .btn,.changeMode{
        font-size: 12px;
    }
    
    body{
        font-size: 11px;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color: gray;
             margin-left: 7px;padding-top: 20px;padding-bottom:10px;">

            <strong style="color:#0090d9;">OFFERS</strong><!-- id="define_page"-->
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs bg-white whenclicked">
                        <!-- <li id= "my1" class="tabs_active <?php echo $new ?>" style="cursor:pointer">
                            <a  class="changeMode New_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/1"><span><?php echo LIST_NEW; ?></span></a>
                        </li> -->
                        <!-- <li id= "my3" class="tabs_active <?php echo $accept ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/3"><span><?php echo LIST_ACCEPTED; ?></span></a>
                        </li> -->
                        <!-- <li id= "my4" class="tabs_active <?php echo $reject ?>" style="cursor:pointer">
                            <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/4"><span><?php echo LIST_REJECTED; ?></span></a>
                        </li> -->
                         </ul>
                   <br>
                       <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="">
                      <ul class="nav nav-tabs  bg-white">
                            <div class=""> <button class="btn btn-primary pull-right m-t-10 cls111" id="chekdel" style="margin-left:10px;margin-top: 5px;background: #d9534f;border-color: #d9534f;"><?php echo BUTTON_DELETE; ?></button></a></div>
                            <div class=""><button class="btn btn-primary pull-right m-t-10 cls111" id="editdriver" style="margin-left:10px;margin-top: 5px;background: #5bc0de;border-color: #5bc0de;"><?php echo BUTTON_EDIT; ?></button></div>
                            <div class="cls110"><a href="<?php echo base_url() ?>index.php?/coupons/createpromotion/3"> <button class="btn btn-primary pull-right m-t-10 cls110" id="add" style="margin-left:10px;margin-top: 5px;background: #337ab7;border-color: #337ab7;"><?php echo BUTTON_ADD; ?></button></a></div>
                      </ul>
                    </div>
                    <!-- Tab panes -->
                     <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                 <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog modal-sm">                                        
                                        <!-- Modal content-->
                                            <div class="modal-content">                                            
                                                <div class="modal-body">
                                                <h5 class="error-box" id="display-data" style="text-align:center"></h5>                                            
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>     

                                    <!-- <div class="searchbtn row clearfix pull-right" style="">
                                        <div class="pull-right">
                                            <input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div> -->

                                </div>
                                &nbsp;
                                <div class="panel-body">

                                   <table id="book-table" border = "1" class="table table-bordered">
                                        <thead>
                      <tr>
                        <th>S. NO.</th>
                        <th>PROMO TITLE</th>
                        <th>PROMO CODE</th>
                        <th>START DATE</th>
                        <th>END DATE</th>
                        <th>NUMBER OF CLAIMS</th>
                        <th>NUMBER OF BOOKINGS</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                      </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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

<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="" id="modalBodyText" style="font-size: large;text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" data_id=""  status="" updateType=""   id="confirmeds" style="margin:0;"><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

