
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
</style>
<script src="<?php echo base_url(); ?>/css/loadingImage.css"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.2/css/bootstrap-colorpicker.css" rel="stylesheet">	
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.2/js/bootstrap-colorpicker.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="<?= base_url() ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">
<script>
$(document).ready(function (){

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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/table/' + status+'/'+cityId,
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

        $('#btnStickUpSizeToggler').click(function () {
           
            $("#display-data").text("");
             $('.bannerImage,.logoImage').attr('src', "");
            $('.error-box-class').val("");
            $('.catname').val("");
            $('#categoryError').text("");

            $('.catDescription').val("");
           $('.editbannerImage,.editlogoImage').attr('src', "");
            
            $("#citiesList option:selected").prop("selected", false);
            $("#citiesList").multiselect('refresh')
           

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $('#modalHeading').html("ADD CATEGORY");
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#myModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#myModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
            } else {
                $('#displayData').modal('show');
                $("#display-data").text("Invalid selection");
            }
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
                        url: "<?php echo base_url('index.php?/Packaging_Controller') ?>/operationCategory/delete",
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/table/' + status+'/'+cityId,
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
                    url: "<?php echo base_url('index.php?/Packaging_Controller/operationCategory') ?>/insert",
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/table/1/'+cityId,
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
                url: "<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/get",
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
                    url: "<?php echo base_url('index.php?/Packaging_Controller/operationCategory') ?>/edit",
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
                url: "<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/hide",
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/table/1/<?php echo $cityId; ?>',
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
                url: "<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/unhide",
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/table/0/<?php echo $cityId; ?>',
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
                url: "<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/order",
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
                url: "<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/order",
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
            url: "<?php echo base_url() ?>index.php?/Packaging_Controller/operationCategory/validate",
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
            <strong><?php echo $this->lang->line('heading_page'); ?></strong>

        </div>


                <div class="panel panel-transparent">
                   <ul class="nav nav-tabs  bg-white whenclicked">
                        <li id= "my1" class="tabs_active active" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Packaging_Controller/operationCategory/table/1/<?php echo $cityId; ?>" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                        </li>

                        <li id= "my2" class="tabs_active" style="cursor:pointer">
                            <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/Packaging_Controller/operationCategory/table/0/<?php echo $cityId; ?>" data-id="0"><span><?php echo $this->lang->line('heading_deactive'); ?></span> <span class="badge bg-red"></span></a>
                        </li>
						
						
                        <div class="pull-right m-t-10  cls110"> <button style="margin-top:10px;" class="btn btn-primary" id="btnStickUpSizeToggler"><span><?php echo $this->lang->line('button_add'); ?></span></button></a></div>
                       
                        <div class="pull-right m-t-10 cls111"> <button style="margin-top:10px;" class="btn btn-warning" id="hide"><?php echo $this->lang->line('button_hide'); ?></button></a></div>
                        <div class="pull-right m-t-10 cls111"> <button style="margin-top:10px;" class="btn btn-success" id="unhide"><?php echo $this->lang->line('button_unhide'); ?></button></a></div>
                    </ul>

</div>
                   <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
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


<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">



    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?php echo $this->lang->line('heading_addCategory'); ?></span>

                <hr/>

                <div class="modal-body">

                    <!-- <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" class="error-box-class form-control name" id="catname_0" minlength="3" placeholder="<?php echo $this->lang->line('enter_name'); ?>" required="">  
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <div class="form-group col-sm-12">
                                    <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_Name'); ?>(<?php echo $val['lan_name']; ?>)</label>
                                    <div class="col-sm-7">
                                        <input type="text"  id="catname_<?= $val['lan_id'] ?>" name="name[<?= $val['lan_id'] ?>]" style="width: 100%;line-height: 2;" placeholder="<?php echo $this->lang->line('enter_name'); ?>" class="name form-control error-box-class" >
                                    </div>

                                </div>

                            <?php } else { ?>
                                <div class="form-group col-sm-12" style="display:none;">
                                    <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_Name'); ?>(<?php echo $val['lan_name']; ?>)</label>
                                    <div class="col-sm-7">
                                        <input type="text"  id="catname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 1.5;" placeholder="<?php echo $this->lang->line('enter_name'); ?>" class="name form-control error-box-class" >
                                    </div>

                                </div>

                                <?php
                            }
                        }
                        ?>
                    </div>      -->

                    <!-- <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_Weight'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="error-box-class form-control " id="weightMetrics" placeholder="<?php echo $this->lang->line('enter_name'); ?>" required="">  
                            </div>
                            <div class="col-sm-3">
                            <select class="form-control" id="weightUnit">
                            <option value="1">KG</option>
                                <option value="2">Ton</option>
                                <option value="3">Pound</option>
                               
                            </select>
                            </div>
                        </div>
                    </div>      -->

                       <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_Price'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" class="error-box-class form-control " id="price"  placeholder="<?php echo $this->lang->line('enter_price'); ?>" required="">  
                            </div>
                        </div>
                    </div>

                       <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_UL'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" class="error-box-class form-control " id="upperLimit"  placeholder="<?php echo $this->lang->line('enter_ul'); ?>" required="">  
                            </div>
                        </div>
                    </div>

                       <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_LL'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" class="error-box-class form-control " id="lowerLimit" minlength="3" placeholder="<?php echo $this->lang->line('enter_ll'); ?>" required="">  
                            </div>
                        </div>
                    </div>     
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_extraFee'); ?></label>
                            <div class="col-sm-7">
                                <input type="text" class="error-box-class form-control " id="extraFee"  placeholder="<?php echo $this->lang->line('enter_extraFee'); ?>" required="">  
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_TaxesApplicable'); ?></label>
                            <div class="col-sm-7">
                               <input type="radio" id="taxYes" name="taxApplicable" value="1" checked><label for="taxYes" style="padding: 5px;"><?php echo $this->lang->line('label_yes'); ?></label>
                               <input type= "radio" id="taxNo" name="taxApplicable" value="0"><label for="taxNo" for="taxNo" style="padding: 5px;" ><?php echo $this->lang->line('label_no'); ?></label>
                            </div>
                        </div>
                    </div>    


                  

                     <!-- <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label">City<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                            <select id="citiesList" name="company_select" class="form-control" style="width: 55% !important" multiple="multiple">
                                                 
                            </select>
                            </div>
                        </div>
                    </div> -->

                </div>

            </div>


            <div class="modal-footer">                            
                <div class="col-sm-6 error-box" id="categoryError" style="color:red;"></div>

                <div class="col-sm-6" >
                    <button type="button" class="btn btn-primary pull-right" id="insert" ><?php echo $this->lang->line('button_add'); ?></button>
                    <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_Cancel'); ?></button></div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
            </div>  
        </div>
        <!-- /.modal-content -->

    </div>
</div>






<div class="modal fade stick-up" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">Edit Category</span>
            </div>

            <div class="modal-body">

                <input type="hidden" id="editedId" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>                       

                <!-- <div id="Category_txt" >
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"> Name(English) <span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"   id="Editcatname_0" name="Editcatname[0]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <div class="form-group col-sm-12">
                                    <label for="fname" class="col-sm-4 control-label">Name (<?php echo $val['lan_name']; ?>)</label>
                                    <div class="col-sm-6">
                                        <input type="text"  id="Editcatname_<?= $val['lan_id'] ?>" name="Editcatname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group formex col-sm-12" style="display:none">
                                    <label for="fname" class="col-sm-5 control-label">Name (<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <input type="text"  id="Editcatname_<?= $val['lan_id'] ?>" name="Editcatname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div> -->

            <!-- cool -->

                     <!-- <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_Weight'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="error-box-class form-control " id="EditweightMetrics" placeholder="<?php echo $this->lang->line('enter_name'); ?>" required="">  
                            </div>
                            <div class="col-sm-3">
                            <select class="form-control" id="weightUnit">
                                <option value="1">KG</option>
                                <option value="2">Ton</option>
                                <option value="3">Pound</option>
                               
                            </select>
                            </div>
                        </div>
                    </div>      -->

                       <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_Price'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" class="error-box-class form-control " id="Editprice"  placeholder="<?php echo $this->lang->line('enter_price'); ?>" required="">  
                            </div>
                        </div>
                    </div>

                       <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_UL'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" class="error-box-class form-control " id="EditupperLimit"  placeholder="<?php echo $this->lang->line('enter_ul'); ?>" required="">  
                            </div>
                        </div>
                    </div>

                       <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_LL'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" class="error-box-class form-control " id="EditlowerLimit" minlength="3" placeholder="<?php echo $this->lang->line('enter_ll'); ?>" required="">  
                            </div>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_extraFee'); ?></label>
                            <div class="col-sm-7">
                                <input type="text" class="error-box-class form-control " id="EditextraFee"  placeholder="<?php echo $this->lang->line('enter_extraFee'); ?>" required="">  
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_TaxesApplicable'); ?></label>
                            <div class="col-sm-7">
                               <input type="radio" id="EdittaxYes" name="EdittaxApplicable" value="1" ><label for="EdittaxYes" style="padding: 5px;"><?php echo $this->lang->line('label_yes'); ?></label>
                               <input type= "radio" id="EdittaxNo" name="EdittaxApplicable" value="0"><label for="EdittaxNo" style="padding: 5px;" ><?php echo $this->lang->line('label_no'); ?></label>
                            </div>
                        </div>
                    </div>    

            

              

                
                
                <!-- <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label">City<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                            <select id="editcitiesList" name="editcitiesList" class="form-control editcitiesList" style="width: 55% !important" multiple="multiple">
                                                 
                            </select>
                            </div>
                        </div>
                    </div> -->

                <div class="modal-footer">
                    <div class="col-sm-4 error-box" id="editclearerror"></div>

                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        <button type="button" class="btn btn-primary pull-right" id="editbusiness" >Save</button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>

                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>  
    </div>

    <div id="wait" style="display:none;width:100px;height:100px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>pics/spinner.gif' width="64" height="64" /><br>Loading..</div>

      <!-- Modal -->
  <div class="modal fade" id="imageErrorModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>