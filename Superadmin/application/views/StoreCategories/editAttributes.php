
<style>
    .MandatoryMarker{
        color: red;
    }

    .form-horizontal .form-group {
        margin-left: 13px;
    }

    .ui-autocomplete {
        z-index: 5000;
    }

    #selectedcity, #companyid {
        display: none;
    }

    .ui-menu-item {
        cursor: pointer;
        background: black;
        color: white;
        border-bottom: 1px solid white;
        width: 200px;
    }
    span.abs_text {
        position: absolute;
        right:0px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    .pos_relative2{
        padding-right:10px
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .marginSet{
        margin-right: 25px;
    }
    .removeButton{
        margin-left: 10px;
        margin-top: 5px;
    }
    .redClass{
        color:red;
    }
    .btn{
        border-radius: 25px;
    }


</style>

<script>
    var selectedsize = [];
//here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function submitform()
    {
        $('#finishbutton').prop('disabled', false);
        $(".error-box").text("");
        var name = $('#name_0').val();
        var title = $('.productTitle').val();
        if (name == '' || name == null) {
            $('#name_0').focus();
            $('#text_name').text('Please enter the name');
        } else if (title == '' || title == null) {
            $('#productTitle').focus();
            $('#text_productCustomText').text('Enter title');
        } else {
            $('#finishbutton').prop('disabled', true);
            $('#addentity').submit();
        }



    }

</script>

<script>

    var OnlymobileNo;
    var CountryCodeMobileNo;
    var expanded = false;
    var expanded1 = false;
    function isNumberKey(evt)
    {
        $("#mobify").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            $("#mobify").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }
    function redirectToDest() {
        window.location.href = "<?php echo base_url(); ?>index.php?/CentralController";
    }

    $(document).ready(function () {
        $('#finishbutton').prop('disabled', false);
        $('.error-box-class ').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class ').change(function () {
            $('.error-box').text('');
        });
        $("#name").keypress(function (event) {
            var inputValue = event.which;
            if ((inputValue > 64 && inputValue < 91) // uppercase
                    || (inputValue > 96 && inputValue < 123) // lowercase
                    || inputValue == 32) { // space
                return;
            }
            event.preventDefault();
        });
    });</script>

<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
        <li><a href="<?php echo base_url(); ?>index.php?/StoreCategoryController/attributes/<?php echo $name?>/<?php echo $id?>" class=""><?php echo $this->lang->line('LIST_ATTRIBUTES'); ?></a></li>
        <li style="width: 100px"><a href="#" class="active"><?php echo $this->lang->line('heading_edit'); ?></a></li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class=" bg-white" data-pages="parallax">
            <div class="inner"></div>

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="navbar-collapsible"  class="navbar-collapse collapse m-t-50">
                    <!-- Nav tabs -->

                    <div class="row"><br></div>

                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form"
                          action="<?php echo base_url(); ?>index.php?/StoreCategoryController/operationCategory/editAttributeData/<?php echo $dataId; ?>"
                          method="post" enctype="multipart/form-data" onsubmit="return redirectToDest()">

                        <div class="tab-content">

                            <div class="row row-same-height">

                                <div class="form-group pos_relative2">
                                    <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_GroupName'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                                    <div class="col-sm-6 pos_relative2">

                                        <input type="text" id="name_0" name="name[en]" required="required" value="<?php echo $addOnData['name']['en'] ?>" class="error-box-class  form-control">

                                    </div>
                                    <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                </div>
                                <?php
                                foreach ($language as $val) {
                                    if ($val['Active'] == 1) {
                                        ?>
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_GroupName'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['langCode'] ?>]" value="<?php echo $addOnData['name'][$val['langCode']] ?>" 
                                                       required="required" class="error-box-class  form-control">

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_name"></div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group pos_relative2" style="display:none;">
                                            <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_GroupName'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['langCode'] ?>]" value="<?php echo $addOnData['name'][$val['langCode']] ?>" 
                                                       required="required" class="error-box-class  form-control">

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_name"></div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>

                                <div class="form-group pos_relative2">
                                    <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Desc'); ?>  </label>
                                    <div class="col-sm-6 pos_relative2">

                                        <textarea id="description_0" name="description[en]"
                                                  required="required" class="error-box-class  form-control" style=" max-width: 100%;"><?php echo $addOnData['description']['en'] ?></textarea>

                                    </div>
                                    <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                </div>
                                <?php
                                foreach ($language as $val) {
                                    if ($val['Active'] == 1) {
                                        ?>
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Desc'); ?>  (<?php echo $val['lan_name']; ?>)</label>
                                            <div class="col-sm-6 pos_relative2">

                                                <textarea id="description" name="description[<?= $val['langCode']; ?>]"
                                                          required="required" class="error-box-class  form-control" style=" max-width: 100%;"><?php echo $addOnData['description'][$val['langCode']] ?></textarea>

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group pos_relative2" style="display:none">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Desc'); ?>  (<?php echo $val['lan_name']; ?>)</label>
                                            <div class="col-sm-6 pos_relative2">

                                                <textarea id="description" name="description[<?= $val['langCode']; ?>]"
                                                          required="required" class="error-box-class  form-control" style=" max-width: 100%;"><?php echo $addOnData['description'][$val['langCode']] ?></textarea>

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>

                                <hr/>
                                <div class="form-group">
                                    <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Sub_heading_Attributes'); ?></label>

                                </div>
                                <hr/>
                                <div class="form-group col-sm-12">

                                    <div id="customePriceMain">

                                        <div class="form-group pos_relative2 customPriceField1">

                                            <div class="customField">
                                                <div class="customPriceField" id="customePriceMain">

                                                </div>
                                            </div>
                                            <div class="col-sm-1" id="text_productTitleText">
                                                <input type="button" id="custom" value="Add" class="btn btn-default pull-right marginSet btn-primary" style="margin-right: -50px;border-radius: 25px;">

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_addOn"></div>


                                        </div>

                                    </div>
                                </div>

                            </div>
  
                            <script>

                                $.ajax({
                                    url: "<?php echo base_url(); ?>index.php?/StoreCategoryController/operationCategory/getAtrributesData/<?php echo $dataId; ?>",
                                            type: "POST",
                                            data: {productId: '<?php echo $dataId; ?>'},
                                            dataType: "JSON",
                                            beforeSend: function () {
                                            },
                                            success: function (response) {
                                               console.log(response);
                                                $.each(response.result, function (index, row) {
    
                                                    var len = $('.customPriceField').length-1;
                                                    var z = len + 1;
                                                    var y = z + 1;
                                                    var divElement1 = '<div class="customPriceField"><div class="form-group pos_relative2 customPriceField' + len + '">'
                                                            + '<label id="titleLabel' + len + '" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Attributes'); ?> ' + len+1 + ' </label>'
                                                            + '<div class="col-sm-3 pos_relative2">'
                                                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                                                            + '<input type="text" name="attributes[' + len + '][name][en]" value="' + row.name.en + '" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                                                            + '<input type="text" name="attributes[' + len + '][id]" value="' + row.id.$oid + '" class="form-control productTitle" id="title' + z + '"  style="display:none">'
                                                            + '</div>'
                                                            + '<div class=""></div>'
                                                            + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                                                            + '<span class="glyphicon glyphicon-remove"></span>'
                                                            + '</button>' 
                                                            + '</div>'
                                                            + '<?php 
                                foreach ($language as $val) {
                                    if ($val["Active"] == 1) {
                                        ?>'
                                                                    + '<div class="form-group pos_relative2 customPriceField' + len + '">'
                                                                    + '<label id="titleLabel' + len + '" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Attributes'); ?> ' + len+1 + ' (<?php echo $val['lan_name']; ?>)</label>'
                                                                    + '<div class="col-sm-3 pos_relative2">'
                                                                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                                                                    + '<input type="text" name="attributes[' + len + '][name][<?php echo $val['langCode']; ?>]" value="' + row.name.<?php echo $val['langCode']; ?> + '" class="form-control productTitle" id="title' + len + '"  placeholder="Enter title">'
                                                                  //  + '<input type="text" name="attributes[' + len + '][id][<?php echo $val['langCode']; ?>]" value="' + row.id.$oid + '" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                                                                    + '</div>'
                                                                    + '<div class=""></div>'
                                                                    + '</div>'
                                                                    + '<?php } else { ?>'
                                                                    + '<div class="form-group pos_relative2 customPriceField' + z + '" style="display:none">'
                                                                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Attributes'); ?> ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                                                                    + '<div class="col-sm-3 pos_relative2">'
                                                                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                                                                    + '<input type="text" name="attributes[' + len + '][name][<?php echo $val['langCode']; ?>]" value="' + row.name.<?php echo $val['langCode']; ?> + '" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                                                                   // + '<input type="text" name="attributes[' + len + '][name][<?php echo $val['langCode']; ?>]" value="' + row.id.$oid + '" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                                                                    + '</div>'
                                                                    + '<div class=""></div>'
                                                                    + '</div>'
                                                                    + '<?php
                                    }
                                }
                                ?>'
                                                            + '<div class="selectedsizeAttr row"></div></div>'

                                                    $('.customField').append(divElement1);
                                                });

                                            },
                                            error: function () {

                                            },
                                            cache: false,
                                            contentType: false,
                                            processData: false
                                        });
                            </script>


                            <div class="padding-20 bg-white col-sm-9">
                                <ul class="pager wizard">

                                    <li class="" id="finishbutton">
                                        <button class="btn btn-success finishbutton pull-right" type="button" onclick="submitform()"><span><?php echo BUTTON_FINISH; ?></span></button>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <!--<input type="hidden" name="current_dt" id="time_hidden" value="" />-->

                    </form>
                </div>
            </div>
            <!-- END PANEL -->
        </div>

    </div>
    <!-- END JUMBOTRON -->

</div>
<!-- END PAGE CONTENT -->


<script>
    $(document).ready(function () {
        var arr = [];
        $(document).on('click', '#custom', function () {
            var len = $('.customPriceField').length-1;
            var z = len + 1;

            var y = z + 1;
            var divElement1 = '<div class="customPriceField"><div class="form-group pos_relative2 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Attributes'); ?> ' + z + ' </label>'
                    + '<div class="col-sm-3 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="attributes[' + len + '][name][en]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + '<div class=""></div>'
                    + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                    + '<span class="glyphicon glyphicon-remove"></span>'
                    + '</button>'
                    + '</div>'
                    + '<?php
                                foreach ($language as $val) {
                                    if ($val["Active"] == 1) {
                                        ?>'
                            + '<div class="form-group pos_relative2 customPriceField' + z + '">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Attributes'); ?> ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                            + '<div class="col-sm-3 pos_relative2">'
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="attributes[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                            + '</div>'
                            + '<div class=""></div>'
                            + '</div>'
                            + '<?php } else { ?>'
                            + '<div class="form-group pos_relative2 customPriceField' + z + '" style="display:none">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Attributes'); ?> ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                            + '<div class="col-sm-3 pos_relative2">'
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="attributes[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                            + '</div>'
                            + '<div class=""></div>'
                            + '</div>'
                            + '<?php
                                    }
                                }
                                ?>'
                    + '</div>'

            $('.customField').append(divElement1);
        });
        function renameUnitsLabels() {
            for (var j = 0, length = $('.customPriceField').length; j < length; j++) {
                $('.customPriceField>label').eq(j).text('Units ' + (j + 2) + ' *');
            }
        }

        $('body').on('click', '.btnRemove', function () {
            var count = $('.customPriceField').length - 1;
            if (count > 1) {
                $(this).parent().parent().remove();
                renameUnitsLabels();
            } else {
                $('#text_addOn').text('can not remove');
            }
        });
    });

</script>
<div id="errorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p class="modalPopUpText" style="color:#0090d9;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>