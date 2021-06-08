<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet">



<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<link href="<?php echo base_url(); ?>css/products.css" rel="stylesheet">
<style>
    .btn{
        font-size: 10px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }
    .multiselect{
        border-radius: 0;
        text-align: left;
        font-size: 10px;
        border-radius: 0 !important;
        width: 136% !important;
    }
    .caret{
        float: right;
        position: relative;
        right: -10px;
    }
    .multiselect-container {
        width: 136% !important;
    }


</style>
<script>



    $(document).ready(function () {
        $('.products').addClass('active');
        $('#big_table_processing').show();

        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        var settings = {
             "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "autoWidth": false,
                            "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/product_detailsProducts',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
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
        // search box for table

        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('#downloadFile').click(function () {
            $('#downloadModal').modal('show');

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
                    + '<span  class="abs_text"><b><?php //echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="units[' + len + '][name][en]" class="form-control productTitle' + z + '" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + ' <div class="col-sm-4 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php //echo $storeType['currencySymbol']; ?></b></span>'
                    + ' <input type="text" name="units[' + len + '][price][en]" class="form-control productValue' + z + '" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
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
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle' + z + '" id="title' + z + '"  placeholder="Enter title">'
                            + '</div>'
                            + ' <div class="col-sm-4 pos_relative2">'
                            + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                            + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue' + z + '" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                            + ' </div>'
                            + '<div class=""></div>'
                            + '</div>'
                            + '<?php } else { ?>'
                            + '<div class="form-group pos_relative2 customPriceField' + z + '" style="display:none">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-3 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                            + '<div class="col-sm-4 pos_relative2">'
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle' + z + '" id="title' + z + '"  placeholder="Enter title">'
                            + '</div>'
                            + ' <div class="col-sm-4 pos_relative2">'
                            + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                            + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue' + z + '" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
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

        $('#complete').click(function () {
            setTimeout(function () {
                $('#downloadModal').modal('hide');
            }, 3000);
        });

        $('#edit').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length < 0 || val.length > 1 || val == '') {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Please select the Product');
            }
            if (val.length == 1) {
                window.location.href = '<?php echo base_url(); ?>index.php?/AddNewProducts/EditProducts/' + val;
            }

        });

        $("#delete").click(function () {

            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Please select the Product ');
            } else if (val.length >= 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
            }


        });
        setTimeout(function () {
            $('#flashdata').hide();
        }, 3000);

        $('#big_table').on("click", '.viewShortDescriptionlistProducts', function () {
            $('#shortDescriptionData').empty();
            var id = $(this).attr('id');

            console.log(id);
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/viewShortDescriptionlistProducts/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';

                    html = '<p style="font-family: Arial, Helvetica, sans-serif; font-size:14px;">' + result.data + '</p>';

                    $('#shortDescriptionData').append(html);

                    $('#viewShortDescriptionlist').modal('show');
                }

            });

        });
        $('#big_table').on("click", '.viewDetailedDescriptionlistProducts', function () {
            $('#descriptionData').empty();
            var id = $(this).attr('id');

            console.log(id);
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/viewDescriptionlistProducts/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';

                    html = '<p style="font-family: Arial, Helvetica, sans-serif; font-size:14px;">' + result.data + '</p>';

                    $('#descriptionData').append(html);

                    $('#viewDescriptionlist').modal('show');
                }

            });

        });
        $('#big_table').on("click", '.unitsList', function () {

            $('#unitListData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/unitsList/' + id,
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

        $('#big_table').on("click", '.strainEffectsProducts', function () {

            $('#strainEffectsData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/strainEffectsProducts/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px;"><td style="text-align:center;width:200px;border-style: ridge;">' + i + '</td><td style="border-style: ridge;width:200px;text-align:center;">' + result.data[i] + ' %</td></tr><br/><br/>';

                        $('#strainEffectsData').append(html);
                    });

                    $('#strainEffectsList').modal('show');
                }

            });
        });
        $('#big_table').on("click", '.medicalAttributesProducts', function () {

            $('#medicalAttributesData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/medicalAttributesProducts/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px;"><td style="text-align:center;width:200px;border-style: ridge;">' + i + '</td><td style="border-style: ridge;width:200px;text-align:center;">' + result.data[i] + '%</td></tr><br/><br/>';

                        $('#medicalAttributesData').append(html);
                    });

                    $('#medicalAttributesList').modal('show');
                }

            });
        });
        $('#big_table').on("click", '.negativeAttributesProducts', function () {

            $('#negativeAttributesData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/negativeAttributesProducts/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px;"><td style="text-align:center;width:200px;border-style: ridge;">' + i + '</td><td style="border-style: ridge;width:200px;text-align:center;">' + result.data[i] + '%</td></tr><br/><br/>';

                        $('#negativeAttributesData').append(html);
                    });

                    $('#negativeAttributesList').modal('show');
                }

            });
        });
        $('#big_table').on("click", '.flavoursProducts', function () {

            $('#flavoursData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/flavoursProducts/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px; "><td style="text-align:center;width:200px;border-style: ridge;">' + i + '</td><td style="border-style: ridge;width:200px;text-align:center;">' + result.data[i] + '</td></tr>';

                        $('#flavoursData').append(html);
                    });

                    $('#flavoursList').modal('show');
                }

            });
        });

        $('#big_table').on("click", '.imglistProducts', function () {

            $('#imagedata').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/imagelistProducts/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<img src="' + row.mobile + '" class="img-thumbnail" alt="" width="204" height="136">';

                        $('#imagedata').append(html);
                    });

                    $('#imagelist').modal('show');
                }

            });
        });
        $('#big_table').on("click", '.nutrilistProducts', function () {

            $('#nutritiondata').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/nutrilistProducts/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px;"><td>' + result.data[i] + '</td></tr>';

                        $('#nutritiondata').append(html);
                    });

                    $('#nutritionlist').modal('show');
                }

            });
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





        $("#confirmed1").click(function () {
       
//            $('#setPrice').prop('disabled', false);
            $(this).prop('disabled', false);

            var val = $('.unitChecks:checked').map(function () {
                return this.value;
            }).get();

            var unitLength = $('.customPriceField').length;
            var unitarr = new Array();

            for (var i = 1; i <= unitLength; i++) {
                var unitTitle = new Array();
                var unitValue = new Array();
                var sizeAttr = '';
                $(".productTitle" + i).each(function () {
                    unitTitle.push($(this).val());
                });

                $(".productValue" + i).each(function () {
                    unitValue.push($(this).val());
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

            var addon = [];
                $.each($(".addons option:selected"), function(){            
                    addon.push($(this).val());
                });
               

            var productData = $('#productData').val();
            console.log(val.length);
            if (val.length == 0) {
                $("#errorModal").modal();
                $("#statusMessage").text('Please select atleast one product');
            } else {
//                $(this).prop('disabled', true);
                $.ajax({
                    url: '<?php echo base_url() ?>index.php?/AddNewProducts/AddNewProductDataList',
                    type: "POST",
                    data: {val: val, productData: productData, unitsValue: unitsValue, unitsTitle: unitsTitle, unitsValueNew: unitsValueNew, unitsTitleNew: unitsTitleNew, unitarr: unitarr,addOnIds:addon},
                    dataType: "JSON",
                    success: function (result) {
                        console.log(result);
                        if (result.status == false) {
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

    });
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    
    function movetonext()
    {
        
        var currenttabstatus = $("li.active.unitsActive").attr('id');
       
        if (currenttabstatus === "firstlitab")
        {
         
        $("#firstlitab").removeClass("active");
        $("#secondlitab").addClass("active");
        $("#tab1").removeClass("active");
        $("#tab2").addClass("active");
        $('#nexttab').hide();
        $('#confirmed1').show();
        $('#addNewUnit').hide();
        
            
           
        } else if (currenttabstatus === "secondlitab")
        {
           
        }

    }

$(document).ready(function(){

    //     $("#setPrice").click(function () {           

    //        $('#productData').val("");
    //        $('.unitsData').html('');         
    //        var val = $('.checkboxProduct:checked').map(function () {
    //            return this.value;
    //        }).get();
           
    //     if (val.length == 1) {
    //            $(this).prop('disabled', true);
    //            $.ajax({
    //                url: '<?php echo base_url() ?>index.php?/AddNewProducts/getUnits',
    //                type: "POST",
    //                data: {val: val},
    //                dataType: "JSON",
    //                success: function (result) {

    //                    $('#productData').val(JSON.stringify(result.result));
    //                    var html = '';
    //                    var k = 1;
    //                    $.each(result.data, function (i, row) {
    //                        console.log(row);
    //                        html = '<div class="form-group formex ">'
    //                                + '<div class="col-sm-12">'
    //                                + '<div class="col-sm-4"><label class="control-label">' + row.name.en + '</label><input type="hidden" value="' + row.name.en + '" class="unitsTitle" /></div>'
    //                                + '<div class="col-sm-4"><input type="text" value="' + row.price.en + '" class="form-control col-sm-12 unitsValue" onkeypress="return isNumberKey(event)"/></div>'
    //                                + '<div class="col-sm-4"><input type="checkbox" class="checkbox unitChecks" value="' + row.unitId + '"/></div>'
    //                                + '</div><br/><br/><hr/>';

    //                        $('.unitsData').append(html);
    //                    });
                       
    //                    //$('.unitTitle').text("Add Units"); cool
    //                    $("#firstlitab").addClass("active");
    //                    $("#secondlitab").removeClass("active");
    //                    $('#nexttab').show();                        
    //                    $('#confirmed1').hide();
    //                    $('#addNewUnit').show();
    //                    $("#tab1").addClass("active");
    //                    $("#tab2").removeClass("active");
    //                    $('#confirmmodel').modal('show');
    //                    storeType();
    //                }

    //            });

    //        } else {
    //            $("#errorModal").modal();
    //            $("#statusMessage").text('Invalid Selection');
    //        }

    //    });

    $("#setPrice").click(function () {           

           $('#productData').val("");
           $('.unitsData').html('');         
           var val = $('.checkboxProduct:checked').map(function () {
               return this.value;
           }).get();
           
        if (val.length == 1) {
               $(this).prop('disabled', true);
               window.location.href="<?php echo base_url() ?>index.php?/AddNewProducts/editAddOns/" + val;
             

           } else {
               $("#errorModal").modal();
               $("#statusMessage").text('Invalid Selection');
           }

       });


function storeType(){

    var storeType1 = "<?php echo $storeType['storeType'];?>";
   if(storeType1==1){      

    $('.tabTwo').css('display','block');
    $('#nexttab').show();  

   } else{    

    $('#nexttab').hide();    
    $('#confirmed1').show(); 

    }
}

});


  
 //onclick of tab  cool
 $(document).ready(function(){
    
    $('.whenclickedtab li').click(function(){
     
     if($(this).attr('id')=="firstlitab"){
        
        $('#addNewUnit').show();
        $('#nexttab').show();        
        $('#confirmed1').hide();

     }else if($(this).attr('id')=="secondlitab"){

        $('#addNewUnit').hide();
        $('#nexttab').hide();        
        $('#confirmed1').show();

     }

  });

 });
  

</script>


<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">
       
        <div class="brand inline" style="  width: auto; margin-left: 8px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 16px;">Products</strong>
        </div>
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked" style="margin-right: -20px;">
            <div class="pull-right m-t-10"><button style="margin-right: 20px;" class="btn btn-success pull-right m-t-10" id="setPrice">Add </button></div>

        </ul>
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent " style="margin-left: -20px;margin-right: -50px;">
 
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="error-box" id="display-data" style="text-align:center; color: red;"></div>
                                    <div class="searchbtn row clearfix pull-right" style="margin-right: 0%;">

                                        <div class=""><input type="text" id="search-table" class="form-control pull-right" style="text-transform: capitalize;" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>
                                    <div class="dltbtn">
                                    </div>
                                </div>
                                &nbsp;

                                <div class="container">
                                    <div class="row clearfix">
                                        <div class="col-md-12 column">
                                            <?php echo $this->table->generate(); ?>
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
        <!-- END JUMBOTRON -->

        <!-- END PAGE CONTENT -->
    </div>
    
    <div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title unitTitle"></div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
					<ul
                        class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm whenclickedtab"
                        id="mytabs">
                        <li class="active tabs_active unitsActive" id="firstlitab"><a data-toggle="tab" href="#tab1"
                            id="tb1"><i id="tab1icon" class=""></i> <span>Add Units</span></a>
                        </li>
                       <li class="tabs_active unitsActive addonli tabTwo" id="secondlitab" style="display:none"><a data-toggle="tab" href="#tab2" id="mtab2">
						<i id="tab2icon" class=""></i> <span>Add Add-On's</span></a>
                        </li>                      
                       

                    </ul>
                </div>

                <br>
                <div class="modal-body">                   

                    <div class="tab-content">
					<div class="tab-pane padding-20 slide-left active" id="tab1">
                     <div class="row unitsData">

                    </div>
                    <input type="hidden" value id="productData"/>
					</div>
                    <!-- tab for Addons -->
					<div class="tab-pane slide-left padding-20" id="tab2">
						<div class="row row-same-height">					
                            
                        <!-- strt -->
                        <div class="form-group required" >
                                <label class="col-sm-2 control-label">Add-On's</label>
                                <div class="col-sm-6">
                                    <div class="multiselect">
                                        <div class="selectBox"  style="width: 102%;">
                                            <select class="addOn multiple form-control addons" name="addon[]" id="addonsId" multiple="multiple">
                                                <?php
                                                
                                                if(count($language) < 1){
                                                foreach ($addon as $result) {
                                                    
                                                        echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['name']['en'] . "'>" . $result['name']['en'] . "</option>";
                                                    
                                                }
                                            }
                                            else{
                                                
                                                foreach ($addon as $result) {
                                                    $catData=$result['name']['en'];
                                                    foreach($language as $lngData){
                                                    $lngcode=$lngData['langCode'];
                                                    $lngvalue= ($result['name'][$lngcode]=='') ? "":$result['name'][$lngcode];
                                                    if(strlen( $lngvalue)>0){
                                                        $catData.= ',' . $lngvalue;
                                                    }
                                                } 
                                                
                                                    echo "<option  value=" .$result['_id']['$oid'] . "  data-name='" .  $catData . "'>" . $catData . "</option>";	
                                                    
                                                }
                                            }
                                                
                                           
                                                ?>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>

                                    </div>
                                    <label id="colors-error" class="error" style="display:none">This field is required.</label>
                                </div>
                                <div class="col-sm-3 error-box" id="colorsErr"></div>

                            </div>
                        <!-- end -->


						</div>
					</div>
				
			    </div>

                </div>
                <br>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-6" >
                            <a class="pull-left" id="addNewUnit" style="cursor:pointer;color:#0090d9">Add New Unit</a>
                        </div>
                       
                        <div class="col-sm-6 pull-right" >
                            <button type="button" class="btn btn-primary " data-id="" id="nexttab"  onclick="movetonext()" style="display:none">NEXT</button>
                        </div>
                        <div class="col-sm-6 pull-right" >
                            <button type="button" class="btn btn-primary " data-id="" id="confirmed1" style="display:none">ADD</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

   
</div>




<div class="modal fade stick-up" id="reviewlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Review List</h4>
            </div>
            <div class="modal-body form-horizontal">

                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    <th style="width :72px !important;" >SL NO</th>
                    <th style="width :72px !important;" >CUSTOMER NAME</th>
                    <th style="width :72px !important;">CUSTOMER ID</th>
                    <th style="width :72px !important;">RATING</th>
                    <th style="width :50px !important;">REVIEW</th>
                    </thead>
                    <tbody id="review_data">
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="viewDescriptionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Detailed Decription</h4>
            </div>
            <div class="modal-body form-horizontal">



                <div id="descriptionData"></div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="viewShortDescriptionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Short Decription</h4>
            </div>
            <div class="modal-body form-horizontal">



                <div id="shortDescriptionData"></div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>





<div class="modal fade stick-up" id="imagelist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Image List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="imagedata">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>



<div class="modal fade stick-up" id="nutritionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Nutrition List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="nutritiondata">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="flavoursList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Flavours List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="flavoursData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="negativeAttributesList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Negative Attributes List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="negativeAttributesData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="medicalAttributesList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Medical Attributes List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="medicalAttributesData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="strainEffectsList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Strain Effects List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="strainEffectsData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>



<div class="modal fade stick-up" id="importmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="  width: 110%;">
            <form action="<?php echo base_url(); ?>index.php?/AddNewProducts/importExcel" method="post" name="upload_excel" enctype="multipart/form-data">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4>Upload File</h4>
                </div>
                <div class="modal-body">
                    <div class="row row-same-height">
                        <div align="center">
                            <div class="row">
                                <label class="col-sm-4 control-label"><h5>Excel File Upload</h5></label>
                                <input type="file" name="file" id="file" class="form-control col-sm-6" style="width:50% !important;">
                            </div>
                            <div class="row"></div>
                            <div class="row"></div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type="submit" id="submit" name="import" class='btn btn-primary pull-right'>Import</button>
                    </div>
                </div>
                <!-- /.modal-dialog -->
            </form>
        </div>
    </div>
</div>

<div id="downloadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Download Sample File</h4>
            </div>
            <div class="modal-body">
                <p class="error-box modalPopUpText">Are you sure you want to download the sample file..</p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url(); ?>application/ajaxFile/ProductsSamplefile.csv" download="ProductsSamplefile.csv"><button class="btn btn-success btnClass" id="complete">Yes</button></a>
                <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
            </div>
        </div>

    </div>
</div>
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
<script>
    $('.multiple').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '100%',
        maxHeight: 300,
    });
</script>

