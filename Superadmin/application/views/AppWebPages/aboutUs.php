<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo 'About Us'; ?></strong>
        </div>
        <script>
            $(document).ready(function () {

                $("#saveButton").click(function () {

                    var terms = new Array();

                    var len = $('.policy').length;
                    console.log(len);
                    for (i = 0; i < len; i++) {
                        terms.push(CKEDITOR.instances['aboutUs' + i].getData());
                    }

                    $.ajax({
                        url: "<?php echo base_url('index.php?/AboutUsController') ?>/update_terms",
                        type: "POST",
                        data: {aboutUs: terms},
                        dataType: 'json',
                        success: function (response)
                        {
                            window.location.reload();
                        }
                    });
                });
            });
        </script>
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                    <div class="pull-right m-t-10"> <button name="testing" class="btn btn-primary btn-cons" id="saveButton"><span><?php echo 'SAVE'; ?></button></a></div>
                                </div>
                                &nbsp;

                                <div class="panel-body">
                                   
                                   
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo 'About Us'; ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<a target="_new" href="<?php echo base_url(); ?>/appWebPages/AboutUs/AboutUsen.html">Preview</a> </label>
                                    </div>

                                    <div class="form-group policy">
                                        <div class="col-sm-12">
                                            <textarea name="aboutUs0" class="aboutUs"><?PHP echo $allData['aboutUs'][0]; ?></textarea>
                                            <script>
                                                CKEDITOR.replace('aboutUs0');
                                            </script>
                                        </div>
                                    </div>
                                    <br><br>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group policy">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('heading_termPage'); ?> (<?php echo $val['lan_name']; ?>)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<a target="_new" href="<?php echo base_url(); ?>/appWebPages/Customer/Terms<?php echo $val['lan_id']; ?>.html">Preview</a> </label>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <textarea name="aboutUs<?= $val['lan_id'] ?>" class="aboutUs"><?PHP echo $allData['aboutUs'][$val['lan_id']]; ?></textarea>
                                                    <script>
                                                        CKEDITOR.replace('aboutUs<?php echo $val['lan_id']; ?>');
                                                    </script>
                                                </div>
                                            </div>

                                        <?php } else { ?>
                                            <div class="form-group policy" style="display:none;">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('heading_termPage'); ?> (<?php echo $val['lan_name']; ?>)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<a target="_new" href="<?php echo base_url(); ?>/appWebPages/Customer/Terms<?php echo $val['lan_id']; ?>.html">Preview</a> </label>
                                            </div>

                                            <div class="form-group" style="display:none;">
                                                <div class="col-sm-12">
                                                    <textarea name="aboutUs<?= $val['lan_id'] ?>" class="aboutUs"><?PHP echo $allData['aboutUs'][$val['lan_id']]; ?></textarea>
                                                    <script>
                                                        CKEDITOR.replace('aboutUs<?php echo $val['lan_id']; ?>');
                                                    </script>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="row"></div>
                            </div>
                        </div>
                    </div>
                    <!-- END PANEL -->
                </div>
                <!--</form>-->
            </div>
        </div>
    </div>
</div>
<!-- END JUMBOTRON -->
