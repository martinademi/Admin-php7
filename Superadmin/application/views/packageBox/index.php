
<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<style>
    .btn{
        border-radius: 25px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }

    span.RemoveMore{
        margin-left: 8px;cursor: pointer;
    }

    .attributesData,.editattributesData{
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
    .tag:after{
        display: none;
    }

    table.sizetable {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

     td,th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    
    span.abs_text {
        position: absolute;
        right: 15px;
        top: 0px;
        z-index: 9;
        padding: 0px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }

    input.select2-search__field {
        width: 100% !important;
    }

    

</style>
 <script src="<?php echo base_url() ?>theme/assets/plugins/jquery-autonumeric/autoNumeric.js" type="text/javascript"></script>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script>
$(document).ready(function (){
    $('.numbervalidation').autoNumeric('init', {aSep: ','});

    $(document).on('click','.fg-button',function(){
        $("#select_all").prop("checked", false);
    });  

      $("body").on('click','#select_all',function(){ 
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    

       $("body").on('click','.checkbox',function(){ 
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }   
       });

});
</script>

<script>
    var currentTab = 1;
    var counter = 0;
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/PackageBox/size_details/1',
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
            },
            "columnDefs": [
                {  targets: "_all",
                    orderable: false 
                }
        ],
        };
        table.dataTable(settings);
        // search box for table

        $('#add').show();
        $('#edit').show();
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

        // get size chart

        $(document).on('click',".sizechartview",function(){
            var id = $(this).attr('data-id');
            $("#sizechartbody").empty();
            $("#errordata").text('');
            $.ajax({
                url: "<?php echo base_url('index.php?/packageBox') ?>/getSizeChart/" + id,
                type: "POST",
                data: {},
                dataType: "JSON",
                success: function (response) {
                         var tbody='';
                         var errodata = '';
                        var sizeData = response[0].sizeChart
                       $.each(sizeData, function (index, row) {
                          
                        tbody += `<tr><td>${row.standard}</td><td>${row['IN Men']}</td><td>${row['IN Women']}</td><td>${row['UK Men']}</td>
                        <td>${row['UK Women']}</td> <td>${row['US Men']}</td><td>${row['US Women']}</td><td>${row['EUR']}</td><tr>
                        `;
                    });
                    if(tbody == ''){
                        errodata = 'data not found';
                        $("#errordata").text('Data not found');
                    }
                    $("#sizechartbody").append(tbody);

                     $("#sizechart").modal('show');
               },
               error: function () {
   
               },
               cache: false,
               contentType: false,
               processData: false
           });

            
        });


        //  store category change event
        $('#storeCategory').on('change', function () {
           var valCat1 =  $('#storeCategory option:selected').val();
           var storeType = $('#storeCategory option:selected').attr('storetype');
          
                $.ajax({
                url: "<?php echo base_url('index.php?/AddNewProducts') ?>/getProductCategory/" + valCat1,
                type: "POST",
                data: {},
                dataType: "JSON",
                success: function (response) {
                   $('#category').empty();
                           var html = '';
                           var listData='';
                           var langData = <?php echo json_encode($language); ?>;
                           var lngcode;
                           html = '<option value="">Select Category</option>'
                       $.each(response, function (index, row) {
   
                               listData= (row.categoryName.en);
   
                              $.each(langData,function(i,lngrow){ 
                                   
                                lngcode= lngrow.langCode;
                                var lngvalue = row.categoryName[lngcode];
                                lngvalue = (lngvalue==''|| lngvalue==null )?"":lngvalue;
   
                                if(lngvalue){
                                   listData +=","+lngvalue; 
                                   }
                               });
                            
                            html += '<option  data-name="' + row.categoryName.en + '"value="' + row._id.$oid + '">' + listData + '</option>';
                    });
                     $('#category').append(html);
               },
               error: function () {
   
               },
               cache: false,
               contentType: false,
               processData: false
           });

        
    })

        // get existing size chart
        
        $('#subSubCategory').on('change', function () {
           var stpreCategory =  $('#storeCategory option:selected').val();
           var storeType = $('#storeCategory option:selected').attr('storetype');
           var catId =  $('#category option:selected').val();
           var categoryName =  $('#category option:selected').text();
           var subCatId =  $('#subCategory option:selected').val();
           var subCategoryName =  $('#subCategory option:selected').text();
           var subSubCatId =  $('#subSubCategory option:selected').val();
           var subSubCategoryName =  $('#subSubCategory option:selected').text();
           console.log(catId,subCatId,subSubCatId);
           
           if((storeType == 7 || storeType == 8) && subSubCatId ){

                $.ajax({
                url: "<?php echo base_url('index.php?/packageBox') ?>/sizeUrl",
                type: "POST",
                data: {
                    category:catId,subCategory:subCatId,subSubCategory:subSubCatId,
                    categoryName:categoryName,subCategoryName:subCategoryName,subSubCategoryName:subSubCategoryName
                    },
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    var result = response.data.data;
                    console.log(result);
                   $('#existsizejson').empty();
                           var html = '';
                           var listData='';
                           var langData = <?php echo json_encode($language); ?>;
                           var lngcode;
                           html = '<option value=""><?php echo $this->lang->line('label_existsize');  ?></option>'
                       $.each(result, function (index, row) {
   
                               listData= (row.jsonName);
   
                              $.each(langData,function(i,lngrow){ 
                                   
                                lngcode= lngrow.langCode;
                                var lngvalue = row.categoryName[lngcode];
                                lngvalue = (lngvalue==''|| lngvalue==null )?"":lngvalue;
   
                                if(lngvalue){
                                   listData +=","+lngvalue; 
                                   }
                               });
                            
                            html += '<option  data-name="' + row.jsonName + '"value="' + row.id + '">' + listData + '</option>';
                    });
                     $('#existsizejson').append(html);
                     $("#jsonlist").removeClass('hide');
                     $("#customSize").addClass('hide');
                     $("#customSizeAdd").addClass('hide');
                    },
                    error: function () {
        
                    }
                });

           }
    })

        // end


        // $('#category').on('change', function () {
        //     var val = $(this).val();
        //     $('#subCategory').load("<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData", {val: val});
        // });
        // $('#subCategory').on('change', function () {
        //     var val = $(this).val();
        //     $('#subSubCategory').load("<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList", {val: val});
        // });

        // $('#editcategory').on('change', function () {
        //     var val = $(this).val();
        //     $('#editsubCategory').load("<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData", {val: val});
        // });
        // $('#editsubCategory').on('change', function () {
        //     var val = $(this).val();
        //     $('#editsubSubCategory').load("<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList", {val: val});
        // });

//        $('#addAttributes').click(function ()
//        {
//            if ($('#attributes').val() == '')
//            {
//                $('#alertForNoneSelected').modal('show');
//                $("#display-data").text('Input field should not be empty');
//            } else {
//                counter += 1;
//                $('.attributesData').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#' + $(this).attr('data-id')).val() + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');
//                $('.attributesData').append('<span class="startDesc" id="' + $(this).attr('id') + counter + '"><input name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><input type="button" value="&#10008"  data-id="' + $(this).attr('id') + counter + '" class="RemoveMore"></span>');
//                $('#attributes').val('');
//
//            }
//        });
//        $('#editaddAttributes').click(function ()
//        {
//            if ($('#editattributes').val() == '')
//            {
//                $('#alertForNoneSelected').modal('show');
//                $("#display-data").text('Input field should not be empty');
//            } else {
//                counter += 1;
//                $('.editattributesData').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#' + $(this).attr('data-id')).val() + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');
//                $('.attributesData').append('<span class="startDesc" id="' + $(this).attr('id') + counter + '"><input name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><input type="button" value="&#10008"  data-id="' + $(this).attr('id') + counter + '" class="RemoveMore"></span>');
//                $('#editattributes').val('');
//
//            }
//        });

        $(document).on('click', '.RemoveMore', function ()
        {
            $('#' + $(this).attr('data-id')).remove();
        });

        $('#add').click(function () {
            $('.error-box-class').val('');
             $('.error-box').text('');
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                tabURL = $('li.active').children("a").attr('data');

                $("#display-data").text("");
                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();

                if (val.length == 0) {
					$('.attributesData').empty();
                    $('#addSize').modal('show');
                } else {
                    $('#alertForNoneSelected').modal('show');
                    $("#display-data").text("Invalid Selection");

                }
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Invalid Selection...');
            }
        });

        $("#yesAdd").click(function () {

            $('#yesAdd').prop('disabled', false);

            var sizeName = new Array();
            $(".sizename").each(function () {
                    sizeName.push($(this).val());
            });
            var weight = $('#weight').val();
                weight =  weight.replace( /,/g, "" );
                weight = parseFloat(weight);
            var sName = $('#name_0').val();
           
            var weightCapacityUnit = $("#weightCapacityUnit").val();         
                weightCapacityUnit = weightCapacityUnit== null ? '' :weightCapacityUnit[0] ;

            var voulumeCapacityUnit = $("#volumeCapacityUnit").val();
                voulumeCapacityUnit = voulumeCapacityUnit== null ? '' :voulumeCapacityUnit[0] ;

            var volumeCapacity = $('#volumeCapacity').val();
                volumeCapacity =  volumeCapacity.replace( /,/g, "" );
                volumeCapacity = parseFloat(volumeCapacity);

            var weightCapacityUnitName='';
            if(weightCapacityUnit){
                weightCapacityUnitName = $("#weightCapacityUnit option:selected").text();
                weightCapacityUnitName = weightCapacityUnitName.trim();
                }

            var voulumeCapacityUnitName='';
            if(voulumeCapacityUnit){
                voulumeCapacityUnitName = $("#volumeCapacityUnit option:selected").text();
                voulumeCapacityUnitName = voulumeCapacityUnitName.trim();
                }

            if (sName == '' || sName == null) {
                $('#name_0').focus();
                $("#text_name").text('<?php echo $this->lang->line('error_name'); ?>');
            } 
            else if(weight == '' || weight == null || weight <= 0){
                $('#weight').focus();
                $("#text_weight").text('<?php echo $this->lang->line('error_weight'); ?>');
            }
            else {

                $('#yesAdd').prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/packageBox') ?>/addSizeGroup",
                    type: "POST",
                    dataType: 'json',
                    data: {
                          name: sizeName,
                          weight: weight,
                          weightCapacityUnit:weightCapacityUnit,
                          volumeCapacity:volumeCapacity,
                          voulumeCapacityUnit:voulumeCapacityUnit,
                          weightCapacityUnitName:weightCapacityUnitName,
                          voulumeCapacityUnitName:voulumeCapacityUnitName
                        },
                    success: function (result) {
                        console.log(result)
                        if (result.flag == 1) {
                            $('#addSize').modal('hide');
                            window.location.reload();
                        } else if (result.flag == 0) {

                            $('#errorModal').modal('show')
                            $(".modalPopUpText").text('Size group is already exist');
                            $('#yesAdd').prop('disabled', false);
                        }
                    }

                });
                $(".error-box-class").val("");
            }

        });

        $('#edit').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length < 0 || val == '') {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_select'); ?>');
            } else if (val.length > 1) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_onceselect'); ?>');
            }
            if (val.length == 1) {
                $.ajax({
                    url: "<?php echo base_url('index.php?/packageBox') ?>/getSize",
                    type: "POST",
                    dataType: 'json',
                    data: {Id: $('.checkbox:checked').val()},
                    success: function (result) {
                        console.log("result==",result.data)
                        
                        $('#editname_0').val(result.data.name['en']);
                        <?php foreach ($language as $val) { ?>
                            $('#editname_<?= $val['lan_id'] ?>').val(result.data.name['<?= $val['langCode'] ?>']);
                        <?php } ?>

                        $("#editweight").val(result.data.weight);
                        $("#editvolumeCapacity").val(result.data.volumeCapacity);
                        $("#editweightCapacity").val(result.data.weightCapacity);

                        $("#editweightCapacityUnit").val('');
                        $("#editvolumeCapacityUnit").val('');

                        $("#editweightCapacityUnit").append(`<option value="${result.data.weightCapacityUnit}" selected>${result.data.weightCapacityUnitName}</option>`);
                        $("#editvolumeCapacityUnit").append(`<option value="${result.data.voulumeCapacityUnit}" selected>${result.data.voulumeCapacityUnitName}</option>`);
                        


                        $('#editSizeModal').modal('show');

                    }
                });
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Invalid Selection...');
            }

        });

        $("#yesEdit").click(function () {
            $(".error-box").text("");

            $(this).prop('disabled', false);

            var sizeName = new Array();
            $(".editsizename").each(function () {
                    sizeName.push($(this).val());
            });
            var weight = $('#editweight').val();
                weight =  weight.replace( /,/g, "" );
                weight = parseFloat(weight); 
           
            var volumeCapacity = $('#editvolumeCapacity').val();
                volumeCapacity =  volumeCapacity.replace( /,/g, "" );
                volumeCapacity = parseFloat(volumeCapacity);

            var weightCapacityUnit = $("#editweightCapacityUnit").val();         
                weightCapacityUnit = weightCapacityUnit== null ? '' :weightCapacityUnit[0] ;

            var voulumeCapacityUnit = $("#editvolumeCapacityUnit").val();
                voulumeCapacityUnit = voulumeCapacityUnit== null ? '' :voulumeCapacityUnit[0] ;

            var weightCapacityUnitName='';
            if(weightCapacityUnit){
                weightCapacityUnitName = $("#editweightCapacityUnit option:selected").text();
                weightCapacityUnitName = weightCapacityUnitName.trim();
                }

            var voulumeCapacityUnitName='';
            if(voulumeCapacityUnit){
                voulumeCapacityUnitName = $("#editvolumeCapacityUnit option:selected").text();
                voulumeCapacityUnitName = voulumeCapacityUnitName.trim();
                }
            if (sizeName.length <= 0)
            {
                $('#name_0').focus();
                $("#text_editname").text('<?php echo $this->lang->line('error_editname'); ?>');
            }else {
                $(this).prop('disabled', true);

               $.ajax({
                    url: "<?php echo base_url('index.php?/packageBox') ?>/editSize",
                    type: "POST",
                    data: {
                        sizeId: $('.checkbox:checked').val(),
                        sizeName: sizeName,
                        weight:weight,
                        weightCapacityUnit:weightCapacityUnit,
                        volumeCapacity:volumeCapacity,
                        voulumeCapacityUnit:voulumeCapacityUnit,
                        weightCapacityUnitName:weightCapacityUnitName,
                        voulumeCapacityUnitName:voulumeCapacityUnitName

                        },
                    success: function (result) {
                        if (result == 1) {
                            $('#editSizeModal').modal('hide');
                            window.location.reload();
                        }

                    }
                }); 
            }

        });

        $("#activate").click(function () {
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length >= 1) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#activateColor');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#activateColor').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxactivateColor").text('<?php echo $this->lang->line('alert_activate'); ?>');

            } else if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_select'); ?>');
            }

        });

        $("#yesActivate").click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            $.ajax({
                url: "<?php echo base_url('index.php?/packageBox') ?>/activateColor",
                type: "POST",
                data: {ids: val},
                success: function (result) {

                    var res = JSON.parse(result)
                    $('#activateColor').modal('hide');
                    if (res.flag == 0) {
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/PackageBox/size_details/2',
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
                                    },
            "columnDefs": [
                {  targets: "_all",
                    orderable: false 
                }
        ],
                        };

                        table.dataTable(settings);
                    } else {
                        $('#errorModal').modal('show')
                        $(".modalPopUpText").text('Selected size group has not been activated');
                    }
                }
            });
        });


        $("#deactivate").click(function () {
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length >= 1) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#deactivateColor');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#deactivateColor').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdeactivate").text('<?php echo $this->lang->line('alert_deactivate'); ?>');

            } else if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_oneselect'); ?>');
            }

        });

        $('#yesdeactivate').click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            $.ajax({
                url: "<?php echo base_url('index.php?/packageBox') ?>/deactivateColor",
                type: "POST",
                data: {ids: val},
                success: function (result) {
                    console.log(JSON.parse(result));
                    var res = JSON.parse(result)
                    $('#deactivateColor').modal('hide');
                    if (res.flag == 0) {
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/PackageBox/size_details/1',
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
                                    },
            "columnDefs": [
                {  targets: "_all",
                    orderable: false 
                }
        ],
                        };

                        table.dataTable(settings);
                    } else {
                        $('#errorModal').modal('show')
                        $(".modalPopUpText").text('Selected size group has not been deactivated');
                    }


                }
            })
        });

        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');

            if (currentTab != tab_id)
            {
//                console.log(tab_id);
                $('#big_table').hide();
                $("#display-data").text("");

                if ($(this).data('id') == 2) {
                    $("#display-data").text("");
                    $('#add').hide();
                    $('#edit').show();
                    $('#activate').show();
                    $('#deactivate').hide();
                }

                $('#big_table_processing').toggle();

                var table = $('#big_table');

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": $(this).attr('data'),
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 20,
                    "oLanguage": {
                    },
                    "fnInitComplete": function () {
                        //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
                        $('#big_table').show();
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
                            },
            "columnDefs": [
                {  targets: "_all",
                    orderable: false 
                }
        ],
                };

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');
                table.dataTable(settings);

            } else {

                $('#add').show();
                $('#edit').show();
                $('#activate').hide();
                $('#deactivate').show();

                $('#big_table_processing').toggle();

                var table = $('#big_table');

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": $(this).attr('data'),
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 20,
                    "oLanguage": {
                        "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                    },
                    "fnInitComplete": function () {
                        //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
                        $('#big_table').show();
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
                            },
            "columnDefs": [
                {  targets: "_all",
                    orderable: false 
                }
        ],
                };

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');
                table.dataTable(settings);

            }

        });

    });

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
                <li id= "my1" class="tabs_active active" style="cursor:pointer">
                    <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/PackageBox/size_details/1" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                </li>

                <li id= "my2" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/PackageBox/size_details/2" data-id="2"><span><?php echo $this->lang->line('heading_deactive'); ?></span> <span class="badge bg-red"></span></a>
                </li>
            </ul>
            <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

                <div class="pull-right m-t-10"> <button class="btn btn-info" id="deactivate"><?php echo $this->lang->line('button_deactivate'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-info" id="activate"><?php echo $this->lang->line('button_activate'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-info" id="edit"><?php echo $this->lang->line('button_edit'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="add"><?php echo $this->lang->line('button_add'); ?> </button></a></div>

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

                                    <div class="cs-loader">
                                        <div class="cs-loader-inner" >
                                            <label class="loaderPoint" style="color:#10cfbd">●</label>
                                            <label class="loaderPoint" style="color:red">●</label>
                                            <label class="loaderPoint" style="color:#FFD119">●</label>
                                            <label class="loaderPoint" style="color:#4d90fe">●</label>
                                            <label class="loaderPoint" style="color:palevioletred">●</label>
                                        </div>
                                    </div>

                                    <div cass="col-sm-6">
                                        <div class="searchbtn row clearfix pull-right" >
                                            <div class="pull-right"><input type="text" id="search-table"  style="margin-right:0px !important;" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                        </div>
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
    <!-- END FOOTER -->
</div>

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h4 id="modalTitle"></h4>
                </div>
            </div>

            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText modalTitleText " id="errorboxdata" ></div>
                </div>
            </div>
            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>

                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" >Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="addSize" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_add'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="sizename form-control error-box-class" id="name_0" name="sizeName[0]"  minlength="3" placeholder="Enter size name" required="">  

                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">
                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="sizeName[<?= $val['lan_id'] ?>]"  placeholder="Enter size name" class="sizename error-box-class  form-control">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">
                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="sizeName[<?= $val['lan_id'] ?>]"  placeholder="Enter size name" class="sizename error-box-class  form-control">
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_weight'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control error-box-class numbervalidation" id="weight" name="weight"  data-v-max="9999999999.99" data-m-dec="2" placeholder="Enter Weight">  
                        </div>

                    </div>

                    <!-- cool -->
                    <!-- weight capacity unit -->
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_weight_unit'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                        <select  id="weightCapacityUnit" class="js-example-weightCapacityUnit form-control " name="weightCapacityUnit" multiple="multiple">

                        </select>
                        </div>

                    </div>

                   
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo  $this->lang->line('label_capacity'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">                       
                            <input type="text" class="form-control error-box-class numbervalidation" id="volumeCapacity" name="volumeCapacity"  data-v-max="9999999999.99" data-m-dec="2" placeholder="Enter Volume Capacity">  

                        </div>

                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_capacity_unit'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                        <select  id="volumeCapacityUnit" class="js-example-volumeCapacityUnit form-control " name="volumeCapacityUnit" multiple="multiple">

                        </select>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_weight" style="color:red"></div>
                    </div>
                <!-- store category -->
                <!-- <div class="form-group  col-sm-12">
                    <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_storeCategory'); ?><span style="" class="MandatoryMarker"> *</span></label>
                    <div class="col-sm-8 pos_relative2">
                        <select id="storeCategory" name="storeCategory"  class="form-control error-box-class">
                            <option data-name="Select Category" value=""><?php echo $this->lang->line('label_SelectStoreCategory'); ?></option>

                            <?php
                                if(count($language) < 1){
                                    foreach ($storeCategory as $result) {
                                        
                                            echo "<option  value=". $result['_id']['$oid'] ."  data-name='" . $result['storeCategoryName']['en'] . "' storetype ='".$result['type'] ."' >" . $result['storeCategoryName']['en'] . "</option>";
                                        
                                    }
                                }
                                else{
                                    
                                    foreach ($storeCategory as $result) {
                                        $catData=$result['storeCategoryName']['en'];
                                        foreach($language as $lngData){
                                        $lngcode=$lngData['langCode'];
                                        $lngvalue= ($result['storeCategoryName'][$lngcode]=='') ? "":$result['storeCategoryName'][$lngcode];
                                        if(strlen( $lngvalue)>0){
                                            $catData.= ',' . $lngvalue;
                                            }
                                        }
                                        
                                            echo "<option  value=". $result['_id']['$oid'] . " storecategoryid='".$result['storeCategoryId']."' data-name='" .  $catData . "' storetype ='".$result['type'] ."'>" . $catData . "</option>";	
                                        
                                    }
                                }
                            ?>

                        </select> 


                    </div>
                </div>
                <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_storeCategory" style="color:red"></div>
                </div> -->
        <!-- store category end -->




                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel6"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesAdd" ><?php echo $this->lang->line('button_add'); ?></button></div>
                </div>

            </div>
        </div>


    </div>
</div>
<div id="editSizeModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_edit'); ?></span>
                <button type="button" class="close editSizeModalClosed">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="editsizename form-control error-box-class" id="editname_0" name="colorName[0]"  minlength="3" placeholder="Enter color name" required="">  

                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_editname" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="colorName[<?= $val['lan_id'] ?>]"  placeholder="Enter color name" class="editsizename error-box-class  form-control">

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="colorName[<?= $val['lan_id'] ?>]"  placeholder="Enter color name" class="editsizename error-box-class  form-control">

                                </div>

                            </div> 
                            <?php
                        }
                    }
                    ?>
                    <!-- cool -->
                     <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_weight'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control error-box-class numbervalidation" id="editweight" name="editweight"  data-v-max="9999999999.99" data-m-dec="2" placeholder="Enter Weight">  

                        </div>

                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_weight_unit'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                        <select  id="editweightCapacityUnit" class="js-example-editweightCapacityUnit form-control " name="editweightCapacityUnit" multiple="multiple">

                        </select>
                        </div>

                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_capacity'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">                       
                            <input type="text" class="form-control error-box-class numbervalidation" id="editvolumeCapacity" name="editvolumeCapacity"  data-v-max="9999999999.99" data-m-dec="2" placeholder="Enter Volume Capacity">  

                        </div>

                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_capacity_unit'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                        <select  id="editvolumeCapacityUnit" class="js-example-editvolumeCapacityUnit form-control " name="editvolumeCapacityUnit" multiple="multiple">

                        </select>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_weight" style="color:red"></div>
                    </div>


                    <!-- store category -->
                    <!-- <div class="form-group  col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_storeCategory'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-8 pos_relative2">
                            <select id="editstoreCategory" name="storeCategory"  class="form-control error-box-class">
                                <option data-name="Select Category" value=""><?php echo $this->lang->line('label_SelectStoreCategory'); ?></option>

                                <?php
                                    if(count($language) < 1){
                                        foreach ($storeCategory as $result) {
                                            
                                                echo "<option  value=". $result['_id']['$oid'] ."  data-name='" . $result['storeCategoryName']['en'] . "' storetype ='".$result['type'] ."' >" . $result['storeCategoryName']['en'] . "</option>";
                                            
                                        }
                                    }
                                    else{
                                        
                                        foreach ($storeCategory as $result) {
                                            $catData=$result['storeCategoryName']['en'];
                                            foreach($language as $lngData){
                                            $lngcode=$lngData['langCode'];
                                            $lngvalue= ($result['storeCategoryName'][$lngcode]=='') ? "":$result['storeCategoryName'][$lngcode];
                                            if(strlen( $lngvalue)>0){
                                                $catData.= ',' . $lngvalue;
                                                }
                                            }
                                            
                                                echo "<option  value=". $result['_id']['$oid'] . " storecategoryid='".$result['storeCategoryId']."' data-name='" .  $catData . "' storetype ='".$result['type'] ."'>" . $catData . "</option>";	
                                            
                                        }
                                    }
                                ?>

                            </select> 


                        </div>
                    </div> -->

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button"  class="btn btn-default btn-cons editSizeModalClosed"  id="cancel6"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesEdit" ><?php echo $this->lang->line('button_save'); ?></button></div>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="modal fade stick-up" id="activateColor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxactivateColor" style="text-align:center;font-size: 14px;">Activate</div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel5"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="yesActivate" ><?php echo $this->lang->line('button_activate'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="deactivateColor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DEACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxdeactivate" style="text-align:center;font-size: 14px;"><?php echo VEHICLEMODEL_DELETE; ?></div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel51"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdeactivate" ><?php echo $this->lang->line('button_deactivate'); ?></button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                <p class="error-box modalPopUpText"></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>

<div id="sizechart" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Size Chart</h4>
            </div>
            <div class="modal-body">
            <table class="sizetable">
             <thead class="tabledata">
             <tr>
             <th>Standard</th>
             <th>IN Men</th>
             <th>IN Women</th>
             <th>UK Men</th>
             <th>UK Women</th>
             <th>US Men</th>
             <th>US Women</th>
             <th>EUR</th>
             </tr>
             <thead> 
             <tbody id="sizechartbody" class="tabledata">
             </tbody>
            </table>
              <p id="errordata"style="text-align:center;padding: 10px;"></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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


//-------------------On click add ----------------------------------------
        $('#addAttributes').click(function ()
        {
            if ($('#attributes').val() == '')
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
                        //                        if ($('#<?php echo $lang['langCode']; ?>_attribute').val() != '')
                        //                        {
                        desc += $('#<?php echo $lang['langCode']; ?>_attribute').val();
                        desc += ',';

                        langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id') + '[]" id="<?php echo $lang['langCode']; ?>_addAttributes" class="<?php echo $lang['langCode']; ?>_Attributes  inputDesc"  type="text"  value="' + $('#<?php echo $lang['langCode']; ?>_attribute').val() + '">';
                        $('#<?php echo $lang['langCode']; ?>_attribute').val('');//Blank it after 
                        //                        }
        <?php
    }
}
?>

                if (desc != '')
                    desc = '(' + desc.replace(/,\s*$/, "") + ')';

                counter += 1;
                $('.attributesData').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#attributes').val() + ' ' + desc + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" id="en_addAttributes" class="en_Attributes inputDesc"  type="text"  value="' + $('#attributes').val() + '">' + langInput + '<span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');

                $('#attributes').val('');

            }
        });
        
        $('#editaddAttributes').click(function ()
        {
            if ($('#editattributes').val() == '')
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
                        //                        if ($('#<?php echo $lang['langCode']; ?>_attribute').val() != '')
                        //                        {
                        desc += $('#<?php echo $lang['langCode']; ?>_editattribute').val();
                        desc += ',';

                        langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id') + '[]" id="<?php echo $lang['langCode']; ?>_editAttributes" class="<?php echo $lang['langCode']; ?>_Attributes  inputDesc"  type="text"  value="' + $('#<?php echo $lang['langCode']; ?>_editattribute').val() + '">';
                        $('#<?php echo $lang['langCode']; ?>_editattribute').val('');//Blank it after 
                        //                        }
        <?php
    }
}
?>

                if (desc != '')
                    desc = '(' + desc.replace(/,\s*$/, "") + ')';

                counter += 1;
                $('.editattributesData').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#editattributes').val() + ' ' + desc + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" id="en_Attributes" class="en_Attributes inputDesc"  type="text"  value="' + $('#editattributes').val() + '">' + langInput + '<span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');

                $('#editattributes').val('');

            }
        });


$(".editSizeModalClosed").click(function(){
    $(".editattributesData").empty();
    $("#editSizeModal").modal('toggle');;
});

    });

    
    
</script>

<script>
        // get data for select2
        $(".js-example-weightCapacityUnit").select2({
            ajax: {
                url: "<?php echo ProductOffers;?>unitmeasurement",
                dataType: 'json',
                // headers: {
                //     'language':'en',
                //     'authorization':'<?php echo $this->session->userdata('godsviewToken');  ?>'
                // },
                delay: 100,
                data: function (params) {
                return {
                    q: params.term || "",
                    page: params.page
                };
                },
                processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                    more: (params.page * 20) < data.total_count
                    }
                };
                },
                cache: true
            },
            placeholder: 'Search like dozen, inch etc. ',
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            maximumSelectionSize: 1,
            maximumSelectionLength:1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width:'100%'
            });

        // voulume capacity
            $(".js-example-volumeCapacityUnit").select2({
            ajax: {
                url: "<?php echo ProductOffers;?>unitmeasurement",
                dataType: 'json',
                // headers: {
                //     'language':'en',
                //     'authorization':'<?php echo $this->session->userdata('godsviewToken');  ?>'
                // },
                delay: 100,
                data: function (params) {
                return {
                    q: params.term || "",
                    page: params.page
                };
                },
                processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                    more: (params.page * 20) < data.total_count
                    }
                };
                },
                cache: true
            },
            placeholder: 'Search like dozen, inch etc. ',
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            maximumSelectionSize: 1,
            maximumSelectionLength:1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width:'100%'
            });

            // edit for weight and volume
            $(".js-example-editweightCapacityUnit").select2({
            ajax: {
                url: "<?php echo ProductOffers;?>unitmeasurement",
                dataType: 'json',
                // headers: {
                //     'language':'en',
                //     'authorization':'<?php echo $this->session->userdata('godsviewToken');  ?>'
                // },
                delay: 100,
                data: function (params) {
                return {
                    q: params.term || "",
                    page: params.page
                };
                },
                processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                    more: (params.page * 20) < data.total_count
                    }
                };
                },
                cache: true
            },
            placeholder: 'Search like dozen, inch etc. ',
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            maximumSelectionSize: 1,
            maximumSelectionLength:1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width:'100%'
            });

        // voulume capacity
            $(".js-example-editvolumeCapacityUnit").select2({
            ajax: {
                url: "<?php echo ProductOffers;?>unitmeasurement",
                dataType: 'json',
                // headers: {
                //     'language':'en',
                //     'authorization':'<?php echo $this->session->userdata('godsviewToken');  ?>'
                // },
                delay: 100,
                data: function (params) {
                return {
                    q: params.term || "",
                    page: params.page
                };
                },
                processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                    more: (params.page * 20) < data.total_count
                    }
                };
                },
                cache: true
            },
            placeholder: 'Search like dozen, inch etc. ',
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            maximumSelectionSize: 1,
            maximumSelectionLength:1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width:'100%'
            });
    
     function formatRepo (repo) {
        if (repo.loading){
            return repo.text;
        }

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.text + "</div>";

        return markup;
    }

    function formatRepoSelection (repo) {
    return repo.full_name || repo.text;
    }
</script>
