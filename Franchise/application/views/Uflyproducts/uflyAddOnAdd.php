<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<style>
    .btn{
        border-radius: 25px !important;
        font-size: 10px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }

    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        width: 70%;
        margin: auto;
    }
    span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }

</style>
<script>
    var currentTab = 1;
    var centralAddOnid;
    $(document).ready(function () {

        $('#big_table_processing').show();
        $('.cs-loader').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/addOn_details/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
                $('.cs-loader').hide();
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

        unitdata();
        

        $('#addsentral').show();
        $('#delete').show();
        $('#activate').hide();
        $('#deactivate').show();

        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class').change(function () {
            $('.error-box').text('');
        });

        //tooltip
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });

        // set price for Addon
        $('#big_table').on("click", '.addOnsList', function () {

           $('#addOnsListData').empty();
            var id = $(this).attr('id');
            centralAddOnid=$(this).attr('id');
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/addOnsList/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html += '<tr><td style="text-align:center;width:250px;border-style: ridge;">' + k + '</td>';
                        html += '<td style="border-style: ridge;width:250px;text-align:center;">' + row.name.en + '</td>';
                        html +=  '<td style="border-style: ridge;width:250px;text-align:center;"><input type="text" class="form-control addOnPricedetail" id="addOnPrice" addOnName="'+  row.name.en +'" addonId="'+row.id.$oid +'" value="0"></td></tr>';//                        
                        k++;
                        
                    });
                    $('#addOnsListData').append(html);
                    $('#addOnsListModal').modal('show');
                }

            });
        });

        // edit price for Addon cool
           $('#big_table').on("click", '.viewAddOnsList', function () {
               
           $('#addOnsListDataPrice').empty();
            var id = $(this).attr('id');           
            centralAddOnid=$(this).attr('id');
            
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/editAddOnsList/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    console.log('data********',result);
                    
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html += '<tr><td style="text-align:center;width:250px;border-style: ridge;">' + k + '</td>';
                        html += '<td style="border-style: ridge;width:250px;text-align:center;">' + row.name.en + '</td>';
                        html +=  '<td style="border-style: ridge;width:250px;text-align:center;"><input type="text" class="form-control editaddOnPricedetail" id="addOnPrice" addOnName="'+  row.name.en +'" addonId="'+row.id +'" value="'+row.price+'"></td></tr>';//                        
                        k++;
                        
                    });
                    $('#addOnsListDataPrice').append(html);
                    $('#addOnsListModalPrice').modal('show');
                }

            });
        });


       $('.whenclicked li').click(function () {
            if ($(this).attr('id') == 0) {
                
                
                
                $('.addOnData').hide();
                $('.unitsDatabody').show();   
                $('#addNewUnit').show();  
                $('#tab2').show(); 
                $('#nexttab').show();                
                $('#confirmed1').hide();             
                $("#0").addClass("active");
                $("#1").removeClass("active");
                
           
              // unitdata();
            
            } else if ($(this).attr('id') == 1) {
                
                
                $('.addOnData').show();                
                $('.unitsDatabody').hide();
                $('#addNewUnit').hide();                 
                $('#nexttab').hide();                
                $('#confirmed1').show();
                $("#0").removeClass("active");
                $("#1").addClass("active");

            } 
        });

        function unitdata(){

           // $('.unitsDatabody').html(''); 
            $('.unitsDatabody').show(); 
             var val='<?php echo $unitId ?>';
                $.ajax({
                   url: '<?php echo base_url() ?>index.php?/AddNewProducts/getUnitsList',
                   type: "POST",
                   data: {val: val},
                   dataType: "JSON",
                   success: function (result) {

                       $('#productData').val(JSON.stringify(result.result));
                       var html = '';
                       var k = 1;
                       
                       $.each(result.data, function (i, row) {
                           console.log(row);
                           
                           html = '<div class="form-group formex ">'
                                   + '<div class="col-sm-12">'
                                   + '<div class="col-sm-4"><label class="control-label">' + row.name.en + '</label><input type="hidden" value="' + row.name.en + '" class="unitsTitle" /></div>'
                                   + '<div class="col-sm-4"><input type="text" value="' + row.price.en + '" class="form-control col-sm-12 unitsValue" onkeypress="return isNumberKey(event)"/></div>'
                                   + '<div class="col-sm-4"><input type="checkbox" class="checkbox unitChecks" value="' + row.unitId + '"/></div>'
                                   + '</div><br/><br/><hr/>';

                           $('.unitsDatabody').append(html);
                       });                    
                     
                     

                   }

               });
        }

        $('.changeMode').click(function () {
         
        //     var table = $('#big_table');
        //     $('#big_table').fadeOut('slow');
        //     $('#big_table_processing').show();
        //     var settings = {
        //         "autoWidth": false,
        //         "sDom": "<'table-responsive't><'row'<p i>>",
        //         "destroy": true,
        //         "scrollCollapse": true,
        //         "iDisplayLength": 20,
        //         "bProcessing": true,
        //         "bServerSide": true,
        //         "sAjaxSource": $(this).attr('data'),
        //         "bJQueryUI": true,
        //         "sPaginationType": "full_numbers",
        //         "iDisplayStart ": 20,

        //         "oLanguage": {
        //         },
        //         "fnInitComplete": function () {
        //             $('#big_table').fadeIn('slow');
        //             $('#big_table_processing').hide();
        //         },
        //         'fnServerData': function (sSource, aoData, fnCallback)
        //         {
        //             $.ajax
        //                     ({
        //                         'dataType': 'json',
        //                         'type': 'POST',
        //                         'url': sSource,
        //                         'data': aoData,
        //                         'success': fnCallback
        //                     });
        //         }
        //     };
            // $('.tabs_active').removeClass('active');
            // $(this).parent().addClass('active');
        //     table.dataTable(settings);
            
        });

        // remove bitton
        $('body').on('click', '.btnRemove', function () {
            $(this).parent().parent().remove();
            renameUnitsLabels();
        });

// add unit price
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

           $('.unitsDatabody').append(htmlAdd);
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

               $("#confirmed1").click(function () {
       
                
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
       
                //    var addon = [];
                //        $.each($(".addons option:selected"), function(){            
                //            addon.push($(this).val());
                //        });
                
                var addOnId = $('.checkboxProduct:checked').map(function()
                {
                    return $(this).val();
                }).get();
    
                    //  var addOnId = $(".checkboxProduct:checked").val();
                    
                   
                    
       
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
                           data: {val: val, productData: productData, unitsValue: unitsValue, unitsTitle: unitsTitle, unitsValueNew: unitsValueNew, unitsTitleNew: unitsTitleNew, unitarr: unitarr,addOnIds:addOnId},
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

    // cool
     

        $('#submitAddOndata').click(function(){
                   console.log('dat aprontrd');
                var centralAddOnids= centralAddOnid;
                var  storeId='<?php echo $storeID ?>';
                var dataArray = [];       
                $(".addOnPricedetail").each(function() {                    
                        var data = {
                          addOnId:$(this).attr('addonId'),
                          value :$(this).val()							                           
                        }
                        dataArray.push(data)
              });
            $.ajax({			
				 url:'<?php echo base_url();?>index.php?/AddNewProducts/AddnewAddOnData/',
			     type:'POST',
				 data: {centralAddOnids:centralAddOnids,addOnPrice:dataArray,storeId:storeId},
				 dataType: 'json',				

				 }).done(function(json){

                         $('#big_table_processing').show();
                        $('.cs-loader').show();
                        var table = $('#big_table');
                        $('#big_table').fadeOut('slow');
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/addOn_details/1',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                            },
                            "fnInitComplete": function () {
                                $('#big_table').fadeIn('slow');
                                $('#big_table_processing').hide();
                                $('.cs-loader').hide();
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

				 });                 
               });

            // edit AddOn price modal submit
             $('#editsubmitAddOndata').click(function(){
                console.log('dat aprontrd');
                var centralAddOnids= centralAddOnid;
                var  storeId='<?php echo $storeID ?>';
                var dataArray = [];       
                $(".editaddOnPricedetail").each(function() {                    
                        var data = {
                          addOnId:$(this).attr('addonId'),
                          value :$(this).val()							                           
                        }
                        dataArray.push(data)
              });
            $.ajax({			
				 url:'<?php echo base_url();?>index.php?/AddNewProducts/editAddnewAddOnData/',
			     type:'POST',
				 data: {centralAddOnids:centralAddOnids,addOnPrice:dataArray,storeId:storeId},
				 dataType: 'json',				

				 }).done(function(json){

                    consoel.log('done***********',json);    
					consoel.log('done***********',json.data);

				 });                 
               });

               $('#redirect').click(function(){

                window.location.href = '<?php echo base_url(); ?>index.php?/AddNewProducts/index';
               });
});

     

</script>

<script>
  function movetonext()
    {

       
        var currenttabstatus = $("li.active.unitsActive").attr('id');
      
        if (currenttabstatus === "0")
        {
           console.log('tab1');
            $('#nexttab').hide();
            $('#confirmed1').show();
            $('#addNewUnit').hide();
            $("#0").removeClass("active");
            $("#1").addClass("active");
            $('.unitsDatabody').hide();   
            $('.addOnData').show(); 
       
        } else if (currenttabstatus === "secondlitab")
        {
            console.log('tab1');
        }

    }
</script>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('heading_page'); ?></strong>
        </div>
        <!-- Nav tabs -->
        <div class="panel panel-transparent ">
            <!-- Nav tabs -->

            <ul class="nav nav-tabs  bg-white whenclicked">
              

                <li id= "0" class="active tabs_active unitsActive" style="cursor:pointer" href="#tab1">
                    <a  class="changeMode" data="index.php?/Category/operationCategory/table/1"><span>Unit</span></a>
                </li>
                 <li id= "1" class=" tabs_active unitsActive" style="cursor:pointer" href="#tab2">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/addOn_details/1" data-id="1"><span>AddOn</span></a>
                </li>
               
               
            </ul>
          
        </div>
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                  
                                </div>
                                &nbsp; 
                                <!-- add on data table --> 
                                <div class="panel-body addOnData" style="display:none" id="tab1">
                                    <?php echo $this->table->generate(); ?>
                                </div>
                                <!-- units table --> 
                                <div class="panel-body active" id="tab2">
                                    <div class="unitsDatabody" >
                                            
                                    </div>
                                <input type="hidden" value id="productData"/>
                                <div class="footerbody">
                                    <div class="row">
                                        <div class="col-sm-6" >
                                            <a class="pull-left" id="addNewUnit" style="cursor:pointer;color:#0090d9">Add New Unit</a>
                                        </div>
                                    
                                        <div class="col-sm-6 pull-right" >
                                            <button type="button" class="btn btn-primary pull-right changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/addOn_details/1" data-id="1" id="nexttab"   onclick="movetonext()" >NEXT</button>
                                        </div>
                                        <div class="col-sm-6 pull-right" >
                                            <button type="button" class="btn btn-primary pull-right" data-id="" id="confirmed1" style="display:none">ADD</button>
                                        </div>
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
    <!-- END FOOTER -->
</div>

<div class="modal fade stick-up" id="addOnsListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="color:blue">AddOns List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:10%;text-align: center;">SI NO.</th>
                            <th style="width:10%;text-align: center;">ADD-ONS</th>
                            <th style="width:10%;text-align: center;">PRICE</th>
                        </tr>
                    </thead>
                    <tbody id="addOnsListData">

                    </tbody>
                </table>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal" id="submitAddOndata">Ok</button>
        </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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

                <button type="button" class="btn btn-default" data-dismiss="modal" id="redirect">OK</button>
            </div>
        </div>

    </div>
</div>

<!-- // edit Addonprice cool-->
<div class="modal fade stick-up" id="addOnsListModalPrice" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="color:blue">AddOns List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:10%;text-align: center;">SI NO.</th>
                            <th style="width:10%;text-align: center;">ADD-ONS</th>
                            <th style="width:10%;text-align: center;">PRICE</th>
                        </tr>
                    </thead>
                    <tbody id="addOnsListDataPrice">

                    </tbody>
                </table>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal" id="editsubmitAddOndata">Ok</button>
        </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

