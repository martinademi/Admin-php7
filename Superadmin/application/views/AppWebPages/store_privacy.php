<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('heading_privacyPage'); ?></strong>
        </div>
        <script>
            $(document).ready(function () {

                $("#saveButton").click(function () {
                    <?php 
                   $jsarray = json_encode($language); 
                 ?>
                var langdata= '<?php echo  $jsarray; ?>';
                 langdata = JSON.parse(langdata);
                var engdata = {'Active':1,"lan_id":0,'lan_name':'english','langCode':"en"};
                langdata.push(engdata);
               
                    var privacy = {};

                    for(i = 0 ; i<langdata.length ; i++){
                        privacy[langdata[i]['langCode']] = CKEDITOR.instances['privacy'+langdata[i]['langCode']].getData();
                        
                    }
              
                    $.ajax({
                        url: "<?php echo base_url('index.php?/PolicyController') ?>/store_update_privacy",
                        type: "POST",
                        data: {privacy: privacy},
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

                                <div class="panel-body policy">
                                    <div class="form-group ">
                                        <label for="" class="control-label col-md-4" style="color: #0090d9;">For Store : </label>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('heading_privacyPage'); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a target="_new" href="<?php echo base_url(); ?>/appWebPages/Store/Privacyen.html">Preview</a>
                                             </label>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        <textarea name="privacyen" class="terms"><?PHP echo $allData['privacyObj']['en']; ?></textarea>
                                            <script>
                                                CKEDITOR.replace('privacyen');
                                            </script>
                                        </div>
                                    </div>
                                    <br><br>
                                    <?php foreach ($language as $val) {
                                            if ($val['Active'] == 1) { ?>
                                        <div class="form-group policy">
                                            <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('heading_privacyPage'); ?> (<?php echo $val['lan_name']; ?>)
                                                 &nbsp;&nbsp;&nbsp;&nbsp;
                                                 <!-- <a target="_new" href="<?php echo base_url(); ?>/appWebPages/Customer/Privacy<?php echo $val['langCode']; ?>.html">Preview</a> -->
                                                  </label>
                                        </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        <textarea name="privacy<?= $val['langCode']  ?>" class="terms"><?PHP    echo $allData['privacyObj'][$val['langCode']];  ?></textarea>
                                            <script>
                                                CKEDITOR.replace('privacy<?php echo $val['langCode']  ?>');
                                            </script>
                                        </div>
                                    </div>
                                       
                                    <?php }else{ ?>
                                    <div class="form-group policy" style="display:none;">
                                            <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('heading_privacyPage'); ?> (<?php echo $val['lan_name']; ?>)
                                                 &nbsp;&nbsp;&nbsp;&nbsp;
                                                 <!-- <a target="_new" href="<?php echo base_url(); ?>/appWebPages/Customer/Privacy<?php echo $val['langCode']; ?>.html">Preview</a> -->
                                                  </label>
                                        </div>
                                    
                                    <div class="form-group" style="display:none;">
                                        <div class="col-sm-12">
                                        <textarea name="privacy<?= $val['langCode'] ?>" class="terms"><?PHP     echo $allData['privacyObj'][$val['langCode']];  ?></textarea>
                                            <script>
                                                CKEDITOR.replace('privacy<?php echo $val['langCode']; ?>');
                                            </script>
                                        </div>
                                    </div>
                                    <?php }} ?>
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
