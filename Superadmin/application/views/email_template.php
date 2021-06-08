<script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<style>
    #selectedcity,#companyid,#account_type{
        display: none;
    }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    html,
    body {
        background-color: #fff;
        color: #555;
        font-family: 'Lato', 'Arial', sans-serif;
        font-weight: 300;
        text-rendering: optimizeLegibility;
        overflow-x: hidden;
    }
    .clearfix {zoom: 1;}
    .clearfix:after {
        content: '.';
        clear: both;
        display: block;
        height: 0;
        visibility: hidden;
    }
    ::-webkit-scrollbar {
        width: 5px;
        height: 30px;
    }
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px #aaa; 
        border-radius: 3px;
    }
    ::-webkit-scrollbar-thumb {
        border-radius: 3px;
        -webkit-box-shadow: inset 0 0 6px #aaa; 
    }
    .section-tempType li{
        font-size: 88%;
        list-style: none;
        cursor: pointer;
        padding: 10px;
        background: #eee;
        border-bottom: 1px solid #aaa;
    }
    .top70{
        margin-top: 12%
    }
    .section-tempBody, .section-tempType{
        height: 65vh;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    .section-tempType .active{
        background: #d5d5d5 !important;
    }
    .section-tempType {
        font-size: 20px;
    }
    #cke_47 {  
        display: none;
    }
</style>
<div class="content">
    <div class="jumbotron  no-margin" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            <div class="inner" style="transform: translateY(0px); opacity: 1;">
                <h3 class="">Page Title</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid container-fixed-lg">
        <ul class="breadcrumb">
            <li>
                <a href="#" class="active">Email Templates</a>
            </li>
        </ul>
        <div class="container-md-height m-b-20">
            <div class="panel panel-default">
                <div class="panel-body no-padding">
                    <div class="col-md-3 no-padding">
                        <ul class="section-tempType">
                            <?php 
                                $s = 'active';
                                foreach($temp_type as $val){
                                    echo '<li class="'.$s.'" href="#" data-val="'.$val.'">'. str_replace("_", " ", $val).'</li>';
                                    $s = '';
                                }
                            ?>
                            <!--<li class="" href="#driver">Driver</li>-->
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <section id="passanger" class="mailbox">
                            <form role="form" id="template_form" class="form-horizontal" method="post" action="<?php echo base_url() ?>index.php/utilities/email_template_action">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Subject</label>
                                    <div class="col-lg-10">
                                        <input type="text" required="" placeholder="" id="subject" class="form-control" name="fdata[subject]" value="<?= $temp_data['subject']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Name</label>
                                    <div class="col-lg-10">
                                        <input type="text" required="" placeholder="Sender Name" id="from_name" class="form-control" name="fdata[from_name]" value="<?= $temp_data['from_name']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-10">
                                        <input type="email" required="" placeholder="Sender Email" id="from_email" class="form-control" name="fdata[from_email]" value="<?= $temp_data['from_email']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Body</label>
                                    <div class="col-lg-10">
                                        <textarea required="" rows="10" cols="30" class="form-control" id="body_editor" name="body_editor"><?= $temp_data['body']?></textarea>
                                    </div>
                                </div>
                                <input type="hidden" id="temp_type" name="fdata[temp_type]" value="<?= (($temp_data['temp_type'])?$temp_data['temp_type']:$temp_type[0])?>"/>
                                <input type="hidden" name="fdata[type]" value="post"/>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button class="btn btn-send" type="submit" id="btn_save">Save</button>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    function wait_me(effect) {
        $('.content').waitMe({
            //none, rotateplane, stretch, orbit, roundBounce, win8, 
            //win8_linear, ios, facebook, rotation, timer, pulse, 
            //progressBar, bouncePulse or img
            effect: effect,
            //place text under the effect (string).
            text: '',
            //background for container (string).
            bg: 'rgba(255,255,255,0.7)',
            //color for background animation and text (string).
            color: '#000',
            //change width for elem animation (string).
            sizeW: '',
            //change height for elem animation (string).
            sizeH: '',
            // url to image
            source: '',
            // callback
            onClose: function () {}

        });
    }
    $(document).on("click", ".section-tempType li", function () {
        wait_me('bounce');
        var temp_type = $(this).attr('data-val');
        var fdata = {
            type : 'get',
            temp_type : temp_type
        };
        $.ajax({
            url: "<?php echo base_url() ?>index.php/utilities/email_template_action",
            type: "POST",
            data: {fdata : fdata},
            dataType: "JSON",
            success: function (result) {
                $('.content').waitMe('hide');
                var data = result.data;
                $(".section-tempType li").removeClass('active');
                $(this).toggleClass('active');
                $('#subject').val(data.subject);
                $('#from_name').val(data.from_name);
                $('#from_email').val(data.from_email);
                $('#temp_type').val(data.temp_type);
//                $('#body').html(data.body);
//                CKEDITOR.replace('fdata[body]');
                CKEDITOR.instances.body_editor.setData(data.body); 
            },
            error: function () {
                $('.content').waitMe('hide');
                alert('Problem occurred please try agin.');
            },
            timeout: 30000
        });
    });
    $(document).ready(function(){
//        $('#body_editor').ckeditor();
        CKEDITOR.replace('body_editor', { toolbar: 'Basic' });
        $('#btn_save1').click(function(){
            $.ajax({
                url: "<?php echo base_url() ?>index.php/utilities/email_template_action",
                type: "POST",
                data: $("#template_form").serialize(),
                dataType: "JSON",
                success: function (result) {
                    
                },
                error: function () {
                    alert('Problem occurred please try agin.');
                },
                timeout: 30000
            });
        });
    });
</script>