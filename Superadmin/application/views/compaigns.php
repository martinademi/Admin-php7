<?php
date_default_timezone_set('UTC');
$rupee = "$";
error_reporting(0);

if ($status == 1) {
    $passenger_status = 'active';
    $active = "active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
} else if ($status == 2) {
    $passenger_status = 'deactive';
    $deactive = "active";
}
?> 

<style>
    
    
    .radio input[type=radio] {
  position: absolute;
  margin-left: -20px;
}
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    /*.ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}*/
    
    .table-bordered>thead>tr>th {
        text-align: center;
    }
    .panel {
   margin-bottom: 0px; 
    }
    
   
    .table-bordered>tbody>tr>td {
        text-align: center;
    }
    
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

</style>

<script>
    var currentTab = <?php echo $status;?>;
    var compaignEditId;

    function isNumberKey(evt)
    {
        $("#pcode").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 45 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#pcode").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }





    $(document).ready(function () {
    $('#two').prop('checked',true);
    
    
    
    var table = $('#big_table1,#big_table2,#big_table3');
      $('.cs-loader').show();
     $('#selectOPT').hide();
    
     var searchInput = $('#search-table');
     searchInput.hide();
     table.hide();
 setTimeout(function() {

        var settings = {
            "autoWidth": true,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
             "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
           "columnDefs": [
                { "width": "30%", "targets": 0 }
              ],
                  
               "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                table.show()
                   $('.cs-loader').hide()
                   searchInput.show()
                    $('#selectOPT').show()
                   
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
            }
            
        };

        table.dataTable(settings);
          $('#search-table').keyup(function () {
       
            table.fnFilter($(this).val());
        });
         }, 1000);
      
        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });

        var date = new Date();
        $('.datepicker-component').datepicker({
            startDate: date
        });

        $("#define_page").html("Compaigns");


        $('.compaigns').addClass('active');
        $('.compaigns').attr('src', "<?php echo base_url(); ?>/theme/icon/campaigns_on.png");
        $('.compaigns_thumb').addClass("bg-success");

//
        $('#btnStickUpSizeToggler').click(function () {
            
            $('.errors').text('');
            $('#title').val('');
            $('#selectcity').val('');
            $('#discount').val('');
            $('#referaldiscount').val('');
            $('#message').val('');
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#addCompainref');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#addCompainref').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
        });

//
        $('#secondadd').click(function () {
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModals');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#myModals').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
        });
//
//
        $("#insert").click(function () {

            $('.errors').text('');

            var city = $("#selectcity").val();
            var title = $("#title").val();

            var discount = $("#discount").val();
            var message = $("#message").val();
            var referaldiscount = $("#referaldiscount").val();
            var title = $("#title").val();
            var alphabit = /^[a-zA-Z ]*$/;

            var discountradio = $('.optionyes1:checked').val();

            var refferalradio = $('.optionyes:checked').val();

            var re = /[a-zA-Z0-9\-\_]$/;
            var reg = /^[0-9]+$/;     //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;



            if (title == '') {
                $('#referralTitle_Err').text(<?php echo json_encode(POPUP_COMPAIGNS_TITLE); ?>);
            }
            else if (city == "0") {
//                alert("please select city");
                $('#referralCity_Err').text(<?php echo json_encode(POPUP_DISPATCHERS_CITY); ?>);
            }
            else if (discount == "" || discount == null)
            {
//                alert("please enter the discount");
                $('#referralNewUserDiscount_Err').text(<?php echo json_encode(POPUP_COMPAIGNS_DISCOUNT); ?>);
            }
            else if (discount == "" || discount == null)
            {
//                alert("please enter the discount");
                $('#referralNewUserDiscount_Err').text(<?php echo json_encode(POPUP_COMPAIGNS_DISCOUNT); ?>);
            }
            else if (discountradio == 1 && discount > 99)
            {
//                alert("please enter the discount");
                $('#referralNewUserDiscount_Err').text('New user discount should not be more than 99 percentage');
            }
//            else if (!reg.test(discount))
//            {
//                //      alert("please enter  numbers only");
//                $('#errorBox_myModal').text(<?php echo json_encode(POPUP_COMPAIGNS_NUMBERS); ?>);
//            }
            else if (referaldiscount == "" || referaldiscount == null)
            {
                //      alert("please enter the referaldiscount");
                $('#referralBonusType_Err').text(<?php echo json_encode(POPUP_COMPAIGNS_REFERALDISCOUNT); ?>);
            }
            else if (refferalradio == 1 && referaldiscount > 99)
            {
                //      alert("please enter the referaldiscount");
                $('#referralBonusType_Err').text('Referral discount should not be more than 99 percentage');
            }
//            else if (!reg.test(referaldiscount))
//            {
//                //    alert("please enter numbers only");
//                $('#errorBox_myModal').text(<?php echo json_encode(POPUP_COMPAIGNS_NUMBERS); ?>);
//            }
            else if (message == "" || message == null)
            {
                //  alert("please enter the message");
                $('#referralMsg_Err').text(<?php echo json_encode(POPUP_COMPAIGNS_MESSAGE); ?>);
            }
//            else if (!re.test(message))
//            {
//                //            alert("please enter message as text only");
//                $('#errorBox_myModal').text(<?php echo json_encode(POPUP_COMPAIGNS_TEXT); ?>);
//            }
            else
            {

                $('.close').trigger('click');

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/insertcompaigns",
                    type: 'POST',
                    data: {
                        coupon_type: 1,
                        city: city,
                        discount: discount,
                        message: message,
                        referaldiscount: referaldiscount,
                        discountradio: discountradio,
                        refferalradio: refferalradio,
                        title: title
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.flag == 1) {

                            var size = $('input[name=stickup_toggler]:checked').val()
                            var modalElem = $('#confirmmodelss');
                            if (size == "mini")
                            {
                                $('#modalStickUpSmall').modal('show')
                            }
                            else
                            {
                                $('#confirmmodelss').modal('show')
                                if (size == "default") {
                                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                                }
                                else if (size == "full") {
                                    modalElem.children('.modal-dialog').addClass('modal-lg');
                                }
                            }



                            $("#errorboxdatass").text(response.msg);
                            $("#confirmedss").click(function () {
//                                 window.location = "<?php echo base_url(); ?>/index.php?/supersuperadmin/compaigns/1";
                                $('.close').trigger('click');
                            });


                        }
                        else if (response.flag == 0) {

                            var size = $('input[name=stickup_toggler]:checked').val()
                            var modalElem = $('#confirmmodelss');
                            if (size == "mini")
                            {
                                $('#modalStickUpSmall').modal('show')
                            }
                            else
                            {
                                $('#confirmmodelss').modal('show')
                                if (size == "default") {
                                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                                }
                                else if (size == "full") {
                                    modalElem.children('.modal-dialog').addClass('modal-lg');
                                }
                            }



                            $("#errorboxdatass").text(response.msg);
                            $("#confirmedss").click(function () {
                                window.location = "<?php echo base_url(); ?>/index.php?/superadmin/compaigns/1";
                            });


                        }

                    }

                });
            }

        });

        $("#firsteditsubmit").click(function () {
            

            $('#errorBox_myModalfirst').text('');
            var val = $('.checkbox:checked').val();

            var title = $("#titlefirst").val();

            var discount = $("#discountfirst").val();
            var message = $("#messagefirst").val();
         
            var referaldiscount = $("#referaldiscountfirst").val();

            var alphabit = /^[a-zA-Z ]*$/;

            var discountradio = $('.optionyesfirst:checked').val();

            var refferalradio = $('.optionyesfirstreferal:checked').val();

            var re = /[a-zA-Z0-9\-\_]$/;
            var reg = /^[0-9]+$/;     //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;



            if (title == '') {
                $('#referral_e_title').text(<?php echo json_encode(POPUP_COMPAIGNS_TITLE); ?>);
            }

            else if (discount == "" || discount == null)
            {

                $('#referral_e_discount').text(<?php echo json_encode(POPUP_COMPAIGNS_DISCOUNT); ?>);
            }
//            else if (!reg.test(discount))
//            {
//
//                $('#errorBox_myModalfirst').text(<?php echo json_encode(POPUP_COMPAIGNS_NUMBERS); ?>);
//            }
            else if (referaldiscount == "" || referaldiscount == null)
            {

                $('#referral_e_referral_discount').text(<?php echo json_encode(POPUP_COMPAIGNS_REFERALDISCOUNT); ?>);
            }
//            else if (!reg.test(referaldiscount))
//            {
//
//                $('#errorBox_myModalfirst').text(<?php echo json_encode(POPUP_COMPAIGNS_NUMBERS); ?>);
//            }
            else if (message == "" || message == null)
            {

                $('#referral_e_msg').text(<?php echo json_encode(POPUP_COMPAIGNS_MESSAGE); ?>);
            }

            else
            {

                $('.close').trigger('click');

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/updatecompaigns",
                    type: 'POST',
                    data: {
                        coupon_type: 1,
                        val:$('#record-id').val(),
                        discount: discount,
                        message: message,
                        referaldiscount: referaldiscount,
                        discountradio: discountradio,
                        refferalradio: refferalradio,
                        title: title
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        window.location = "<?php echo base_url(); ?>/index.php?/superadmin/compaigns/1";
                    }

                });
            }

        });
//        
        $(document).on('click','.Activate',function () {
        

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/activateCompaigns",
                    type: "POST",
                    data: {val:$(this).attr('row-id')},
                    dataType: 'json',
                    success: function (response)
                    {
                            
                             window.location = "<?php echo base_url(); ?>/index.php?/superadmin/compaigns/"+<?php echo $status;?>;
                    }
                });
                   

        });
        
        $(document).on('click','.deactive',function () {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deactivecompaigns",
                        type: "POST",
                        data: {val: $(this).attr('row-id')},
                        dataType: 'json',
                        success: function (response)
                        {
                             window.location = "<?php echo base_url(); ?>/index.php?/superadmin/compaigns/"+<?php echo $status;?>;
                        }

                    });
        });


        $(document).on('click','.referralEdit',function () {

            $(".errors").text("");
            $("#record-id").val($(this).attr('row-id'));
            
             $("#nofirst").prop('checked',true);
                
                $('#myModalsfirstedit').modal('show');
                
                  $('#yesreferralfirst').removeAttr('checked');
                $('#noreferralfirst').removeAttr('checked');
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/editcompaigns",
                    type: "POST",
                    data: {val: $(this).attr('row-id')},
                    dataType: 'json',
                    success: function (row)
                    {
//                            alert(JSON.stringify(response));

//                        $.each(response, function (index, row) {
                        $('#titlefirst').val(row.title);
                        $('#selectcityfirst').val(row.city_id);
                        var dis = row.discount_type;
                        if (dis == 1)
                            $("#yesfirst").attr('checked', 'checked');
//                                      
                        else if (dis == 2)
                            $("#nofirst").attr('checked', 'checked');
//                                  
                        $('#discountfirst').val(row.discount);
                        var refferal = row.referral_discount_type;

                        if (refferal == 1)
                            $("#yesreferralfirst").attr('checked', 'checked');
                        else if (refferal == 2)
                            $("#noreferralfirst").attr('checked', 'checked');
                        $('#referaldiscountfirst').val(row.referral_discount);
                        $('#messagefirst').val(row.message);
//                        });

                    }
                });
        });




        $(document).on('click','.compaignEdit',function () {
        
        compaignEditId = $(this).attr('row-id');

            $(".errors").text("");
          
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/editcompaigns",
                    type: "POST",
                    data: {val: $(this).attr('row-id')},
                    dataType: 'json',
                    success: function (row)
                    {
//                        alert(JSON.stringify(response));

//                        $.each(response, function (index, row) {
                        $('#titlesecond').val(row.title);
                        $('#selectcitysecond').val(row.city_id);
                        $('#codesecond').val(row.coupon_code); 
                        $('#sdatesecond').val(moment(row.start_date *1000).format("YYYY-MM-DD"));
                        $('#edatesecond').val(moment(row.expiry_date *1000).format("YYYY-MM-DD"));
                        var dis = row.discount_type;
                        if (dis == 1)
                            $("#yessecondedit").attr('checked', 'checked');
//                                     
                        else if (dis == 2)
                            $("#nosecondedit").attr('checked', 'checked');
//                                   
                        $('#discountsecond').val(row.discount);
                        $('#messagesecond').val(row.message);
//                        });
                    }

                });


                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#compaignEdit');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#compaignEdit').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }


            

        });
        
        

        $('.changeMode').click(function () {
             var tab_id = $(this).attr('data-id');
            
            if(currentTab != tab_id)
            {
               currentTab = tab_id;
                location.href =  $(this).attr('data');
            }
        });




        $("#inserts").click(function () {

            $('.errors').text('');

            var city = $("#selectcitys").val();


            var discount = $("#discounts").val();
            var message = $("#messages").val();
            var code = $("#code").val();
            var sdate = $("#sdate").val();
            var edate = $("#edate").val();
            var title = $("#title1").val();

            var alphabit = /^[a-zA-Z ]*$/;
            var alphanumeric = /[a-zA-Z0-9\-\_]$/;
            var reg = /^[0-9]+$/;     //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;
            var discounttypes = $('.discount_types:checked').val();


            if (title == '') {
                $('#compaign_titleErr').text(<?php echo json_encode(POPUP_COMPAIGNS_TITLE); ?>);
            }
            else if (city == "0")
            {
                //   alert("please select city");
                $('#compaign_CityErr').text(<?php echo json_encode(POPUP_DISPATCHERS_CITY); ?>);
            }
            else if (code == "" || code == null)
            {
                //     alert("please enter the code");
                $('#compaign_CodeErr').text(<?php echo json_encode(POPUP_COMPAIGNS_CODE); ?>);
            }
            else if (!alphanumeric.test(code))
            {
                //  alert("please enter code as text or number");
                $('#compaign_CodeErr').text(<?php echo json_encode(POPUP_COMPAIGNS_TEXTNUMBER); ?>);
            }

            else if (sdate == "" || sdate == null)
            {
                //    alert("please select  the start date");
                $('#compaign_stDateErr').text(<?php echo json_encode(POPUP_COMPAIGNS_STARTDATE); ?>);
            }
            else if (edate == "" || edate == null)
            {
                //      alert("please select  the expire date");
                $('#compaign_endDateErr').text(<?php echo json_encode(POPUP_COMPAIGNS_EXPIREDATE); ?>);
            }



            else if (discount == "" || discount == null)
            {
                //      alert("please enter the discount");
                $('#compaign_DiscountErr').text(<?php echo json_encode(POPUP_COMPAIGNS_PROMOTION); ?>);
            }
//            else if (!reg.test(discount))
//            {
//                //     alert("please enter  numbers only");
//                $('#errorbox_myModals').text(<?php echo json_encode(POPUP_COMPAIGNS_NUMBERS); ?>);
//            }

            else if (message == "" || message == null)
            {
                //       alert("please enter the message");
                $('#compaign_MsgErr').text(<?php echo json_encode(POPUP_COMPAIGNS_MESSAGE); ?>);
            }

            else
            {
                $('.close').trigger('click');


                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/insertcompaigns",
                    type: 'POST',
                    data: {
                        coupon_type: 2,
                        citys: city,
                        discounts: discount,
                        messages: message,
                        codes: code,
                        sdate: sdate,
                        edate: edate,
                        discounttypes: discounttypes,
                        title: title

                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.flag == 0) {

                            var size = $('input[name=stickup_toggler]:checked').val()
                            var modalElem = $('#confirmmodelss');
                            if (size == "mini")
                            {
                                $('#modalStickUpSmall').modal('show')
                            }
                            else
                            {
                                $('#confirmmodelss').modal('show')
                                if (size == "default") {
                                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                                }
                                else if (size == "full") {
                                    modalElem.children('.modal-dialog').addClass('modal-lg');
                                }
                            }
                            $("#errorboxdatass").text(<?php echo json_encode(POPUP_COMPAIGNS_TEXT_PROMOTIONS_S); ?>);
                            $("#confirmedss").click(function () {
                                window.location = "<?php echo base_url(); ?>/index.php?/superadmin/compaigns/2";
                            });


                        }

                        else if (response.flag == 1) {

                            var size = $('input[name=stickup_toggler]:checked').val()
                            var modalElem = $('#confirmmodelss');
                            if (size == "mini")
                            {
                                $('#modalStickUpSmall').modal('show')
                            }
                            else
                            {
                                $('#confirmmodelss').modal('show')
                                if (size == "default") {
                                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                                }
                                else if (size == "full") {
                                    modalElem.children('.modal-dialog').addClass('modal-lg');
                                }
                            }
                            $("#errorboxdatass").text(response.msg);
                            $("#confirmedss").click(function () {
                                window.location = "<?php echo base_url(); ?>/index.php?/superadmin/compaigns/2";
                            });
                        }
                    }

                });
            }

        });

        $("#compaignUpdate").click(function () {

            $('.errors').text('');

            var val = $(this).val();
            var discount = $("#discountsecond").val();
            var message = $("#messagesecond").val();
            var code = $("#codesecond").val();
            var sdate = $("#sdatesecond").val();
            var edate = $("#edatesecond").val();
            var title = $("#titlesecond").val();

            var alphabit = /^[a-zA-Z ]*$/;
            var alphanumeric = /[a-zA-Z0-9\-\_]$/;
            var reg = /^[0-9]+$/;     //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;
            var discounttypes = $('.discounttypesecondedit:checked').val();


            if (title == '') {
                $('#compaign_e_titleErr').text(<?php echo json_encode(POPUP_COMPAIGNS_TITLE); ?>);
            }

            else if (code == "" || code == null)
            {
                //     alert("please enter the code");
                $('#compaign_e_codeErr').text(<?php echo json_encode(POPUP_COMPAIGNS_CODE); ?>);
            }
            else if (!alphanumeric.test(code))
            {
                //  alert("please enter code as text or number");
                $('#compaign_e_codeErr').text(<?php echo json_encode(POPUP_COMPAIGNS_TEXTNUMBER); ?>);
            }

            else if (sdate == "" || sdate == null)
            {
                //    alert("please select  the start date");
                $('#compaign_e_stDateErr').text(<?php echo json_encode(POPUP_COMPAIGNS_STARTDATE); ?>);
            }
            else if (edate == "" || edate == null)
            {
                //      alert("please select  the expire date");
                $('#compaign_e_endDateErr').text(<?php echo json_encode(POPUP_COMPAIGNS_EXPIREDATE); ?>);
            }
            else if (discount == "" || discount == null)
            {
                //      alert("please enter the discount");
                $('#compaign_e_discountErr').text(<?php echo json_encode(POPUP_COMPAIGNS_PROMOTION); ?>);
            }
//            else if (!reg.test(discount))
//            {
//                //     alert("please enter  numbers only");
//                $('#errorbox_myModals').text(<?php echo json_encode(POPUP_COMPAIGNS_NUMBERS); ?>);
//            }

            else if (message == "" || message == null)
            {
                //       alert("please enter the message");
                $('#compaign_e_msgErr').text(<?php echo json_encode(POPUP_COMPAIGNS_MESSAGE); ?>);
            }

            else
            {
                $('.close').trigger('click');


                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/updatecompaigns",
                    type: 'POST',
                    data: {
                        coupon_type: 2,
                        val2:compaignEditId,
                        discounts: discount,
                        messages: message,
                        codes: code,
                        sdate: sdate,
                        edate: edate,
                        discounttypes: discounttypes,
                        title: title

                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                         location.href =  "<?php echo base_url(); ?>/index.php?/superadmin/compaigns/2";
                        
                    }

                });
            }

        });

        $('#selectOPT').change(function () {


            if ($(this).val() == 0) {
                $('#deactive').show();
                $('#secondadd').show();
            }
            else if ($(this).val() == 10) {

                $('#secondadd').hide();
                $('#deactive').hide();

            }
            else if ($(this).val() == 1) {
                $('#deactive').hide();


            }
            
            var selectedAction = $(this).val();

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/compaigns_ajax/<?php echo $status ?>",
                                type: 'POST',
                                data: {value: $(this).val()},
                                dataType: 'JSON',
                                success: function (response)
                                {
                                    var table = $('#big_table1').DataTable();
                                    table.clear().draw();
                                    
                                    var t = $('#big_table2').DataTable();
                                    t.clear().draw();
                                    
                                    var t3 = $('#big_table3').DataTable();
                                    t3.clear().draw();
                                    if(response.data)
                                    {
                                        if(response.data[0].coupon_type == 1)
                                        {

    //                                    
                                            $.each(response.data, function (index, row) {
                                                var disc = '--';
                                                var other = '--';
                                                var referr = '--';
                                                var others = '--';
                                                if (row.discount_type == 1) {
                                                    disc = row.discount;

                                                }
                                                else if (row.discount_type == 2) {
                                                    other = row.discount;
                                                }

                                                if (row.referral_discount_type == 1) {
                                                    referr = row.referral_discount;
                                                }
                                                else if (row.referral_discount_type == 2) {
                                                    others = row.referral_discount;
                                                }

                                                if(row.status == 0)
                                                {
                                                table.row.add([

                                                    row.title,
                                                    disc,
                                                    other,
                                                    referr,
                                                    others,
                                                    row.city_name,
                                                    row.currency,
                                                    '<button class="btn btn-info btn-cons referralEdit"  row-id="'+ row._id.$id +'">Edit </button><br> <button class="btn btn-warning btn-cons deactive" row-id="'+ row._id.$id +'">Deactivate</button><br><a href="<?php echo base_url(); ?>index.php?/superadmin/referral_details/' + row._id.$id + '">\n\
                                        <button class="btn btn-success btn-cons" style="background-color:lightcoral;border:1px;">Details</button></a>'
        //                                            
                                                ]).draw();
                                                }
                                                else{
                                                 table.row.add([

                                                    row.title,
                                                    disc,
                                                    other,
                                                    referr,
                                                    others,
                                                    row.city_name,
                                                    row.currency,
                                                    '<button class="btn btn-info btn-cons referralEdit"  row-id="'+ row._id.$id +'">Edit </button><br><button class="btn btn-success btn-cons Activate"  row-id="'+ row._id.$id +'">Activate</button><br><a href="<?php echo base_url(); ?>index.php?/superadmin/referral_details/' + row._id.$id + '">\n\
                                        <button class="btn btn-success btn-cons" style="background-color:lightcoral;border:1px;">Details</button></a>'
        //                                            
                                                ]).draw();

                                                }

                                            });
                                        }
                                        else if(response.data[0].coupon_type == 2)
                                        {

                                        $.each(response.data, function (index, row) {
                                            var disc = '--';
                                            var other = '--';
    //                                        var referr= '--';
    //                                        var others = '--';
                                            if (row.discount_type == 1) {
                                                disc = row.discount;

                                            }
                                            else if (row.discount_type == 2) {
                                                other = row.discount;
                                            }
                                            console.log('Status'+row.status);

                                                var st_date = moment(row.start_date * 1000).format("YYYY-MM-DD");
                                            var end_date =moment(row.expiry_date * 1000).format("YYYY-MM-DD");

                                            if(selectedAction == 0)
                                            {

                                                    if(row.status == 0)
                                                        {

                                                            t.row.add([

                                                                row.coupon_code,
                                                                row.title,
                                                               st_date,
                                                                end_date,
                                                                disc,
                                                                other,
                                                                row.city_name,
                                                                row.currency,
                                                               '<button class="btn btn-info btn-cons compaignEdit"  row-id="'+ row._id.$id +'">Edit </button><br><button class="btn btn-warning btn-cons deactive" row-id="'+ row._id.$id + '">Deactivate</button><br><a href="<?php echo base_url(); ?>index.php?/superadmin/promo_details/' + row._id.$id + '">\n\
                                                    <button class="btn btn-success btn-cons" style="background-color:lightcoral;border:1px;">Details</button></a>'
                    ////                                            
                                                            ]).draw();

                                                        }
                                                        else
                                                        {
                                                            t.row.add([

                                                                row.coupon_code,
                                                                row.title,
                                                                st_date,
                                                                end_date,
                                                                disc,
                                                                other,
                                                                row.city_name,
                                                                row.currency,
                                                               '<button class="btn btn-info btn-cons compaignEdit"  row-id="'+ row._id.$id +'">Edit </button><br><button class="btn btn-success btn-cons Activate" row-id="'+ row._id.$id + '">Activate</button><br><a href="<?php echo base_url(); ?>index.php?/superadmin/promo_details/' + row._id.$id + '">\n\
                                                    <button class="btn btn-success btn-cons" style="background-color:lightcoral;border:1px;">Details</button></a>'
                    ////                                            
                                                            ]).draw();

                                                    }

                                                }
                                                else{
                                                     t.row.add([

                                                                row.coupon_code,
                                                                row.title,
                                                               st_date,
                                                                end_date,
                                                                disc,
                                                                other,
                                                                row.city_name,
                                                                row.currency,
                                                               '<a href="<?php echo base_url(); ?>index.php?/superadmin/promo_details/' + row._id.$id + '">\n\
                                                    <button class="btn btn-success btn-cons" style="background-color:lightcoral;border:1px;">Details</button></a>'
                    ////                                            
                                                            ]).draw();
                                                }
                                          });

                                        }
                                        else if(response.data[0].coupon_type == 3)
                                        {
                                            
                                            $.each(response.data, function (index, row) {
                                            t3.row.add([
                                                row.user_id,
                                                row.email,
                                                row.coupon_code,
                                                row.discount,
                                                moment(row.expiry_date *1000).format("DD-MM-YYYY"),

                                                '-',
                                               '-'

                                            ]).draw();
                                            
                                              });
                                        }
                                        
                                    }
                                }

                            });

                        });

});

</script>

<style>
    .exportOptions{
        display: none;
    }

    .datepicker{z-index:1151 !important;}
</style>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
         
            <strong>CAMPAIGNS</strong>
        </div>
        <!-- START JUMBOTRON -->
                <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">

                    <!-- Nav tabs -->

                    <div>
                        <ul class="nav nav-tabs nav-tabs-fillup  bg-white">
                            <li class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>">
                                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/compaigns/1" data-id="1"><span><?php echo LIST_REFERRALS; ?></span></a>
                            </li>
                            <li class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>">
                                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/compaigns/2" data-id="2"><span><?php echo LIST_PROMOTIONS; ?> </span></a>
                            </li>
                            <li class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>">
                                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/compaigns/3" data-id="3"><span><?php echo LIST_REFFERED_PROMOS; ?> </span></a>
                            </li>

                           
                            <?php if ($status == 1) { ?>
                               

                            <div class="pull-right m-t-10" style="margin-right: 2%;margin-top: 1%;"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler" ><?php echo BUTTON_ADD; ?></button></div>
                            <?php } ?>

                            <?php if ($status == 2) { ?>
                                <!--<div class="pull-right m-t-10 " > <button class="btn btn-info btn-cons " id="secondedit" ><?php echo BUTTON_EDIT; ?></button></div>-->

                                <div class="pull-right m-t-10" > <button class="btn btn-primary btn-cons" id="secondadd" ><?php echo BUTTON_ADD; ?></button></div>
                            <?php } ?> 

                        </ul>


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
                                    
                                    <div class="pull-left">
                                        <select class="form-control col-md-3" id="selectOPT" style="background-color:gainsboro;height:30px;font-size:11px;display: none;">

                                            <?php if ($status == 1) { ?>
                                                <option value="0" id="act">ACTIVE</option>
                                                <option value="1" id="inact">INACTIVE</option>
                                            <?php } else if ($status == 3) { ?>
                                                <option value="31" id='expire'> USED</option>
                                                <option value="32" id='expire'> UNUSED</option>
                                                <option value="33" id='expire'> EXPIRED</option>
                                            <?php } else { ?>
                                                <option value="0" id="act">ACTIVE</option>
                                                <option value="10" id='expire'> EXPIRED</option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?> "> </div>
                              
                                        
                                </div>
                                 <div class="panel-body" style="margin-top: 2%;">
                                    <?php if ($status == 1) { ?>    
                            
                                     <div id="tableWithSearch_wrapper1" class="dataTables_wrapper no-footer" >
                                          <div class="table-responsive" style="overflow-x:hidden;">
                                              <table id="big_table1" border="1"  class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="big_table_info" style="display:none;">
                                                <thead>
                                                      <tr style= "font-size:10px"role="row">
                                                            
                                                             <th rowspan="2"class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">TITLE</th>
                                                             <th colspan="2" class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"> NEW USER <?php echo COMPAIGNS_TABLEL_DISCOUNT; ?></th>
                                                             <th colspan="2" class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"> REFERRAL BONUS</th>
   
                                                             <th rowspan="2" class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" ><?php echo COMPAIGNS_TABLE_CITY; ?></th>
                                                             <th rowspan="2" class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo COMPAIGNS_TABLE_CURRENCY; ?></th>
                                                             <th rowspan="2" class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 210px;">ACTIONS</th>
                                                        </tr>

                                                        <tr style= "font-size:10px"role="row">

                                                            <th class="discountpercent" style="width:100px;"> PERCENT (%)</th>
                                                            <th  class="discountfixed" style="width:100px;">  FIXED  </th>
                                                            <th  class="referralpercent" style="width:100px;"> PERCENT (%)</th>
                                                            <th  class="referralfixed" style="width:100px;">  FIXED  </th>

                                                        </tr>


                                                    </thead>
                                                    <tbody>


                                                        <?php
                                                        $i = '1';
                                                        foreach ($compaign as $result) {
                                                            ?>


                                                          <tr style= "font-size:10px"role="row">
                                                                <!--<td id = "" class="v-align-middle "><?php echo (string) $result['_id']; ?></td>-->
                                                                <td id = "" class="v-align-middle "> <p><?php echo $result['title']; ?></p></td>
                                                                <td id = "" class="v-align-middle "> <p><?php echo ($result['discount_type'] == 1 ? ($result['discount']) : '--'); ?></p></td>
                                                                <td id = "" class="v-align-middle "> <p><?php echo ($result['discount_type'] == 2 ? ($result['discount']) : '--'); ?></p></td>
                                                                <td id = "" class="v-align-middle "> <p><?php echo ($result['referral_discount_type'] == 1 ? ($result['referral_discount']) : '--'); ?></p></td>
                                                                <td id = "" class="v-align-middle "> <p><?php echo ($result['referral_discount_type'] == 2 ? ($result['referral_discount']) : '--'); ?></p></td>
                                                
                                                                <td class="v-align-middle"> <?php echo $result['city_name']; ?> </td>
                                                                <td class="v-align-middle"> <?php echo $result['currency']; ?> </td>



                                                                <td class="v-align-middle">
                                                                     <button class="btn btn-info btn-cons referralEdit"  row-id="<?php echo $result['_id'];?>">Edit </button><br>
                                                                    
                                                                   <button class="btn btn-warning btn-cons deactive" row-id="<?php echo $result['_id'];?>">Deactivate</button><br>
                                                                     
                                                                    
                                                                    <a  href="<?php echo base_url(); ?>index.php?/superadmin/referral_details/<?php echo (string) $result['_id']; ?>">
                                                                        <button class="btn btn-success btn-cons" style="background-color:lightcoral;border:1px;" value="<?php echo (string) $result['_id']; ?>">Details</button></a>
                                                                   
                                                               </td>

                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        //                                            
                                                        ?>
                                                    </tbody>
                                                </table>

                                            <?php } ?>

                                        </div>
                                        </div>
                                  

                                        <?php if ($status == 2) { ?>                               
                                            
                                        <div id="tableWithSearch_wrapper2" class="dataTables_wrapper no-footer" style="margin-top: -1%;">
                                          <div class="table-responsive" style="overflow-x:hidden;">
                                              <table id="big_table2" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="big_table_info" style="width:98%;margin-left: 1.2%;">
                                                <thead>

                                                                  <tr style= "font-size:10px"role="row">
                                                                    <!--<th  rowspan="2" class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"> PROMOTION ID</th>-->
                                                                    <th  rowspan="2" class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending"> <?php echo COMPAIGNS_TABLE_CODE; ?></th>
                                                                    <th rowspan="2"  class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" > TITLE</th>
                                                                    <th rowspan="2"  class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" ><?php echo COMPAIGNS_TABLE_STARTDATE; ?></th>

                                                                    <th rowspan="2"  class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo COMPAIGNS_TABLE_ENDDATE; ?></th>
                                                                    <th  colspan="2" class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"> PROMOTION <?php echo COMPAIGNS_TABLE_DISCOUNT; ?></th>
    <!--                                                                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:15px">--><?php //echo COMPAIGNS_TABLE_MESSAGE;                ?><!--</th>-->
                                                                    <th rowspan="2"  class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" ><?php echo COMPAIGNS_TABLE_PROMOT_CITY; ?></th>
                                                                    <th rowspan="2"  class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo COMPAIGNS_TABLE_CURRENCY; ?></th>
                                                                    <th rowspan="2"  class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" >ACTIONS</th>


                                                                </tr>

                                                                <tr>

                                                                    <th width="100px" > PERCENT (%)</th>
                                                                    <th width="100px">  FIXED </th>
                                                                </tr>

                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                $i = '1';
                                                                foreach ($compaign as $result) {
                                                                    ?>

                                                                      <tr style= "font-size:10px"role="row">
                                                                        <!--<td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo (string) $result['_id']; ?></p></td>-->
                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result['coupon_code']; ?></p></td>
                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result['title']; ?></p></td>
                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo date('Y-m-d', $result['start_date'])?></p></td>
                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo date('Y-m-d', $result['expiry_date']); ?></p></td>
                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo ($result['discount_type'] == 1 ? ($result['discount']) : '--'); ?></p></td>
                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo ($result['discount_type'] == 2 ? ($result['discount']) : '--'); ?></p></td>
                                        
                                                                        <td class="v-align-middle"> <?php echo $result['city_name']; ?> </td>
                                                                        <td class="v-align-middle"> <?php echo $result['currency']; ?> </td>



                                                                        <td class="v-align-middle">
                                                                            <button class="btn btn-info btn-cons compaignEdit"  row-id="<?php echo $result['_id'];?>">Edit </button><br>
                                                                            
                                                                            <?php
                                                                            if( $result['status'] == 0)
                                                                                {
                                                                            ?>
                                                                                <button class="btn btn-warning btn-cons deactive" row-id="<?php echo $result['_id'];?>">Deactivate</button><br>
                                                                              <?php
                                                                            }
                                                                            else
                                                                                {
                                                                                ?>
                                                                                 <button class="btn btn-success btn-cons Activate" row-id="<?php echo $result['_id'];?>">Activate</button><br>
                                                                            <?php
                                                                            
                                                                                }
                                                                            ?>   
                                                                             
                                                                            <a  href="<?php echo base_url(); ?>index.php?/superadmin/promo_details/<?php echo (string) $result['_id']; ?>">
                                                                                <button class="btn btn-success btn-cons" style="background-color:lightcoral;border:1px;" value="<?php echo (string) $result['_id']; ?>">Details</button></a>
                                                                            
                                                                        </td>

                                                                    </tr>

                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?> 


                                                            </tbody>
                                                        </table>
                                                </div>
                                        </div>
                                       
                                                    <?php } ?>


                                                    <?php if ($status == 3) { ?> 
                               
                                                <div id="tableWithSearch_wrapper3" class="dataTables_wrapper no-footer" style="margin-top: -1%;">
                                                        <div class="table-responsive" style="overflow-x:hidden;">
                                                            <table id="big_table3" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="big_table_info" style="width:98%;margin-left: 1.2%;">
                                                              <thead>
                                                       

                                        <tr>                                   
                                            <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 100px;">
                                                CUSTOMER ID</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                               CUSTOMER EMAIL</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                               PROMO CODE</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                               DISCOUNT</th>

                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                                EXPIRY DATE</th>
                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                                BOOKING ID</th>
                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                                INVOICE VALUE</th>
                                           
                                        </tr>



                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($compaign as $data) 
                                                                            { ?>
                                                                             <tr role="row"  class="gradeA odd">
                                                                                <td id = "d_no" class="v-align-middle sorting_1 "><?php echo $data['user_id']; ?> </td>
                                                                                <td id = "d_no" class="v-align-middle sorting_1 "> <?php echo $data['email']; ?></td>
                                                                                <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $data['coupon_code']; ?></p></td>
                                                                                <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php
                                                                                        echo $data['discount'];
                                                                                        echo ($data['discount_type'] == '2' ? "" : "%");
                                                                                        ?></p></td>
                                                                                <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo date('Y-m-d', $data['expiry_date']); ?></p></td>
                                                                                <?php
                                                                                $flag = 1;
                                                                                foreach ($data['bookings'] as $booking) {
                                                                                    if ($booking['status'] == '2') {
                                                                                        $flag = 0;
                                                                                        ?>
                                                                                        <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $booking['booking_id']; ?></p></td>
                                                                                        <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo $booking['sub_total']; ?></p></td>
                                                                                    <?php }
                                                                                } if($flag == 1){
                                                                                    ?>
                                                                                        
                                                                                <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo "-"; ?></p></td>
                                                                                <td id = "d_no" class="v-align-middle sorting_1 "> <p><?php echo "-"; ?></p></td>
                                                                                        <?php
                                                                                }
?>


                                                                            </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                           

                                                            </div>
                                                    </div>
                                                   
                                     <?php } ?>
                                               
                                                <!-- END PANEL -->

                                            </div>
                                            </div>
                                        
                                    </div>
                                </div>


                            </div>
            
                        </div>
                        <!-- END PAGE CONTENT -->
                        <!-- START FOOTER -->
                        <div class="container-fluid container-fixed-lg footer">
                            <div class="copyright sm-text-center">
                                <p class="small no-margin pull-left sm-pull-reset">
                                    <span class="hint-text"></span>

                                </p>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- END FOOTER -->
                    </div>
                  </div>
                </div>
    


                    <div class="modal fade stick-up" id="addCompainref" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-body">

                                    <div class="modal-header">

                                        <span class="modal-title">ADD</span>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>                  

                                    <div class="modal-body">
                                         <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_TITLE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="title" name="title" class="form-control" placeholder="Title">
                                            </div>
                                             <div class="col-sm-3 errors" id="referralTitle_Err"></div>
                                        </div>

                                      
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label" id=""><?php echo FIELD_VEHICLE_SELECTCITY; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">

                                                <select id="selectcity" name="city_select"  class="form-control">
                                                    <option value="0">Select city</option>
                                                    <?php
                                                    foreach ($city as $result) {

                                                        echo "<option value=" . $result->City_Id . ">" . $result->City_Name . "</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                             <div class="col-sm-3 errors" id="referralCity_Err"></div>
                                        </div>
                                      
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label" ><?php echo FIELD_COMPAIGNS_DISCOUNTTYPE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-3">
                                                <div class="radio radio-success" >
                                                      <label for="yes">
                                                    <input type="radio" value="1" name="optionyes1" class="optionyes1" id="yes">
                                                  <?php echo FIELD_COMPAIGNS_PERCENTAGE; ?></label>
                                                   
                                                </div>
                                            </div>
                                              <div class="col-sm-3">
                                                  <div class="radio radio-success" >
                                                      <label for="no">
                                                       <input type="radio"  value="2"  checked="checked" name="optionyes1" class="optionyes1"  id="no" class="formex">
                                                    <?php echo FIELD_COMPAIGNS_FIXED; ?></label>
                                                  </div>
                                              </div>
                                               
                                        </div>
                                        
                                        

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_COMPAIGNS_DISCOUNT; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="discount" name="latitude"  class="form-control" placeholder="" onkeypress="return isNumberKey(event)">
                                            </div>
                                            <div class="col-sm-3 errors" id="referralNewUserDiscount_Err"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_REFERRALDISCOUNTTYPE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-3">
                                                <div class="radio radio-success" class="formex">
                                                     <label for="yes1">
                                                    <input type="radio" value="1" name="optionyes" class="optionyes" id="yes1">
                                                   <?php echo FIELD_COMPAIGNS_PERCENTAGE; ?></label>
                                                    
                                                </div>
                                            </div>
                                             <div class="col-sm-3">
                                                 <div class="radio radio-success" class="formex">
                                                      <label for="no1">
                                                     <input type="radio" checked="checked" value="2" name="optionyes"  class="optionyes" id="no1" >
                                                   <?php echo FIELD_COMPAIGNS_FIXED; ?></label>
                                                 </div>
                                                 </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_REFERRALDISCOUNT; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="referaldiscount" name="longitude" class="form-control" placeholder="" onkeypress="return isNumberKey(event)">
                                            </div>
                                            <div class="col-sm-3 errors" id="referralBonusType_Err"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_MESSAGE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <textarea  id="message"  class="form-control" placeholder=""></textarea>
                                            </div>
                                              <div class="col-sm-3 errors" id="referralMsg_Err"></div>
                                        </div>
                                         </form>
                                        </div>
                                    
                                    
                                        <div class="modal-footer">
                                            <div class="col-sm-4 error-box" id=""></div>
                                            <div class="col-sm-8">
                                                <div class="pull-right m-t-10"><button type="button" class="btn btn-primary pull-right" id="insert" >Add</button></div>
                                                 <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                 
                    <div class="modal fade stick-up" id="myModalsfirstedit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                 <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                                    <div class="modal-header">

                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <span class="modal-title">EDIT REFERRAL</span>
                                      
                                    </div>

                              
                                    <div class="modal-body">
                                         
                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_TITLE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="titlefirst" name="title" class="form-control" placeholder="Title" value="">
                                            </div>
                                            <div class="col-sm-3 errors" id="referral_e_title"></div>
                                        </div>
                                     

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label" id=""><?php echo FIELD_VEHICLE_SELECTCITY; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">

                                                <select id="selectcityfirst" name="city_select"  class="form-control" disabled="disabled" value="">
                                                    <option value="0">Select city</option>
                                                    <?php
                                                    foreach ($city as $result) {

                                                        echo "<option value=" . $result->City_Id . ">" . $result->City_Name . "</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                             <div class="col-sm-3 errors" id="referral_e_city"></div>
                                        </div>

                                         <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label" ><?php echo FIELD_COMPAIGNS_DISCOUNTTYPE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-3">
                                                <div class="radio radio-success" >
                                                      <label for="yes">
                                                    <input type="radio" value="1" name="optionyesfirst" class="optionyesfirst" id="yesfirst">
                                                  <?php echo FIELD_COMPAIGNS_PERCENTAGE; ?></label>
                                                   
                                                </div>
                                            </div>
                                             <div class="col-sm-3">
                                                 <div class="radio radio-success" >
                                                      <label for="no">
                                                    <input type="radio"  value="2" name="optionyesfirst" class="optionyesfirst"  id="nofirst" class="formex">
                                                    <?php echo FIELD_COMPAIGNS_FIXED; ?></label>
                                                 </div></div>
                                        </div>


                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_COMPAIGNS_DISCOUNT; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="discountfirst" name="latitude"  class="form-control" value="" onkeypress="return isNumberKey(event)">
                                            </div>
                                             <div class="col-sm-3 errors" id="referral_e_discount"></div>
                                        </div>

                                         <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_REFERRALDISCOUNTTYPE; ?><span style="color:red;font-size: 18px">*</span></label>
                                            <div class="col-sm-3">
                                                <div class="radio radio-success" class="formex">
                                                     <label for="yes1"><input type="radio" value="1" name="optionyesfirstreferal" class="optionyesfirstreferal" id="yesreferralfirst">
                                                   <?php echo FIELD_COMPAIGNS_PERCENTAGE; ?></label>
                                                    
                                                </div>
                                            </div>
                                             <div class="col-sm-3">
                                                 <div class="radio radio-success" class="formex">
                                                      <label for="no1">
                                                    <input type="radio"  value="2" name="optionyesfirstreferal" checked="checked" class="optionyesfirstreferal" id="noreferralfirst" >
                                                   <?php echo FIELD_COMPAIGNS_FIXED; ?></label>
                                                 </div>
                                             </div>
                                        </div>

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_REFERRALDISCOUNT; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="referaldiscountfirst" name="longitude" class="form-control" placeholder="" onkeypress="return isNumberKey(event)">
                                            </div>
                                             <div class="col-sm-3 errors" id="referral_e_referral_discount"></div>
                                        </div>

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_MESSAGE; ?></label>
                                            <div class="col-sm-6">
                                                <textarea id="messagefirst" class="form-control" placeholder="Text the message"></textarea>

                                            </div>
                                             <div class="col-sm-3 errors" id="referral_e_msg"></div>
                                        </div>
                                       
                                    </div>
                                 <div class="modal-footer">
                                            <div class="col-sm-4 error-box" id="errorBox_myModalfirst"></div>
                                            <div class="col-sm-8" >
                                                <div class="pull-right m-t-10"><button type="button" class="btn btn-success pull-right" id="firsteditsubmit" ><?php echo BUTTON_SUBMIT; ?></button></div>
                                                 <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons">Cancel</button></div>
                                            </div>
                                        </div>
                                         
                                </form>
                                <!-- /.modal-content -->
                            </div>
                                    
                            <!-- /.modal-dialog -->
                        </div>

                    </div>





                    <div class="modal fade stick-up" id="myModals" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-body">

                                    <div class="modal-header">

                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <span class="modal-title">ADD</span>
                                    </div>


                                    <div class="modal-body">
                                         <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_TITLE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="title1" name="title1" class="form-control" placeholder="Title">
                                            </div>
                                             <div class="col-sm-3 errors" id="compaign_titleErr"></div>
                                        </div>

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label" id=""><?php echo POPUP_DISPATCHERS_CITY; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <select id="selectcitys" name="city_select"  class="form-control">
                                                    <option value="0">Select city</option>
                                                    <?php
                                                    foreach ($city as $result) {

                                                        echo "<option value=" . $result->City_Id . ">" . $result->City_Name . "</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                             <div class="col-sm-3 errors" id="compaign_CityErr"></div>
                                        </div>
>

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_CODE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="code" name="longitude" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-sm-3 errors" id="compaign_CodeErr"></div>
                                        </div>


                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label" id="strdate"><?php echo FIELD_COMPAIGNS_STARTDATE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <div  class="input-group date ">
                                                    <input type="text" class="form-control datepicker-component"  id="sdate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 errors" id="compaign_stDateErr"></div>
                                        </div>


                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_EXPIREDATE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <div  class="input-group date">
                                                    <input type="text" class="form-control datepicker-component" id="edate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                             <div class="col-sm-3 errors" id="compaign_endDateErr"></div>
                                        </div>


                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label" id="discounttype"><?php echo FIELD_COMPAIGNS_DISCOUNTTYPE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-3">
                                                <div class="radio radio-success" >
                                                     <label for="yes2"><input type="radio" value="1" name="discount_types" class="discount_types" id="yes2" >
                                                   <?php echo FIELD_COMPAIGNS_PERCENTAGE; ?></label>
                                                   
                                                </div>
                                            </div>
                                             <div class="col-sm-3">
                                                 <div class="radio radio-success" >
                                                       <label for="no2"><input type="radio" checked="checked" value="2" name="discount_types" class="discount_types" id="no2" class="formex" >
                                                   <?php echo FIELD_COMPAIGNS_FIXED; ?></label>
                                                 </div>
                                                 </div>
                                             <div class="col-sm-3 errors" id="compaign_DiscountTypeErr"></div>
                                        </div>


                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_PROMOTION_DISCOUNT; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="discounts" name="discount"  class="form-control" placeholder="" onkeypress="return isNumberKey(event)">
                                            </div>
                                             <div class="col-sm-3 errors" id="compaign_DiscountErr"></div>
                                        </div>


                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_MESSAGE; ?></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="messages" name="message" class="form-control" placeholder="">
                                            </div>
                                             <div class="col-sm-3 errors" id="compaign_MsgErr"></div>
                                        </div>
                                    </form>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="col-sm-4 error-box" id="errorbox_myModals"></div>
                                            <div class="col-sm-8">
                                                  <div class="pull-right m-t-10"><button type="button" class="btn btn-primary pull-right" id="inserts" ><?php echo BUTTON_SUBMIT; ?></button></div>
                                                  <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons">Cancel</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>


                    </div>
                    <div class="modal fade stick-up" id="compaignEdit" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-body">

                                    <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <span class="modal-title">EDIT</span>
                                    </div>


                                    <div class="modal-body">
                                          <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_TITLE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="titlesecond" name="title1" class="form-control" placeholder="Title" value="">
                                            </div>
                                            <div class="col-sm-3 errors" id="compaign_e_titleErr"></div>
                                        </div>

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label" id=""><?php echo POPUP_DISPATCHERS_CITY; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">

                                                <select id="selectcitysecond" name="city_select"  class="form-control" disabled="disabled">
                                                    <option value="0">Select city</option>
                                                    <?php
                                                    foreach ($city as $result) {

                                                        echo "<option value=" . $result->City_Id . ">" . $result->City_Name . "</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-3 errors" id="compaign_e_cityErr"></div>
                                        </div>

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_CODE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="codesecond" name="longitude" class="form-control" value="">
                                            </div>
                                             <div class="col-sm-3 errors" id="compaign_e_codeErr"></div>
                                        </div>

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label" id="strdate"><?php echo FIELD_COMPAIGNS_STARTDATE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <div  class="input-group date ">
                                                    <input type="text" class="form-control datepicker-component"  id="sdatesecond" value="" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>

                                            </div>
                                             <div class="col-sm-3 errors" id="compaign_e_stDateErr"></div>
                                        </div>


                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_EXPIREDATE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <div  class="input-group date">
                                                    <input type="text" class="form-control datepicker-component" id="edatesecond" value=""><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                                <div class="col-sm-3 errors" id="compaign_e_endDateErr"></div>
                                        </div>

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label" id="discounttype"><?php echo FIELD_COMPAIGNS_DISCOUNTTYPE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-3">
                                                <div class="radio radio-success" >
                                                     <label for="yes2">
                                                    <input type="radio" value="1" name="discount_type" class="discounttypesecondedit" id="yessecondedit" >
                                                   <?php echo FIELD_COMPAIGNS_PERCENTAGE; ?></label>
                                                   
                                                </div>
                                            </div>
                                              <div class="col-sm-3">
                                                  <div class="radio radio-success">
                                                       <label for="no2">
                                                       <input type="radio" checked="checked" value="2" name="discount_type" class="discounttypesecondedit" id="nosecondedit" class="formex" >
                                                   <?php echo FIELD_COMPAIGNS_FIXED; ?></label>
                                                  </div>
                                              </div>
                                        </div>


                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_PROMOTION_DISCOUNT; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="discountsecond" name="discount"  class="form-control" value="" onkeypress="return isNumberKey(event)">
                                            </div>
                                                <div class="col-sm-3 errors" id="compaign_e_discountErr"></div>
                                        </div>

                                        <div class="form-group" class="formex">
                                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_COMPAIGNS_MESSAGE; ?></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="messagesecond" name="message" class="form-control" value="">
                                            </div>
                                             <div class="col-sm-3 errors" id="compaign_e_msgErr"></div>
                                        </div>
                                    </form>
                                        </div>
                                    
                                        <div class="modal-footer">
                                            <div class="col-sm-4 error-box" id="errorbox_myModals"></div>
                                            <div class="col-sm-8" >
                                               <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="compaignUpdate" ><?php echo BUTTON_SUBMIT; ?></button></div>
                                                 <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                                            </div>
                                          
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>


                    </div>

                    <div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <div class=" clearfix text-left">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                                        </button>

                                    </div>

                                </div>
                                <br>
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                                    </div>
                                </div>

                                <br>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-4" ></div>
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-4" >
                                            <button type="button" class="btn btn-primary pull-right" id="confirmed" ><?php echo BUTTON_YES; ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <div class="modal fade stick-up" id="confirmmodelss" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="error-box" id="errorboxdatass" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-8" >
                                            <button type="button" class="btn btn-default pull-right" id="confirmedss" >Close</button>
                                        </div>
                                    
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    
                    <input type="hidden" id="record-id" name="record-id">
