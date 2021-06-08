<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('heading_termPage'); ?></strong>
        </div>
        <script>
            $(document).ready(function () {

                $("#saveButton").click(function () {

                    var terms = new Array();

                    var len = $('.policy').length;
                    console.log(len);
                    for (i = 0; i < len; i++) {
                        if(CKEDITOR.instances['terms' + i]){
                            terms.push(CKEDITOR.instances['terms' + i].getData());
                        }
                        
                    }

                    $.ajax({
                        url: "<?php echo base_url('index.php?/PolicyController') ?>/update_sterms",
                        type: "POST",
                        data: {terms: terms},
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

                                    <div class="pull-right m-t-10"> <button name="testing" class="btn btn-primary btn-cons cls110" id="saveButton"><span><?php echo 'SAVE'; ?></button></a></div>
                                </div>
                                &nbsp;

                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-4" style="color: #0090d9;">For Store : </label>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('heading_termPage'); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<a target="_new" href="<?php echo base_url(); ?>/appWebPages/Store/Termsen.html">Preview</a> </label>
                                    </div>

                                    <div class="form-group policy">
                                        <div class="col-sm-12">
                                            <textarea name="terms0" class="terms"><?PHP echo $allData['terms'][0]; ?></textarea>
                                            <script>
                                                CKEDITOR.replace('terms0');
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
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<a target="_new" href="<?php echo base_url(); ?>/appWebPages/Customer/Terms<?php echo $val['langCode']; ?>.html">Preview</a> </label>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <textarea name="terms<?= $val['lan_id'] ?>" class="terms"><?PHP echo $allData['terms'][$val['lan_id']]; ?></textarea>
                                                    <script>
                                                        CKEDITOR.replace('terms<?php echo $val['lan_id']; ?>');
                                                    </script>
                                                </div>
                                            </div>

                                        <?php } else { ?>
                                            <div class="form-group policy" style="display:none;">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('heading_termPage'); ?> (<?php echo $val['lan_name']; ?>)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<a target="_new" href="<?php echo base_url(); ?>/appWebPages/Customer/Terms<?php echo $val['langCode']; ?>.html">Preview</a> </label>
                                            </div>

                                            <div class="form-group" style="display:none;">
                                                <div class="col-sm-12">
                                                    <textarea name="terms<?= $val['lan_id'] ?>" class="terms"><?PHP echo $allData['terms'][$val['lan_id']]; ?></textarea>
                                                    <script>
                                                        CKEDITOR.replace('terms<?php echo $val['lan_id']; ?>');
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
