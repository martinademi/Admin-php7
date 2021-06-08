
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .btn{
        font-size: 10px !important;
        width: 72px !important;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
  
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
/*    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }*/
    
</style>

<script>

    $(document).ready(function () {

       

        $('.Category').addClass('active');
        var id = '';
        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });


        $('#btnStickUpSizeToggler').click(function () {
            $("#display-data").text("");
            $("#display-data").text("");
            $('.catname').val("");
            $('#categoryError').text("");

            $('.catDescription').val("");
            $('#cat_photos').val("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                window.location.href = "<?php echo base_url() ?>index.php?/AddOns/addNewaddOn";
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
                        url: "<?php echo base_url('index.php?/Category') ?>/operationCategory/delete",
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/AddOns/operationCategory/table/',
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
                        }
                    });
                });
            }

        });


        $('#insert').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if ($('#catname_0').val() == "" || $('#catname_0').val() == null)
            {
                $("#categoryError").text("Please enter the category name");
            } else if ($("#cat_photos").val() == "" || $("#cat_photos").val() == null) {
                $("#categoryError").text("Please select the image");
            } else if (val.length == 1 || val.length > 1) {
                $('#displayData').modal('show');
                $('#display-data').text('Invalid Selection')
            } else {
                var imgUrl = '';
                var form_data = new FormData();
                var form_data1 = new FormData();
                var catname = new Array();
                var catDescription = new Array();
                $(".catname").each(function () {
                    catname.push($(this).val());
                    form_data1.append('name[]', $(this).val());
                });

                $(".catDescription").each(function () {
                    catDescription.push($(this).val());
                    form_data1.append('description[]', $(this).val());
                });

                var visibility = parseInt(1);

                form_data1.append('visibility', visibility);
                form_data1.append('addedFrom', "store");


                var cat_photos = $("#cat_photos").val();
                var file_data = $('#cat_photos').prop('files')[0];
                var fileName = file_data.name;
                form_data.append('OtherPhoto', file_data);

                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image');
                form_data.append('folder', 'first_level_category');

                var imgUrl = '';
                $(document).ajaxStart(function () {
                    $("#wait").css("display", "block");
                });
                $.ajax({
                    url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",
                    success: function (result) {

                        if (result) {

                            imgUrl = result.fileName;
                            form_data1.append('imageUrl', imgUrl);
                            $.ajax({
                                url: "<?php echo base_url('index.php?/Category/operationCategory') ?>/insert",
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
                                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Category/operationCategory/table',
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


                                    } else {
//                                        $(document).ajaxComplete(function () {
//                                            $("#wait").css("display", "none");
//                                        });
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
                        } else {
                            alert('Problem In Uploading Image-' + result.folder);
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false

                });
                $(".catname").val("");
                $(".catDescription").val("");
                $("#cat_photos").val("");
                $('#myModal').hide();
            }
        });

        var editVal = '';
        $(document).on('click', '#btnedit', function () {
            $("#display-data").text("");
            $('#modalHeading').html("EDIT CATEGORY");
            editVal = $(this).val();

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/StoreAddons/operationCategory/get",
                type: 'POST',
                data: {val: editVal},
                dataType: 'JSON',
                success: function (response)
                {
                    $.each(response, function (index, row) {
                        $('#editedId').val(row._id.$oid);

                        $('#Editcatname_0').val(row.category['en']);
<?php foreach ($language as $val) { ?>
                            $('#Editcatname_<?= $val['lan_id'] ?>').val(row.category['<?= $val['langCode'] ?>']);
<?php } ?>
                        $('#EditcatDescription_0').val(row.description['en']);
<?php foreach ($language as $val) { ?>
                            $('#EditcatDescription_<?= $val['lan_id'] ?>').val(row.description['<?= $val['langCode'] ?>']);
<?php } ?>

                        if (row.imageUrl) {
                            $('#Edit_photo').show();
                            $('#Edit_photo').attr('href', row.imageUrl);

                        } else
                            $('#Edit_photo').hide();
                    });
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
          //  $("#errorboxdatas").text("Are you sure you wish to activate the category ?");

        });

        $('#editbusiness').click(function () {

            $("#display-data").text("");
            var form_data = new FormData();
            var form_data1 = new FormData();
            var val = editVal;
            $('.editclearerror').text("");
            var editcatname = new Array();
            var editcatnameDesc = new Array();
            $(".Editcatname").each(function () {
                form_data1.append('name[]', $(this).val());
                editcatname.push($(this).val());

            });

            $(".EditcatDescription").each(function () {
                form_data1.append('description[]', $(this).val());
                editcatnameDesc.push($(this).val());

            });

            var editcatpic = $("#Editcat_photos").val();

            var file_data = $('#Editcat_photos').prop('files')[0];
            if (file_data) {
                form_data.append('cat_photos', file_data);

                var fileName = file_data.name;
                form_data.append('OtherPhoto', file_data);

                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image');
                form_data.append('folder', 'first_level_category');
            }
            form_data1.append('editId', val);
            if ($(".Editcatname").val() == "" || $(".Editcatname").val() == null || $(".Editcatname").val() == '' || $(".Editcatname").val() == 0) {

                $("#editclearerror").text("Please enter the Category name");
            } else {

                var imgUrl = '';
                var img = '';
              
                if (file_data) {
                    $.ajax({
                        url: "<?php echo superadminLink ?>index.php?/Common/uploadImagesToAws",
                        type: "POST",
                        data: form_data,
                        dataType: "JSON",
                        success: function (result) {
                            if (result) {
                                imgUrl = result.fileName;
                                form_data1.append('imageUrl', imgUrl);
                                $.ajax({
                                    url: "<?php echo base_url('index.php?/Category/operationCategory') ?>/edit",
                                    type: 'POST',
                                    data: form_data1,
                                    dataType: 'JSON',
                                    success: function (response)
                                    {
                                        window.location.reload();
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });
                            } else {

                                alert('Problem In Uploading Image-' + result.folder);
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                } else {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Category/operationCategory') ?>/edit",
                        type: 'POST',
                        data: form_data1,
                        async: true,
                        dataType: 'JSON',
                        success: function (response)
                        {
                            window.location.reload();
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                }
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
            } else if (val.length == 1)
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

                $(".modalPopUpText").text("Are you sure you wish to hide category");



            } else if (val.length > 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text("Invalid selection");
            }

        });


        $("#btnHide").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Category/operationCategory/hide",
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Category/operationCategory/table/',
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
            } else if (val.length == 1)
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
                $(".modalPopUpText").text("Are you sure you wish to unhide category");

            } else if (val.length > 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text("Invalid Selection");
            }

        });

        $("#btnUnhide11").click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Category/operationCategory/unhide",
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Category/operationCategory/table/',
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
                    } else {
                        $('#displayData').modal('show');
                        $("#display-data").text("Category is already Unhidden");
                        $('#unhideModal').modal('hide');
                    }
                }
            });
        });

       // Function to update campaign status
       function updateStatus(addOnIds, status){
            $.ajax({
                    
                    url: "<?php echo base_url('index.php?/StoreAddons/update_addOnDetails');?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        addOnIds : addOnIds,
                        status : status
                    },
            })
            .done(function(json) {
                //console.log('***',json);
                if (json === "status updated") {
                  
                     $('#big_table').DataTable().ajax.reload();
                     $("#popupmodel").modal('hide');
                  
                }else{
                    alert('Unable to update status. Please try agin later');
                }
            });
     }

//modal popup for confirmation delete
    $("#delete").click(function () {
      
       if ($(".checkbox").is(":checked") == false) {
           $('#popupmodeltext').text('Please select atleast one to delete');
           $("#popupmodel").modal();
           return;
       }
           $('#popupmodeltext').text('');
           $("#popupmodelfooter").text('');
           $('#confirmeds').attr('data_id', '');
           $('#confirmeds').attr('status', '');
           $('#confirmeds').attr('updateType', '');
           var addOnId = $(".checkbox:checked").val();
   
           var modalText = 'Do you want to continue to delete';
   
           $('#popupmodeltext').text(modalText);
           var deleteButton = '<button type="button" class="btn btn-primary pull-right" data_id="'+ addOnId +' " id="confirmDelete" style="width: 87px !important;">DELETE</button>"';
           $("#popupmodelfooter").append(deleteButton);
           $("#popupmodel").modal();
       });



 

       //modal confirmation for deactivate
    $("#deactivate").click(function () {
       
       if ($(".checkbox").is(":checked") == false) {
           $('#popupmodeltext').text('Please select atleast one to deactivate');
           $("#popupmodel").modal();
           return;
       }
           $('#popupmodeltext').text('');
           $("#popupmodelfooter").text('');
           $('#confirmeds').attr('data_id', '');
           $('#confirmeds').attr('status', '');
           $('#confirmeds').attr('updateType', '');
           var addOnId = $(".checkbox:checked").val();
   
           var modalText = 'Do you want to continue to deactivate';
   
           $('#popupmodeltext').text(modalText);
           var deleteButton = '<button type="button" class="btn btn-primary pull-right" data_id="'+ addOnId +' " id="confirmDeactivate" style="width: 108px !important;">DEACTIVATE</button>"';
           $("#popupmodelfooter").append(deleteButton);
           $("#popupmodel").modal();
       });

       //modal popup for confirmation activate
    $("#activate").click(function () {
      
      if ($(".checkbox").is(":checked") == false) {
          $('#popupmodeltext').text('Please select atleast one to activate');
          $("#popupmodel").modal();
          return;
      }
          $('#popupmodeltext').text('');
          $("#popupmodelfooter").text('');
          $('#confirmeds').attr('data_id', '');
          $('#confirmeds').attr('status', '');
          $('#confirmeds').attr('updateType', '');
          var addOnId = $(".checkbox:checked").val();
  
          var modalText = 'Do you want to continue to activate';
  
          $('#popupmodeltext').text(modalText);
          var deleteButton = '<button type="button" class="btn btn-primary pull-right" data_id="'+ addOnId +' " id="confirmActivate" style="width: 95px !important;">ACTIVATE</button>"';
          $("#popupmodelfooter").append(deleteButton);
          $("#popupmodel").modal();
      });

       //delete the addon delete
    $("body").on('click','#confirmDelete',function(){

            var status=3;
            var val=[];
            
            $(':checkbox:checked').each(function(i){
                    val[i] = $(this).val();
                    
                    });
            updateStatus(val, status);
        
    });

    //delete the addon deactivate
    $("body").on('click','#confirmDeactivate',function(){

            var status=2;
            var val=[];
            
            $(':checkbox:checked').each(function(i){
                    val[i] = $(this).val();
                    
                    });
            updateStatus(val, status);
        
    });

      //delete the addon activate
    $("body").on('click','#confirmActivate',function(){

            var status=1;
            var val=[];
            
            $(':checkbox:checked').each(function(i){
                    val[i] = $(this).val();
                    
                    });
            updateStatus(val, status);
        
    });


    });



    function moveUp(id) {
        var row = $(id).closest('tr');
        var prev_id = row.prev('tr').find('.moveUp').attr('id')
        var curr_id = row.find('.moveUp').attr('id');
        if (prev_id == undefined) {
            $('#displayData').modal('show');
            $('#display-data').text('Cannot reorder , Category is at the end..!!')
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Category/operationCategory/order",
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
            $('#display-data').text('Cannot reorder , Category is at the end..!!')
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Category/operationCategory/order",
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
            url: "<?php echo base_url() ?>index.php?/Category/operationCategory/validate",
            type: "POST",
            data: {catname: $('#catname_0').val()},
            dataType: "JSON",
            success: function (result) {
                $('#catname_0').attr('data', result.msg);

                if (result.count == true) {

                    $("#clearerror").html("Category name already exists.");
                    $('#catname_0').focus();
                    return false;
                } else if (result.count != true) {
                    $("#clearerror").html("");

                }
            }
        });
    }


</script>

<script type="text/javascript">
    $(document).ready(function () {
        
        var status = 1;
        if (status == 1) {
            $('#btnStickUpSizeToggler').show();
//            $('#edit').show();
//            $('#bdelete').show();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreAddons/operationCategory/table/0',
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
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });


        $('.whenclicked li').click(function () {
            if ($(this).attr('id') == 'my1') {
                console.log('clicked1');
                $('#btnStickUpSizeToggler').show();
                $('#activate').show();
                $('#delete').show();
                $('#deactivate').show();
            } else if ($(this).attr('id') == 'my2') {
                console.log('clicked2');
                $('#btnStickUpSizeToggler').show();
                $('#edit').show();
                $('#bdelete').show();
                $('#activate').hide();
                $('#deactivate').show();
                $('#delete').show();

            } else if($(this).attr('id')=='my3') {
                console.log('clicked3');
                $('#btnStickUpSizeToggler').show();
                $('#edit').show();
                $('#deactivate').hide();
                $('#activate').show();
                $('#delete').show();
            }else if($(this).attr('id')== 'my4') {
                console.log('clicked4');
                $('#btnStickUpSizeToggler').hide();
                $('#delete').hide();
                $('#deactivate').hide();
                $('#activate').hide();

            }
        });
        $('.changeMode').click(function () {
            
            var table = $('#big_table');
            $('#big_table').fadeOut('slow');
            $('#big_table_processing').show();
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
            $('.tabs_active').removeClass('active');
            $(this).parent().addClass('active');
            table.dataTable(settings);
        });
    });
    function refreshTableOnCityChange() {

        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        $('#big_table_processing').show();
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": $(".whenclicked li.active").children('a').attr('data'),
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
    }


       $('body').on("click", '.addOnDetailmodal', function () {
           

      
        $('#addOnsListData').empty('');

            $('#addOnsListData').empty();
            var id = $(this).attr('id');
           

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/StoreAddons/addOnsList/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    
                   
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                       
                        html += '<tr><td style="text-align:center;width:250px;border-style: ridge;">' + k + '</td>';
                        html += '<td style="border-style: ridge;width:250px;text-align:center;">' + row.name.en + '</td>';
                        html += '<td style="border-style: ridge;width:250px;text-align:center;">'+result.currencySymbol +' '+ + row.price + '</td></tr>';

                        k++;
                        
                    });
                    $('#addOnsListData').append(html);

                    $('#addOnsListModal').modal('show');
                }

            });
        });

    
</script>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 8px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 16px;">Store Add-Ons</strong>
        </div>

        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
        <li id= "my1" class="tabs_active active" style="cursor:pointer">
                    <a  class="changeMode New_" data="<?php echo base_url("/index.php?/StoreAddons/operationCategory/table/0/") ?>" data-id="1">
                        <span>Pending Approval</span>
                        <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                    </a>
                </li>
                <li id= "my2" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode New_" data="<?php echo base_url("/index.php?/StoreAddons/operationCategory/table/1/") ?>" data-id="1">
                        <span>Active</span>
                        <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                    </a>
                </li>
                <li id= "my3" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode New_" data="<?php echo base_url("/index.php?/StoreAddons/operationCategory/table/2/") ?>" data-id="1">
                        <span>Inactive</span>
                        <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                    </a>
                </li>
                <li id= "my4" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode New_" data="<?php echo base_url("/index.php?/StoreAddons/operationCategory/table/3/") ?>" data-id="1">
                        <span>Deleted</span>
                        <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                    </a>
                </li>
            <div class="pull-right m-t-10  cls110" style="display:none"> 
                <button class="btn btn-success pull-right m-t-10" id="btnStickUpSizeToggler">Add</button>
            </div>
            <div class="pull-right m-t-10  cls110"> 
                <button class="btn btn-warning pull-right m-t-10" id="deactivate">Deactivate</button>
            </div>
            <div class="pull-right m-t-10  cls110"> 
                <button class="btn btn-danger pull-right m-t-10" id="delete">Delete</button>
            </div>
            <div class="pull-right m-t-10  cls110"> 
                <button class="btn btn-success pull-right m-t-10" id="activate">Activate</button>
            </div>
            
        </ul>

        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent " >
 
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="error-box" id="display-data" style="text-align:center; color: red;"></div>
                                    <div class="searchbtn row clearfix pull-right" style="margin-right: 0%;">

                                        <div class=""><input type="text" id="search-table" class="form-control pull-right" style="text-transform: capitalize;margin-bottom:6px" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
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







<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">



    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="modal-header">
                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title">Add Category</span>
                </div>
                <div class="modal-body">


                    <div id="Category_txt" >
                        <div class="row">
                            <div class="form-group formex">
                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">Name(English) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">    
                                        <input type="text"   id="catname_0" name="catname[0]" onblur="validatecat()" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
                                    </div>

                                </div>
                            </div>
                        </div> 

                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <br/>
                                <div class="row">
                                    <div class="form-group formex">
                                        <div class="frmSearch">
                                            <label for="fname" class="col-sm-4 control-label">Name(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="catname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <div class="row">
                                    <div class="form-group formex" style="display:none;">
                                        <div class="frmSearch">
                                            <label for="fname" class="col-sm-4 control-label">Name(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="catname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>

                    <br/>
                    <div class="categoryDescription">
                        <div class="row">
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-4 control-label">Description(English)</label>
                                <div class="col-sm-6">
                                    <textarea type="text"  id="catDescription_0" name="catDescription[0]"  class="catDescription form-control error-box-class" style="max-width: 100%;"></textarea>
                                    <input type="hidden" id="cat_photosamz" name="cat_photosamz" value=""/>
                                </div>
                            </div>
                        </div>

                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <br/>
                                <div class="row">
                                    <div class="form-group formex">
                                        <div class="frmSearch">
                                            <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]" style="line-height: 2; max-width: 100%;" class="catDescription form-control error-box-class" ></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <div class="row">
                                    <div class="form-group formex" style="display:none;">
                                        <div class="frmSearch">
                                            <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]" style="line-height: 2; max-width: 100%;" class="catDescription form-control error-box-class" ></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>

                    </div>

                    <br/>
                    <div class="categoryImage">
                        <div class="row">
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-4 control-label">Image<span class="MandatoryMarker"> * (max size - 2 mb)</span></label>
                                <div class="col-sm-6">
                                    <input type="file" class="form-control error-box-class"  name="cat_photos" id="cat_photos"  placeholder=""></div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="modal-footer">                            
                        <div class="col-sm-6 error-box" id="categoryError"></div>

                        <div class="col-sm-6" >
                            <button type="button" class="btn btn-primary pull-right" id="insert" >Add</button>
                            <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>  
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
    </div>
</div>





<div class="modal fade stick-up" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">Edit Add-On</span>
            </div>

            <div class="modal-body">

                <input type="hidden" id="editedId" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>                       

                <div id="Category_txt" >
                    <div class="row">
                        <div class="form-group formex">
                            <div class="frmSearch">
                                <div class="col-sm-1"></div>
                                <label for="fname" class="col-sm-4 control-label"> Name(English) <span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6">    <!--<div class="col-sm-6">-->  
                                    <input type="text"   id="Editcatname_0" name="Editcatname[0]" style="line-height: 2;max-width: 100%;" class="Editcatname form-control error-box-class" >
                                </div>

                            </div>
                        </div>  
                    </div>

                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <br/>
                            <div class="row">
                                <div class="form-group formex">
                                    <div class="frmSearch">
                                        <div class="col-sm-1"></div>
                                        <label for="fname" class="col-sm-4 control-label">Name (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="Editcatname_<?= $val['lan_id'] ?>" name="Editcatname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
                                        </div>

                                    </div>
                                </div>
                            </div>


                        <?php } else { ?>
                            <div class="row">
                                <div class="form-group formex" style="display: none;">
                                    <div class="frmSearch">
                                        <div class="col-sm-1"></div>
                                        <label for="fname" class="col-sm-4 control-label">Name (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="Editcatname_<?= $val['lan_id'] ?>" name="Editcatname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>

                </div>
                <br/>
                <div class="row"></div>

                <div class="categoryDescription">
                    <div class="row">
                        <div class="form-group" class="formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="EditcatDescription_0" name="EditcatDescription"  class=" EditcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                            </div>
                        </div>
                    </div>

                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <br/>
                            <div class="row">
                                <div class="form-group formex">
                                    <div class="frmSearch">
                                        <div class="col-sm-1"></div>
                                        <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>" name="EditcatDescription[<?= $val['lan_id'] ?>]" style="line-height: 2; max-width: 100%;" class="EditcatDescription form-control error-box-class" ></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php } else { ?> 
                            <div class="row">
                                <div class="form-group formex"  style="display: none;">
                                    <div class="frmSearch">
                                        <div class="col-sm-1"></div>
                                        <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>"  name="EditcatDescription[<?= $val['lan_id'] ?>]" style="line-height: 2; max-width: 100%;" class="EditcatDescription form-control error-box-class" ></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>

                </div>
                <br/>
                <div class="row"></div>
                <div class="categoryImage">
                    <div class="row">
                        <div class="form-group" class="formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Image<span class="MandatoryMarker">  (max size - 2 mb)</span></label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class"  name="Editcat_photos" id="Editcat_photos" value="" placeholder="">
                                <input type="hidden" id="Edit_photos" name="Edit_photos"  class="form-control error-box-class">

                                <a target="_blank" id="Edit_photo" name="Edit_photo" style="display:none;" href="" >view</a> 

                            </div>

                        </div>
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

<!--<div id="wait" style="display:none;width:100px;height:100px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>pics/spinner.gif' width="64" height="64" /><br>Loading..</div>-->
   


<div class="modal fade " id="popupmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Confirmation</h4>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="" id="popupmodeltext" style="font-size:15px"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" id="popupmodelfooter">
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="addOnsListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>AddOns List</h4>
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
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>