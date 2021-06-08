<style>
    .page-sidebar .sidebar-menu .menu-items > li > a {
        width: 189px !important;
    }
    .modalPopUpText{
                font-size: 14px !important;
                text-align:center;
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
                $("#errorpass").text('');
                
            }

            else if (newpass == "" || newpass == null)
            {
//                alert("please enter the new password");
                $("#errorpass").text('');
            }
            else if (!reg.test(newpass))
            {
//                alert("please enter the password with atleast one chareacter and one letter");
                $("#errorpass").text('');
            }
            else if (confirmpass == "" || confirmpass == null)
            {
//                alert("please confirm the password");
                $("#errorpass").text('');
            }
            else if (confirmpass != newpass)
            {
//                alert("please confirm the same password");
                $("#errorpass").text('');
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

                            $("#errorboxdatass").text('');
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

                            $("#errorboxdatass").text('');
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
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url(); ?>/../../pics/user.jpg" alt=""><?php echo $this->session->userdata('first_name');
                                                                                       //                                                                                        echo $s;
                                                                                     ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
<!--                    <li><a href="javascript:;" class="fa fa-lock"> Forgot Password</a></li>-->
                    <li><a tabindex="-1" href="<?php echo base_url(); ?>Common/Logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

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
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
