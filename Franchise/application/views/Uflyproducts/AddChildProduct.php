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

    ul.navbar-nav.navbar-left.nav.nav-tabs.nav-tabs-linetriangle.nav-tabs-separator.nav-stack-sm.fixednab {
        position: fixed;
        z-index: 999;
        width: 100%;
        top: 0;
        background: white;
    }
    .multiselect{
        border-radius: 0;
        text-align: left;
        font-size: 10px;
    }
    .caret{
        float: right;
        position: relative;
        right: -10px;
    }

</style>

<script src="<?php echo ServiceLink ; ?>vendors/bootstrap/dist/js/bootstrap-multiselect.js"></script>
<link href="<?php echo ServiceLink ; ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">

<script>
    var selectedsize = [];

    function selectall() {
        var checked = $("#selectbids:checked").length;

        if (checked == 0) {
            $(".selectbids").attr('checked', false);
        } else {
            $(".selectbids").attr('checked', true);
        }
    }

//here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function submitform()
    {
        $('#finishbutton').prop('disabled', false);
        $(".error-box").text("");

        var val = $('.unitChecks:checked').map(function () {
            return this.value;
        }).get();

        var storeIds = $('.selectbids:checked').map(function () {
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

        var productData = $('#productData').val();

        var taxIds = $('#tax').val();
        var taxFlags = new Array();
        if (taxIds) {
            var taxCount = taxIds.length;

            for (var i = 1; i <= taxCount; i++) {
                taxFlags.push($('#taxFlag_' + i).val());
            }
        }

//        var currentdate = new Date();
//        var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
//
//        $('#time_hidden').val(datetime);

        $.ajax({
            url: '<?php echo base_url() ?>index.php?/AddNewProducts/AddNewProductData',
            type: "POST",
            data: {val: val,
                productData: productData,
                unitsValue: unitsValue,
                unitsTitle: unitsTitle,
                unitsValueNew: unitsValueNew,
                unitsTitleNew: unitsTitleNew,
                unitarr: unitarr,
                tax: taxIds,
                taxFlag: taxFlags,
                storeIds: storeIds
            },
            dataType: "JSON",
            success: function (result) {
                console.log(result);
                if (result.status == false) {
//                    $("#confirmmodel").modal('hide');
                    $('#confirmed').prop('disabled', false);
                    $("#errorModal").modal();
                    $("#statusMessage").text('Product already exists');
                } else {
//                    $("#confirmmodel").modal('hide');
                    $("#errorModal").modal();
                    $("#statusMessage").text('Product added successfully');
                    $('#confirmed').prop('disabled', false);

                }
            }

        });

//        $('#addentity').submit();
    }
    
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

</script>

<script>
    $(document).ready(function () {


        $(document).on("click", '#okbutton', function () {
            location.href = "<?php echo base_url() ?>index.php?/AddNewProducts";
        });

        $(document).on("click", '.unitChecks', function () {
            $('.error-box').text('');
        });

        var productId = '<?php echo $productId; ?>';
        $.ajax({
            url: '<?php echo base_url() ?>index.php?/AddNewProducts/getUnits',
            type: "POST",
            data: {val: productId},
            dataType: "JSON",
            success: function (result) {
//                console.log(JSON.stringify(result.result));
                $('#productData').val(JSON.stringify(result.result));
                var html = '';
                var k = 1;
                $.each(result.data, function (i, row) {
//                    console.log(row);
                    html = '<div class="form-group formex ">'
                            + '<div class="col-sm-12">'
                            + '<div class="col-sm-2"><label class="control-label">' + row.name.en + '</label><input type="hidden" value="' + row.name.en + '" class="unitsTitle" /></div>'
                            + '<div class="col-sm-4"><input type="text" value="' + row.price.en + '" class="form-control col-sm-12 unitsValue" onkeypress="return isNumberKey(event)"/></div>'
                            + '<div class="col-sm-4"><input type="checkbox" class="checkbox unitChecks" value="' + row.unitId + '"/></div>'
                            + '</div><br/><br/><hr/>';
                    $('.unitsData').append(html);
                });
                $('.unitTitle').text("Add Units");
            }

        });


        $('#addNewUnit').click(function () {
            var htmlAdd = '';
            var len = $('.customPriceField').length;
            var z = len + 1;
            var y = z + 1;
            htmlAdd = '<div class="customPriceField row"><div class="form-group pos_relative2 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' </label>'
                    + '<div class="col-sm-4 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="units[' + len + '][name][en]" class="form-control productTitle' + z + '" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + ' <div class="col-sm-4 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
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
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
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
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
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

            $('.unitsData').append(htmlAdd);
            selectedsize = [];
            var prodata = JSON.parse($('#productData').val());
            var sizegroups = prodata.sizes;

            if (sizegroups.length > 0) {

                $(sizegroups).each(function (index, sizeAttr) {
                    var data = sizeAttr['sizeId'];
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

    });



//validations for each previous tab before proceeding to the next tab
    function managebuttonstate()
    {
        $("#nextbutton").removeClass("hidden");
        $("#prevbutton").addClass("hidden");
        $("#finishbutton").addClass("hidden");
    }
//    function managebutton()
//    {
//        $("#prevbutton").removeClass("hidden");
//        $("#finishbutton").removeClass("hidden");
//        $("#nextbutton").addClass("hidden");
//    }

    function firsttabvalidate(litabtoremove, divtabtoremove)
    {
        var pstatus = true;

        $(".error-box").text("");

        var val = $('.unitChecks:checked').map(function () {
            return this.value;
        }).get();

        var taxids = $('#tax').val();
        var taxflags = new Array();
        if (taxids) {
            var taxCount = taxids.length;

            for (var i = 1; i <= taxCount; i++) {
                if ($('#taxFlag_' + i).val() != '')
                    taxflags.push($('#taxFlag_' + i).val());
            }
        }

        if (val.length == 0) {
            $("#unit_error").text('Please select atleast one unit');
            pstatus = false;
        } else if (taxids == '' || taxids == null) {
            $("#text_tax").text('Please select atleast one tax');
            pstatus = false;
        } else if (taxflags.length == 0 || taxflags.length < taxCount) {
            $("#text_taxFlags").text('Please select atleast one tax type');
            pstatus = false;
        }

        if (pstatus === false)
        {
            setTimeout(function ()
            {
                proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
            }, 300);

            $("#tab1icon").removeClass("fs-14 fa fa-check");

            return false;
        }
        $("#tab1icon").addClass("fs-14 fa fa-check");
        $("#prevbutton").removeClass("hidden");
        $("#nextbutton").addClass("hidden");
        $("#finishbutton").removeClass("hidden");
        return true;
    }



    function proceed(litabtoremove, divtabtoremove, litabtoadd, divtabtoadd)
    {
        $("#" + litabtoremove).removeClass("active");
        $("#" + divtabtoremove).removeClass("active");

        $("#" + litabtoadd).addClass("active");
        $("#" + divtabtoadd).addClass("active");
    }

    /*-----managing direct click on tab is over -----*/

//manage next next and finish button
    function movetonext()
    {
        var currenttabstatus = $("li.active").attr('id');
        if (currenttabstatus === "firstlitab")
        {
            firsttabvalidate('secondlitab', 'tab2');
            proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
        }
    }

    function movetoprevious()
    {
        var currenttabstatus = $("li.active").attr('id');
        if (currenttabstatus === "secondlitab")
        {
            proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
            $("#prevbutton").addClass("hidden");
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");
        }
    }

</script>

<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
        <li><a href="<?php echo base_url(); ?>index.php?/AddNewProducts" class=""><?php echo $this->lang->line('LIST_PRODUCTS'); ?></a></li>
        <li style="width: 100px"><a href="#" class="active"><?php echo $this->lang->line('heading_add'); ?></a></li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- START PAGE CONTENT -->
    <div class="content">
        <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
            <li class="active tabs_active" id="firstlitab" onclick="managebuttonstate()">
                <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
            </li>
            <li class="tabs_active" id="secondlitab">
                <a data-toggle="tab" href="#tab2" onclick="firsttabvalidate('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>Products available in</span></a>
            </li>

        </ul>        
        <!-- START JUMBOTRON -->
        <div class=" bg-white" data-pages="parallax">
            <div class="inner"></div>

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="navbar-collapsible"  class="navbar-collapse collapse m-t-50">
                    <!-- Nav tabs -->

                    <!-- Tab panes onsubmit="return redirectToDest()"-->
                    <!--                    <form id="addentity" class="form-horizontal" role="form"
                                              action="<?php echo base_url(); ?>index.php?/AddNewProducts/AddNewProductData"
                                              method="post" enctype="multipart/form-data" >-->

                    <div class="tab-content">
                        <div class="tab-pane padding-20 slide-left active" id="tab1">

                            <div class="row unitsData">

                            </div>
                            <input type="hidden" name="productData" value id="productData"/>
                            <div class="row col-sm-3 error-box" id="unit_error"></div>
                            <br/>
                            <div class="row">
                                <div class="col-sm-4" >
                                    <a class="pull-left" id="addNewUnit" style="cursor:pointer;color:#0090d9; font-size: 13px;">Add New Unit</a>
                                </div>
                            </div>

                            <hr/>
                            <br/>
                            <div class="row">
                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Tax'); ?><span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6 pos_relative2">
                                    <select id="tax" name="tax[]"  class="multiple form-control error-box-class" multiple="multiple">
                                        <?php
                                        foreach ($taxData as $result) {
                                            echo "<option data-name='" . $result['name']['en'] . "' data-id=" . $result['Id'] . " value=" . $result['Id'] . ">" . $result['name']['en'] . "</option>";
                                        }
                                        ?>

                                    </select> 

                                </div>
                                <div class="col-sm-3 error-box redClass" id="text_tax"></div>

                            </div>
                            <br/>
                            <div class="row">
                                <div class="selectTax hidden "></div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-3 error-box redClass" id="text_taxFlags"></div>
                            </div>
                            <script>
                                var selected = [];
                                $('#tax').multiselect({
                                    selectAllValue: 'multiselect-all',
                                    includeSelectAllOption: true,
                                    enableFiltering: true,
                                    enableCaseInsensitiveFiltering: true,
                                    buttonWidth: '100%',
                                    maxHeight: 300,
                                    onChange: function (element, checked) {
                                        var brands = $('#tax option:selected');
                                        var i = 1;
                                        $(brands).each(function (index, brand) {
//                                                console.log($(this).attr('data-name'));

                                            if (selected.indexOf($(this).val()) == -1) {
                                                $('.selectTax').removeClass('hidden');
                                                $('.selectTax').append("<div class='row'><div class='form-group'  id='" + $(this).val() + "'><div class='col-sm-2'></div>\n\
                                                                    \n\<label for='fname' class='col-sm-2 control-label'>" + $(this).attr('data-name') + "<span class='MandatoryMarker'>*</span></label>\n\
                                                                    <div class='col-sm-4' ><select id='taxFlag_" + i + "' name='taxFlag[]' class='selectType form-control error-box-class'>\n\
                                                                    <option value='' >select Type </option>\n\
                                                                    <option value='0' >Inclusive </option>\n\
                                                                    <option value='1' >exclusive </option>\n\
                                                                    </select>\n\
                                                                    </div></div><div class='col-sm-3 error-box redClass' id='text_taxflag'></div></div>");
                                                selected.push($(this).val());
                                            }
                                            i++;
                                        });
                                        $('input:checkbox').each(function (index, value) {

                                            if ($(this).is(':checked')) {
                                            } else {

                                                var index = selected.indexOf($(this).val());
                                                if (index !== -1)
                                                    selected.splice(index, 1);
                                                $('#' + $(this).val()).remove();
                                            }
                                        });
                                    }
                                });

                            </script>
                        </div>

                        <div class="tab-pane slide-left padding-20" id="tab2">
                            <div class="row row-same-height">

                                <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                    <div class="table-responsive">
                                        <table class="table table-hover demo-table-search dataTable no-footer" id="businesstable" role="grid" aria-describedby="tableWithSearch_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                        Store Name</th>

                                                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                        <?php
                                                        if (is_array($AllBusinesses)) {
                                                            foreach ($AllBusinesses as $bizs) {
                                                                if ($bizs['added'] == '1') {
                                                                    $sid = '1';
                                                                } else {
                                                                    $sid = '0';
                                                                }
                                                            }
                                                        }
                                                        if ($sid != '1') {
                                                            echo ' <input type="checkbox"  id="selectbids"  onclick="selectall();">';
                                                        } else {
                                                            echo ' <input type="checkbox"  id="selectbids"  onclick="selectall();" checked disabled  >';
                                                        }
                                                        ?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?PHP
                                                $bid = 0;
                                                if (is_array($AllBusinesses)) {
                                                    foreach ($AllBusinesses as $bizs) {
                                                        ?>
                                                        <tr id='Row<?PHP echo $bid; ?>'>
                                                            <td> <label id=""><?PHP echo $bizs['name'][0]; ?></label></td>

                                                            <td  class="v-align-middle">
                                                                <div class="btn-group">
                                                                    <?PHP
                                                                    if ($bizs['added'] == '1') {
                                                                        echo '<input type="checkbox"  value="' . (string) $bizs['_id'] . '" checked disabled>';
                                                                        echo '<input type="hidden" class="selectbids" name="businesses[]" value="' . (string) $bizs['_id']['$oid'] . '">';
                                                                    } else {
                                                                        echo '<input type="checkbox"  class="selectbids" name="businesses[]" value="' . (string) $bizs['_id']['$oid'] . '" >';
                                                                    }
                                                                    ?>       
                                                                </div>
                                                            </td></tr>
                                                        <?PHP
                                                        $bid++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="modal-footer">
                                <ul class="pager wizard">
                                    <li class="next" id="nextbutton">
                                        <button class="btn btn-info  pull-right" type="button"
                                                onclick="movetonext()">
                                            <span>Next</span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-success  pull-right" type="button"
                                                onclick="submitform()">
                                            <span>Finish</span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-default  pull-right" type="button"
                                                onclick="movetoprevious()">
                                            <span>Previous</span>
                                        </button>
                                    </li>
                                </ul>

                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="current_dt" id="time_hidden" value="" />

                    <!--</form>-->
                </div>
            </div>
            <!-- END PANEL -->
        </div>

    </div>
    <!-- END JUMBOTRON -->

</div>
<!-- END PAGE CONTENT -->
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

                <button type="button" id="okbutton" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

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