<!--<style>
    .page-sidebar .sidebar-menu .menu-items > li > a {
        width: 189px !important;
  

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

                
                <p class="pull-right" style="color:#1ABB9C;margin-right:60px;margin-top:20px;">  <b>Server Time: <?php echo date('d-m-Y H:', time()); ?><label id="minutes"><?php echo date('i', time()); ?></label>:<label id="seconds"><?php echo date('s', time()); ?></label></b></p>

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