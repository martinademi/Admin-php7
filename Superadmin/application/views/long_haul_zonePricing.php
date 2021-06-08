<style>
    span.abs_text {
        position: absolute;
        left: 12px;
        top: 1px;
        z-index: 9;
        padding: 2px 9px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;

    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .pos_relative2{
        padding-right:10px
    }

    input[type="text"]{
        padding-left: 40px;
    }
</style>
<script>
    $(document).ready(function () {

        $('.number').keypress(function (event) {
            if (event.which < 46
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46
                    && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot
        });

        $('#save').click(function ()
        {
            var isBlack = false;
//           $('input:text').each(function(){
//                if( $(this).val().length == 0)
//                {
//                    isBlack = false;
//                   $(".error").text('Please enter price for all vehicles');
//                }
//                else
//                {
//                     isBlack = true;
//                    $(".error").text('');
//                }
//            }); 
//            
//            if(isBlack)
            $('#vehiclePriceForm').submit();

        });

        $('.plusClick').click(function ()
        {
            if (!$('.' + $(this).attr('id')).is(':visible'))
            {
                $('#' + $(this).attr('id')).attr('src', '<?php echo base_url() ?>pics/negative.png');
                $('.' + $(this).attr('id')).show();
            } else
            {
                $('#' + $(this).attr('id')).attr('src', '<?php echo base_url() ?>pics/add.png');
                $('.' + $(this).attr('id')).hide();
            }
        });
    });
</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong>
                <?php
                foreach ($cities as $city) {

                    if ($ID == $city['_id']['$oid']) {
                        echo 'PRICES FROM ' . strtoupper($city['city']);
                    }
                }
                ?>
            </strong>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-transparent ">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <!--                                     <div class="cs-loader">
                                                                                <div class="cs-loader-inner" >
                                                                                    <label class="loaderPoint" style="color:#10cfbd">●</label>
                                                                                    <label class="loaderPoint" style="color:red">●</label>
                                                                                    <label class="loaderPoint" style="color:#FFD119">●</label>
                                                                                    <label class="loaderPoint" style="color:#4d90fe">●</label>
                                                                                    <label class="loaderPoint" style="color:palevioletred">●</label>
                                                                            </div>
                                                                          </div>-->

                                <!--                              <div class="pull-right">
                                                                    <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?>"/> 
                                
                                                                </div>-->
<?php
?>

                                &nbsp;
                                <div class="panel-body" style="padding: 0px; margin-top: 2%;">
                                    <form id="vehiclePriceForm" method="post" action="<?php echo base_url() . 'index.php?/superadmin/long_haul_pricing_set/' . $ID; ?>">


                                    <?php
                                    $slNo = 1;
                                    foreach ($cities as $city) {

                                        if ($ID != $city['_id']['$oid']) {

                                            echo '<img class="plusClick" id="table' . $slNo . '" src="' . base_url() . 'pics/add.png">  <b>' . $city['city'] . '</b>';
                                            ?>
                                                <br>
                                                <br>
                                                <table  border="1" cellpadding="2" style="display:none;" cellspacing="1" class="table table-striped table-bordered no-footer table<?php echo $slNo; ?>" role="grid" aria-describedby="big_table_info" style="">
                                                    <thead>
                                                        <tr style= "font-size:10px"role="row">
                                                            <th> VEHICLE TYPE NAME</th>
                                                            <th>FULL VEHICLE LOAD PRICE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                        <?php
                                        foreach ($vehicleTypes as $type) {
                                            ?>
                                                            <tr><td><?php echo $type['type_name'] ?></td><td>
                                                                    <div class="col-sm-3 pos_relative">
                                                                        <span class="abs_text" style="color: #73879C;"><?php echo $appConfig['currencySymbol']; ?></span>
                                                                        <input type="text"  class="autonumeric form-control prices number" name="pricing[<?php echo $city['_id']['$oid']; ?>][<?php echo $type['_id']['$oid']; ?>]" id="" placeholder="Enter price" value="<?php echo $citySpecific['LongHaulPrice'][(string) $city['_id']['$oid']][(string) $type['_id']['$oid']]; ?>"> </div></td></tr>

                                                            <?php
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table><br>
                                                        <?php
                                                        ++$slNo;
                                                    }
                                                }
                                                ?>

                                    </form>
                                </div>

                                <div class="error" style="text-align: center;color:red"></div><button id="save" class="btn btn-success pull-left cls111">Save</button> 
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>

