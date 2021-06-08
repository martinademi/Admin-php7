<style>
    .rating>.rated {
        color: #10cfbd;
    }
    span.RemoveMore{
        margin-left: 8px;cursor: pointer;
    }

    .oneStartDesc,.secondStartDesc,.thirdStarDesc,.fourthStarDesc,.fiveStarDesc {
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        display: inline-block;
        padding: 4px 6px;
        color: #555;
        vertical-align: middle;
        border-radius: 4px;
        max-width: 100%;
        line-height: 22px;
        cursor: text;
        width: 100%;
    }
    span.tag {
        padding:9px 10px;
        background-color: #5bc0de;
        font-size:10px;
    }


    .label-info {
        background-color: #5bc0de;
    }


    .startDesc{
        height: 28px;
        padding: 6px;
        display: inline-flex;
        margin: 0px 1px 1px;
        font-weight: 600;
        /*background: #5bc0de;*/
        border: 1px solid;
        border-radius: 4px;
        /*width: 100%;*/
        max-width:400px
    }
    .inputDesc {
        width: 100%;
        min-width:15px!important;
        max-width:400px!important;
        border: none;
    }
    td span {
        line-height:0px !important;
    }

    .tag:after {
        display: none;
    }

</style>

<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <ul class="breadcrumb" style="background:white;margin-top: 4%;">
            <li><a class="active" href="<?php echo base_url(); ?>index.php?/parametersController" class=""><?php
                    print_r(strtoupper($appConfig['pName'][0]));
                    ?></a> </li>
            <li style="width: 70%"><a href="javascript:history.go(0);" class="active">
                    CONFIGURE
                </a>
            </li>
        </ul>

        <div class="">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                </div>
                                &nbsp;
                                <div class="panel-body">

                                    <div class="form-group col-md-1"></div>
                                    <div class="col-md-9">
                                        <form id="updateDriverRating" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/parametersController/updateDriverRating"  enctype="multipart/form-data">
                                            <input type="hidden" id="parameterId" name="parameterId" value="<?php echo $parameterId; ?>" />
                                            <table class="table table-striped table-bordered dataTable no-footer">
                                                <thead>
                                                    <tr>

                                                        <th style="text-align: center; width:90px;">RATING</th>
                                                        <th style="text-align: center;">DESCRIPTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="doc_body">

                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <p class="rating">
                                                                <?php
                                                                for ($count = 0; $count < 1; $count++)
                                                                    echo '<i class="fa fa-star rated"></i>';
                                                                ?>

                                                            </p>
                                                        </td>
                                                        <td>
                                                            <div class="form-group"><div class="oneStartDesc" style="padding-left: 1%;"></div></div>

                                                            <br>
                                                            <div class="form-group">
                                                                <div class="col-sm-6">
                                                                    <br><label>ENGLISH</label>
                                                                    <input id="OneStartDesc"  class="form-control" type="text">
                                                                    <?php
                                                                    foreach ($language as $lang) {
                                                                        if ($lang['Active'] == 1) {
                                                                            ?>
                                                                            <br><label><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input id="<?php echo $lang['langCode']; ?>_OneStartDesc"  class="form-control" type="text">
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <br><label style="display: none;"><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input style="display: none;" id="<?php echo $lang['langCode']; ?>_OneStartDesc"  class="form-control" type="text">
                                                                        <?php }
                                                                    } ?>
                                                                </div>
                                                                <div class="col-sm-2" style=" margin-top: 37px;">
                                                                    <button type="button" class="btn btn-primary cls110" data-id="OneStartDesc" id="addOneStartDesc">ADD</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <p class="rating">
                                                                <?php
                                                                for ($count = 0; $count < 2; $count++)
                                                                    echo '<i class="fa fa-star rated"></i>';
                                                                ?>

                                                            </p>
                                                        </td>
                                                        <td>
                                                            <div class="form-group"><div class="secondStartDesc" style="padding-left: 1%;"></div></div>
                                                            <br>
                                                            <div class="form-group">
                                                                <div class="col-sm-6">
                                                                    <br><label>ENGLISH</label>
                                                                    <input id="SecondStartDesc" class="form-control" type="text">
                                                                    <?php
                                                                    foreach ($language as $lang) {
                                                                        if ($lang['Active'] == 1) {
                                                                            ?>
                                                                            <br><label><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input id="<?php echo $lang['langCode']; ?>_SecondStartDesc"  class="form-control" type="text">
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <br><label style="display: none;"><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input  style="display: none;" id="<?php echo $lang['langCode']; ?>_SecondStartDesc"  class="form-control" type="text">
    <?php }
} ?>
                                                                </div>
                                                                <div class="col-sm-2" style=" margin-top: 37px;">
                                                                    <button type="button" class="btn btn-primary cls110" data-id="SecondStartDesc" id="addSecondStartDesc">ADD</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <p class="rating">
                                                                <?php
                                                                for ($count = 0; $count < 3; $count++)
                                                                    echo '<i class="fa fa-star rated"></i>';
                                                                ?>

                                                            </p>
                                                        </td>
                                                        <td>
                                                            <div class="form-group"><div class="thirdStarDesc" style="padding-left: 1%;"></div></div>
                                                            <br>
                                                            <div class="form-group">
                                                                <div class="col-sm-6">
                                                                    <br><label>ENGLISH</label>
                                                                    <input id="ThirdStarDesc" class="form-control" type="text">
                                                                    <?php
                                                                    foreach ($language as $lang) {
                                                                        if ($lang['Active'] == 1) {
                                                                            ?>
                                                                            <br><label><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input id="<?php echo $lang['langCode']; ?>_ThirdStarDesc"  class="form-control" type="text">
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <br><label  style="display: none;"><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input  style="display: none;" id="<?php echo $lang['langCode']; ?>_ThirdStarDesc"  class="form-control" type="text">
    <?php }
} ?>
                                                                </div>
                                                                <div class="col-sm-2" style=" margin-top: 37px;">
                                                                    <button type="button" class="btn btn-primary cls110" data-id="ThirdStarDesc" id="addThirdStartDesc">ADD</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <p class="rating">
                                                                <?php
                                                                for ($count = 0; $count < 4; $count++)
                                                                    echo '<i class="fa fa-star rated"></i>';
                                                                ?>

                                                            </p>
                                                        </td>
                                                        <td>
                                                            <div class="form-group"><div class="fourthStarDesc" style="padding-left: 1%;"></div></div>
                                                            <br>
                                                            <div class="form-group">
                                                                <div class="col-sm-6">
                                                                    <br><label>ENGLISH</label>
                                                                    <input id="FourthStarDesc" class="form-control" type="text">
                                                                    <?php
                                                                    foreach ($language as $lang) {
                                                                        if ($lang['Active'] == 1) {
                                                                            ?>
                                                                            <br><label><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input id="<?php echo $lang['langCode']; ?>_FourthStarDesc"  class="form-control" type="text">
        <?php
    } else {
        ?>
                                                                            <br><label style="display: none;"><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input style="display: none;" id="<?php echo $lang['langCode']; ?>_FourthStarDesc"  class="form-control" type="text">
    <?php }
} ?>
                                                                </div>
                                                                <div class="col-sm-2" style=" margin-top: 37px;">
                                                                    <button type="button" class="btn btn-primary cls110" data-id="FourthStarDesc" id="addFourthStartDesc">ADD</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <p class="rating">
<?php
for ($count = 0; $count < 5; $count++)
    echo '<i class="fa fa-star rated"></i>';
?>

                                                            </p>
                                                        </td>
                                                        <td>
                                                            <div class="form-group"><div class="fiveStarDesc" style="padding-left: 1%;"></div></div>
                                                            <br>
                                                            <div class="form-group">

                                                                <div class="col-sm-6">
                                                                    <br><label>ENGLISH</label>
                                                                    <input id="FiveStartDesc" class="form-control" type="text">
<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                                                                            <br><label><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input id="<?php echo $lang['langCode']; ?>_FiveStartDesc"  class="form-control" type="text">
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <br><label style="display: none;"><?php echo strtoupper($lang['lan_name']); ?></label>
                                                                            <input style="display: none;" id="<?php echo $lang['langCode']; ?>_FiveStartDesc"  class="form-control" type="text">
    <?php }
} ?>
                                                                </div>
                                                                <div class="col-sm-2" style=" margin-top: 37px;">
                                                                    <button type="button" class="btn btn-primary cls110" data-id="FiveStartDesc" id="addFiveStartDesc">ADD</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </form>

                                        <div class="form-group">
                                            <label for="" class="control-label col-md-4"></label>
                                            <div class="col-sm-6">
                                                <button type="button" class="btn btn-success cls111" id="save">Update</button>
                                            </div>
                                            <div class="col-sm-2"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<script>
    var counter = 0;
    var desc = '';
    var langInput = '';

    $(document).ready(function ()
    {

        var desc = '';
        var langInput = '';
<?php
//------------------------------------------------------------------------------------
//One star rating
for ($index = 0; $index < count($appConfig['attributes']['en']['1']); $index++) {
    $desc = '';

    foreach ($language as $lang) {
        if ($lang['Active'] == 1) {
            $desc .= ' ' . $appConfig['attributes'][$lang['langCode']]['1'][$index];
            $desc .= ',';
            $rateDesc = $appConfig['attributes'][$lang['langCode']]['1'][$index];
            ?>
                    langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_OneStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $rateDesc; ?>">';
            <?php
        }
    }
    ?>
    <?php
    $englishText = $appConfig['attributes']['en']['1'][$index]; //Default english text
    ?>
            desc = '<?php echo rtrim($desc, ','); ?>';
            var engText1 = "<?php echo htmlspecialchars($englishText) ; ?>";

            $('.oneStartDesc').append("<span class='tag label label-info' id='addOneStartDesc" + counter + "'>"+ engText1 + "(" + desc + ")" + langInput + "<input  style='display:none;' name='OneStartDesc[]' class='inputDesc'  type='text'  value='<?php echo $englishText; ?>'><span class='RemoveMore' data-id='addOneStartDesc" + (counter++) + "' style=''>x</span></span>");
            langInput = '';
            desc = '';
    <?php
}
?>

<?php
//Two star rating
for ($index = 0; $index < count($appConfig['attributes']['en']['2']); $index++) {
    $desc = '';

    foreach ($language as $lang) {
        if ($lang['Active'] == 1) {
            $desc .= ' ' . $appConfig['attributes'][$lang['langCode']]['2'][$index];
            $desc .= ',';
            $rateDesc = $appConfig['attributes'][$lang['langCode']]['2'][$index];
            ?>
                    langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_SecondStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $rateDesc; ?>">';
            <?php
        }
    }
    ?>
    <?php
    $englishText = $appConfig['attributes']['en']['2'][$index]; //Default english text
    ?>
            desc = "<?php echo rtrim($desc, ','); ?>";
            var engText2 = "<?php echo htmlspecialchars($englishText); ?>";
            $('.secondStartDesc').append("<span class='tag label label-info' id='addSecondStartDesc" + counter + "'>"+ engText2 + "(" + desc + ")" + langInput + "<input  style='display:none;' name='SecondStartDesc[]' class='inputDesc'  type='text'  value='<?php echo $englishText; ?>'><span class='RemoveMore' data-id='addSecondStartDesc" + (counter++) + "' style=''>x</span></span>");

            langInput = '';
            desc = '';
    <?php
}
?>



<?php
//Three star rating
for ($index = 0; $index < count($appConfig['attributes']['en']['3']); $index++) {
    $desc = '';

    foreach ($language as $lang) {
        if ($lang['Active'] == 1) {
            $desc .= ' ' . $appConfig['attributes'][$lang['langCode']]['3'][$index];
            $desc .= ',';
            $rateDesc = $appConfig['attributes'][$lang['langCode']]['3'][$index];
            ?>
                    langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_ThirdStarDesc[]" class="inputDesc"  type="text"  value="<?php echo $rateDesc; ?>">';
            <?php
        }
    }
    ?>
    <?php
    $englishText = $appConfig['attributes']['en']['3'][$index]; //Default english text
    ?>
            desc = '<?php echo rtrim($desc, ','); ?>';
            var engText3 ="<?php echo htmlspecialchars($englishText); ?>";
            $('.thirdStarDesc').append("<span class='tag label label-info' id='addThirdStartDesc" + counter + "'>"+ engText3 + "(" + desc + ")" + langInput + "<input  style='display:none;' name='ThirdStarDesc[]' class='inputDesc'  type='text'  value='<?php echo $englishText; ?>'><span class='RemoveMore' data-id='addThirdStartDesc" + (counter++) + "' style=''>x</span></span>");


            langInput = '';
            desc = '';
    <?php
}
?>

<?php
//Four star rating
for ($index = 0; $index < count($appConfig['attributes']['en']['4']); $index++) {
    $desc = '';

    foreach ($language as $lang) {
        if ($lang['Active'] == 1) {
            $desc .= ' ' . $appConfig['attributes'][$lang['langCode']]['4'][$index];
            $desc .= ',';
            $rateDesc = $appConfig['attributes'][$lang['langCode']]['4'][$index];
            ?>
                    langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_FourthStarDesc[]" class="inputDesc"  type="text"  value="<?php echo $rateDesc; ?>">';
            <?php
        }
    }
    ?>
    <?php
    $englishText = $appConfig['attributes']['en']['4'][$index]; //Default english text
    ?>
            desc = '<?php echo rtrim($desc, ','); ?>';
            var engText4= "<?php echo htmlspecialchars( $englishText); ?>";
            $('.fourthStarDesc').append("<span class='tag label label-info' id='addFourthStartDesc" + counter + "'>"+ engText4 + "(" + desc + ")" + langInput + "<input  style='display:none;' name='FourthStarDesc[]' class='inputDesc'  type='text'  value='<?php echo $englishText; ?>'><span class='RemoveMore' data-id='addFourthStartDesc" + (counter++) + "' style=''>x</span></span>");

            langInput = '';
            desc = '';
    <?php
}
?>

<?php
//Five star rating
for ($index = 0; $index < count($appConfig['attributes']['en']['5']); $index++) {
    $desc = '';

    foreach ($language as $lang) {
        if ($lang['Active'] == 1) {
            $desc .= ' ' . $appConfig['attributes'][$lang['langCode']]['5'][$index];
            $desc .= ',';
            $rateDesc = $appConfig['attributes'][$lang['langCode']]['5'][$index];
            ?>
                    langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_FiveStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $rateDesc; ?>">';
            <?php
        }
    }
    ?>
    <?php
    $englishText = $appConfig['attributes']['en']['5'][$index]; //Default english text
    ?>
            desc = '<?php echo rtrim($desc, ','); ?>';
            var engText5 = "<?php echo htmlspecialchars($englishText); ?>";
            $('.fiveStarDesc').append("<span class='tag label label-info' id='addFiveStartDesc" + counter + "'>"+ engText5 + "(" + desc + ")" + langInput + "<input  style='display:none;' name='FiveStartDesc[]' class='inputDesc'  type='text'  value='<?php echo $englishText; ?>'><span class='RemoveMore' data-id='addFiveStartDesc" + (counter++) + "' style=''>x</span></span>");

            langInput = '';
            desc = '';
    <?php
}
?>
//------------------------------------------------------------------------------




//-------------------On click add rating----------------------------------------
        $('#addOneStartDesc').click(function ()
        {
            if ($('#OneStartDesc').val() == '')
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Input field should not be empty');
            } else {
                var desc = '';
                var langInput = '';
<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                        if ($('#<?php echo $lang['langCode']; ?>_OneStartDesc').val() != '')
                        {
                            desc += $('#<?php echo $lang['langCode']; ?>_OneStartDesc').val();
                            desc += ',';

                            langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id')).val() + '">';
                            $('#<?php echo $lang['langCode']; ?>_OneStartDesc').val('');//Blank it after
                        }
        <?php
    }
}
?>

                if (desc != '')
                    desc = '(' + desc.replace(/,\s*$/, "") + ')';

                counter += 1;
                $('.oneStartDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#OneStartDesc').val() + ' ' + desc + langInput + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');

                $('#OneStartDesc').val('');

            }
        });


        $('#addSecondStartDesc').click(function ()
        {
            if ($('#SecondStartDesc').val() == '')
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Input field should not be empty');
            } else {
                var desc = '';
                var langInput = '';
<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                        if ($('#<?php echo $lang['langCode']; ?>_SecondStartDesc').val() != '')
                        {
                            desc += $('#<?php echo $lang['langCode']; ?>_SecondStartDesc').val();
                            desc += ',';

                            langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id')).val() + '">';
                            $('#<?php echo $lang['langCode']; ?>_SecondStartDesc').val('');//Blank it after
                        }
        <?php
    }
}
?>

                if (desc != '')
                    desc = '(' + desc.replace(/,\s*$/, "") + ')';

                counter += 1;
                $('.secondStartDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#SecondStartDesc').val() + ' ' + desc + langInput + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');

                $('#SecondStartDesc').val('');

            }
        });


        $('#addThirdStartDesc').click(function ()
        {
            if ($('#ThirdStarDesc').val() == '')
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Input field should not be empty');
            } else {
                var desc = '';
                var langInput = '';
<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                        if ($('#<?php echo $lang['langCode']; ?>_ThirdStarDesc').val() != '')
                        {
                            desc += $('#<?php echo $lang['langCode']; ?>_ThirdStarDesc').val();
                            desc += ',';

                            langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id')).val() + '">';
                            $('#<?php echo $lang['langCode']; ?>_ThirdStarDesc').val('');//Blank it after
                        }
        <?php
    }
}
?>

                if (desc != '')
                    desc = '(' + desc.replace(/,\s*$/, "") + ')';

                counter += 1;
                $('.thirdStarDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#ThirdStarDesc').val() + ' ' + desc + langInput + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');

                $('#ThirdStarDesc').val('');

            }
        });


        $('#addFourthStartDesc').click(function ()
        {
            if ($('#FourthStarDesc').val() == '')
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Input field should not be empty');
            } else {
                var desc = '';
                var langInput = '';
<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                        if ($('#<?php echo $lang['langCode']; ?>_FourthStarDesc').val() != '')
                        {
                            desc += $('#<?php echo $lang['langCode']; ?>_FourthStarDesc').val();
                            desc += ',';

                            langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id')).val() + '">';
                            $('#<?php echo $lang['langCode']; ?>_FourthStarDesc').val('');//Blank it after
                        }
        <?php
    }
}
?>

                if (desc != '')
                    desc = '(' + desc.replace(/,\s*$/, "") + ')';

                counter += 1;
                $('.fourthStarDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#FourthStarDesc').val() + ' ' + desc + langInput + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');

                $('#FourthStarDesc').val('');

            }
        });


        $('#addFiveStartDesc').click(function ()
        {
            if ($('#FiveStartDesc').val() == '')
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Input field should not be empty');
            } else {
                var desc = '';
                var langInput = '';
<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                        if ($('#<?php echo $lang['langCode']; ?>_FiveStartDesc').val() != '')
                        {
                            desc += $('#<?php echo $lang['langCode']; ?>_FiveStartDesc').val();
                            desc += ',';

                            langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id')).val() + '">';
                            $('#<?php echo $lang['langCode']; ?>_FiveStartDesc').val('');//Blank it after
                        }
        <?php
    }
}
?>

                if (desc != '')
                    desc = '(' + desc.replace(/,\s*$/, "") + ')';

                counter += 1;
                $('.fiveStarDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#FiveStartDesc').val() + ' ' + desc + langInput + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');

                $('#FiveStartDesc').val('');

            }
        });


        $(document).on('click', '.RemoveMore', function ()
        {
            $('#' + $(this).attr('data-id')).remove();
        });

        $('#save').click(function ()
        {
            $('#updateDriverRating').submit();
        });
    });
</script>
