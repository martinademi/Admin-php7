<script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<style>
    #selectedcity,#companyid,#account_type{
        display: none;
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
                <a href="#" class="active">Other Pages</a>
            </li>
        </ul>
        <div class="container-md-height m-b-20">
            <div class="panel panel-default">
                <div class="panel-body">
                    <section id="passanger" class="mailbox">
                        <form role="form" id="template_form" class="form-horizontal" method="post" action="<?php echo base_url() ?>index.php?/utilities/other_page_action">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Page</label>
                                <div class="col-lg-10">
                                    <select id="page_name" name="page_name" class="form-control">
                                        <option value="" disabled="" selected="">Select Page</option>
                                        <option value="privacy_policy">DayRunner Privacy Policy</option>
                                        <option value="terms_of_use">Passenger Terms & Condition</option>
                                        <option value="drv_terms_of_use">Driver Terms & Condition</option>
                                        <option value="drv_privacy_policy">Driver Privacy Policy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Body</label>
                                <div class="col-lg-10">
                                    <textarea required="" rows="10" cols="30" class="form-control" id="body_editor" name="body_editor"><?= $temp_data['body']?></textarea>
                                </div>
                            </div>
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
    $(document).on("change", "#page_name", function () {
        wait_me('bounce');
        var temp_type = $(this).val();
        var fdata = {
            type : 'get',
            temp_type : temp_type
        };
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/utilities/other_page_action",
            type: "POST",
            data: {fdata : fdata},
            dataType: "JSON",
            success: function (result) {
                $('.content').waitMe('hide');
                var data = result.data;
                CKEDITOR.instances.body_editor.setData(data); 
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
                url: "<?php echo base_url() ?>index.php?/utilities/other_page_action",
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