<style>
    .rating>.rated {
        color: #10cfbd;
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
        max-width: 100%;
    }
    .inputDesc {

        min-width:15px!important;
        max-width:400px!important;
        border: none;
    }
    td span {
        line-height:0px !important;
    }
    .RemoveMore  {
        color: #6185b0;height: 18px;
    }
</style>


<script>
    var counter = 0;

    $(document).ready(function ()
    {

        //Get Already updated Data
<?php
foreach ($appConfig['DriverRating']['1'] as $row) {
    ?>
            counter += 1;
            $('.oneStarDesc').append('<span class="startDesc" id="addOneStartDesc' + counter + '"><input name="OneStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><input type="button" value="&#10008"  data-id="addOneStartDesc' + counter + '" class="RemoveMore"></span>');
    <?php
}
?>
        //Get Already updated Data
<?php
foreach ($appConfig['DriverRating']['2'] as $row) {
    ?>
            counter += 1;
            $('.secondStartDesc').append('<span class="startDesc" id="addSecondStartDesc' + counter + '"><input name="SecondStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><input type="button" value="&#10008"  data-id="addSecondStartDesc' + counter + '" class="RemoveMore"></span>');
    <?php
}
?>
        //Get Already updated Data
<?php
foreach ($appConfig['DriverRating']['3'] as $row) {
    ?>
            counter += 1;
            $('.thirdStarDesc').append('<span class="startDesc" id="addThirdStartDesc' + counter + '"><input name="ThirdStarDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><input type="button" value="&#10008"  data-id="addThirdStartDesc' + counter + '" class="RemoveMore"></span>');
    <?php
}
?>
        //Get Already updated Data
<?php
foreach ($appConfig['DriverRating']['4'] as $row) {
    ?>
            counter += 1;
            $('.fourthStarDesc').append('<span class="startDesc" id="addFourthStartDesc' + counter + '"><input name="FourthStarDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><input type="button" value="&#10008"  data-id="addFourthStartDesc' + counter + '" class="RemoveMore"></span>');
    <?php
}
?>
        //Get Already updated Data
<?php
foreach ($appConfig['DriverRating']['5'] as $row) {
    ?>
            counter += 1;
            $('.fiveStarDesc').append('<span class="startDesc" id="addFiveStartDesc' + counter + '"><input name="FiveStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><input type="button" value="&#10008"  data-id="addFiveStartDesc' + counter + '" class="RemoveMore"></span>');
    <?php
}
?>


        $('#addOneStartDesc').click(function ()
        {
            if ($('#OneStartDesc').val() == '')
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Input field should not be empty');
            } else {
                counter += 1;
                $('.oneStarDesc').append('<span class="startDesc" id="' + $(this).attr('id') + counter + '"><input name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><input type="button" value="&#10008"  data-id="' + $(this).attr('id') + counter + '" class="RemoveMore"></span>');
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
                counter += 1;
                $('.secondStartDesc').append('<span class="startDesc" id="' + $(this).attr('id') + counter + '"><input name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><input type="button" value="&#10008"  data-id="' + $(this).attr('id') + counter + '" class="RemoveMore"></span>');
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
                counter += 1;
                $('.thirdStarDesc').append('<span class="startDesc" id="' + $(this).attr('id') + counter + '"><input name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><input type="button" value="&#10008"  data-id="' + $(this).attr('id') + counter + '" class="RemoveMore"></span>');
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
                counter += 1;
                $('.fourthStarDesc').append('<span class="startDesc" id="' + $(this).attr('id') + counter + '"><input name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><input type="button" value="&#10008"  data-id="' + $(this).attr('id') + counter + '" class="RemoveMore"></span>');
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
                counter += 1;
                $('.fiveStarDesc').append('<span class="startDesc" id="' + $(this).attr('id') + counter + '"><input name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><input type="button" value="&#10008"  data-id="' + $(this).attr('id') + counter + '" class="RemoveMore"></span>');
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

<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">



        <div class="brand inline" style="  width: auto;

             color: gray;
             margin-left: 30px;padding-top: 20px;">

            <strong style="color:#0090d9;">CONFIGURE TRIP RATING </strong>
        </div>



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
                                        <form id="updateDriverRating" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/superadmin/updateDriverRating"  enctype="multipart/form-data"> 
                                            <table class="table table-striped table-bordered dataTable no-footer">
                                                <thead>
                                                    <tr>

                                                        <th style="text-align: center;">RATING</th>
                                                        <th style="text-align: center;">DESCRIPTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="doc_body">
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <p class="rating">
                                                                <i class="fa fa-star rated"></i>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <div class="form-group"><div class="oneStarDesc" style="padding-left: 1%;"></div></div>
                                                            <br>
                                                            <div class="form-group">
                                                                <div class="col-sm-6">
                                                                    <input id="OneStartDesc"  class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <button type="button" class="btn btn-primary" data-id="OneStartDesc" id="addOneStartDesc">ADD</button>
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
                                                                    <input id="SecondStartDesc" class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <button type="button" class="btn btn-primary" data-id="SecondStartDesc" id="addSecondStartDesc">ADD</button>
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
                                                                    <input id="ThirdStarDesc" class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <button type="button" class="btn btn-primary" data-id="ThirdStarDesc" id="addThirdStartDesc">ADD</button>
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
                                                                    <input id="FourthStarDesc" class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <button type="button" class="btn btn-primary" data-id="FourthStarDesc" id="addFourthStartDesc">ADD</button>
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
                                                                    <input id="FiveStartDesc" class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <button type="button" class="btn btn-primary" data-id="FiveStartDesc" id="addFiveStartDesc">ADD</button>
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
                                                <button type="button" class="btn btn-success" id="save">Update</button>
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