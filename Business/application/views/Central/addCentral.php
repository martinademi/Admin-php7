
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
        border-radius: 25px !important;
        font-size:10px !important;
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
        }  else {
            $('#finishbutton').prop('disabled', true);

            $('#addentity').submit();
        }



    }

    //ajax to fill form
      $(document).ready(function(){

        $.ajax({
           
            url:"<?php echo base_url()?>index.php?/CentralController/getCentralDetail/" + "<?php echo $addCentralId ?>",
            type:'POST',
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            data: '',          

        }).done(function(json){
                console.log('details********',json);
                $('#name_0').val(json.name.en);
                $('#description_0').val(json.name.en);


                $.each(json.addOns,function(index,row){


                   
                    var len = $('.customPriceField').length;
            var z = len ;
           
            var y = z + 1;
                    //verify
            var divElement1 = '<div class="customPriceField"><div class="form-group pos_relative2 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label"> <?php echo $this->lang->line('label_AddOns'); ?> ' + z + ' <span style="" class="MandatoryMarker"> *</span> </label>'
                    + '<div class="col-sm-2 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="addOns['+len+'][name]" value="'+row.name.en+'" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + '<div class="col-sm-2 pos_relative2">'
                    +'<span  class="abs_text"><b><?php echo $currencySymbol ?></b></span>'
                    +'<input type="text" name="addOns['+len+'][price]" class="error-box-class  form-control productTitle" id="currency0"  placeholder="Currency">'
                    +'</div>'
                    + '<div class=""></div>'
                    + '<button style="display:none" type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                    + '<span class="glyphicon glyphicon-remove"></span>'
                    + '</button>'
                    + '</div>'
                  
                    + '<div class="selectedsizeAttr row"></div></div>'

//                            + '</div><div class="selectedsizeAttr row"></div>'

            $('.customField').append(divElement1);


                });
                
                


        });

    });

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


    });
</script>

<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
        <li><a href="<?php echo base_url(); ?>index.php?/CentralController" class=""><?php echo $this->lang->line('LIST_CENTRAL'); ?></a></li>
        <li style="width: 100px"><a href="#" class="active"><?php echo $this->lang->line('heading_add'); ?></a></li>
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
                          action="<?php echo base_url(); ?>index.php?/CentralController/AddNewCentral"
                          method="post" enctype="multipart/form-data" onsubmit="return redirectToDest()">

                        <div class="tab-content">

                            <div class="row row-same-height">

                                <div class="form-group pos_relative2">
                                    <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_Name'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                                    <div class="col-sm-6 pos_relative2">

                                        <input type="text" id="name_0" name="name[en]" required="required" class="error-box-class  form-control">

                                    </div>
                                    <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                </div>
                                <?php
                                foreach ($language as $val) {
                                    if ($val['Active'] == 1) {
                                        ?>
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['langCode'] ?>]"
                                                       required="required" class="error-box-class  form-control">

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_name"></div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group pos_relative2" style="display:none;">
                                            <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['langCode'] ?>]"
                                                       required="required" class="error-box-class  form-control">

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_name"></div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>

                                <div class="form-group pos_relative2">
                                    <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Description'); ?> </label>
                                    <div class="col-sm-6 pos_relative2">

                                        <textarea id="description_0" name="description[en]"
                                                  required="required" class="error-box-class  form-control" style=" max-width: 100%;"></textarea>

                                    </div>
                                    <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                </div>
                                <?php
                                foreach ($language as $val) {
                                    if ($val['Active'] == 1) {
                                        ?>
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                            <div class="col-sm-6 pos_relative2">

                                                <textarea id="description" name="description[<?= $val['langCode']; ?>]"
                                                          required="required" class="error-box-class  form-control" style=" max-width: 100%;"></textarea>

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group pos_relative2" style="display:none">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                            <div class="col-sm-6 pos_relative2">

                                                <textarea id="description" name="description[<?= $val['langCode']; ?>]"
                                                          required="required" class="error-box-class  form-control" style=" max-width: 100%;"></textarea>

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>

                                 <div class="form-group ">
                                        <label for="fname" class="col-sm-2  control-label"> Quantity Limits <span style="color:red;font-size: 18px"></span></label>
                                        <div class="col-sm-6" style="margin-top:10px;">  
                                            <input type="text"   id="quantitylimit" name="quantityLimit" value="<?PHP echo $AddonDetails['quantityLimit'] ?>" class="form-control error-box-class" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Mandatory</label>
                                        <div class="col-sm-6">
                                            <?PHP
                                            if ($AddonDetails['mandatory'] == '1') {
                                                echo ' <input type="checkbox" name="mandatory" value="1" checked>';
                                            } else {
                                                echo ' <input type="checkbox" name="mandatory" value="1">';
                                            }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Multiple</label>
                                        <div class="col-sm-6">
                                            <?PHP
                                            if ($AddonDetails['multiple'] == '1') {
                                                echo ' <input type="checkbox" name="multiple" value="1" checked>';
                                            } else {
                                                echo ' <input type="checkbox" name="multiple" value="1">';
                                            }
                                            ?>

                                        </div>

                                    </div>

                                <hr/>
                                <div class="form-group">
                                    <label for="fname" class="col-sm-2 control-label"><?php echo 'ADD-ONS'; ?></label>

                                </div>
                                <hr/>
                                <div class="customField ">
                                    <div class="customPriceField" id="customePriceMain">

                                        <div class="form-group pos_relative2 customPriceField1">
                                           

                                            <div class="col-sm-1" id="text_productTitleText">
                                                <input type="button" id="custom" value="Add" class="btn btn-default pull-right marginSet btn-primary" >

                                            </div>
                                            <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>
                                        </div>



                                    </div>
                                </div>

                            </div>


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

            var len = $('.customPriceField').length;
           // var len=1;
            //verify
            var z = len ;
           // console.log(z);
            var y = z + 1;
            var divElement1 = '<div class="customPriceField"><div class="form-group pos_relative2 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AddOns'); ?> ' + z + ' <span style="" class="MandatoryMarker"> *</span> </label>'
                    + '<div class="col-sm-2 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="addOns['+len+'][name]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + '<div class="col-sm-2 pos_relative2">'
                    +'<span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    +'<input type="text" name="addOns['+len+'][price]" class="error-box-class  form-control productTitle" id="currency0"  placeholder="Currency">'
                    +'</div>'
                    + '<div class=""></div>'
                    + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                    + '<span class="glyphicon glyphicon-remove"></span>'
                    + '</button>'
                    + '</div>'
                  
                    + '<div class="selectedsizeAttr row"></div></div>'

//                            + '</div><div class="selectedsizeAttr row"></div>'

            $('.customField').append(divElement1);

        });

        function renameUnitsLabels() {
            for (var j = 0, length = $('.customPriceField').length; j < length; j++) {
                $('.customPriceField>label').eq(j).text('Units ' + (j + 2) + ' *');


            }
        }

        $('body').on('click', '.btnRemove', function () {
            $(this).parent().parent().remove();
            renameUnitsLabels();
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