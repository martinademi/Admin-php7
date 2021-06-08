<link href="application/views/city/styles.css" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet" type="text/css">

<script src="//maps.googleapis.com/maps/api/js?key=<?= GOOGLE_API_KEY ?>&v=3&libraries=drawing,places"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/javascript.util.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/jsts.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket-gmap3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<style>
    span.unit_tag1 {
        position: absolute;
        right: 10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    a .box-title{
        padding-left: 10px;
    }

    .panel-collapse .panel-body{
        border-top: 1px solid #000000;
    }
    .panel-default {
        border-color: #000000 !important; 
    }
    .aerow:before{
        content: "\f106";
        font-size: 18px;
        font-family: 'FontAwesome';
    }
    .collapsed .aerow:before{
        content: "\f107" !important;
        font-size: 18px;
        font-family: 'FontAwesome';
    }
</style>
<script>


    $(document).ready(function () {




    });
    function setPriceModel(data)
    {
        $.ajax({
            url: '<?= base_url() ?>index.php?/Zones_Controller/PricingSetForCity',
            type: 'POST',
            dataType: "JSON",
            data: $(data).closest('form').serialize(),
            success: function (response) {
                if (response.flag == 0) {
//                    window.location.href = "<?= base_url() ?>index.php?/city";
                    swal("", "Set Price SuccessFully", "success");
                } else {
                    swal("", response.data, "error");
                }
            }
        });
    }

</script>
<div class="page-content-wrapper">
    <div class="content">
        <div class="container-fluid container-fixed-lg">
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url('index.php?/Zones_Controller') ?>">ZONE</a>
                </li>
                <li>
                    <a href="#" class="active">PRICING - <?php echo $zoneName['city']; ?></a>
                </li>
            </ul>
            <div class="container-md-height m-b-20">
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs nav-tabs-simple bg-white" role="tablist" data-init-reponsive-tabs="collapse">
                        </ul>
                    </div>
                    <div class="panel-body no-padding">

                              <?php
                        if (count($data) == 0) {
                            ?>
                            <div class="form-group required">
                                <h6 class="box-title">
                                    <label for="address" class="col-sm-12 control-label" style="color: black;padding:10px;text-align:center">Note : Only one Zone exists for this particular city. </label>
                                </h6>
                            </div>
                            <?php
                        } else {
                            ?>
                            <!--                        -->
                            <div class="row" style="padding: 10px;">
                                <div class="col-lg-12 col-md-12 col-sm-12">                                
                                    <div class="panel-group" id="accordion">
                                        <?php
                                        foreach ($data as $city) {
                                            ?>
                                            <div class="panel panel-default col-sm-7" style="margin: 10px 25px;">
                                                <div class="panel-header with-border">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#pricingDetails_<?php echo $city['_id']['$oid']; ?>" class="collapsed">
                                                        <h6 class="box-title">
                                                            <label for="address" class="control-label text-black">To: <?php echo $city['title']; ?></label>
                                                            <span class="aerow pull-right text-black"></span>
                                                        </h6>
                                                    </a>
                                                </div> 
                                                <div id="pricingDetails_<?php echo $city['_id']['$oid']; ?>" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <form action="" class="form-horizontal pricingSet" role="form" method="post">
                                                            <input type="hidden" name="fromzoneId" value="<?php echo $zoneName['_id']['$oid']; ?>"/>
                                                            <input type="hidden" name="fromzoneName" value="<?php echo $zoneName['title']; ?>"/>
                                                            <input type="hidden" name="tozoneId" value="<?php echo $city['_id']['$oid']; ?>"/>
                                                            <input type="hidden" name="tozoneName" value="<?php echo $city['title']; ?>"/>
                                                            <input type="hidden" name="currency" value="<?php echo $zoneName['currencySymbol']; ?>"/>

                                                            
                                                                <div class="form-group required">
                                                                    <label for="address" class="col-sm-2 control-label"></label>
                                                                    <div class="col-sm-6">
                                                                        <!-- <input type="text" name="pricing" placeholder="Enter Price" class="form-control autonumeric" value="<?php echo $pricingData[$city['_id']['$oid']];?>"> -->
                                                                        <input type="text" name="pricing" placeholder="Enter Price" class="form-control autonumeric" value="<?php echo isset($pricingData[$city['_id']['$oid']]) ? $pricingData[$city['_id']['$oid']] : "" ;?>">
                                                                        
                                                                        
                                                                        <span class="unit_tag1"><?php echo $zoneName['currencySymbol']; ?></span>
                                                                    </div>
                                                                    <div class="col-sm-4"></div>
                                                                </div>

                                                            
                                                            <div class="form-group">
                                                                <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right text-right">
                                                                    <button type='button' class="btn btn-primary" onclick="setPriceModel(this);">Set Price</button>
                                                                </div>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                         <?php } ?>                   
                    </div>                                    
                </div>
            </div>
        </div>
    </div>
</div>