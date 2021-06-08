<?php
$data = $helpText;
if ($scat_id != '') {
    foreach ($helpText['sub_cat'] as $val) {
        if ($scat_id == (String) $val['scat_id']) {
            $val['has_scat'] = false;
            $data = $val;
            break;
        }
    }
}
$ttl_cat = '';
$landis = '';
if ($scat_id != '') {
    $ttl_cat = 'Sub ';
    $landis = 'disabled';
}
$elan = array();
$elang = array();
$data1 = $helpText;
foreach ($data1['name'] as $ind => $val)
    array_push($elan, $ind);

foreach ($language as $val)
    if (array_search($val['lan_id'], $elan) != false)
        array_push($elang, $val);
?>
<script src="<?= base_url() ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script>
//    $('.sm-table').find('.header-inner').html('<div class="brand inline" style="  width: auto;\
//                     font-size: 27px;\
//                     color: gray;\
//                     margin-left: 100px;margin-right: 20px;margin-bottom: 12px; margin-top: 10px;">\
//                    <strong><?= Appname ?> Super Admin Console</strong>\
//                </div>');

    var inputtextId = 1;
    $(document).ready(function () {
        var data = <?= json_encode($data1) ?>;
        var elan = <?= json_encode($elan) ?>;
        var lan = <?= json_encode($elang) ?>;

        $.each(lan, function (ind, val) {
            if (typeof data.name[val.lan_id] == 'undefined')
                    data.name[val.lan_id] = '';
            var html = '<div class="form-group form-group-default required cat_lan_' + val.lan_id + '">\
                            <label><?= $ttl_cat ?>Category (' + val.lan_name + ')</label>\
                            <input type="text" required name="cat_name[' + val.lan_id + ']" id="cat_name_' + val.lan_id + '" value="" class="form-control" >\
                        </div>';
            $(html).insertAfter($('.maincat'));
        });
        $('#cat_name').val(data.name[0]);
        if (data.has_scat == false) {
            $('#desc_name').val(data.desc[0]);
            $.each(lan, function (ind, val) { 
                if (typeof data.desc[val.lan_id] == 'undefined')
                    data.desc[val.lan_id] = '';
                var html = '<div class="form-group form-group-default required cat_lan_' + val.lan_id + '">\
                            <label>Description (' + val.lan_name + ')</label>\
                            <textarea required name="desc[' + val.lan_id + ']" id="desc_name[' + val.lan_id + ']"  value="" class="form-control nhas_scat" rows="5"></textarea>\
                        </div>';
                $(html).insertAfter($('.maindesc'));
                  CKEDITOR.replace('desc[' + val.lan_id + ']');
            });
        }
        $.each(lan, function (ind, val) {
            if (elan.indexOf(val.lan_id) != -1) {

            }
        });
        $('#cat_subcat').change(function () {
            if ($(this).is(':checked')) {
                $('.has_scat').fadeOut('slow');
                $('.nhas_scat').removeAttr('required');
            } else {
                $('.has_scat').fadeIn('slow');
                $('.nhas_scat').attr('required', '');
            }
        });
        $('#cat_subcat').trigger('change');
        $('#cat_hform').change(function () {
            if ($(this).is(':checked')) {
                $('#has_form').fadeIn('slow');
            } else {
                $('#has_form').fadeOut('slow');
//                $('#cat_form_fields').html('');
            }
        });
        $('#cat_hform').trigger('change');
        $('.lan_check').change(function () {
            if ($(this).is(':checked')) {
                var html = '<div class="form-group form-group-default required cat_lan_' + $(this).val() + '">\
                            <label><?= $ttl_cat ?>Category (' + $(this).attr('data-id') + ')</label>\
                            <input type="text" required name="cat_name[' + $(this).val() + ']" id="cat_name" class="form-control" >\
                        </div>';
                $(html).insertAfter($('.maincat'));
                html = '<div class="form-group form-group-default required cat_lan_' + $(this).val() + '">\
                            <label>Description (' + $(this).attr('data-id') + ')<a target="_new" href="http://192.241.153.106/app_configs/.html">Preview</a></label>\
                            <textarea required name="desc[' + val.lan_id + ']" id="desc_name" class="form-control nhas_scat" rows="5" value=""></textarea>\
                        </div>';
                $(html).insertAfter($('.maindesc'));
               CKEDITOR.replace('desc[' + val.lan_id + ']');

                var val = this;
                $('.main_field').each(function () {
                    html = '<div class="row cat_lan_' + $(val).val() + '">\
                            <div class="form-group form-group-default required col-sm-5" style="padding:7px 4px 12px 12px !important;">\
                                <label>Label Name (' + $(val).attr('data-id') + ')</label>\
                                <input type="text" class="form-control" name="lbl[' + $(this).attr('data-id') + '][' + $(val).val() + ']" required>\
                            </div>\
                        </div>';
                    $(html).insertAfter(this);
                });
            } else {
                $('.cat_lan_' + $(this).val()).remove();
            }
            $('#cat_subcat').trigger('change');
        });
        $('#add_new_field').click(function () {
            $('#cat_form_fields').append('\
                <div class="row main_field" style="margin-top:10px;" data-id="' + inputtextId + '">\
                    <div class="form-group form-group-default required col-sm-5" style="padding:7px 4px 12px 12px !important;">\
                        <label>Label Name (English)</label>\
                        <input type="text" class="form-control" name="lbl[' + inputtextId + '][0]" required>\
                    </div>\
                    <div class="form-group form-group-default required col-sm-4" style="padding:7px 4px 12px 12px !important;">\
                        <label>Data Type</label>\
                        <select class="form-control" id="dtype[' + inputtextId + ']" name="dtype[' + inputtextId + ']">\
                            <option value="0">Text</option>\
                            <option value="1">Date</option>\
                        </select>\
                    </div>\
                    <div class="col-sm-3 checkbox" style="padding:7px 4px 12px 12px !important;">\
                        <input type="checkbox" value="1" name="Mand[' + inputtextId + ']" id="Mand[' + inputtextId + ']" data="Mand[' + inputtextId + ']" class="mandatory_or_not">\
                        <label for="Mand[' + inputtextId + ']">Mandatory</label>\
                    </div>\
                </div>');
            $('.lan_check').each(function () {
                if ($(this).is(':checked')) {
                    $('#cat_form_fields').append('\
                                <div class="row cat_lan_' + $(this).val() + '">\
                                    <div class="form-group form-group-default required col-sm-5" style="padding:7px 4px 12px 12px !important;">\
                                        <label>Label Name (' + $(this).attr('data-id') + ')</label>\
                                        <input type="text" class="form-control" name="lbl[' + inputtextId + '][' + $(this).val() + ']" required>\
                                    </div>\
                                </div>');
                }
            });
            
            inputtextId++;
        });
    });
</script>

<style>
    .header{
        height:60px !important;
    }
    .header h3{
        margin:10px 0 !important;
    }
    .rating>.rated {
        color: #10cfbd;
    }
    .social-user-profile {
        width: 83px;
    }
    .table > thead > tr > th{
        font-size: 14px;
    }
    textarea.form-control {
        height: 100px !important;
    }
</style>

<div class="content">
    <div class="" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            <div class="inner" style="transform: translateY(0px); opacity: 1;">
                <h3 class="">Page Title</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid container-fixed-lg">
        <ul class="breadcrumb" style="padding: 10px 5px;background: white;">
            <li>
                <a class="active" href="<?= base_url() ?>index.php?/utilities/supportText">Support Text</a>
            </li>
            <li>
                <a href="#" class="active">
                    Edit <?= $ttl_cat ?>Category
                </a>
            </li>
        </ul>
        <div class="container-md-height m-b-20">
            <div class="panel panel-default" style="border:0;">
                <form action="<?= base_url() ?>index.php?/utilities/support_action" method='post'>
                    <div class="panel-heading">
                        <div class="panel-title">
                        </div>
                        <div class="panel-body no-padding">
                            <div class="form-group-attached">
                                
                              <?php foreach($helpText as $data){?>
                                <div class='col-sm-12'>
                                    <div class='col-sm-3'>
                                        <div class="checkbox check-success disabled">
                                            <input type="checkbox" value="0" id="checkbox0" data-id='English' disabled checked>
                                            <label for="checkbox0">English</label>
                                        </div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        $s = '';
                                        if (array_search($val['lan_id'], $elan) != false) {
                                            array_push($elang, $val);
                                            $s = 'checked';
                                        }
                                        ?>
                                        <div class='col-sm-3'>
                                            <div class="checkbox check-success <?= $landis ?>">
                                                <input <?= $s ?> type="checkbox" class='lan_check' value="<?= $val['lan_id'] ?>" id="checkbox<?= $val['lan_id'] ?>" data-id='<?= $val['lan_name'] ?>' <?= $landis ?>>
                                                <label for="checkbox<?= $val['lan_id'] ?>"><?= $val['lan_name'] ?></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                               
                                <div class='col-sm-6'>
                                    <div class="form-group form-group-default required maincat">
                                        <label><?= $ttl_cat ?>Category (English)</label>
                                        <input type="text" required name='cat_name[0]' id="cat_name" class="form-control" value='<?=$data['name'][0]?>'>
                                        <input type="hidden" name='edit_id' id='edit_id' value='<?= $edit_id ?>'>
                                        <input type="hidden" name='cat_id' id='cat_id' value='<?= $edit_id ?>'>
                                        <input type="hidden" name='scat_id' id='scat_id' value='<?= $scat_id ?>'>
                                    </div>
                                    <?php
                                    if ($scat_id == '') {
                                        $s = '';
                                        if ($data['has_scat'] == true) {
                                            $s = 'checked';
                                        }
                                        ?>
                                        <div class="form-group form-group-default input-group">
                                            <label>
                                                Has Sub-Categories
                                            </label>
                                            <span class="input-group-addon bg-transparent">
                                                <input <?= $s ?> type="checkbox" data-init-plugin="switchery" data-size="small" data-color="primary" name="cat_subcat" id="cat_subcat"/>
                                            </span>
                                        </div>
<?php } ?>
                                    <div class='has_scat'>
                                        <div class="form-group form-group-default required maindesc">
                                            <label>Description (English)<a target="_new" href="<?php echo base_url();?>app_configs/'.html">Preview</a></label>
                                            <textarea required name="desc[0]" id="desc_name" class="form-control nhas_scat" rows="5" value="<?php echo $data['desc'][0]?>"></textarea>
                                             <script>
                                                    CKEDITOR.replace('desc[0]');

                                                </script>
                                        </div>
                                    </div>
                                </div>
                              <?php }?>
                            </div>
                        </div>
                        <div class="panel-footer bg-white">
                            <div class='row'>
                                <button class='btn btn-primary pull-right' type='submit' name='add_new_cat'>
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>