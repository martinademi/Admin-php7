
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    .btn {
        border-radius: 25px !important;
    }
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }
    .pageAdj{
        margin-top: -35px;
        padding-top: 15px;
        margin-left: -50px;
        margin-right: -50px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
    position: absolute;
    margin-left: -21px;
    }
    .colorpicker-alpha{
        display:none !important;  
    }

    span.abs_text {
    position: absolute;
    right: 16px !important;
    top: 1px;
    z-index: 9;
    padding: 8px;
    background: #f1f1f1;
    border-right: 1px solid #d0d0d0;
    border-left: 1px solid #d0d0d0;
}

span.abs_text1 {
    position: absolute;
    right: 15px !important;
    top: 1px;
    z-index: 9;
    padding: 8px;
    background: #f1f1f1;
    border-right: 1px solid #d0d0d0;
    border-left: 1px solid #d0d0d0;
}

span.abs_textLeft {
    position: absolute;
    left: 16px !important;
    top: 1px;
    z-index: 9;
    padding: 8px;
    background: #f1f1f1;
    border-right: 1px solid #d0d0d0;
}
</style>
<script src="<?php echo base_url(); ?>/css/loadingImage.css"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.2/css/bootstrap-colorpicker.css" rel="stylesheet">	
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.2/js/bootstrap-colorpicker.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="<?= base_url() ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">
<link href="application/views/vehicleSettings/vehicleTypes/styles.css" rel="stylesheet" type="text/css">
<script>

var storeId;
var cityId;

$(document).ready(function (){

    var currencySymbol='<?php echo $citydata['currencySymbol'];?>';
    $('.currencySpan').text(currencySymbol);

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
<script type="text/javascript">
    var currentTab = 1;
    var cityId = "<?php echo $cityId; ?>";
    $(document).ready(function () {
        citiesList();
        editcitiesList();
        var status = 1;
        if (status == 1) {
            $('#btnStickUpSizeToggler').show();
            $('#bdelete').show();
            $('#unhide').hide();
        }

        $('#big_table_processing').show();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/table/' + status+'/'+cityId,
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
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

      function citiesList(){
        $.ajax({
               url: "<?php echo APILink ?>" + "admin/city",
              //url:"https://api.flexyapp.com/admin/city",
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 0
                },
                data: {                  
                },
            }).done(function(json) {
                
                $("#citiesList").html('');
                
                 for (var i = 0; i< json.data.length; i++) {
                
                    var citiesList = "<option value="+ json.data[i].id + ">"+  json.data[i].cityName +"</option>";
                    $("#citiesList").append(citiesList);  
                }

                $('#citiesList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '100%',
                    maxHeight: 300,
                });
        });
     }

     //edit citieslist
     function editcitiesList(){
        $.ajax({
               url: "<?php echo APILink ?>" + "admin/city",
              //url:"https://api.flexyapp.com/admin/city",
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 0
                },
                data: {                  
                },
            }).done(function(json) {
                
                $("#editcitiesList").html('');
                
                 for (var i = 0; i< json.data.length; i++) {
                
                    var citiesList = "<option value="+ json.data[i].id + " currency="+ json.data[i].currency + ">"+  json.data[i].cityName +"</option>";
                    $("#editcitiesList").append(citiesList);  
                }

                $('#editcitiesList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '100%',
                    maxHeight: 300,
                });
        });
     }

    });

   
</script>
<script>
    $(document).ready(function () {

        $('.store').click(function () {
            $('#typeStore').prop("checked", true);
//            $('#typeStore').val("2");
        });
        $('.resturant').click(function () {
            $('#typeResturant').prop("checked", true);
//            $('#typeResturant').val("1");
        });
        $('.shopping').click(function () {
            $('#typeShopping').prop("checked", true);
//            $('#typeShopping').val("3");
        });
		
		  $('.marijuana').click(function () {
            $('#typeMarijuana').prop("checked", true);
//            $('#typeMarijuana').val("3");
        });

        var id = '';
        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class').click(function () {
            $('.error-box').text('');
        });

        $('.businesscat').addClass('active');


      
        $(document).on('click', '.btnStickUpSizeToggler', function () {
            
            storeId=$(this).attr('storeType');
            cityId=$(this).attr('cityId');
            // cool
            $('#storeId').val(storeId);
            $('#cityId').val(cityId);         

            $.ajax({
                    url: '<?php echo base_url('index.php?/Pricing_Controller') ?>/getPriceByType/'+ storeId +'/'+ cityId,
                    type: 'POST',
                    data: {},
                    dataType: 'JSON',
                    success: function (response)
                    {   
                      
                         if(response.rel==1){
                                $('#myModal').modal('show');   
                                $('#orderCapacity').val(response.data.pricing.orderCapacity)
                                $('#baseFare').val(response.data.pricing.baseFare)
                                $('#mileage').val(response.data.pricing.mileage)
                                $('#mileage_after_x_km_mile').val(response.data.pricing.mileage_after_x_km_mile)
                                $('#price_after_x_minutesTripDuration').val(response.data.pricing.price_after_x_minutesTripDuration)
                                $('#x_minutesTripDuration').val(response.data.pricing.x_minutesTripDuration)
                                $('#price_after_x_minWaiting').val(response.data.pricing.price_after_x_minWaiting)
                                $('#x_minutesWaiting').val(response.data.pricing.x_minutesWaiting)
                                $('#price_MinimumFee').val(response.data.pricing.price_MinimumFee)
                                $('#price_after_x_minCancel').val(response.data.pricing.price_after_x_minCancel)
                                $('#x_minutesCancel').val(response.data.pricing.x_minutesCancel)
                                $('#price_after_x_minCancelScheduledBookings').val(response.data.pricing.price_after_x_minCancelScheduledBookings)
                                $('#x_minutesCancelScheduledBookings').val(response.data.pricing.x_minutesCancelScheduledBookings)
                        }else{

                            $("#updateRidePriceForm").trigger('reset');
                            $('#myModal').modal('show');   
                        }

                    }    

            });

    });


    $(document).on('click', '.btnStickUpSizeTogglerfixed', function () {
            
            storeId=$(this).attr('storeType');
            cityId=$(this).attr('cityId');
          
           $('#storeIdfixed').val(storeId);
           $('#cityIdfixed').val(cityId);    


           $.ajax({
                    url: '<?php echo base_url('index.php?/Pricing_Controller') ?>/getPriceByTypefixed/'+ storeId +'/'+ cityId,
                    type: 'POST',
                    data: {},
                    dataType: 'JSON',
                    success: function (response)
                    {   
                        console.log('response---',response)
                       if(response.rel==1){

                        var data=response.data.fixedPricing;
                        $('.customField').empty('');

                        $.each(data,function(index,value){
                            // cool12
                            console.log('val---',value)

                            var z = $('.customPriceField').length;
                            var y = z + 1;
                            var x =index+1;
                            var divElement1 = '<div class="customPriceField row" style="margin-left:32px"><div class="form-group pos_relative2 customPriceField' + z + '">'
                                + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Delivery Price ' + x + ' </label>'
                                + '<div class="col-sm-3 pos_relative2">'
                                + '<span  class="abs_text"><b><?php echo $citydata['currencySymbol'];?></b></span>'
                                + '<input type="text" name="fixedPricing[' + z + '][price]"  value="'+value.price+'" class="form-control productTitle" id="title' + z + '"  >'
                                + '</div>'
                                +  '<div class="col-sm-1 pos_relative2" style="margin-top:15px"> <span>Upto</span></div>'
                                + ' <div class="col-sm-2 pos_relative2">'
                                + ' <span  class="abs_text"><b><?php echo $citydata['mileageMetricText'];?></b></span>'
                                + ' <input type="text" maxlength="8" name="fixedPricing[' + z + '][upto]" value="'+value.upto+'" class="form-control productValue" id="value' + z + '"  onkeypress="return isNumberKey(event)">'
                                + ' </div>'
                                + '<div class=""></div>'
                                + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                                + '<span class="glyphicon glyphicon-remove"></span>'
                                + '</button>'
                                + '</div>'
                                + '<div class="form-group pos_relative2 customPriceField1">'
                                + '<label  class="col-sm-2 control-label"></label>'
                                +' <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div> </div>'
                               + '<div class="selectedsizeAttr row"></div></div>'
                            
                         $('.customField').append(divElement1);


                        });

                           
                                $('#myModalfixed').modal('show');   

                                // $('#title0').val(response.data.fixedPricing[0].price);
                                // $('#value0').val(response.data.fixedPricing[0].upto);
                               
                        }else{

                           
                            $("#updateRidePriceFormfixed").trigger('reset');
                            $('#myModalfixed').modal('show');   
                        }

                    }    

            });   

              $('#myModalfixed').modal('show');     

            

    });


        $('#bdelete').click(function () {
            $("#display-data").text("");
            $(".modalPopUpText").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            id = '';
            id = val;
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a category");
            } else if (val.length == 1 || val.length > 1)
            {
                $(".modalPopUpText").text("Do you wish to delete the selected categories ?");
                $("#display-data").text("");
                var BusinessId = val;
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
//                var condition = {MONGO_id: val};
                $("#confirmed").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/Pricing_Controller') ?>/operationCategory/delete",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {

                            $('.close').trigger("click");
                            $('#big_table_processing').show();
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/table/' + status+'/'+cityId,
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
                        }
                    });
                });
            }

        });


        $(":file").on("change", function (e) {
            var fieldID = $(this).attr('id');
            var ext = $(this).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                // cool
                //$('#imageErrorModal').modal('show')
                $(this).val('');
                alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
            } else
            {
                var type;
                var folderName;
                switch ($(this).attr('id'))
                {
                    case "banner_image":
                        type = 1; // banner image
                        folderName = 'bannerImages';
                        break;
                    case "logo_image":
                        type = 2; // logo image
                        folderName = 'logoImages';
                        break;
                    case "editbanner_image":
                        type = 3; // banner image
                        folderName = 'bannerImages';
                        break;
                    default :
                        type = 4; // logo image
                        folderName = 'logoImages';
                        break;

                }

                var formElement = $(this).prop('files')[0];
                var form_data = new FormData();

                form_data.append('OtherPhoto', formElement);
                form_data.append('type', 'storeCategory');
                form_data.append('folder', folderName);
                $.ajax({
                    url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",
                    async: false,
                    beforeSend: function () {
                        //                    $("#ImageLoading").show();
                    },
                    success: function (result) {

                        switch (type)
                        {
                            case 1:
                                $('#bannerImage').val(result.fileName);
                                $('.bannerImage').attr('src', result.fileName);
                                $('.bannerImage').show();
                                break;
                            case 2:
                                $('#logoImage').val(result.fileName);
                                $('.logoImage').attr('src', result.fileName);
                                $('.logoImage').show();
                                break;
                            case 3:
                                $('#editbannerImage').val(result.fileName);
                                $('.editbannerImage').attr('src', result.fileName);
                                $('.editbannerImage').show();
                                break;
                            case 4:
                                $('#editlogoImage').val(result.fileName);
                                $('.editlogoImage').attr('src', result.fileName);
                                $('.editlogoImage').show();
                                break;

                        }


                    },
                    error: function () {

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

        $('#insert').click(function () {
            var form_data1 = new FormData();
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            // var weight=$('#weightMetrics').val();
            var extrafee = $("#extraFee").val()
            var price=$('#price').val();
            var upperLimit=$('#upperLimit').val();
            var lowerLimit=$('#lowerLimit').val();
            var taxesApplicable = $("input[name='taxApplicable']:checked"). val();
            var cityId = "<?php echo $cityId; ?>";
            // var cname = $('#catname_0').val();
          //  var weightUnit=$('#weightUnit').val();
          
            // var availableInCities =new Array();        
            // $("#citiesList option:selected").each(function () {
            //    var $this = $(this);
            //    if ($this.length) {
            //     var selVal = $this.val();
            //     availableInCities.push(selVal);
            //    }
            // });

            

           
            // if (cname == "" || cname == null)
            // {
            //     $("#categoryError").text("");
            //     $("#categoryError").text("Please enter the  name");
            // } 
            // else
            //  if ( weight=='' || weight == null) {
            //     $("#categoryError").text("");
            //     $("#categoryError").text("Please enter the weight");
            // } else
             if (price == "" || price == null) {
                $("#categoryError").text("");
                $("#categoryError").text("Please price");
            } else if (upperLimit == "" || upperLimit == null) {
                $("#categoryError").text("");
                $("#categoryError").text("Please enter upper limit");
            } else if (lowerLimit == "" ||lowerLimit == null) {
                $('#displayData').modal('show');
                $('#display-data').text('Please enter lower limit')
            } else {           
              
                // var name = new Array();
             
                // $(".name").each(function () {
                //     form_data1.append('name[]', $(this).val());
                //     name.push($(this).val());
                // });
               
               
                // form_data1.append('weight', weight);
                form_data1.append('price', price);
                form_data1.append('upperLimit', upperLimit);
                form_data1.append('lowerLimit', lowerLimit);
                form_data1.append('extraFeeForExpressDelivery', extrafee);
                form_data1.append('taxesApplicable', taxesApplicable);
                form_data1.append('cityId',cityId);
                // form_data1.append('availableInCities', $("#citiesList").val());

                $.ajax({
                    url: "<?php echo base_url('index.php?/Pricing_Controller/operationCategory') ?>/insert",
                    type: 'POST',
                    data: form_data1,
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.msg == 1) {

                            $('.close').trigger('click');
                            var size = $('input[name=stickup_toggler]:checked').val()
                            var modalElem = $('#addmodal');
                            if (size == "mini")
                            {
                                $('#modalStickUpSmall').modal('show')
                            } else
                            {
                                $('#addmodal').modal('show');
                                $('.modalPopUpText').text('Packaging plan has been added successfully..');
                            }
                            $('#big_table_processing').show();
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/table/1/'+cityId,
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
                            $('.close').trigger('click');
                            var size = $('input[name=stickup_toggler]:checked').val()
                            var modalElem = $('#addmodal');
                            if (size == "mini")
                            {
                                $('#modalStickUpSmall').modal('show')
                            } else
                            {
                                $('#addmodal').modal('show')
                                if (size == "default") {
                                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                                } else if (size == "full") {
                                    modalElem.children('.modal-dialog').addClass('modal-lg');
                                }
                            }
                            $('.modalPopUpText').text('Category already exists..');
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

                $(".name").val("");
                $(".catDescription").val("");
                $("#cat_photos").val("");
                $('#myModal').hide();
            }
        });


        var editval = '';
        $(document).on('click', '.btnedit', function () {
          
            $("#display-data").text("");
            $('.editbannerImage,.editlogoImage').attr('src', "");
            $('#modalHeading').html("EDIT CATEGORY");
            editval = $(this).val();
            packageId= $(this).attr('package-id');
           
          
            $("#editcitiesList option:selected").prop("selected", false);
            $("#editcitiesList").multiselect('refresh')

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/get",
                type: 'POST',
                data: {val: editval, packageId : packageId},
                dataType: 'JSON',
                success: function (response)
                {
                        console.log(response);
                        var row = response.data;
                        console.log(row.laundry.taxesApplicable);
                        $('#editedId').val(row.laundry.packageId);  
                        $('#editedId').attr('cityId',response.cityId)                            
                        $('#Editprice').val(row.laundry.price);
                        $('#EditupperLimit').val(row.laundry.upperLimit);
                        $('#EditlowerLimit').val(row.laundry.lowerLimit);
                        $('#EditextraFee').val(row.laundry.extraFeeForExpressDelivery);
                        $("input[name=EdittaxApplicable][value=" + row.laundry.taxesApplicable + "]").attr('checked', 'checked');
                },


            });




            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#editModal');
            if (size == "mini")
            {
                $('#modalStickUpSmall').modal('show')
            } else
            {
                $('#editModal').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
            $("#errorboxdatas").text("Are you sure you wish to activate the category ?");

        });

        $('#editbusiness').click(function () {
            $("#display-data").text("");
            var form_data = new FormData();
            // var val = editval;
            $('.editclearerror').text("");
            // var editcatname = new Array();
            // var editcatnameDesc = new Array();
            // $(".Editcatname").each(function () {
            //     form_data.append('name[]', $(this).val());
            //     editcatname.push($(this).val());
            // });
          
            var price=$('#Editprice').val();
            var upperLimit=$('#EditupperLimit').val();
            var lowerLimit=$('#EditlowerLimit').val();
            var extrafee=$('#EditextraFee').val();
            var taxesApplicable=$("input[name='EdittaxApplicable']:checked"). val();
            var cityId = $("#editedId").attr('cityId');
            var packageId = $("#editedId").val();

            form_data.append('cityId', cityId);
            form_data.append('packageId', packageId);
            form_data.append('price', price);
            form_data.append('upperLimit', upperLimit);
            form_data.append('lowerLimit', lowerLimit);
            form_data.append('extrafee', extrafee); 
            form_data.append('taxesApplicable', taxesApplicable);                
                
            
           

           if (price == "" || price == null) {
                $("#categoryError").text("");
                $("#categoryError").text("Please price");
            } else if (upperLimit == "" || upperLimit == null) {
                $("#categoryError").text("");
                $("#categoryError").text("Please enter upper limit");
            } else if (lowerLimit == "" ||lowerLimit == null) {
                $('#displayData').modal('show');
                $('#display-data').text('Please enter lower limit')
            } else {

                $.ajax({
                    url: "<?php echo base_url('index.php?/Pricing_Controller/operationCategory') ?>/edit",
                    type: 'POST',
                    data: form_data,
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $('.close').trigger('click');
                        window.location.reload();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        });

        $('#hide').click(function () {
            $("#display-data").text("");
            $(".modalPopUpText").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            id = val;
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a plan");
            } else if (val.length >= 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#hideModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#hideModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $(".modalPopUpText").text("Are you sure you wish to deactivate plan");



            }

        });


        $("#btnHide").click(function () {
            var packageId=[];
            var count=0;
            var val = $('.checkbox:checked').map(function () {
                packageId[count++] = $(this).attr('package-id');
                return this.value;
            }).get();

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/hide",
                type: "POST",
                data: {cityList: val,packageList:packageId},
                dataType: 'json',
                success: function (response)
                {
                    if (response.flag == 1) {
                        $(".close").trigger("click");
                        $('#big_table_processing').show();
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/table/1/<?php echo $cityId; ?>',
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
                        $('#hideModal').modal('hide')
                        $('#displayData').modal('show');
                        $('#display-data').text('Category is already Hidden')

                    }
                }
            });
        });

        $('#unhide').click(function () {
            $("#display-data").text("");
            $(".modalPopUpText").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a plan");
            } else if (val.length >= 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#unhideModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show');
                } else {
                    $('#unhideModal').modal('show');
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $(".modalPopUpText").text("Are you sure you wish to activate plan");

            }
        });

        $("#btnUnhide11").click(function () {

           var packageId=[];
            var count=0;
            var val = $('.checkbox:checked').map(function () {
                packageId[count++] = $(this).attr('package-id');
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/unhide",
                type: "POST",
                data: {cityList: val,packageList:packageId},
                dataType: 'json',
                success: function (response)
                {
                    if (response.flag == 1) {
                        $(".close").trigger("click");
                        $('#big_table_processing').show();
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/table/0/<?php echo $cityId; ?>',
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
                        $('#displayData').modal('show');
                        $("#display-data").text("Category is already Activated");
                        $("#display-data").text("<?php echo $this->lang->line('Category is_already_Unhidden'); ?>");
                        $('#unhideModal').modal('hide');
                    }
                }
            });
        });

    });



    function moveUp(id) {
        var row = $(id).closest('tr');
        var prev_id = row.prev('tr').find('.moveUp').attr('id')
        var curr_id = row.find('.moveUp').attr('id');
        if (prev_id == undefined) {
            $('#displayData').modal('show');
            $('#display-data').text('<?php echo $this->lang->line('Cannot_reorder_,_Category_is_at_the_end..!!'); ?>')
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/order",
                type: "POST",
                data: {kliye: 'interchange', curr_id: curr_id, prev_id: prev_id},
                success: function (result) {

                }
            });
            row.prev().insertAfter(row);
            $('#saveOrder').trigger('click');
        }
//        });
    }
    function moveDown(id) {

        var row = $(id).closest('tr');
        var prev_id = row.find('.moveDown').attr('id');
        var curr_id = row.next('tr').find('.moveDown').attr('id');
        if (curr_id == undefined) {
            $('#displayData').modal('show');
            $('#display-data').text('<?php echo $this->lang->line('Cannot_reorder_,_Category_is_at_the_end..!!'); ?>')

        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/order",
                type: "POST",
                data: {kliye: 'interchange', prev_id: prev_id, curr_id: curr_id},
                success: function (result) {

//                    alert("intercange done" + result);

                }
            });
            row.insertAfter(row.next());
            $('#saveOrder').trigger('click');
        }
//        });
    }

    function validatecat() {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Pricing_Controller/operationCategory/validate",
            type: "POST",
            data: {catname: $('#catname_0').val()},
            dataType: "JSON",
            success: function (result) {

                // alert();
//                alert(result.count);
                console.log(result.count);
                $('#catname_0').attr('data', result.msg);

                if (result.count == true) {


                    $("#clearerror").html("<?php echo $this->lang->line('Category_name_already_exists.'); ?>");
                    $('#catname_0').focus();
                    return false;
                } else if (result.count != true) {
                    $("#clearerror").html("");

                }
            }
        });
    }

    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}


</script>


<script>
    $(document).ready(function () {
        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');

            if (currentTab != tab_id)
            {
//                console.log(tab_id);
                $('#big_table').hide();
                $("#display-data").text("");

                if ($(this).data('id') == 0) {
                    $("#display-data").text("");
                    $('#btnStickUpSizeToggler').hide();
                    $('#unhide').show();
                    $('#hide').hide();
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

                $("#display-data").text("");
                $('#btnStickUpSizeToggler').show();
                $('#unhide').hide();
                $('#hide').show();

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


    $(document).on('click', '#ridePriceUpdateButton', function () {
    

            if ($("#updateRidePriceForm").valid()) {

                $.ajax({
                    url: "<?php echo base_url('index.php?/Pricing_Controller') ?>/updateTypePrice",
                    type: 'POST',
                    data: $('#updateRidePriceForm').serialize(),
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.data == "Added successfully")
                        {
                            $('#myModal').modal('hide');
                        } else {
                            $('.ResponseErr').text(response.msg);
                        }
                    }
                });
            }

        })

        $(document).on('click', '#ridePriceUpdateButtonfixed', function () {
    

                if ($("#updateRidePriceFormfixed").valid()) {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/Pricing_Controller') ?>/updateTypePricefixed",
                        type: 'POST',
                        data: $('#updateRidePriceFormfixed').serialize(),
                        dataType: 'JSON',
                        success: function (response)
                        {
                            if (response.data == "Added successfully")
                            {
                                $('#myModalfixed').modal('hide');
                            } else {
                                $('.ResponseErr').text(response.msg);
                            }
                        }
                    });
                }

        })

        $('body').on('click', '.btnRemove', function () {
            $(this).parent().parent().remove();
            renameUnitsLabels();
        });

        // cool
        $(document).on('click', '#custom', function () {
            console.log('clicked')
            var len = $('.customPriceField').length;
            var z = len + 1;
            var y = z + 1;
            var divElement1 = '<div class="customPriceField row" style="margin-left:32px"><div class="form-group pos_relative2 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Mileage Price ' + z + ' </label>'
                    + '<div class="col-sm-3 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $citydata['currencySymbol'];?></b></span>'
                    + '<input type="text" name="fixedPricing[' + len + '][price]" class="form-control productTitle" id="title' + z + '"  >'
                    + '</div>'
                    +  '<div class="col-sm-1 pos_relative2" style="margin-top:15px"> <span>Upto</span></div>'
                    + ' <div class="col-sm-2 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php echo $citydata['mileageMetricText'];?></b></span>'
                    + ' <input type="text" maxlength="8" name="fixedPricing[' + len + '][upto]" class="form-control productValue" id="value' + z + '"  onkeypress="return isNumberKey(event)">'
                    + ' </div>'
                    + '<div class=""></div>'
                    + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                    + '<span class="glyphicon glyphicon-remove"></span>'
                    + '</button>'
                    + '</div>'
                    + '<div class="form-group pos_relative2 customPriceField1">'
	                + '<label  class="col-sm-2 control-label"></label>'
	                +' <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div> </div>'
                    + '<div class="selectedsizeAttr row"></div></div>'
                            
                 $('.customField').append(divElement1);
            

        });

</script>
<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong><?php echo $this->lang->line('PAGE_TITLE'); ?></strong>

        </div>


                <div class="panel panel-transparent">
                   <ul class="nav nav-tabs  bg-white whenclicked">
                        <li id= "my1" class="tabs_active active" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Pricing_Controller/operationCategory/table/1/<?php echo $cityId; ?>" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                        </li>

                      
                    </ul>

</div>
                   <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">

                            <div class="pull-left col-sm-6" >

                    <div class="">
                        <ul class="breadcrumb" style="background:white;margin-top: 0%;">
                            <li><a class="active" href="<?php echo base_url() ?>index.php?/City" class="">City</a> </li>
                            <li><a class="active" href="#" class=""><?= $citydata['cityName'] ?></a> </li>
                            <li><a class="active" href="#" class="">Delivery Pricing Plan</a> </li>
                        </ul>
                    </div>


                </div>
                                <div class="panel-heading">

                                    <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog">                                        
                                            <!-- Modal content-->
                                            <div class="modal-content">   
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                                    <span class="modal-title">ALERT</span>

                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="error-box modalPopUpText" id="display-data" style="text-align:center"></h5>                                            
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>     

                                    <div class="searchbtn row clearfix pull-right" style="">

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search"> </div>
                                    </div>

                                </div>
                                <br>
                                <div class="panel-body">
                                    <?php echo $this->table->generate(); ?>

                                </div>
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                


    </div>
    <!-- END PAGE CONTENT -->

</div>

<div class="modal fade stick-up" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Success Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="boxaddmodal">Category Added successfully..!!</div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default pull-right" id="confirmeds1" data-dismiss="modal" >OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="hideModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="boxhidemodal">Are you sure you want to hide the category?</div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-success pull-right" id="btnHide" data-dismiss="modal" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" ></div>

                </div>
            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="unhideModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" ></div>

                </div>
            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        <button type="button" class="btn btn-primary pull-right" id="btnUnhide11" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:0;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center">Delete</div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<!-- ******************************* -->
<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="updateRidePriceForm" action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title" ><?php echo 'Delivery Pricing'; ?></span>                   
                </div>
                <!-- <input type="hidden" name="documentId" class="documentId"> -->
                <div class="modal-body">
                    <!-- <input type="hidden" id="updateRidePriceId" name="updateRidePriceId"> -->
                    <div class="row row-same-height">
                       
                       
                        <input type="hidden" id='storeId' name='storeType' value="">
                        <input type="hidden" id='cityId' name='cityId' value="">


                        <div class="form-group specialTypeDiv" style="display:none;">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('label_vehicle_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4">
                                <div class="multiselect">
                                    <div class="selectBox" onclick="showSpecialType()">
                                        <select class="form-control" name="goodTypeSelect">
                                            <option><?php echo $this->lang->line('select_option'); ?></option>
                                        </select>
                                        <div class="overSelect"></div>
                                    </div>
                                    <div id="specialTypeCheckboxDiv">

                                    </div>

                                </div>
                                <label id="specialType-error" class="error" style="display:none">This field is required.</label>
                            </div>
                            <div class="col-sm-3 error-box" id=""></div>
                        </div>
                        <div class="form-group promotedTypeDiv" style="display:none;">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('label_vehicle_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4">
                                <div class="multiselect">
                                    <div class="selectBox" onclick="showPromotedType()">
                                        <select class="form-control" name="goodTypeSelect">
                                            <option><?php echo $this->lang->line('select_option'); ?></option>
                                        </select>
                                        <div class="overSelect"></div>
                                    </div>
                                    <div id="promotedTypeCheckboxDiv">

                                    </div>

                                </div>
                                <label id="promotedType-error" class="error" style="display:none">This field is required.</label>
                            </div>
                            <div class="col-sm-3 error-box" id=""></div>
                        </div>


                        <div class="form-group divSeatingCapacity" >
                            <label for="orderCapacity" class="col-sm-3 control-label"><?php echo 'Order Capacity'; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="orderCapacity" name="orderCapacity" class="form-control" value="" placeholder="Enter order capacity" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                            </div>
                            <div class="col-sm-3 error-box" id="orderCapacityErr"></div>
                        </div>

                      


                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_basefare'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="baseFare" name="baseFare" class="form-control autonumeric" value="" placeholder="Enter basefare" required="">

                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>
                            </div>
                            <div class="col-sm-3 pos_relative2">
                            </div>
                            <div class="col-sm-3 error-box" id="baseFareErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_mileage_price'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="input-group col-sm-4">
                                <input type="text" id="mileage" name="mileage" class="form-control autonumeric" placeholder="Enter mileage price" value="" required="">

                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ <span class="mileageMetricSpan" style="color: #73879C;"><?php echo $citydata['mileageMetricText'];?></span></span>

                            </div>
                            <div class="col-sm-5 pos_relative2">
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="mileage_after_x_km_mile" name="mileage_after_x_km_mile" class="form-control" value="" placeholder="Enter no .of <?php echo $mileageMetric; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <!-- <span class="abs_text Mileagemetric"><span class="mileageMetricSpan" style="color: #73879C;"></span></span> -->
                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ <span class="mileageMetricSpan" style="color: #73879C;"><?php echo $citydata['mileageMetricText'];?></span></span>
                            </div>
                            <div class="col-sm-3 error-box" id="mileageErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_time_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minutesTripDuration" name="price_after_x_minutesTripDuration" class="form-control autonumeric" placeholder="Enter Price per Minute" value="" required="">

                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ <?php echo $this->lang->line('lable_minutes'); ?></span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="x_minutesTripDuration" name="x_minutesTripDuration" class="form-control" placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes'); ?></span>
                            </div>
                            <div class="col-sm-3 error-box" id="price_after_x_minutesTripDurationErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_waiting_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minWaiting" name="price_after_x_minWaiting" class="form-control autonumeric" placeholder="Enter Price per Minute" value="" required="">

                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ Minutes</span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="x_minutesWaiting" name="x_minutesWaiting" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes'); ?></span>
                            </div>
                            <div class="col-sm-3 error-box" id="price_after_x_minWaitingErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_minimum_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_MinimumFee" name="price_MinimumFee" class="form-control autonumeric"  placeholder="Enter Price" value="" required="">

                                <span class="currencySpan abs_text1"  style="color: #73879C;"></span>

                            </div>

                            <div class="col-sm-3 error-box" id="price_MinimumFeeErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_on_demand_bookings_cancellation_fee'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minCancel" name="price_after_x_minCancel" class="form-control autonumeric" placeholder="Enter Price" value="" required="">

                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="x_minutesCancel" name="x_minutesCancel" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes'); ?></span>
                            </div>
                            <div class="col-sm-4 error-box" id="price_after_x_minCancelErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_scheduled_bookings_cancellation_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minCancelScheduledBookings" name="price_after_x_minCancelScheduledBookings" class="form-control autonumeric" placeholder="Enter Price" value="" required="">

                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <input style="padding-left : 12px" type="text" id="x_minutesCancelScheduledBookings" name="x_minutesCancelScheduledBookings" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes_before_pickup_time'); ?></span>
                            </div>
                            <div class="col-sm-3 error-box" id="price_after_x_minCancelScheduledBookingsErr"></div>
                        </div>

                       
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-sm-4 error-box errors responseErr"></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="ridePriceUpdateButton" >Save</button></div>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="ridePriceUpdateButtonfixed" style="display:none" >Save Fixed</button></div>
                        <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                    </div>
                </div>
            </form>   
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- fixed price modal -->

<div class="modal fade stick-up" id="myModalfixed" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:750px;">
        <div class="modal-content">
            <form id="updateRidePriceFormfixed" action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title" ><?php echo 'SET FIXED PRICE'; ?></span>                   
                </div>
                
                <div class="modal-body">
                  
                    <div class="row row-same-height">
                       
                       
                        <input type="hidden" id='storeIdfixed' name='storeType' value="">
                        <input type="hidden" id='cityIdfixed' name='cityId' value="">                     

                        <div class="customField  row" style="margin-top:15px">
                            <div class="customPriceField row" id="customePriceMain" style="margin-left:32px">


                                <div class="form-group pos_relative2 customPriceField1">
                                        <label id="titleLabel" for="fname" class="col-sm-2 control-label"><?php echo 'Delivery Price'; ?> 1<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-3 pos_relative2">
                                            <span  class="abs_text"><b><?php echo $citydata['currencySymbol'];?></b></span>
                                            <input type="text" name="fixedPricing[0][price]" class="error-box-class  form-control productTitle" id="title0"  >
                                        </div>
                                        <div class="col-sm-1 pos_relative2" style="margin-top:15px">
                                            <span>Upto</span>
                                        </div>
                                       
                                        <div class="col-sm-2 pos_relative2">
                                            <span  class="abs_text"><b><?php echo $citydata['mileageMetricText'];?></b></span>
                                            <input type="text" maxlength="8" name="fixedPricing[0][upto]" class="error-box-class  form-control productValue" id="value0"   >
                                        </div>

                                        <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>
                                </div>

                            </div>
                        </div>

                        <div id="main" class="row">
                            <button type="button" id="custom" value="Add"  class="btn btn-default marginSet btn-primary " style="margin-left: 609px;">
                                <span >Add</span>
                            </button>
                        </div>

                             
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-sm-4 error-box errors responseErr"></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="ridePriceUpdateButtonfixed" >Save</button></div>
                        <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                    </div>
                </div>
            </form>   
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>





   

   
