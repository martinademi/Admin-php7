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
            $('.oneStartDesc').append('<span class="tag label label-info" id="addOneStartDesc' + counter + '"><?php echo $row ?><input  style="display:none;" name="OneStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><span class="RemoveMore" data-id="addOneStartDesc' + counter + '" style="">x</span></span>')
    <?php
}
?>
        //Get Already updated Data
<?php
foreach ($appConfig['DriverRating']['2'] as $row) {
    ?>
            counter += 1;
            $('.secondStartDesc').append('<span class="tag label label-info" id="addSecondStartDesc' + counter + '"><?php echo $row ?><input  style="display:none;" name="SecondStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><span class="RemoveMore" data-id="addSecondStartDesc' + counter + '" style="">x</span></span>');

    <?php
}
?>
        //Get Already updated Data
<?php
foreach ($appConfig['DriverRating']['3'] as $row) {
    ?>
            counter += 1;
    //                    $('.thirdStarDesc').append('<span class="startDesc" id="addThirdStartDesc'+counter+'"><input name="ThirdStarDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><input type="button" value="&#10008"  data-id="addThirdStartDesc'+counter+'" class="RemoveMore"></span>');
            $('.thirdStarDesc').append('<span class="tag label label-info" id="addThirdStartDesc' + counter + '"><?php echo $row ?><input  style="display:none;" name="ThirdStarDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><span class="RemoveMore" data-id="addThirdStartDesc' + counter + '" style="">x</span></span>');
    <?php
}
?>
        //Get Already updated Data
<?php
foreach ($appConfig['DriverRating']['4'] as $row) {
    ?>
            counter += 1;
    //                    $('.fourthStarDesc').append('<span class="startDesc" id="addFourthStartDesc'+counter+'"><input name="FourthStarDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><input type="button" value="&#10008"  data-id="addFourthStartDesc'+counter+'" class="RemoveMore"></span>');
            $('.fourthStarDesc').append('<span class="tag label label-info" id="addFourthStartDesc' + counter + '"><?php echo $row ?><input  style="display:none;" name="FourthStarDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><span class="RemoveMore" data-id="addFourthStartDesc' + counter + '" style="">x</span></span>');
    <?php
}
?>
        //Get Already updated Data
<?php
foreach ($appConfig['DriverRating']['5'] as $row) {
    ?>
            counter += 1;
    //                    $('.fiveStarDesc').append('<span class="startDesc" id="addFiveStartDesc'+counter+'"><input name="FiveStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><input type="button" value="&#10008"  data-id="addFiveStartDesc'+counter+'" class="RemoveMore"></span>');
            $('.fiveStarDesc').append('<span class="tag label label-info" id="addFiveStartDesc' + counter + '"><?php echo $row ?><input  style="display:none;" name="FiveStartDesc[]" class="inputDesc"  type="text"  value="<?php echo $row ?>"><span class="RemoveMore" data-id="addFiveStartDesc' + counter + '" style="">x</span></span>');
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
                $('.oneStartDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#OneStartDesc').val() + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');
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
                $('.secondStartDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#SecondStartDesc').val() + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');
//               $('.secondStartDesc').append('<span class="startDesc" id="'+$(this).attr('id')+counter+'"><input name="'+$(this).attr('data-id')+'[]" class="inputDesc"  type="text"  value="'+$('#'+$(this).attr('data-id')).val()+'"><input type="button" value="&#10008"  data-id="'+$(this).attr('id')+counter+'" class="RemoveMore"></span>');
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
//               $('.thirdStarDesc').append('<span class="startDesc" id="'+$(this).attr('id')+counter+'"><input name="'+$(this).attr('data-id')+'[]" class="inputDesc"  type="text"  value="'+$('#'+$(this).attr('data-id')).val()+'"><input type="button" value="&#10008"  data-id="'+$(this).attr('id')+counter+'" class="RemoveMore"></span>');
                $('.thirdStarDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#ThirdStarDesc').val() + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');
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
//               $('.fourthStarDesc').append('<span class="startDesc" id="'+$(this).attr('id')+counter+'"><input name="'+$(this).attr('data-id')+'[]" class="inputDesc"  type="text"  value="'+$('#'+$(this).attr('data-id')).val()+'"><input type="button" value="&#10008"  data-id="'+$(this).attr('id')+counter+'" class="RemoveMore"></span>');
                $('.fourthStarDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#FourthStarDesc').val() + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');
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
//               $('.fiveStarDesc').append('<span class="startDesc" id="'+$(this).attr('id')+counter+'"><input name="'+$(this).attr('data-id')+'[]" class="inputDesc"  type="text"  value="'+$('#'+$(this).attr('data-id')).val()+'"><input type="button" value="&#10008"  data-id="'+$(this).attr('id')+counter+'" class="RemoveMore"></span>');
                $('.fiveStarDesc').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#FiveStartDesc').val() + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');
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

            <strong style="color:#0090d9;">CONFIGURE TRIP RATING</strong>
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

                                            <!--                                               
                                                                                                   <p class="rating">
                                                                                                       <i class="fa fa-star rated"></i>
                                                                                                   </p>
                                                                                             
                                                                                                   <div class="form-group"><div class="oneStartDesc" style="padding-left: 1%;"></div></div>
                                                                                                   <br>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-sm-6">
                                                                                                           <input id="OneStartDesc"  class="form-control" type="text">
                                                                                                        </div>
                                                                                                        <div class="col-sm-2">
                                                                                                             <button type="button" class="btn btn-primary" data-id="OneStartDesc" id="addOneStartDesc">ADD</button>
                                                                                                        </div>
                                                                                                      </div>-->

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
                                                                    <input id="OneStartDesc"  class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
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
                                                                    <input id="SecondStartDesc" class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
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
                                                                    <input id="ThirdStarDesc" class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
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
                                                                    <input id="FourthStarDesc" class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
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
                                                                    <input id="FiveStartDesc" class="form-control" type="text">
                                                                </div>
                                                                <div class="col-sm-2">
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