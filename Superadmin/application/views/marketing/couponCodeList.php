<?php

date_default_timezone_set('UTC');
$rupee = "$";
// $accept = "active";
// $reject = "Inactive";


if ($status == "1") {
    $new = "active";
} else if ($status == "3") {
    $accept = "active";
} else if ($status == "3") {
    $free = "active";
} else if ($status == "4") {
    $reject = 'active';
}
else if ($status == "30") {
    $offline = 'active';
} else if ($status == "567") {
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
    .table>thead:first-child>tr:first-child>th {
            text-align: center !important;
            font-size: 12px !important;
        }
    .table-bordered>tbody>tr>th{
         text-align: center !important;
    }

    th.sorting {
        width: 56px !important;
    }


        .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .nav-md .container.body .right_col {
        padding: 2% 2% 0 3% !important;
        margin-left: 230px !important;
    }

    #add,#updatePromo,#chekdel,#addactive{
        border-radius: 25px !important;
    }


</style>

<script>
$(document).ready(function (){

$(document).on('click','.fg-button',function(){
    $("#select_all").prop("checked", false);
});  

  $("body").on('click','#select_all',function(){ 
    if(this.checked){
        $('.checkbox1').each(function(){
            this.checked = true;
        });
    }else{
         $('.checkbox1').each(function(){
            this.checked = false;
        });
    }
});


   $("body").on('click','.checkbox1',function(){ 
        if($('.checkbox1:checked').length == $('.checkbox1').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }   
   });

           $(".cityDetails").live('click', function(){
            var cityIds = $(this).attr("city_ids");
            $.ajax({
            url: "<?php echo APILink ?>admin/cityDetailsByCityIds/" + cityIds,
            type: 'GET',
            dataType: 'json',
            headers: {
                  language: 0
                },
            data: { },
        })
        .done(function(json) {
            if (json.data.length > 0 ) {
                $("#showCityDetailsModal").modal();
                $("#cityDetailsBody").empty();
                for (var i = 0; i< json.data.length; i++) {
                    var cityDetailsData = '<tr>'+
                                    '<td style="text-align:center">' + (i+1) +'</td>' +
                                    '<td style="text-align:center">' + json.data[i].cities.cityName+ '</td>' +
                                    '<td style="text-align:center">' + json.data[i].country+ '</td>' +
                                    '<td style="text-align:center">' + json.data[i].cities.currency + '</td>' +
                                    '</tr>';
                    $("#cityDetailsBody").append(cityDetailsData);  
                }



            }else{

            }
            
            
        });
});

    /*Start date*/
             /*
                    $("#searchData").click(function(){
                                console.log('clciked');

                            var st = $("#start").datepicker().val();
                        
                            var stDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1]+'-';
                            var end = $("#end").datepicker().val();
                            var enDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];

                            var datetime=stDate+enDate;
                            alert(datetime);
                            return false;

                            var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 10,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/campaigns/getAllCampaigns/2/'+datetime,
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
                            }
                            };
                            table.dataTable(settings);

                    });
                    
                    */


      //from date to end date
         $("#searchData").click(function(){

                console.log('clicke');
                var st = $("#start").datepicker().val();
                var stDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1];
                var end = $("#end").datepicker().val();
                var enDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];
                
                var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 10,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/productOffers/offer_details/0/'+stDate+'/'+enDate,
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

        });

});
</script>
<script>


// Function to get  qulified trip details
function getQualifiedTripDetails(campaignId){    
        $.ajax({
                    url: "http://13.59.208.176:7009/qualifiedTripsDetail/" + campaignId,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                    },
            })
            .done(function(json) {
                $("#qualifyingTripData").html('');
                console.log("json data " + json.data.length);
                if (json.data.length !=0) {
                    for (var i = 0; i < json.data.length ; i++) {
                        console.log(json.data);
                        var unlockedCount = json.data[i].totalTrps/json.data[i].requiredTrips;
                        var responseData = '<tr>' +
                                      '<th scope="row">'+json.data[i].name+'</th>' +
                                      '<td>'+json.data[i].phone+'</td>' +
                                      '<td>'+json.data[i].email+'</td> ' +
                                      '<td>'+json.data[i].totalTrps+'</td>' +
                                    '</tr>';
                        $("#qualifyingTripData").append(responseData);
                    }
                    
                }else{
                    $("#modalData").html('');
                   modalData = '<p style="text-align: center; color: coral; font-size: 20px;">No data found</p>';
                   $("#modalData").append(modalData);
                }
                
                $("#qualiFyingTripModal").modal();

                
            });
}

function citiesList(){
        $.ajax({
                url: "<?php echo APILink ?>" + "admin/city",
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 0
                },
                data: {                  
                },
            }).done(function(json) {

                console.log(json);
                
                $("#citiesList").html('<option value="" selected>Select All</option>');
                
                 for (var i = 0; i< json.data.length; i++) {
                
                    var citiesList = "<option value="+ json.data[i].id + " currency="+ json.data[i].currency + ">"+  json.data[i].cityName +"</option>";
                    $("#citiesList").append(citiesList);  
                }
                //   $('#citiesList').multiselect({
                //     includeSelectAllOption: true,
                //     enableFiltering: true,
                //     enableCaseInsensitiveFiltering : true,
                //     buttonWidth: '100%',
                //     maxHeight: 300,
                // });
        });
     }


// Function to get claim details

function getClaimDetails(campaignId){    
        $.ajax({
                    url: "http://13.59.208.176:7009/getClaimedData/" + campaignId,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                    },
            })
            .done(function(json) {
                $("#claimTableBody").html('');
                console.log("json data " + json.data.length);
                if (json.data.length !=0) {
                    for (var i = 0; i < json.data.length ; i++) {
                        console.log(json.data);
                        var responseData = '<tr>' +
                                      '<th scope="row">'+json.data[i]._id+'</th>' +
                                      '<td>'+json.data[i].bookingId+'</td>' +
                                      '<td>'+json.data[i].lockedTimeStamp+'</td> ' +
                                      '<td>'+ json.data[i].status +'</td>' +
                                    '</tr>';
                        $("#claimTableBody").append(responseData);
                    }
                    
                }else{
                    $("#claimTable").html('');
                   modalData = '<p style="text-align: center; color: coral; font-size: 20px;">No data found</p>';
                   $("#claimTable").append(modalData);
                }
                
                $("#claimDetailsData").modal();

                
            });
}


// Function to update offer status
    function updateCampaignStatus(couponIds, status){
            $.ajax({
                    url: "<?php echo base_url('index.php?/CouponCode/updatecouponCodeStatus');?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        couponId : couponIds,
                        status : status
                    },
            })
            .done(function(json) {
                console.log(json);
                if (json.msg.message === "Success") {
                     $('#promo_table').DataTable().ajax.reload();
                    $("#confirmmodels").modal('hide')
                    // window.location.reload();
                }else{
                    alert('Unable to update status. Please try agin later');
                }
            });
   }




$(document).ready(function () {


    $('#addactive').hide();


    // Offer deactive del123

    $("#updatePromo").click(function(){
        $("#modalFooter").html("");
        var status = 3;
        var val = [];
        //alert(val);
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
          console.log(val[i]);
        });
        if (val.length ==0) {
            
            var modalText = 'Please select at least one code to deactivate';
            var button = '<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">CLOSE</button>';
                $('#modalBodyText').text(modalText);
                $("#modalFooter").append(button);
                $("#confirmmodels").modal();
        }else{

               $('#modalBodyText').text('');
                $("#modalFooter").text(''); 
                $('#confirmeds').attr('data_id', '');
                $('#confirmeds').attr('status', '');
                $('#confirmeds').attr('updateType', '');
                var couponId = $(".checkbox1:checked").val();

                var modalText = 'Do you want to continue to deactivate';

                $('#modalBodyText').text(modalText);
                var deleteButton = '<button type="button" class="btn btn-primary pull-right" data_id="'+ couponId +' " id="confirmDeactivate" style="margin:0;">YES</button>"';
                $("#modalFooter").append(deleteButton);
                $("#confirmmodels").modal();
                //  updateCampaignStatus(val, status);
    }
   });


     // Deactivate offer
     $("body").on('click', '#confirmDeactivate', function (){        
            var status = 3;
            var val = [];
            $(':checkbox:checked').each(function(i){
              val[i] = $(this).val();
            });
            updateCampaignStatus(val, status);
        });



    /*date picker*/
    var date = new Date();
        $('.datepicker-component').datepicker({
        });

         $('.datepicker-component').on('changeDate', function () {
          $(this).datepicker('hide');
        });
      
        $('#datepicker-component').on('changeDate', function () {
            $('.datepicker').hide();
        });

    //datatables start 
    citiesList();
    var table = $('#promo_table');
    var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 10,
                "bProcessing": true,
                "bServerSide": true,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "serverSide": true,
                "ajax": {
                    url : "<?php echo base_url('index.php?/couponCode/getAllcouponCodes/2/');?>",
                    type : 'POST',
                    "data": function (d) {
                        d.cityId = $("#citiesList").val();
                        return d;
                    }
                },
                "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],
                // "sAjaxSource": '<?php echo base_url('index.php?/couponCode/getAllcouponCodes/2/');?>',
                // 'fnServerData': function (sSource, aoData, fnCallback)
                // {
                //     // csrf protection
                //     aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                //     aoData.push('cityId', $('#citiesList').val());
                //     $.ajax
                //             ({
                //                 'dataType': 'json',
                //                 'type': 'POST',
                //                 'url': sSource,
                //                 'data': aoData,
                //                 'success': fnCallback
                //             });
                // },
                "language": {
                            "lengthMenu": "Displays -- records per page",
                            "zeroRecords": "No matching records found",
                            "infoEmpty": "No records available"
                            }
            };

        table.dataTable(settings);

        // search box for table
        $('#search-tables').keyup(function () {
                table.fnFilter($(this).val());
        });

     $("#citiesList").change(function(){
        table.fnFilter($('#search-table').val());
     });
     
    
    //datatables end del123
    // class="close" data-dismiss="modal"
        $("#chekdel").click(function () {
            $("#modalFooter").html("");
            if ($(".checkbox1").is(":checked") == false) {
                $('#modalBodyText').text('Please select atleast one code to delete');
                var deleteButton = '<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">CLOSE</button>';
                $("#modalFooter").append(deleteButton);
                $("#confirmmodels").modal();
                // return;
            }else{

                $('#modalBodyText').text('');
                $("#modalFooter").text('');
                $('#confirmeds').attr('data_id', '');
                $('#confirmeds').attr('status', '');
                $('#confirmeds').attr('updateType', '');
                var couponId = $(".checkbox1:checked").val();

                var modalText = 'Do you want to continue to delete';

                $('#modalBodyText').text(modalText);
                var deleteButton = '<button type="button" class="btn btn-primary pull-right" data_id="'+ couponId +' " id="confirmDelete1" style="margin:0;">DELETE</button>"';
                $("#modalFooter").append(deleteButton);
                $("#confirmmodels").modal();
            }
        });
        
        // Delete offer
        $("body").on('click', '#confirmDelete1', function (){        
            var status = 5;
            var val = [];
            $(':checkbox:checked').each(function(i){
              val[i] = $(this).val();
            });
            console.log(val);
            updateCampaignStatus(val, status);
        });

// Update offer status
    $(".offerActive").click(function(){
         $("#modalFooter").html("");
        var status = 2;
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
        if (val.length ==0) {
            var modalText = 'Please select at least one code to activate';
            var button = '<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">CLOSE</button>';
                $('#modalBodyText').text(modalText);
                $("#modalFooter").append(button);
                $("#confirmmodels").modal();
        }else{
            $('#modalBodyText').text('');
                $("#modalFooter").text('');
                $('#confirmeds').attr('data_id', '');
                $('#confirmeds').attr('status', '');
                $('#confirmeds').attr('updateType', '');
                var couponId = $(".checkbox1:checked").val();

                var modalText = 'Do you want to continue to Activate';

                $('#modalBodyText').text(modalText);
                var deleteButton = '<button type="button" class="btn btn-primary pull-right" data_id="'+ couponId +' " id="confirmActivate" style="margin:0;">YES</button>"';
                $("#modalFooter").append(deleteButton);
                $("#confirmmodels").modal();

        // updateCampaignStatus(val, status);
            
        }
   });

     // Deactivate offer
     $("body").on('click', '#confirmActivate', function (){        
            var status = 2;
            var val = [];
            $(':checkbox:checked').each(function(i){
              val[i] = $(this).val();
            });
            updateCampaignStatus(val, status);
        });




// get the qualifying trip details
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
                $("#display-data").text("");
            }
                
        });
        
        // var device_settings = {
        //     "sDom": "<'table-responsive't><'row'<p i>>",
        //     "destroy": true,
        //     "scrollCollapse": true,
        //     "oLanguage": {
        //         "sLengthMenu": "_MENU_ ",
        //         "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
        //     },
        //     "iDisplayLength": 20,
        //    "aoColumns": [
        //         {"sWidth": "220%","sClass" : "text-center td2"},
        //         {"sWidth": "100%","sClass" : "text-center td2"},
        //         {"sWidth": "150%","sClass" : "text-center td2"},
        //         {"sWidth": "0%","sClass" : "text-center td1"},
        //         {"sWidth": "230%","sClass" : "text-center td2"}
        //     ]
        // };
     
     // Update status click function
      
     $("#confirmeds").click(function(){

        
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
        var aprv = 'enabled';
    }else if(val == 2){
        var aprv = 'disabled';        
    }else{
        var aprv = 'expired';        

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

        $(".updatePromo").click(function(){
            alert('deactive witj class');
                    var status = 3;
                    var val = [];
                    $(':checkbox:checked').each(function(i){
                      val[i] = $(this).val();
                    });
                   updateCampaignStatus(val, status);
                  
                });

console.log("!st called");
        $('#joblogs').hide();
        $('#big_table_processing').hide();
        var status = '<?php echo $status; ?>';
        if (status == 1) {
            $('#resetpassword').show();
            $('#btn_device_logs').hide();
            $('#chekdel').show();
            $('#reject').show();
            $('#accept').show();
            //$('#add').hide();
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
          
            //  if (forwhat == 'mo') {
            //     if (status == 30 ) {
            //         $('#big_table').dataTable().fnSetColumnVis([4], false);
            //         $('#big_table').dataTable().fnSetColumnVis([5], false);
            //         $('#big_table').dataTable().fnSetColumnVis([6], false);
            //         $('#big_table').dataTable().fnSetColumnVis([7], false);
            //         $('#big_table').dataTable().fnSetColumnVis([9], false);
            //         $('#big_table').dataTable().fnSetColumnVis([10], false);
            //         $('#big_table').dataTable().fnSetColumnVis([12], false);
            //     }
            //     if(status == 567){
            //          $('#big_table').dataTable().fnSetColumnVis([4], false); 
            //          $('#big_table').dataTable().fnSetColumnVis([5], false); 
            //          $('#big_table').dataTable().fnSetColumnVis([7], false); 
            //          $('#big_table').dataTable().fnSetColumnVis([8], false); 
            //          $('#big_table').dataTable().fnSetColumnVis([9], false);
            //          $('#big_table').dataTable().fnSetColumnVis([10], false); 
            //          $('#big_table').dataTable().fnSetColumnVis([12], false); 
                    
            //     }
            //     if(status == 3){
            //           $('#big_table').dataTable().fnSetColumnVis([4], false);
            //           $('#big_table').dataTable().fnSetColumnVis([5], false);
            //           $('#big_table').dataTable().fnSetColumnVis([6], false);
            //           $('#big_table').dataTable().fnSetColumnVis([8], false);
            //           $('#big_table').dataTable().fnSetColumnVis([10], false);
            //           $('#big_table').dataTable().fnSetColumnVis([12], false);
            //     }
            // }
            // else if(forwhat == 'my'){
            //     if(status == 1){
            //          $('#big_table').dataTable().fnSetColumnVis([5], false);
            //          $('#big_table').dataTable().fnSetColumnVis([6], false);
            //          $('#big_table').dataTable().fnSetColumnVis([7], false);
            //          $('#big_table').dataTable().fnSetColumnVis([8], false);
            //          $('#big_table').dataTable().fnSetColumnVis([9], false);
            //          $('#big_table').dataTable().fnSetColumnVis([10], false);
            //          $('#big_table').dataTable().fnSetColumnVis([12], false);
    
            //     }
            //     if(status == 4 || status == 3){
            //          $('#big_table').dataTable().fnSetColumnVis([6], false);
            //          $('#big_table').dataTable().fnSetColumnVis([7], false);
            //          $('#big_table').dataTable().fnSetColumnVis([8], false);
            //          $('#big_table').dataTable().fnSetColumnVis([9], false);
            //          $('#big_table').dataTable().fnSetColumnVis([12], false);
            //     }
            // }

        });
        
       $('.whenclicked li').click(function () {
            if ($(this).attr('id') == "my2") {
                $('#add').show();
                $('#accept').show();
                $('#reject').show();
                $('#joblogs').hide();
                $('#updatePromo').show();
                $('#chekdel').show();
                $('#resetpassword').show();
                $('#document_data').show();
                  $('#btn_device_logs').hide();
                $('#selectedcity').hide();
                $('#companyid').hide();
                 $('#logout').hide();
                   $('#search-table').val('');
                   $('#edit').show();
                   $('#addactive').hide();
        }
           else if ($(this).attr('id') == "my3") {
                $('#add').hide();
                $('#accept').hide();
                $('#reject').show();
                $('#joblogs').show();
                $('#updatePromo').hide();
                $('#chekdel').show();
                $('#resetpassword').show();
                $('#document_data').show();
                  $('#btn_device_logs').show();
                  $('#edit').hide();
                  $('#selectedcity').show();
                $('#companyid').show();
                 $('#logout').hide();
                 $('#search-table').val('');
                 $('#addactive').show();

               
        }else
             if ($(this).attr('id') == "my4") {
                $('#add').hide();
                $('#accept').hide();
                $('#reject').hide();
                $('#joblogs').show();
                $('#updatePromo').hide();
                $('#chekdel').show();
                $('#resetpassword').show();
                $('#document_data').show();
                  $('#selectedcity').show();
                    $('#btn_device_logs').show();
                $('#companyid').show();
                 $('#logout').hide();
                 $('#search-table').val('');
                 $('#edit').hide();
        } else
             if ($(this).attr('id') == "my5") {
                $('#add').hide();
                $('#accept').hide();
                $('#reject').hide();
                $('#joblogs').show();
                $('#updatePromo').hide();
                $('#chekdel').hide();
                $('#resetpassword').show();
                $('#document_data').show();
                  $('#selectedcity').show();
                    $('#btn_device_logs').show();
                $('#companyid').show();
                 $('#logout').hide();
                 $('#search-table').val('');
                 $('#edit').hide();
                 $('#addactive').hide();
        } 



            if ($(this).attr('id') == "mo3") {
                $('#add').hide();
                $('#accept').hide();
                $('#reject').hide();
                $('#joblogs').hide();
                $('#updatePromo').hide();
                $('#chekdel').hide();
                $('#resetpassword').hide();
                $('#document_data').hide();
                  $('#btn_device_logs').show();
                  $('#selectedcity').show();
                $('#companyid').show();
                 $('#logout').show();
                 $('#search-table').val('');
                 $('#edit').hide();
        }
            if ($(this).attr('id') == "mo30") {
                $('#add').hide();
                $('#accept').hide();
                $('#reject').hide();
                $('#joblogs').hide();
                $('#updatePromo').hide();
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
                $('#updatePromo').hide();
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

    console.log(this.id);
   //alert("chnagemode");
   $('#promo_table').DataTable({
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 10,
                "bProcessing": true,
                "bServerSide": true,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "serverSide": true,
                "ajax": {
                    url : $(this).attr('data'),
                    type : 'POST'
                },
                "language": {
                            "lengthMenu": "Display -- records per page",
                            "zeroRecords": "No matching records found",
                            "infoEmpty": "No records available"
                            },
                            "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],
            });
            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');
         
        });
         
    });

    function refreshTableOnCityChange() {

        var table = $('#data_table');
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
            },
            "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],
            "language": {
                            "lengthMenu": "Display -- records per page",
                            "zeroRecords": "No matching records found - You don't add anything yet.",
                            "infoEmpty": "No records available"
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
            },
            "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],
            "language": {
                            "lengthMenu": "Display -- records per page",
                            "zeroRecords": "No matching records found - You don't add anything yet.",
                            "infoEmpty": "No records available"
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

            <strong style="color:#0090d9;">PROMO CODES</strong><!-- id="define_page"-->
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs bg-white whenclicked">
                           <!-- <li id= "my1" class="tabs_active  <?php //echo $new ?>" style="cursor:pointer">
                                <a  class="changeMode New_ " id = "new" data="<?php echo base_url(); ?>index.php?/couponCode/getAllcouponCodes/1/0/10">
                                    <span>NEW</span>
                                    <!-- <span style="margin-left: 5px; color: darkorange;">(<?php //echo $codeCounts['newCount']?>)</span>
                                </a>
                            </li>-->
                            <li id= "my2" class="tabs_active active<?php //echo $accept ?>" style="cursor:pointer">
                                <a  class="changeMode accepted_" id="active" data="<?php echo base_url(); ?>index.php?/couponCode/getAllcouponCodes/2/">
                                    <span>ACTIVE</span>
                                    <!-- <span style="margin-left: 5px; color: green;">(<?php //echo $codeCounts['activeCount']?>)</span> -->
                                </a>
                            </li>
                            <li id= "my3" class="tabs_active <?php //echo $accept ?>" style="cursor:pointer">
                                <a  class="changeMode accepted_" id="inactive" data="<?php echo base_url(); ?>index.php?/couponCode/getAllcouponCodes/3/">
                                    <span>INACTIVE</span>
                                    <!-- <span style="margin-left: 5px; color: darkred;">(<?php //echo $codeCounts['inActiveCount']?>)</span> -->
                                </a>
                            </li>
                            <li id= "my4" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer">
                                <a  class="changeMode rejected_" id="expired" data="<?php echo base_url(); ?>index.php?/couponCode/getAllcouponCodes/4/">
                                    <span>EXPIRED</span>
                                    <!-- <span style="margin-left: 5px; color: red;">(<?php //echo $codeCounts['deleteCount']?>)</span> -->
                                </a>
                            </li>
                            <li id= "my5" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer">
                                <a  class="changeMode rejected_" id="expired" data="<?php echo base_url(); ?>index.php?/couponCode/getAllcouponCodes/5/">
                                    <span>DELETED</span>
                                    <!-- <span style="margin-left: 5px; color: red;">(<?php //echo $codeCounts['deleteCount']?>)</span> -->
                                </a>
                            </li>
                            <div class=""> <button class="btn btn-danger pull-right m-t-10 cls111" id="chekdel" style="margin-left:10px;margin-top: 5px;background: #d9534f;border-color: #d9534f;">DELETE</button></a></div>
                            <div class=""><button class="btn btn-primary pull-right m-t-10 cls111" id="updatePromo" style="margin-left:10px;margin-top: 5px;background: #d9534f;border-color: #d9534f;">DEACTIVATE</button></div>
                            <div class="cls110"><button class="btn btn-primary pull-right m-t-10 cls110 offerActive" id="addactive" style="margin-left:10px;margin-top: 5px;background: #337ab7;border-color: #337ab7;">ACTIVATE</button></div>
                            <div class=""><a href="<?php echo base_url() ?>index.php?/couponCode/addNewCode"> <button class="btn btn-primary pull-right m-t-10 cls110" id="add" style="margin-left:10px;margin-top: 5px;background: #337ab7;border-color: #337ab7;">CREATE</button></a></div>
                         </ul>
                   <br>
                       
                     <!-- Tab panes 
                     <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                 <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog modal-sm">                                        
                                      
                                            <div class="modal-content">                                            
                                                
                                            </div>                                            
                                        </div>
                                    </div>     

                                </div>
                                &nbsp;
                                <div class="panel-body">
                                   <table id="data-table" border = "1" class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">
                                        <thead>
                                            <tr>
                                                <th>S. NO.</th>
                                                <th>TITLE</th>
                                                <th>CODE</th>
                                                <th>START DATE</th>
                                                <th>END DATE</th>
                                                <th>CITIES</th>
                                                <th>ZONES</th>
                                               
                                                <th>UNLOCKED COUNT</th>
                                                <th>CLAIMS</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>-->
                     <!-- Tab panes -->
                <div class="tab-content">
                    <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="row">
                                   
                                    
                 <!--city-->
                  <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 citiesData">
                                    <div class="col-sm-6 form-group">
                                                <label for="fname" class="col-sm-1 control-label aligntext" style="padding:10px">CITIES <span ></span></label> 
                                                <div class="col-sm-8">
                                                    <select id="citiesList" name="company_select" class="form-control" style="width: 40% !important">
                                                    <!-- <option disabled selected value> None Selected</option> -->
                                                    </select>
                                                </div>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                          
                                    <!-- <div class="col-sm-5 row input-daterange input-group" style="float: left;">
												<input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
												<span class="input-group-addon">to</span>
												<input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">
                                    </div>
                                    <div class="col-sm-1 " style="margin-left: 10px;">
                                             <button class="btn btn-primary" style="width: 60px !important;" type="button" id="searchData">Search</button>
                                    </div> -->
                                           
                                            <div class="col-sm-5 row pull-right">
                                                <div class="pull-right"><input type="text" id="search-tables" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                            </div>
                                     </div>


                            </div>

                            <div class="panel-body">

                                <?php
                                    echo $this->table->generate();
                                ?>

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

<div class="modal fade " id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Confirmation</h4>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="" id="modalBodyText" ></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" id="modalFooter">
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal for all -->
<div class="modal fade stick-up" id="qualiFyingTripModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="margin-left: -80%; margin-right: -80%">
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <P style="font-size: 15px; font-weight: bold;">QUALIFYING TRIP DETAILS</P>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>
            </div>
            <br>
            <div class="modal-body" id="modalData">
                <table class="table table-bordered">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th scope="col">USER NAME</th>
                                      <th scope="col">PHONE</th>
                                      <th scope="col">EMAIL</th>
                                      <th scope="col">TRIP COUNT</th>
                                     </tr>
                                  </thead>
                                  <tbody id="qualifyingTripData" style="text-align: center;">
                                  </tbody>
                              </table>
                
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


<!-- Claim details modal -->
<div class="modal fade stick-up" id="claimDetailsData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="margin-left: -80%; margin-right: -80%">
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <P style="font-size: 15px; font-weight: bold;">CLAIM DETAILS</P>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>
            </div>
            <br>
            <div class="modal-body" id="claimTable">
                <table class="table table-bordered">
                                  <thead class="thead-dark">
                                    <tr>
                                      <th scope="col">CLAIM ID</th>
                                      <th scope="col">BOOKING ID</th>
                                      <th scope="col">TIMESTAMP</th>
                                      <th scope="col">STATUS</th>
                                      

                                    </tr>
                                  </thead>
                                  <tbody id="claimTableBody" style="text-align: center;">
                                  </tbody>
                              </table>
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

<!--show city details -->
<div class="modal fade" id="showCityDetailsModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;text-transform: capitalize;"><span id="cityDetails">CITIES DETAILS</span></strong>
            </div>
            <div class="modal-body">
                 <!-- data is comming from js which is written at top-->
            <table class="table table-bordered schedulepopup">
                <thead>
                  <tr>
                    <th style="width:10%;text-align: center; color: darkturquoise;">S.NO</th>
                    <th style="width:15%;text-align: center; color: darkturquoise;">CITY NAME</th>
                    <th style="width:20%;text-align: center; color: darkturquoise;">COUNTRY NAME</th>
                    <th style="width:20%;text-align: center; color: darkturquoise;">CURRENCY</th>
                  </tr>
                </thead>
               <tbody id="cityDetailsBody">
              </tbody>
            </table>
            
            
            </div>
            <div class="modal-footer">  
               <button type="button" class="btn btn-default" data-dismiss="modal">
                  Close
               </button>
            </div>
        </div>
    </div>
</div>
<script>



</script>