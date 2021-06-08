<?php  error_reporting(0)?>
<script>
    $(document).ready(function(){



    });


    function showMsg(){
        $('#rout').css('display','block');

    }
    function hideMsg(){
        $('#rout').css('display','none');

    }
    function showMsgacc(){
        $('#acc').css('display','block');

    }
    function hideMsgacc(){
        $('#acc').css('display','none');

    }
</script>
<style type="text/css">
    div.bank-account-popover-view {
        position: absolute;
        padding: 20px 16px;
        width: 352px;
        -webkit-box-shadow: 0 5px 13px 0 rgba(0,0,0,0.2),0 0 0 1px rgba(0,0,0,0.1);
        -moz-box-shadow: 0 5px 13px 0 rgba(0,0,0,0.2),0 0 0 1px rgba(0,0,0,0.1);
        -ms-box-shadow: 0 5px 13px 0 rgba(0,0,0,0.2),0 0 0 1px rgba(0,0,0,0.1);
        -o-box-shadow: 0 5px 13px 0 rgba(0,0,0,0.2),0 0 0 1px rgba(0,0,0,0.1);
        box-shadow: 0 5px 13px 0 rgba(0,0,0,0.2),0 0 0 1px rgba(0,0,0,0.1);
        background: #fff;
    }
    .popover-view {
        position: absolute;
        z-index: 10000;
        margin-top: -12px;
        padding: 1px;
        font-size: 12px;
        background: rgba(0,0,0,0.45);
        background: -webkit-linear-gradient(rgba(0,0,0,0.35),rgba(0,0,0,0.45));
        background: -moz-linear-gradient(rgba(0,0,0,0.35),rgba(0,0,0,0.45));
        background: -ms-linear-gradient(rgba(0,0,0,0.35),rgba(0,0,0,0.45));
        background: -o-linear-gradient(rgba(0,0,0,0.35),rgba(0,0,0,0.45));
        background: linear-gradient(rgba(0,0,0,0.35),rgba(0,0,0,0.45));
        -webkit-border-radius: 7px;
        -moz-border-radius: 7px;
        -ms-border-radius: 7px;
        -o-border-radius: 7px;
        border-radius: 7px;
        -webkit-box-shadow: 0 4px 13px rgba(0,0,0,0.46);
        -moz-box-shadow: 0 4px 13px rgba(0,0,0,0.46);
        -ms-box-shadow: 0 4px 13px rgba(0,0,0,0.46);
        -o-box-shadow: 0 4px 13px rgba(0,0,0,0.46);
        box-shadow: 0 4px 13px rgba(0,0,0,0.46);
    }
    div.bank-account-popover-view div.check {
        display: block;
        height: 156px;
        width: 328px;
        background-image: url("https://a.stripecdn.com/manage/assets/settings/transfers/checks/us-routing-d5902dbb59a5bcf762112898ef33e108.png");
        background-size: 328px 156px;
    }
    p.explanation {
        padding-top: 6px;
        color: #596a7f;
        font-size: 13px;
        line-height: 1.3em;
        text-align: center;
    }
    div.bank-account-popover-view p.explanation {
        padding-top: 6px;
        color: #596a7f;
        font-size: 13px;
        line-height: 1.3em;
        text-align: center;
    }
</style>

<div class="page-content-wrapper">
<!-- START PAGE CONTENT -->
<div class="content">
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
        <div class="inner">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
                <li>
                    <p>Banking</p>
                </li>
                <li><a href="#" class="active"> </a>
                </li>
            </ul>
            <!-- END BREADCRUMB -->
        </div>


        <div class="panel panel-transparent">

            <div class="panel-body">
                <div class="col-md-1 sm-no-padding"></div>
                <div class="col-md-10 sm-no-padding">

                    <div class="panel panel-transparent">
                        <div class="panel-body no-padding">
                            <div id="portlet-advance" class="panel panel-default">
                                <div class="panel-heading ">


                                </div>
                                <div class="panel-body">
                                    <div class="row">

                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8">
                                            <form id="form-work" class="form-horizontal" method="post" role="form" autocomplete="off" novalidate="novalidate"  enctype="multipart/form-data" action="udpadedataProfile">

                                                <div class="form-group">
                                                    <label for="fname" class="col-sm-3 control-label">First Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="fname" placeholder="Full name"  value="<?php echo $userinfo->first_name; ?>" name="fdata[first_name]" required="" aria-required="true">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="fname" class="col-sm-3 control-label">Last Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="fname" placeholder="Last name" value="<?php echo $userinfo->last_name; ?>" name="fdata[last_name]" required="" aria-required="true">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="position" class="col-sm-3 control-label">Mobile</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control " id="position" value="<?php echo $userinfo->mobile; ?>" placeholder="Mobile" name="fdata[mobile]"  aria-required="true" aria-invalid="true">
                                                        <!--<label id="position-error" class="error" for="position">This field is required.</label>-->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-3 control-label">Email</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="position" value="<?php echo $userinfo->email; ?>" placeholder="Email"  name="fdata[email]"   aria-required="true" aria-invalid="true">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="fname" class="col-sm-3 control-label">Tax ID</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="fname" placeholder="Full name"  value="<?php echo $userinfo->first_name; ?>" name="fdata[first_name]" required="" aria-required="true">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="fname" class="col-sm-3 control-label">Bank Country</label>
                                                    <div class="col-sm-9">



                                         <select class="form-control" >
                                                                <option value="sightseeing">india</option>
                                                                <option value="business">usa</option>

                                                            </select>
                                                   </div>


                                                </div>





                                                <div class="form-group">
                                                    <label for="position" class="col-sm-3 control-label">Routing Number</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control " id="position" value="<?php echo $userinfo->mobile; ?>" placeholder="Mobile" name="fdata[mobile]"   onfocus="showMsg()"  onblur="hideMsg()" aria-required="true" aria-invalid="true">
                                                        <!--<label id="position-error" class="error" for="position">This field is required.</label>-->
                                                        <div class="icon" style="float: right;margin-top: -28px;margin-right: 12px;">
                                                            <img src="https://a.stripecdn.com/manage/assets/settings/transfers/account/info-5f252a77a8150ae4389ee5c3e9413c77.png" >

                                                        </div>
                                                    </div>
                                                    <div class="bank-account-popover-view popover-view" style="left: 735px;top: 298px;display: none;"  id="rout">
                                                        <div class="check us-routing"></div>
                                                        <p class="explanation">Your <span class="type">routing</span> number is normally found on a check provided by your bank.</p>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-3 control-label">Account Number</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="position" value="<?php echo $userinfo->email; ?>" placeholder="Acc no"  name="fdata[email]"   onfocus="showMsgacc()"  onblur="hideMsgacc()" aria-required="true" aria-invalid="true">

                                                        <div class="icon" style="float: right;margin-top: -28px;margin-right: 12px;">
                                                            <img src="https://a.stripecdn.com/manage/assets/settings/transfers/account/info-5f252a77a8150ae4389ee5c3e9413c77.png" >

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="bank-account-popover-view popover-view" style="left: 735px;top: 401px;display: none;" id="acc">
                                                        <div class="check us-routing" style="background-image: url('https://a.stripecdn.com/manage/assets/settings/transfers/checks/us-account-4f0de4f5f3daf7ea0935de52251dc8b6.png')"></div>
                                                        <p class="explanation">Your <span class="type">account</span> number is normally found on a check provided by your bank.</p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-3 control-label">Confirm A/c</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="position" value="<?php echo $userinfo->email; ?>" placeholder="Email"  name="fdata[email]"   aria-required="true" aria-invalid="true">
                                                        <div class="icon" style="float: right;margin-top: -28px;margin-right: 12px;">
                                                            <img src="https://a.stripecdn.com/manage/assets/settings/transfers/account/info-5f252a77a8150ae4389ee5c3e9413c77.png" >

                                                        </div>
                                                    </div>
                                                </div>


                                         <br>
                                                <br>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <!--<p>I hereby certify that the information above is true and accurate. </p>-->
                                                </div>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-success" type="submit">Submit</button>
                                                    <!--                                                                <button class="btn btn-default"><i class="pg-close"></i> Clear</button>-->
                                                </div>
                                            </div>
                                            <input type="hidden" name="val" value="1">
                                            </form>
                                        </div>
                                        <div class="col-sm-2"></div>


                                    </div>
                                </div>
                                <img src="pages/img/progress/progress-circle-master.svg" style="display:none"></div>
                        </div>
                    </div>


                </div>
                <div class="col-md-1 sm-no-padding"></div>
            </div>
        </div>




    </div>


</div>
<!-- END JUMBOTRON -->

<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg">
    <!-- BEGIN PlACE PAGE CONTENT HERE -->

    <!-- END PLACE PAGE CONTENT HERE -->
</div>
<!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset">
            <span class="hint-text">Copyright © 2014</span>
            <span class="font-montserrat">REVOX</span>.
            <span class="hint-text">All rights reserved.</span>
                <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
                </span>
        </p>
        <p class="small no-margin pull-right sm-pull-reset">
            <a href="#">Hand-crafted</a>
            <span class="hint-text">&amp; Made with Love ®</span>
        </p>
        <div class="clearfix"></div>
    </div>
</div>
<!-- END FOOTER -->
</div>