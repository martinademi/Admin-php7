
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
    $(document).ajaxComplete(function () {
        // console.log("hsdfsdf");
        var access_right_pg = '<?= $access_right_pg ?>';
        if (access_right_pg == 000) {
    //   base_url().'index.php?/superadmin/access_denied';
        } else if (access_right_pg == 100) {
            $('.cls110').remove();
            $('.cls111').remove();
        } else if (access_right_pg == 110) {
            $('.cls111').remove();
        } 
    });

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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/table/' + status,
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
           
           $("#webvisible").removeAttr('checked');

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
                        url: "<?php echo base_url('index.php?/StoreCategoryController') ?>/operationCategory/delete",
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/table/' + status,
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

                console.log('img---',$(this).attr('id'))
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
                    case "icon_logo_image":
                        type = 5; // banner image
                        folderName = 'iconImages';
                        break;
                    case "editiconlogo_image":
                        type = 6; // banner image
                        folderName = 'iconImages';
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

                        console.log('type',type)
                        console.log('resut--------',result)
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
                            case 5:
                                $('#iconlogoImage').val(result.fileName);
                                $('.iconlogoImage').attr('src', result.fileName);
                                $('.iconlogoImage').show();
                                break;
                            case 6:
                                $('#editiconlogoImage').val(result.fileName);
                                $('.editiconlogoImage').attr('src', result.fileName);
                                $('.editiconlogoImage').show();
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

            var isChecked = $('#typeResturant').attr('checked') ? true : false;
            var isCheckedStore = $('#typeStore').attr('checked') ? true : false;
            var isCheckedShopping = $('#typeShopping').attr('checked') ? true : false;
		    var isCheckedMarujiuana = $('#typeMarijuana').attr('checked') ? true : false;
            var isCheckedLaundry = $('#typeLaundry').attr('checked') ? true : false;

            var visibleInApp = $('#appvisible').attr('checked') ? "1" : "0";
            var visibleInWeb = $('#webvisible').attr('checked') ? "1" : "0";

            var bimg = $("#bannerImage").val();
            var logoimg = $("#logoImage").val();
            var iconlogoimg = $("#iconlogoImage").val();
           
            form_data1.append('bannerImage', bimg);
            form_data1.append('logoImage', logoimg);
            form_data1.append('iconlogoimg', iconlogoimg);
            
            var cname = $('#catname_0').val();
            var colorp=$('#colorval').val();
            var colorpicker = colorp.substring(1);
          
         
           
            //      var cityDetails = [];
            
            // $("#citiesList option:selected").each(function () {
            //    var $this = $(this);
            //    if ($this.length) {
            //     var selText = $this.text();
            //     var selVal = $this.val();

            //      var cityDetail = {
            //             cityId: selVal,
            //             cityName: selText 
            //         }
            //         cityDetails.push(cityDetail);
            //    }
            // });

    


             var availableInCities =new Array();        
            $("#citiesList option:selected").each(function () {
               var $this = $(this);
               if ($this.length) {
                var selVal = $this.val();
                availableInCities.push(selVal);
               }
            });

           
            if (cname == "" || cname == null)
            {
                $("#categoryError").text("");
                $("#categoryError").text("Please enter the category name");
            } 
            // else if (isCheckedStore == false && isChecked == false && isCheckedShopping == false && isCheckedMarujiuana == false && isCheckedLaundry == false ) {
            //     $("#categoryError").text("");
            //     $("#categoryError").text("Please select the type");
            // } 
            else if (bimg == "" || bimg == null) {
                $("#categoryError").text("");
                $("#categoryError").text("Please select the banner image");
            } else if (logoimg == "" || logoimg == null) {
                $("#categoryError").text("");
                $("#categoryError").text("Please select the logo image");
            } else if (val.length == 1 || val.length > 1) {
                $('#displayData').modal('show');
                $('#display-data').text('Invalid Selection')
            } else {
                var imgUrl = '';
               // var type1 = $('input[name=type]:checked').val();
               // var typeName = $('input[name=type]:checked').attr('typeName');
                var type1 = $("#storeType option:selected").val();
                var typeName = $("#storeType option:selected").attr('data-name');
                var deliverTo=$('input[name=deliverTo]:checked').val();             
                var deliverToMsg=$('input[name=deliverTo]:checked').attr('deliverTo');  
                var cartsAllowed=$('input[name=cartsAllowed]:checked').val();             
                var cartsAllowedMsg=$('input[name=cartsAllowed]:checked').attr('data-msg');  
              

                var name = new Array();
                var catDescription = new Array();
                $(".name").each(function () {
                    form_data1.append('name[]', $(this).val());
                    name.push($(this).val());
                });
                $(".catDescription").each(function () {
                    form_data1.append('description[]', $(this).val());
                    catDescription.push($(this).val());
                });

                var visibility = parseInt(1);
                form_data1.append('visibility', visibility);
                form_data1.append('type', type1);
                form_data1.append('typeName', typeName);
                form_data1.append('deliverTo', deliverTo);
                form_data1.append('deliverToMsg', deliverToMsg);
                form_data1.append('cartsAllowed', cartsAllowed);
                form_data1.append('cartsAllowedMsg', cartsAllowedMsg);
                form_data1.append('colorCode', colorpicker);
                
                form_data1.append('availableInCities', $("#citiesList").val());
                form_data1.append('visibleInApp', visibleInApp);
                form_data1.append('visibleInWeb', visibleInWeb);

                $.ajax({
                    url: "<?php echo base_url('index.php?/StoreCategoryController/operationCategory') ?>/insert",
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
                                $('.modalPopUpText').text('Category has been added successfully..');
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/table/1',
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
        $(document).on('click', '#btnEdit', function () {
            
            $("#display-data").text("");
            $('.editbannerImage,.editlogoImage').attr('src', "");
            $('#modalHeading').html("EDIT CATEGORY");
            editval = $(this).val();
           
          
            $("#editcitiesList option:selected").prop("selected", false);
            $("#editcitiesList").multiselect('refresh')

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/get",
                type: 'POST',
                data: {val: editval},
                dataType: 'JSON',
                success: function (response)
                {

                   console.log('data---',response)
                    $.each(response, function (index, row) {
                        // edit cities
                        console.log("---------", row);

                        $('#editedId').val(row._id.$oid);
                        $('#Editcatname_0').val(row.storeCategoryName['en']);
<?php foreach ($language as $val) { ?>
                            $('#Editcatname_<?= $val['lan_id'] ?>').val(row.storeCategoryName['<?= $val['langCode'] ?>']);
<?php } ?>
                        $('#EditcatDescription_0').val(row.storeCategoryDescription['en']);
<?php foreach ($language as $val) { ?>
                            $('#EditcatDescription_<?= $val['lan_id'] ?>').val(row.storeCategoryDescription['<?= $val['langCode'] ?>']);
<?php } ?>

                        
                        
                        $("#editappvisible").prop('checked',row.visibleInApp);
                        $("#editwebvisible").prop('checked',row.visibleInWeb); 
                        

                        $('#editstoreType').val(row.type);

                         if(row.deliverTo == 0){
                            $('#editdeliverToStore').prop("checked", true);
                        }else if(row.deliverTo == 1){
                            $('#editdeliverToDriver').prop("checked", true);
                        }

                       


                        if(row.cartsAllowed ==1){
                            $('#editsinglestore').prop("checked", true);
                        }else if(row.cartsAllowed == 2){
                            $('#editmultiplestore').prop("checked", true);
                        }else if(row.cartsAllowed == 3){
                            $('#editmultiplestorecat').prop("checked", true);
                        }




                        //edit citied
                          //multiselect
                    $.each( row.availableInCities, function(index,val){
                        var citydata=val;
                        var res = citydata.split(",");                      
                        $('#editcitiesList').multiselect('select', res);
                    });
                       
                        if (row.bannerImage) {
                            $('#editbannerImage').val(row.bannerImage);
                            $('.editbannerImage').attr('src', row.bannerImage);
                            $('.editbannerImage').show();
                        }
                        if (row.logoImage) {
                            $('#editlogoImage').val(row.logoImage);
                            $('.editlogoImage').attr('src', row.logoImage);
                            $('.editlogoImage').show();
                        }
                        if (row.iconlogoimg) {
                            $('#editiconlogoImage').val(row.iconlogoimg);
                            $('.editiconlogoImage').attr('src', row.iconlogoimg);
                            $('.editiconlogoImage').show();
                        }

                    });
                    $('#editcolorval').val('#'+response.data.colorCode);
                    $('#editcolorval').keyup();
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

            console.log('clike');

            $("#display-data").text("");
            var form_data = new FormData();
            var val = editval;
            $('.editclearerror').text("");
            var editcatname = new Array();
            var editcatnameDesc = new Array();
            $(".Editcatname").each(function () {
                form_data.append('name[]', $(this).val());
                editcatname.push($(this).val());
            });

            $(".EditcatDescription").each(function () {
                form_data.append('description[]', $(this).val());
                editcatnameDesc.push($(this).val());
            });
            
           
            var editvisibleInApp = $('#editappvisible').attr('checked') ? "1" : "0";
            var editvisibleInWeb = $('#editwebvisible').attr('checked') ? "1" : "0";
          

              var availableInCities =new Array();        
            // $("#editcitiesList option:selected").each(function () {
            //    var $this = $(this);
            //    if ($this.length) {
            //     var selVal = $this.val();
            //     availableInCities.push(selVal);
            //    }
            // });
            
            // cool

            var catName = $('#Editcatname_0').val();

            var editbimg = $("#editbannerImage").val();
            var editlogoimg = $("#editlogoImage").val();
            var editiconlogoimg = $("#editiconlogoImage").val();
            
           
            var colorp=$('#editcolorval').val();
            var colorpicker = colorp.substring(1);

            form_data.append('bannerImage', editbimg);
            form_data.append('logoImage', editlogoimg);
            form_data.append('iconlogoimg', editiconlogoimg);


            form_data.append('editvisibleInApp', editvisibleInApp);
            form_data.append('editvisibleInWeb',editvisibleInWeb);

            form_data.append('editId', val);
            
            // var type = $('input[name=edittype]:checked').val();
            // var typeName = $('input[name=edittype]:checked').attr('typeName');

            var type = $("#editstoreType option:selected").val();
            var typeName = $("#editstoreType option:selected").attr('data-name');

            var deliverTo=$('input[name=editdeliverTo]:checked').val();
            var deliverToMsg=$('input[name=editdeliverTo]:checked').attr('deliverTo');  
            var cartsAllowed=$('input[name=editcartsAllowed]:checked').val();             
            var cartsAllowedMsg=$('input[name=editcartsAllowed]:checked').attr('data-msg');              
            form_data.append('type', type);
            form_data.append('typeName', typeName);
            form_data.append('deliverTo', deliverTo);
            form_data.append('deliverToMsg', deliverToMsg);
            form_data.append('cartsAllowed', cartsAllowed);
            form_data.append('cartsAllowedMsg', cartsAllowedMsg);
            form_data.append('colorCode', colorpicker);
            form_data.append('', colorpicker);
            form_data.append('availableInCities', $("#editcitiesList").val());
            
           

            if (catName == "" || catName == null) {
                $("#editclearerror").text("Please enter the Category name");
            } else {

                $.ajax({
                    url: "<?php echo base_url('index.php?/StoreCategoryController/operationCategory') ?>/edit",
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
                $("#display-data").text("Please select a category");
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

                $(".modalPopUpText").text("Are you sure you wish to deactivate category");



            }

        });


        $("#btnHide").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/hide",
                type: "POST",
                data: {val: val},
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/table/1',
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
                $("#display-data").text("Please select a category");
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

                $(".modalPopUpText").text("Are you sure you wish to activate category");

            }
        });

        $("#btnUnhide11").click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/unhide",
                type: "POST",
                data: {val: val},
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/table/' + status,
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
                url: "<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/order",
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
                url: "<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/order",
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
            url: "<?php echo base_url() ?>index.php?/StoreCategoryController/operationCategory/validate",
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
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/StoreCategoryController/operationCategory/table/1" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                        </li>

                        <li id= "my2" class="tabs_active" style="cursor:pointer">
                            <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/StoreCategoryController/operationCategory/table/0" data-id="0"><span><?php echo $this->lang->line('heading_deactive'); ?></span> <span class="badge bg-red"></span></a>
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

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
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

                    <div class="row">
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
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_Desc'); ?></label>
                            <div class="col-sm-7">
                                <textarea type="text"  id="catDescription_0" name="Fdata[catDescription]"  class="catDescription form-control error-box-class" style="max-width: 100%;"></textarea>
                                <input type="hidden" id="cat_photosamz" name="cat_photosamz" value=""/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <div class="form-group col-sm-12">
                                    <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_Desc'); ?>(<?php echo $val['lan_name']; ?>)</label>
                                    <div class="col-sm-7">
                                        <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]" style="max-width: 100%;line-height: 2;" class="catDescription form-control error-box-class" ></textarea>
                                    </div>

                                </div>


                            <?php } else { ?>

                                <div class="form-group col-sm-12" style="display:none;">
                                    <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_Desc'); ?>(<?php echo $val['lan_name']; ?>)</label>
                                    <div class="col-sm-7">
                                        <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]" style=" max-width: 100%;line-height: 2;" class="catDescription form-control error-box-class" ></textarea>
                                    </div>

                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_Type'); ?><span class="MandatoryMarker"> *</span></label>

                            <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" typeName="Restaurant" class="resturant"  name="type" id="typeResturant" value="1">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="fname"  class=" col-sm-3 control-label"><?php echo "Food"; ?></label>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" class="store" typeName="Store" name="type" id="typeStore" value="2">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Store'); ?></label>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" class="shopping" typeName="Shopping" name="type" id="typeShopping" value="3">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="fname" class="col-sm-3 control-label "><?php echo "Retail"; ?></label>
                                </div>

                            </div>
							 <div class="col-sm-4" style="display:none">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" class="marijuana" typeName="Marijuana" name="type" id="typeMarijuana" value="4">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="fname" class="col-sm-3 control-label ">Marijuana</label>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" class="laundry" typeName="Laundry" name="type" id="typeLaundry" value="5">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="fname" class="col-sm-3 control-label ">Laundry</label>
                                </div>

                            </div>

                        </div>
                    </div> -->

                      <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_Type'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                            <select  class="form-control" name="storeType" id="storeType">
                                <option value="1" data-name="Food">Food</option>
                                <option value="2" data-name="Grocery">Grocery</option>
                                <option value="3" data-name="Fashion">Fashion</option>
                                <option value="4" data-name="Order Anything">Order Anything</option>
                                <option value="5" data-name="Laundry">Laundry</option>
                                <option value="6" data-name="Pharmacy">Pharmacy</option>
                                <option value="7" data-name="Send Anything">Send Anything</option>
                                <option value="8" data-name="Liquor">Liquor</option>
                            </select>
                            </div>
                        </div>
                    </div>



                            <!-- visibility option for app and dispatcher -->
                            <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="visibleapp" class="col-sm-4 control-label"><?php echo "Visibility"; ?></label>

                             <div class="col-sm-4">
                                <input style="cursor: pointer" type="checkbox" class="col-sm-1"  name="categoryVisibility" id="appvisible" value="0" checked>
                                <label style="cursor: pointer" for="appvisible" class="col-sm-11 control-label "><?php echo "Visible in App" ?></label>

                            </div>

                            <div class="col-sm-4">

                                <input style="cursor: pointer" type="checkbox"  class="col-sm-1"  name="categoryVisibility" id="webvisible" value="1">
                                <label style="cursor: pointer" for="webvisible"  class="col-sm-11 control-label"><?php echo "Visible in Web"; ?></label>
                            </div>
                           
                           

                        </div>
                    </div>


                     <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo "Deliver To"; ?><span class="MandatoryMarker"> *</span></label>

                             <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" class="deliverToStore" deliverTo="deliverToStore" name="deliverTo" id="deliverToStore" value="0" checked>
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="deliverTo" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Store'); ?></label>
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio"  class="deliverToDriver" deliverTo="deliverToDriver"  name="deliverTo" id="deliverToDriver" value="1">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="deliverTo"  class=" col-sm-3 control-label"><?php echo "Driver"; ?></label>
                                </div>

                            </div>
                           
                           

                        </div>
                    </div>


                    <!-- cart functionality -->
                      <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo "Carts Allowed"; ?><span class="MandatoryMarker"> *</span></label>

                             <div class="col-sm-6">
                                <div >
                                    <input style="cursor: pointer" type="radio" class="cartsAllowed"  data-msg="Singlecartsinglestore" name="cartsAllowed" id="singlestore" value="1" checked>
                                    <label style="cursor: pointer" for="deliverTo" class=" control-label "><?php echo 'Single cart single store'; ?></label>
                                </div>
                                <div >
                                   
                                </div>
                            </div>                               
                                                 

                        </div>
                    </div>

                     <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"></label>

                             <div class="col-sm-6">
                                <div >
                                    <input style="cursor: pointer" type="radio"  class="cartsAllowed"  data-msg="SinglecartMultiplestore" name="cartsAllowed" id="multiplestore" value="2">
                                    <label style="cursor: pointer" for="deliverTo"  class=" control-label"><?php echo "Single cart Multiple store"; ?></label>
                                </div>
                               

                            </div>                          
                                                 

                        </div>
                    </div>


                     <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"></label>

                             <div class="col-sm-6">
                                <div >
                                    <input style="cursor: pointer" type="radio"  class="cartsAllowed"  data-msg="SinglecartMultipleStoreCategory" name="cartsAllowed" id="multiplestorecat" value="3">
                                    <label style="cursor: pointer" for="deliverTo"  class=" control-label"><?php echo "Single cart Multiple Store Category"; ?></label>
                                </div>
                                

                            </div>                          
                                                 

                        </div>
                    </div>

                   

                     <!-- color picker -->
                     <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label">Color-Picker</label>
                            <div class="col-sm-7">
                               <div id="colorp" class="input-group colorpicker-component">
                                    <input type="text" id="colorval" value="#00AABB" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                                <script>
                                    $(function() {
                                        $('#colorp').colorpicker();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_BannerImage'); ?><span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                            <div class="col-sm-7">
                                <input type="file" class="addImage form-control error-box-class"  name="banner_image" id="banner_image"  placeholder="">
                                <input type="hidden" class="form-control" style="height: 37px;"  name="bannerImage" id="bannerImage">
                            </div>
                            <div class="col-sm-1">
                                <img src="" style="width: 35px; height: 35px; display: none;"
                                     class="bannerImage style_prevu_kit">
                            </div>
                            <div class="col-sm-5"></div>
                            <div class="col-sm-6 error-box" id="text_bimage" style="color:red"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_LogoImage'); ?><span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                            <div class="col-sm-7">
                                <input type="file" class="addImage form-control error-box-class"  name="logo_image" id="logo_image"  placeholder="">
                                <input type="hidden" class=" form-control" style="height: 37px;"  name="logoImage" id="logoImage">
                            </div>
                            <div class="col-sm-1">
                                <img src="" style="width: 35px; height: 35px; display: none;"
                                     class="logoImage style_prevu_kit">
                            </div>
                            <div class="col-sm-5"></div>
                            <div class="col-sm-6 error-box" id="text_limage" style="color:red"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_iconLogoImage'); ?><span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                            <div class="col-sm-7">
                                <input type="file" class="addImage form-control error-box-class"  name="icon_logo_image" id="icon_logo_image"  placeholder="">
                                <input type="hidden" class=" form-control" style="height: 37px;"  name="iconlogoImage" id="iconlogoImage">
                            </div>
                            <div class="col-sm-1">
                                <img src="" style="width: 35px; height: 35px; display: none;"
                                     class="iconlogoImage style_prevu_kit">
                            </div>
                            <div class="col-sm-5"></div>
                            <div class="col-sm-6 error-box" id="text_limage" style="color:red"></div>
                        </div>
                    </div>

                    

                     <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label">City<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                            <!-- <select id="citiesList" name="citiesList" class="form-control citiesList" style="width: 55% !important" multiple="multiple"> -->
                            <select id="citiesList" name="company_select" class="form-control" style="width: 55% !important" multiple="multiple">
                                                 
                            </select>
                            </div>
                        </div>
                    </div>

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

                <div id="Category_txt" >
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
                </div>

                <div class="categoryDescription">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="EditcatDescription_0" name="EditcatDescription"  class=" EditcatDescription form-control error-box-class" > </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <div class="form-group col-sm-12">
                                    <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>" name="EditcatDescription[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="EditcatDescription form-control error-box-class" ></textarea>
                                    </div>
                                </div>
                            <?php } else { ?> 
                                <div class="form-group  col-sm-12" style="display: none;">
                                    <label for="fname" class="col-sm-5 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>" name="EditcatDescription[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="EditcatDescription form-control error-box-class" ></textarea>
                                    </div>

                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_Type'); ?><span class="MandatoryMarker"> *</span></label>

                        <div class="col-sm-4">
                            <div class="col-sm-1">
                                <input style="cursor: pointer" type="radio" typeName="Restaurant" class="editresturant"  name="edittype" id="edittypeResturant" value="1">
                            </div>
                            <div class="col-sm-3">
                                <label style="cursor: pointer" for="fname"  class="editresturant col-sm-3 control-label"><?php echo "Food"; ?></label>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-1">
                                <input style="cursor: pointer" type="radio" class="editstore " typeName="Store" name="edittype" id="edittypeStore" value="2">
                            </div>
                            <div class="col-sm-3">
                                <label style="cursor: pointer" for="fname" class="col-sm-3 control-label editstore"><?php echo $this->lang->line('label_Store'); ?></label>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-1">
                                <input style="cursor: pointer" type="radio" class="editshopping " typeName="Shopping" name="edittype" id="edittypeShopping" value="3">
                            </div>
                            <div class="col-sm-3">
                                <label style="cursor: pointer" for="fname" class="col-sm-3 control-label editstore"><?php echo "Retail"; ?></label>
                            </div>

                        </div>
						 <div class="col-sm-4" style="display:none"> 
                            <div class="col-sm-1">
                                <input style="cursor: pointer" type="radio" class="editmarijuana " typeName="Marijuana" name="edittype" id="edittypeMarijuana" value="4">
                            </div>
                            <div class="col-sm-3">
                                <label style="cursor: pointer" for="fname" class="col-sm-3 control-label editmarijuana">Marijuana</label>
                            </div>

                        </div>

                         <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" class="editlaundry" typeName="Laundry" name="edittype" id="edittypeLaundry" value="5">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="fname" class="col-sm-3 control-label ">Laundry</label>
                                </div>

                            </div>

                       

                    </div>
                </div> -->

                  <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_Type'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                            <select  class="form-control" name="editstoreType" id="editstoreType">
                                <option value="1" data-name="Food">Food</option>
                                <option value="2" data-name="Grocery">Grocery</option>
                                <option value="3" data-name="Fashion">Fashion</option>
                                <option value="4" data-name="Order Anything">Order Anything</option>
                                <option value="5" data-name="Laundry">Laundry</option>
                                <option value="6" data-name="Pharmacy">Pharmacy</option>
                                <option value="7" data-name="Send Anything">Send Anything</option>
                                <option value="8" data-name="Liquor">Liquor</option>
                            </select>
                            </div>
                        </div>
                    </div>
                        <!-- visible in app web -->

                        <div class="row">
                            <div class="form-group col-sm-12">
                            <label for="visibleapp" class="col-sm-4 control-label"><?php echo "Visibility"; ?></label>
                             <div class="col-sm-4">
                                <input style="cursor: pointer" type="checkbox" class="col-sm-1"  name="editcategoryVisibility" id="editappvisible" value="0" >
                                <label style="cursor: pointer" for="editappvisible" class="col-sm-11 control-label "><?php echo "Visible in App" ?></label>

                            </div>
                            <div class="col-sm-4">

                                <input style="cursor: pointer" type="checkbox"  class="col-sm-1"  name="editcategoryVisibility" id="editwebvisible" value="1">
                                <label style="cursor: pointer" for="editwebvisible"  class="col-sm-11 control-label"><?php echo "Visible in Web"; ?></label>
                            </div>

                        </div>
                    </div>


                <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo "Deliver To"; ?><span class="MandatoryMarker"> *</span></label>

                             <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" class="deliverToStore" deliverTo="deliverToStore" name="editdeliverTo" id="editdeliverToStore" value="0" >
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="deliverTo" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Store'); ?></label>
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio"  class="deliverToDriver" deliverTo="deliverToDriver"  name="editdeliverTo" id="editdeliverToDriver" value="1">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="deliverTo"  class=" col-sm-3 control-label"><?php echo "Driver"; ?></label>
                                </div>

                            </div>
                           
                           

                        </div>
                    </div>

                     <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"></label>

                            <div class="col-sm-6">
                                <div >
                                    <input style="cursor: pointer" type="radio" class="cartsAllowed"  data-msg="Singlecartsinglestore" name="editcartsAllowed" id="editsinglestore" value="1" checked>
                                    <label style="cursor: pointer" for="deliverTo" class=" control-label "><?php echo 'Single cart single store'; ?></label>
                                </div>
                                
                            </div>
                                                  
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"></label>

                            <div class="col-sm-6">
                                <div >
                                    <input style="cursor: pointer" type="radio"  class="cartsAllowed"  data-msg="SinglecartMultiplestore" name="editcartsAllowed" id="editmultiplestore" value="2">
                                    <label style="cursor: pointer" for="deliverTo"  class="  control-label"><?php echo "Single cart Multiple store"; ?></label>
                                </div>
                              

                            </div>                          
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"></label>

                            <div class="col-sm-6">
                                <div >
                                    <input style="cursor: pointer" type="radio"  class="cartsAllowed"  data-msg="SinglecartMultipleStoreCategory" name="editcartsAllowed" id="editmultiplestorecat" value="3">
                                    <label style="cursor: pointer" for="deliverTo"  class="  control-label"><?php echo "Single cart Multiple Store Category"; ?></label>
                                </div>
                                

                            </div>                          
                        </div>
                    </div>
                 <!-- color picker -->
                 <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label">Color-Picker</label>
                            <div class="col-sm-7">
                               <div id="editcolorp" class="input-group colorpicker-component">
                                    <input type="text" id="editcolorval" value="#00AABB" class="form-control" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                                <script>
                                    $(function() {
                                        $('#editcolorp').colorpicker();
                                       // alert('called');
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-4 control-label">Banner Image<span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control error-box-class"  name="banner_image" id="editbanner_image"  placeholder="">
                            <input type="hidden" class="form-control" style="height: 37px;"  name="editbannerImage" id="editbannerImage">
                        </div>
                        <div class="col-sm-1">
                            <img src="" style="width: 35px; height: 35px; display: none;"
                                 class="editbannerImage style_prevu_kit">
                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-6 error-box" id="text_editbimage" style="color:red"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-4 control-label">Logo<span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control error-box-class"  name="logo_image" id="editlogo_image"  placeholder="">
                            <input type="hidden" class=" form-control" style="height: 37px;"  name="editlogoImage" id="editlogoImage">
                        </div>
                        <div class="col-sm-1">
                            <img src="" style="width: 35px; height: 35px; display: none;"
                                 class="editlogoImage style_prevu_kit">
                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-6 error-box" id="text_editlimage" style="color:red"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-4 control-label">Icon<span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control error-box-class"  name="icon_logo_image" id="editiconlogo_image"  placeholder="">
                            <input type="hidden" class=" form-control" style="height: 37px;"  name="editiconlogoImage" id="editiconlogoImage">
                        </div>
                        <div class="col-sm-1">
                            <img src="" style="width: 35px; height: 35px; display: none;"
                                 class="editiconlogoImage style_prevu_kit">
                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-6 error-box" id="text_editlimage" style="color:red"></div>
                    </div>
                </div>
                
                <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label">City<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                            <select id="editcitiesList" name="editcitiesList" class="form-control editcitiesList" style="width: 55% !important" multiple="multiple">
                                                 
                            </select>
                            </div>
                        </div>
                    </div>

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