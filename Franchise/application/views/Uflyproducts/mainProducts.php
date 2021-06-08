
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .imageborder{
        border-radius: 50%;
    }
    .btn{
        border-radius: 25px !important;
        width: 115px !important;
    }
    a.fg-button{
        cursor:pointer;
    }


    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>

<script type="text/javascript">
    $(document).ready(function () {

    $("#setPrice").click(function () {

        $('#productData').val("");
        $('.unitsData').html('');

        var val = $('.checkboxProduct:checked').map(function () {
            return this.value;
        }).get();
        // console.log(val);
        // console.log(val[0]);

            if (val.length == 1) {
                pid= val[0];
            $(this).prop('disabled', true);
            $.ajax({
            url: '<?php echo base_url() ?>index.php?/CentralProducts/getUnits',
            type: "POST",
            data: {val: pid},
            dataType: "JSON",
            success: function (result) {

                $('#productData').val(JSON.stringify(result.result));
                //console.log(result.result);
                var html = '';
                var k = 1;
                $.each(result.data, function (i, row) {
                    //console.log(row);
                    html = '<div class="form-group formex ">'
                            + '<div class="col-sm-12">'
                            + '<div class="col-sm-4"><label class="control-label">' + row.name.en + '</label><input type="hidden" value="' + row.name.en + '" class="unitsTitle" /></div>'
                            + '<div class="col-sm-4"><input type="text" value="' + row.price.en + '" class="form-control col-sm-12 unitsValue" onkeypress="return isNumberKey(event)"/></div>'
                            + '<div class="col-sm-4"><input type="checkbox" class="checkbox unitChecks" value="' + row.unitId + '"/></div>'
                            + '</div><br/><br/><hr/>';

                    $('.unitsData').append(html);
                });

            $('.unitTitle').text("Add Units");
            $('#confirmmodel').modal('show');
        }

    });

} else {
    $("#errorModal").modal();
    $("#statusMessage").text('Invalid Selection');
}

});

        // Set price confirmation
        $('#big_table').on("click", '.checkboxProduct', function () {
            console.log('clicked');
            $('#setPrice').prop('disabled', false);
        });


        $('.close').click(function () {
            $('#setPrice').prop('disabled', false);
            $('#confirmmodel').modal('hide');
        });

        $("#confirmmodel").modal({
            show: false,
            backdrop: 'static'
        });
        $('body').on('click', '.btnRemove', function () {
            $(this).parent().parent().remove();
            renameUnitsLabels();
        });

         $('#addNewUnit').click(function () {
            var htmlAdd = '';
            var len = $('.customPriceField').length;
            var z = len + 1;
            var y = z + 1;
            htmlAdd = '<div class="customPriceField row"><div class="form-group pos_relative2 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-3 control-label">Units ' + z + ' </label>'
                    + '<div class="col-sm-4 pos_relative2">'
                   
                    + '<input type="text" name="units[' + len + '][name][en]" class="form-control productTitle' + z + '" id="title' + z + '" data-lng="en" placeholder="Enter title">'
                    + '</div>'
                    + ' <div class="col-sm-4 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    + ' <input type="text" name="units[' + len + '][price][en]" class="form-control productValue' + z + '" id="value' + z + '" data-lng="en" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                    + ' </div>'
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
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-3 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                            + '<div class="col-sm-4 pos_relative2">'
                            
                        + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle' + z + '" id="title' + z + '" data-lng="<?php echo $val['langCode']; ?>"  placeholder="Enter title">'
                            + '</div>'
                            + ' <div class="col-sm-4 pos_relative2">'
                            + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                            + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue' + z + '" id="value' + z + '" data-lng="<?php echo $val['langCode']; ?>" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                            + ' </div>'
                            + '<div class=""></div>'
                            + '</div>'
                            + '<?php } else { ?>'
                            + '<div class="form-group pos_relative2 customPriceField' + z + '" style="display:none">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-3 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                            + '<div class="col-sm-4 pos_relative2">'
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle' + z + '" id="title' + z + '" data-lng="<?php echo $val['langCode']; ?>"  placeholder="Enter title">'
                            + '</div>'
                            + ' <div class="col-sm-4 pos_relative2">'
                            + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                            + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue' + z + '" id="value' + z + '" data-lng="<?php echo $val['langCode']; ?>"  placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                            + ' </div>'
                            + '<div class=""></div>'
                            + '</div>'
                            + '<?php
                    }
                }
                ?>'
                    + '<div class="selectedsizeAttr"></div></div><hr/>';
//            htmlAdd = '<div class="row">'
//                    + '<div class="col-sm-4"><input type="text" class=" form-control unitsTitleNew" placeholder="Enter title"></div>'
//                    + '<div class="col-sm-1"></div>'
//                    + '<div class="col-sm-4"><input type="text" class="form-control unitsValueNew" placeholder="Enter Value"/></div>'
//                    + '</div><hr/>';
            $('.unitsData').append(htmlAdd);
            selectedsize = [];
            var prodata = JSON.parse($('#productData').val());
//            console.log(prodata.sizes);
//            console.log(prodata.sizes.length);
            var sizegroups = prodata.sizes;

            if (sizegroups.length > 0) {

                $(sizegroups).each(function (index, sizeAttr) {
                    var data = sizeAttr['sizeId'];
//                                                    console.log(data);
                    if (selectedsize.indexOf(data) == -1) {

                <?php foreach ($size as $sizes) { ?>
                            if ('<?php echo $sizes['_id']['$oid']; ?>' == data) {
                                if (sizegroups.length == 1) {

                                    $('.customPriceField:last').find('.selectedsizeAttr').html('<div class="form-group" id="selectedSizeAttr_' + data + '">\n\
                                                                                                           <label class="col-sm-3 control-label">Size Attribute</label>\n\
                                                                                                           <div class="col-sm-6"><span class="multiselect-native-select">\n\
                                                                                                           <select class="multiple sizeGroup form-control" id="sizeGroup' + z + '" name="units[' + z + '][sizeAttr][]" multiple="multiple" >\n\
                                    <?php foreach ($sizes['sizeAttr'] as $siz) {
                                        ?><option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + data + '" ><?php echo $siz['en']; ?></option>\n\
                                    <?php } ?></select></div></div>');

                                                                } else {
                                    <?php foreach ($sizes['sizeAttr'] as $siz) { ?>
                                                                        $('.sizeGroup').append('<option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + data + '" ><?php echo $siz['en']; ?></option>');
                                    <?php } ?>
                                }
                                $('.sizeGroup').multiselect("destroy").multiselect({
                                    selectAllValue: 'multiselect-all',
                                    includeSelectAllOption: true,
                                    enableFiltering: true,
                                    enableCaseInsensitiveFiltering: true,
                                    buttonWidth: '100%',
                                    maxHeight: 300});
                            }
                    <?php } ?>
                        selectedsize.push(data);
                    }
                });
            }

        });

        $("#confirmed1").click(function () {
       
       //            $('#setPrice').prop('disabled', false);
                   $(this).prop('disabled', true);
       
                   var val = $('.unitChecks:checked').map(function () {
                       return this.value;
                   }).get();
       
                   var unitLength = $('.customPriceField').length;
                   console.log("lenght=",unitLength);
                   var unitarr = new Array();
                   for (var i = 1; i <= unitLength; i++) {
                       var unitTitle ={}; // new Array();
                       var unitValue = {}; //new Array();
                      
                       var sizeAttr = '';
                       $(".productTitle" + i).each(function () {
                        //    console.log("i=",i);
                           var lngkey = $(this).attr('data-lng');
                           unitTitle[lngkey]= $(this).val();
                           //unitTitle.push({ en : $(this).val() });
                       });
       
                       $(".productValue" + i).each(function () {
                        var lngkey = $(this).attr('data-lng');
                            unitValue[lngkey]= $(this).val();
                           //unitValue.push($(this).val());
                       });
                       sizeAttr = $('#sizeGroup' + i).val();
                       unitarr.push({name: unitTitle, price: unitValue, sizeAttr: sizeAttr});
                   }
                   var unitsTitleNew = $('.unitsTitleNew').map(function () {
                       return this.value;
                   }).get();
       
                   var unitsValueNew = $('.unitsValueNew').map(function () {
                       return this.value;
                   }).get();
       
                   var unitsValue = $('.unitsValue').map(function () {
                       return this.value;
                   }).get();
       
                   var unitsTitle = $('.unitsTitle').map(function () {
                       return this.value;
                   }).get();
       
                   var productData = $('#productData').val();
                   console.log(val.length);
                   if (val.length == 0) {
                       $("#errorModal").modal();
                       $("#statusMessage").text('Please select atleast one product');
                   } else {
       //                $(this).prop('disabled', true);
                        console.log(unitarr);

                       $.ajax({
                           url: '<?php echo base_url() ?>index.php?/CentralProducts/AddNewProductData1',
                           type: "POST",
                           data: {val: val, productData: productData, unitsValue: unitsValue, unitsTitle: unitsTitle, unitsValueNew: unitsValueNew, unitsTitleNew: unitsTitleNew, unitarr: unitarr},
                           dataType: "JSON",
                           success: function (result) {
                               console.log(result);
                               if (result.statusCode != 200) {
                                   $("#confirmmodel").modal('hide');
                                   $('#confirmed1').prop('disabled', false);
                                   $("#errorModal").modal();
                                   $("#statusMessage").text('Product already exists');
                               } else {
                                   $("#confirmmodel").modal('hide');
                                   $("#errorModal").modal();
                                   $("#statusMessage").text('Product added successfully');
                                   $('#confirmed1').prop('disabled', false);
       
                               }
                           }
       
                       });
                   }
       
               });

               $('#big_table').on("click", '.unitsList', function () {

                    $('#unitListData').empty();
                    var id = $(this).attr('id');

                    $.ajax({
                        url: '<?php echo base_url() ?>index.php?/CentralProducts/unitsList/' + id,
                        type: "POST",
                        data: {id: id},
                        dataType: "JSON",
                        success: function (result) {
                            var html = '';
                            var k = 1;
                            $.each(result.data, function (i, row) {
                                html = '<tr style="font-size:14px; "><td style="text-align:center;width:250px;border-style: ridge;">' + row.name.en + '</td><td style="border-style: ridge;width:250px;text-align:center;">' + row.price.en + '</td></tr>';

                                $('#unitListData').append(html);
                            });

                            $('#unitListModal').modal('show');
                        }

                    });
            });



        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {
            $('#big_table_processing').show();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/CentralProducts/product_detailsProducts',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {

                },
                "fnInitComplete": function () {
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback
                            });
                }
            };
            table.dataTable(settings);
        }, 1000);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });


    });
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>

<link
    href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css"
    rel="stylesheet" type="text/css" />

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content" >

        <!-- <div class="brand inline" style="  width: auto;            
             color: gray;
             margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;">PRODUCTS</strong>
        </div> -->

        <div class="brand inline" style="  width: auto;">
            <?php echo str_replace('_', ' ', $pageTitle); ?> Products
        </div>

        <div id="test"></div>
        <!-- Nav tabs -->
        <!-- <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked"> -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked" style="margin-right: 15px;padding-top:5px; margin-left:15px;">
            <div class="pull-right m-t-10"><button style="margin-right: 20px;" class="btn btn-success pull-right m-t-10" id="setPrice">Add </button></div>

        </ul>

           
        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                    <div class="cs-loader">
                                        <div class="cs-loader-inner" >
                                            <label class="loaderPoint" style="color:#10cfbd">●</label>
                                            <label class="loaderPoint" style="color:red">●</label>
                                            <label class="loaderPoint" style="color:#FFD119">●</label>
                                            <label class="loaderPoint" style="color:#4d90fe">●</label>
                                            <label class="loaderPoint" style="color:palevioletred">●</label>
                                        </div>
                                    </div>

                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right"  placeholder="Search"> </div>
                                    </div>


                                </div>
                                &nbsp;
                                <div class="panel-body">
                                    <?php echo $this->table->generate(); ?>

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


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title unitTitle"></div>
                    <div class="" style=" margin-top: -4%;margin-right: -7%;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close fs-14" style="font-size: 14px;">X</i>
                        </button>
                    </div>
                </div>

                <br>
                <div class="modal-body">
                    <div class="row unitsData">

                    </div>
                    <input type="hidden" value id="productData"/>
                </div>
                <br>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4" >
                            <a class="pull-left" id="addNewUnit" style="cursor:pointer;color:#0090d9">Add New Unit</a>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" data-id="" id="confirmed1" >ADD</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="unitListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Unit List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="unitListData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- invalid selection -->
<div id="errorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p class="" id="statusMessage" style="font-size: 15px; margin-left: 100px;"></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>






