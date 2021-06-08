<!--<style>
    .page-sidebar .sidebar-menu .menu-items > li > a {
        width: 189px !important;
    }
</style>-->
<style>
    /* .nav_menu {
   background: #2A3F54 !important;
   
} */
</style>
<script>
    var compHTML;
    var url;
    var citiesHTML;
    $(document).ready(function () {

        $('#operatorType').val('<?php echo $this->session->userdata('operatorType') ?>');


        if ($('#operatorType').val() == 2)
        {
            $('#planFilter').val('');
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getOperatorsAjax",
                type: "POST",
                data: {},
                dataType: 'JSON',
                async: false,
                success: function (response)
                {
                    refreshContent(url)
                    $('#companyid').empty();
                    compHTML = '<option value="">Select</option>';
                    $.each(response.data, function (i, row)
                    {
                        compHTML += '<option value="' + row._id.$oid + '">' + row.operatorName + '</option>';

                    });

                    $('#companyid').append(compHTML);
                }
            });
            $('#companyid').val("<?php echo (string) $this->session->userdata('company_id') ?>");

            $('.showOperators').show();
        }
        if ($('#operatorType').val() == 3)
        {
            $('#planFilter').val('');
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getStores",
                type: "POST",
                data: {},
                dataType: 'JSON',
                async: false,
                success: function (response)
                {
                    refreshContent(url)
                    $('#storeId').empty();
                    compHTML = '<option value="">Select</option>';
                    $.each(response.data, function (i, row)
                    {
                        compHTML += '<option value="' + row._id.$oid + '">' + row.storeName + '</option>';

                    });

                    $('#storeId').append(compHTML);
                }
            });
            $('#storeId').val("<?php echo (string) $this->session->userdata('storeId') ?>");

            $('.showStores').show();
        }


        $('#operatorType').change(function () {
            $('#planFilter').val('');
            url = $('li.active').children("a").attr('data');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/setcity_session",
                type: "POST",
                data: {city: $('#selectedcity').val(), operatorType: $(this).val(), company: '', 'plan': ''},
                //                dataType: 'JSON',
                success: function (response)
                {
                    if ($('#operatorType').val() == 2 || $('#operatorType').val() == '2')
                    {
                        refreshContent(url);//Load datatable
                        $.ajax({
                            url: "<?php echo base_url('index.php?/superadmin') ?>/getOperatorsAjax",
                            type: "POST",
                            data: {},
                            dataType: 'JSON',
                            success: function (response)
                            {
                                $('#companyid').empty();
                                compHTML = '<option value="">Select</option>';
                                $.each(response.data, function (i, row)
                                {
                                    compHTML += '<option value="' + row._id.$oid + '">' + row.operatorName + '</option>';

                                });

                                $('#companyid').append(compHTML);

                            }
                        });

                        $('.showOperators').show();

                    } else if ($('#operatorType').val() == 3) {
                        refreshContent(url);//Load datatable
                        $.ajax({
                            url: "<?php echo base_url('index.php?/superadmin') ?>/getStores",
                            type: "POST",
                            data: {},
                            dataType: 'JSON',
                            success: function (response)
                            {
                                $('#storeId').empty();
                                compHTML = '<option value="">Select</option>';
                                $.each(response.data, function (i, row)
                                {
                                    var name = '';
                                    $.each(row.name, function (index,value)
                                    {
                                        name += value;
                                        name += ',' ;
                                    });
                                    compHTML += '<option value="' + row._id.$oid + '">' +name + '</option>';

                                });

                                $('#storeId').append(compHTML);

                            }
                        });

                        $('.showStores').show();
                    } else
                    {
                        $('.showStores').hide();
                        $('#storeId').val('0');
                        $('.showOperators').hide();
                        $('#companyid').val('0');
                        refreshContent(url);//Load datatable


                    }

                }
            });



        });


//        
        $('#companyid').change(function () {
            $('#planFilter').val('');
            url = $('li.active').children("a").attr('data');
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/setcity_session",
                type: "POST",
                dataType: 'JSON',
                data: {city: '', operatorType: $('#operatorType').val(), company: $(this).val(), 'plan': ''},
                success: function (response)
                {
                    refreshContent(url);//Load datatable
                }
            });

        });
        $('#storeId').change(function () {
            $('#planFilter').val('');
            url = $('li.active').children("a").attr('data');
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/setcity_session",
                type: "POST",
                dataType: 'JSON',
                data: {city: '', operatorType: $('#operatorType').val(), store: $(this).val(), 'plan': ''},
                success: function (response)
                {
                    refreshContent(url);//Load datatable
                }
            });

        });


        //Filter based on plan
        $('#planFilter').change(function () {
            url = $('li.tabs_active.active').children("a").attr('data');
            $('#operatorType').val('');
            $('#companyid').val('');
            $('.showOperators').hide();

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/setcity_session",
                type: "POST",
                dataType: 'JSON',
                data: {city: '', operatorType: '', company: '', 'plan': $(this).val()},
                success: function (response)
                {
                    refreshContent(url);//Load datatable
                }
            });

        });

        //Load the city initially
//        $.ajax({
//            url: "<?php echo base_url('index.php?/superadmin') ?>/getCities",
//            type: "POST",
//            dataType: 'JSON',
//            data: {},
//            success: function (response)
//            {
//                $('#cityFilter').empty();
//                citiesHTML = '<option value="">ALL</option>';
//                $.each(response.cities, function (i, row)
//                {
//                    citiesHTML += '<option value="' + row._id.$oid + '">' + row.city + '</option>';
//
//                });
//
//                $('#cityFilter').append(citiesHTML);
//            }
//        });

//        //Filter based on city
//        $('#cityFilter').change(function () {
//            $('#companyid').val('');
//            $.ajax({
//                url: "<?php echo base_url('index.php?/superadmin') ?>/setcity_session",
//                type: "POST",
//                dataType: 'JSON',
//                data: {city: $('#cityFilter').val(), company: ''},
//                success: function (response)
//                {
////                    refreshContent(url);//Load datatable
//                }
//            });
//
//            if ($('#cityFilter').val() != '')
//            {
//                 $('.showOperators').show();
//                ajaxUrl = "<?php echo base_url('index.php?/superadmin/getOperatorsAjax/') ?>"+$('#cityFilter').val();
//            } else
//            {
//                ajaxUrl = "<?php echo base_url('index.php?/superadmin/getOperatorsAjax') ?>";
//                $('.showOperators').hide();
//            }
//            
//                //Load the operators by selected city
//                $.ajax({
//                    url:ajaxUrl,
//                    type: "POST",
//                    data: {},
//                    dataType: 'JSON',
//                    async: false,
//                    success: function (response)
//                    {
////                        refreshContent(url)
//                        $('#companyid').empty();
//                        compHTML = '<option value="">Select</option>';
//                        $.each(response.data, function (i, row)
//                        {
//                            compHTML += '<option value="' + row._id.$oid + '">' + row.operatorName + '</option>';
//
//                        });
//
//                        $('#companyid').append(compHTML);
//                    }
//                });
//
//
//        });


        $(document).on('click', '.getDriverHistory', function ()
        {

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getBookingHistory",
                type: "POST",
                data: {order_id: $(this).attr('bid')},
                dataType: 'json',
                success: function (result) {
                    var html;
                    var order_id = '';
                    $('#doc_body').empty();

                    $('.bookingType').text('BOOKING TYPE: ' + result.bookingType)
                    if (result.bookingHistoryData)
                    {
                        $.each(result.bookingHistoryData, function (index, row)
                        {
                            order_id = row.order_id;
//                                    html += "<tr><td style='text-align: center;'>"+row.driver_id;
                            html += "<tr><td style='text-align: center;'>" + row.driverName + "</td>";
                            html += "</td><td style='text-align: center;'>" + row.driverPhone + "</td>";
                            html += "</td><td style='text-align: center;'>" + row.bookingReceivedTime + "</td>";
                            html += "</td><td style='text-align: center;'>" + row.bookingReceivedTime + "</td>";
                            html += "</td><td style='text-align: center;'>" + row.bookingReceivedTime + "</td>";
                            html += "</td><td style='text-align: center;'>" + row.status + "</td>";

                            html += "</tr>";

                        });
                    } else
                    {
                        html += "<tr><td style='text-align: center;' colspan='5'>No data available</td></tr>";
                    }
                    $('#headingFor').text('ORDER SENT HISTORY');
                    $('#doc_body').append(html);
                    $('#modelBookingHistory').modal('show');//Code in footer.php

                }
            });
        });

        $(document).on('click', '.getDriverDetails', function ()
        {
            $('.dname').text('');
            $('.demail').text('');
            $('.dphone').text('');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getDriverDetails",
                type: "POST",
                data: {mas_id: $(this).attr('mas_id')},
                dataType: 'json',
                success: function (result) {
                    var accoutType = (result.driverData.accountType == 3) ? 'Store' : 'Freelancer';
                    var myDate = new Date(result.driverData.createdDate * 1000);

                    if (result.driverData.firstName != null)
                    {
                        $('.dprofilePic').attr('src', '');
                        $('.dprofilePic').hide();
                        $('.dname').text(result.driverData.firstName + ' ' + result.driverData.lastName);
                        $('.demail').text(result.driverData.email);
                        $('.dphone').text(result.driverData.countryCode + result.driverData.mobile);
                        $('.dbusinessType').text(myDate);

                        if (result.driverData.profilePic != '')
                        {
                            $('.dprofilePic').attr('src', result.driverData.profilePic);
                            $('.dprofilePic').show();
                        }
                    }

                    $('#getDriverDetails').modal('show');//Code in footer.php

                }
            });
        });
		
		$(document).on('click', '.getDriverDetailsData', function ()
        {
            $('.dname').text('');
            $('.demail').text('');
            $('.dphone').text('');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getDriverDetails",
                type: "POST",
                data: {mas_id: $(this).attr('mas_id')},
                dataType: 'json',
                success: function (result) {
                    var accoutType = (result.driverData.accountType == 3) ? 'Store' : 'Freelancer';
                    var myDate = new Date(result.driverData.createdDate * 1000);
					if(result.driverData.accountType == 3){
						$('#planPopUp').hide();
					}else{
						$('#storePopUp').hide();
					}
                    if (result.driverData.firstName != null)
                    {
                        $('.dprofilePic').attr('src', '');
                        $('.dprofilePic').hide();
                        $('.dname').text(result.driverData.firstName + ' ' + result.driverData.lastName);
                        $('.demail').text(result.driverData.email);
                        $('.dphone').text(result.driverData.countryCode + result.driverData.mobile);
                        $('.dbusinessType').text(myDate);
						 $('.driverType').text(accoutType);
						 $('.storeName').text(result.driverData.storeName);
							 $('.drivingExpiry').text(result.driverData.driverLicenseExp);
                        if (result.driverData.profilePic != '')
                        {
                            $('.dprofilePic').attr('src', result.driverData.profilePic);
                            $('.dprofilePic').show();
                        }
						 if (result.driverData.driverLicenseFront != '')
                        {
                            $('.drivingLicenseFront').attr('src', result.driverData.driverLicenseFront);
                            $('.drivingLicenseFront').show();
                        }
						 if (result.driverData.driverLicenseBack != '')
                        {
                            $('.drivingLicenseBack').attr('src', result.driverData.driverLicenseBack);
                            $('.drivingLicenseBack').show();
                        }
                    }

                    $('#getDriverDetailsData').modal('show');//Code in footer.php

                }
            });
        });
        
        // reset pwd
		$('#btnStickUpSizeToggle').click(function () {
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModal1');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#myModal1').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
        });

    $("#superpass").click(function () {
        $("errorpass").text("");
        var oldpass = $("#oldpass").val();
        var newpass = $("#newpass").val();
        var confirmpass = $("#confirmpass").val();
        var currentpassword = $("#currentpassword").val();
        var reg = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;    //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;

        if (oldpass == "" || oldpass == null)
        {
            $("#errorpass").show();
            $("#errorpass").text('Please enter the current password ');
        } else if (newpass == "" || newpass == null)
        {
            $("#errorpass").show();
            $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSNEW); ?>);
        } else if (!reg.test(newpass))
        {
            $("#errorpass").show();
            $("#errorpass").text("Please enter the password with atleast one chareacter and one letter");

        } else if (confirmpass == "" || confirmpass == null)
        {
           
            $("#errorpass").show();
            $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSCONFIRM); ?>);
        } else if (confirmpass != newpass)
        {   
           
            $("#errorpass").show();
            $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_SAMEPASSCONFIRM); ?>);
        } else
        {
           
            $.ajax({
                url: "<?php echo base_url('index.php?/Superadmin') ?>/editpassword",
                type: 'POST',
                data: {
                    password: newpass,
                    currentpassword: currentpassword
                },
                dataType: 'JSON',
                success: function (response)
                {
                    if (response == 1) {

                        $(".close").trigger('click');

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

                        $("#errorboxdatas").text('password changed successfully');
                        $(".error-box-class").val('');

                    }

                }

            });
        }

    });

    

        $(document).on('click', '.getCustomerDetails', function ()
        {

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getCustomerDetails",
                type: "POST",
                data: {slave_id: $(this).attr('slave')},
                dataType: 'json',
                success: function (result) {

                    if (result.driverData.name != null)
                    {
                        $('.sprofilePic').attr('src', '');
                        $('.sprofilePic').hide();
                        $('.sname').text(result.driverData.name);
                        $('.semail').text(result.driverData.email);
                        $('.sphone').text(result.driverData.countryCode + result.driverData.phone);

                        $('.sbusinessName').text('N/A');
                        if (typeof result.driverData.businessName != 'undefined')
                            $('.sbusinessName').text(result.driverData.businessName);

                        $('.sbusinessAddress').text('N/A');
                        if (typeof result.driverData.businessAddress != 'undefined')
                            $('.sbusinessAddress').text(result.driverData.businessAddress);

//                                           if(result.driverData.profile_pic != '')
//                                           {
                        $('.sprofilePic').attr('src', result.driverData.profilePic);
                        $('.sprofilePic').show();
//                                           }
                    }


                    $('#getCustomerDetails').modal('show');//Code in footer.php

                }
            });
        });



        //Filter based on VehicleType
//        $('#vehicleTypeFilter').change(function () {
//            $('#planFilter').val('');
//            $('#operatorType').val('');
//            $('#companyid').val('');
//            $('.showOperators').hide();
//        
//            $.ajax({
//                url: "<?php echo base_url('index.php?/superadmin') ?>/setcity_session",
//                type: "POST",
//                dataType: 'JSON',
//                data: {city: '',operatorType:'',company:'','plan':'','vehicleType':$(this).val()},
//                success: function (response)
//                {
//                    refreshContent(url);//Load datatable
//                }
//            });
//
//        });

//        var obj = {};
//        $('#mainFilter').change(function (){
//        
//            switch($('#mainFilter').val()){
//                    case '':obj.city = '';
//                            obj.vehicleType = '';
//                            obj.operatorType = '';
//                            obj.plan = '';
//                            break;
//                            
//                    case '1':obj.city = '';
//                            obj.vehicleType = '';
//                            obj.operatorType = '';
//                            obj.plan = '';
//                            break;
//            }
//        });
//        var obj = {};
//        $('#mainFilter').change(function (){
//        
//            switch($('#mainFilter').val()){
//                    case '':$('#vehivleTypeFilterDiv').hide();
//                            $('#driverTypeFilterDiv').hide();
//                            $('#operatorsFilterDiv').hide();
//                            $('#planFilterDiv').hide();
//                            break;
//                            
//                    case '1':$('#vehivleTypeFilterDiv').show();
//                            $('#driverTypeFilterDiv').hide();
//                            $('#operatorsFilterDiv').hide();
//                            $('#planFilterDiv').hide();
//                            break;
//                            
//                    case '2':$('#vehivleTypeFilterDiv').hide();
//                            $('#driverTypeFilterDiv').show();
//                            $('#operatorsFilterDiv').hide();
//                            $('#planFilterDiv').hide();
//                            break;
//                            
//                    case '3':$('#vehivleTypeFilterDiv').hide();
//                            $('#driverTypeFilterDiv').hide();
//                            $('#operatorsFilterDiv').show();
//                            $('#planFilterDiv').hide();
//                            break;
//            }
//        });



//        }

    // $('#confirmedYes').click(function () {
    //     window.location.href="<?php echo base_url(); ?>index.php?/superadmin/Logout";    
        
    // });

    });

    function validatePassword() {
        var oldpass = $("#oldpass").val();
        if (oldpass == '' || oldpass == null) {
            $("#errorpass").html("Please enter current password");
        } else {
            $.ajax({
                url: "<?php echo base_url('index.php?/Superadmin') ?>/validatePassword",
                type: 'POST',
                data: {
                    oldpass: oldpass
                },
                dataType: 'JSON',
                success: function (result)
                {
                    console.log(result);
                    if (result.msg == '1') {
                        $("#errorpass").show();
                        $("#errorpass").html("Wrong current Password");
                        $('#oldpass').focus();
                    } else if (result.msg == '0') {
                        $("#errorpass").hide();

                    }
                }

            });
        }
    }

    


</script>


<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <!--              <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                          </div>-->
            <div class="pull-left" style="margin-top: 20px;">
                <strong style="color:hotpink" class="Msg"></strong>

            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?= $this->lang->line('language'); ?><span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right" style="width:0px;">
                        <!-- <li>
                            <a tabindex="-1" href="<?php echo base_url(); ?>index.php?/Language/index/english">
                                <img class="menuIconClass" style="width:25px"  class=""/>English
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?php echo base_url(); ?>index.php?/Language/index/arabic">
                                <img class="menuIconClass" style="width:25px"  class=""/>Arabic
                            </a>
                        </li> -->


                         <li>
                            <a tabindex="-1" href="<?php echo base_url(); ?>index.php?/Language/index/english">
                                    <img src="<?php echo ServiceLink; ?>theme/grocerIcons/IN.png" class="pull-right" alt="" style="width:20%;margin-top-3px">English
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" href="<?php echo base_url(); ?>index.php?/Language/index/arabic">
                                    <img src="<?php echo base_url() . 'pics/french_flag.png' ?>" class="pull-right" alt="" style="width:20%">Arabic
                            </a>
                        </li>
                      
                    </ul>
                </li>
                <li class="">

                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo base_url() . '../../pics/user.jpg' ?>" alt=""> <span  style="color:#ffffff"><?php echo $this->session->userdata('role'); ?></span>
                        <span class=" fa fa-angle-down"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-usermenu pull-right" style="width:0px;">

                        <li><a tabindex="-1" href="#" id="btnStickUpSizeToggle"><i class="fa fa-lock pull-right" aria-hidden="true"></i>Reset Password</a></li>
                        <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php?/superadmin/Logout"><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>

 
                    </ul>
                </li>
                
                <!-- <p class="pull-right" style="color:#ffffff;margin-right:60px;margin-top:20px;">  <b>Server Time: <?php echo date('d-m-Y H:', time()); ?><label id="minutes"><?php echo date('i', time()); ?></label>:<label id="seconds"><?php echo date('s', time()); ?></label></b></p> -->

                <p class="pull-right" style="color:#ffffff;margin-right:60px;margin-top:20px;">  <b>Server Time: <?php echo  date('d-m-Y H', (time()) - ($this->session->userdata('timeOffset') * 60)); ?>:<label id="minutes"><?php echo date('i', (time() - ($this->session->userdata('timeOffset') * 60))); ?></label>:<label id="seconds"><?php echo date('s', time()); ?></label></b></p>

                <li role="presentation" class="dropdown">

                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
                              <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
      <!--                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                              <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                              <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <div class="text-center">
                                <a>
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

<div class="modal fade stick-up" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


            <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"><?php echo LIST_RESETPASSWORD_HEAD; ?></span>
                </div>


                <div class="modal-body">
                    <br>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_CURRENTPASSWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="oldpass" name="oldpass" onblur="validatePassword()"  class="form-control" placeholder="Password">
                        </div>
                    </div>


                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_NEWPASSWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="newpass" name="latitude"  class="form-control" placeholder="Password">
                        </div>
                    </div>


                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_CONFIRMPASWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="confirmpass" name="longitude" class="form-control" placeholder="Password">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-sm-4 error-box" id="errorpass" style="color:red;"></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="superpass" ><?php echo BUTTON_SUBMIT; ?></button></div>
                        <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                    </div>
                </div>
        </div>
        </form>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

</div>

<script type="text/javascript">
    var minutesLabel = document.getElementById("minutes");
    var secondsLabel = document.getElementById("seconds");
    var totalSeconds = parseInt(($('#minutes').text() * 60)) + parseInt($('#seconds').text());
    setInterval(setTime, 1000);

    function setTime()
    {
        ++totalSeconds;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
    }

    function pad(val)
    {
        var valString = val + "";
        if (valString.length < 2)
        {
            return "0" + valString;
        } else
        {
            return valString;
        }
    }
</script>


<div class="right_col" role="main" style="min-height:1035px;">

<div class="modal fade stick-up" id="confirmmodels1212" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:0;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class=" clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>

            </div>

        </div>
        <br>
        <div class="modal-body">
            <div class="row">

                <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center">Delete</div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default pull-right" id="confirmedYes" ><?php echo "OK"; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>