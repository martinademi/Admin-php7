<style>
    .page-sidebar .sidebar-menu .menu-items > li > a {
        width: 189px !important;
    }
</style>
<script>

    $(document).ready(function () {

        $('#selectedcity').change(function () {

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/showcompanys",
                type: "POST",
                data: {city: $(this).val(), vt: '1'},
//                dataType: 'JSON',
                success: function (response)
                {
//                    $(this).val()
                    $("#companyid").html(response);
                    refreshTableOnActualcitychagne();

//                    $("#companyid").val("<?php //$this->session->userdata('company_id') ?>//");
                }
            });

        });
        $('#companyid').change(function () {

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/setcity_session",
                type: "POST",
                data: {company: $(this).val(), city: $('#selectedcity').val()},
//                dataType: 'JSON',
                success: function (response)
                {
                    refreshTableOnCityChange();
//                   alert('sessionset');
                }
            });

        });

        if ("<?php echo $this->session->userdata('city_id') ?>" != '0' || "<?php echo $this->session->userdata('company_id') ?>" != '0') {
//alert("<?php //echo  $this->session->userdata('city_id') ?>//");
//alert("<?php //echo  $this->session->userdata('company_id') ?>//");
            $('#selectedcity').val("<?php echo $this->session->userdata('city_id') ?>");
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/showcompanys",
                type: "POST",
                data: {city: "<?php echo $this->session->userdata('city_id') ?>"},
//                dataType: 'JSON',
                success: function (response)
                {
                    $("#companyid").html(response);
                    $("#companyid").val("<?php echo $this->session->userdata('company_id') ?>");
                }
            });


        }
        
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

            var newpass = $("#newpass").val();
            var confirmpass = $("#confirmpass").val();
            var currentpassword = $("#currentpassword").val();
            
            var reg = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;    //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;
             
             
             
              if (currentpassword == "" || currentpassword == null)
            {
//                alert("please enter the new password");
                $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_CURRENTPASSWORD); ?>);
                
            }

            else if (newpass == "" || newpass == null)
            {
//                alert("please enter the new password");
                $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSNEW); ?>);
            }
            else if (!reg.test(newpass))
            {
//                alert("please enter the password with atleast one chareacter and one letter");
                $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
            }
            else if (confirmpass == "" || confirmpass == null)
            {
//                alert("please confirm the password");
                $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSCONFIRM); ?>);
            }
            else if (confirmpass != newpass)
            {
//                alert("please confirm the same password");
                $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_SAMEPASSCONFIRM); ?>);
            }
            else
            {

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/editsuperpassword",
                    type: 'POST',
                    data: {
                        newpass: newpass,
                        currentpassword:currentpassword
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                       
                        if (response.flag == 1) {

                            $(".close").trigger('click');

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

                            $("#errorboxdatass").text(<?php echo json_encode(POPUP_DRIVERS_ERRCURRENTPASSWORD); ?>);
                            $("#confirmedss").hide();


                            $("#newpass").val('');
                            $("#confirmpass").val('');
                            $("#currentpassword").val('');
                        }
                        
                        else if(response.flag == 0){
                             $(".close").trigger('click');

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

                            $("#errorboxdatass").text(<?php echo json_encode(POPUP_DRIVERS_NEWPASSWORD); ?>);
                            $("#confirmedss").hide();


                            $("#newpass").val('');
                            $("#confirmpass").val('');
                            $("#currentpassword").val('');
                        }


//                        location.reload();

                    }

                });
            }

        });


        
        
        
        
    });
    
    
</script>

<!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
                <div>
                     <h3>superadmin</h3>
                </div>
                
<!--                      <div class="brand inline toggle" style="width:auto">
                    <img src="<?php //echo base_url();              ?>theme/assets/img/Rlogo.png" alt="logo" data-src="<?php //echo base_url();              ?>theme/assets/img/Rlogo.png" data-src-retina="<?php //echo base_url();              ?>theme/assets/img/logo_2x.png" width="93" height="25">
                    <div class="form-group " >
                        <label for="fname" class="col-sm-6 control-label" style="margin-top: 10px;font-size: 13px;padding:0px">SELECT CITY</label>
                        <div class="col-sm-8" style="width: auto;
                                     padding: 0px;
                                     margin-bottom: 10px;margin-left: -0.7%" >

                            <select id="selectedcity" name="company_select" class="form-control"  onchange="loadcompay()" style="background-color:mistyrose;">
                                <option value="0">Select city</option>
                                <?php // $city = $this->db->query("select * from city_available ORDER BY City_Name ASC")->result(); ?>
                                <option value="0">All</option>
                                <?php
//                                foreach ($city as $result) {
//
//                                    echo '<option value="' . $result->City_Id . '">' . $result->City_Name . '</option>';
//                                }
                                ?>   
                            </select>

                        </div>


                    </div>
                   <strong>Roadyo Super Admin Console</strong> id="define_page"
                </div>

                <div class="brand inline toggle"  style="width:auto" >
                    <img src="<?php //echo base_url();              ?>theme/assets/img/Rlogo.png" alt="logo" data-src="<?php //echo base_url();              ?>theme/assets/img/Rlogo.png" data-src-retina="<?php //echo base_url();              ?>theme/assets/img/logo_2x.png" width="93" height="25">
                    <div class="form-group" >
                        <label for="fname" class="col-sm-6 control-label" style="margin-top: 10px;font-size: 13PX;padding:0px">SELECT COMPANY</label>
                        <div class="col-sm-8" style="width: auto;
                             padding: 0px;
                             margin-bottom: 10px;" >

                            <select id="companyid" name="company_select" class="form-control"  style="background-color:mistyrose;">
                                <option value="0">Select company</option>
                            </select>

                        </div>
                    </div>
                   <strong>Roadyo Super Admin Console</strong> id="define_page"
                </div>-->
                

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <!--<img src="<?php // echo ServiceLink.'pics/user.jpg'?>" alt="">John Doe-->
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <!--<ul class="dropdown-menu dropdown-usermenu pull-right">-->
                    <ul class="dropdown-menu" style="margin-left: -135px;margin-top: 14px;background: #ffffff;width: 171px;">
                            <li>
                                <div class="row center-margin m-b-10">
                                    <div class="col-xs-2 text-center">
                                        <i class="fs-14 sl-user-follow"></i>
                                    </div>
                                    <div class="col-xs-8 text-center">
                                        <a tabindex="-1" href="<?php echo base_url(); ?>index.php?/superadmin/profile">MY PROFILE</a>
                                    </div>
                                </div>

                            </li>
                            <li class="divider"></li>

                            <li>

                                <center><a tabindex="-1" href="Logout">LOGOUT</a></center>
                            </li>

                        </ul>
              <!--</ul>-->
                </li>

                <li role="presentation" class="dropdown">
                 
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                        <span>
                           <!--<a tabindex="-1" href="<?php echo base_url(); ?>index.php?/superadmin/profile">MY PROFILE</a>-->
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
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
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
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
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
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
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
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
       