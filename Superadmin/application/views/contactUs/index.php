<link href="application/views/paymentsGateways/styles.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>theme/assets/plugins/bootstrap-tag/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
<script src='http://ubilabs.github.io/geocomplete/jquery.geocomplete.js'></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY ?>&libraries=places"
></script>
<style >
    .pac-container{
        z-index:9999999!important;
    }

    .btn {
        /* font-size: 11px; */
        width: auto;
        border-radius: 30px;
    }
    button#btnStickUpSizeToggler {
        /* font-size: 11px; */
        width: auto;
    }
</style>
<script type="text/javascript">
    var componentForm = {
        administrative_area_level_1: 'long_name',
        locality: 'long_name',
        postal_code: 'short_name'
    };
    var shortAdd = {
        route: 'long_name',
        sublocality_level_2: 'long_name'
    };
    $(document).ready(function () {



//         initMaps();
        initMap();
    });
    function initMap() {
        console.log("print");
        var input = (document.getElementById('address'));
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }


            $("#lat").val(place.geometry.location.lat());
            $("#long").val(place.geometry.location.lng());

            for (var component in componentForm) {
                document.getElementById(component).value = '';
            }
            var shortAddress = place.name;
            for (var i = 0; i < place.address_components.length; i++) {

                var addressType = place.address_components[i].types[0];
                if (shortAdd[addressType]) {
                    var val = place.address_components[i][shortAdd[addressType]];
                    shortAddress += "," + val;
                }
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
            console.log("shortAddress", shortAddress)
            $("#address").val(shortAddress)

        });

    }
    function einitMap() {
        console.log("print");
        var input = (document.getElementById('eaddress'));
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            $("#elat").val(place.geometry.location.lat());
            $("#elong").val(place.geometry.location.lng());

            for (var component in componentForm) {
                document.getElementById(component).value = '';
            }
            var shortAddress = place.name;
            for (var i = 0; i < place.address_components.length; i++) {

                var addressType = place.address_components[i].types[0];
                if (shortAdd[addressType]) {
                    var val = place.address_components[i][shortAdd[addressType]];
                    shortAddress += "," + val;
                }
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
            $("#eaddress").val(shortAddress)

        });

    }
    $(document).ready(function () {

        var table = $('#big_table');

        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/ContactUsCity/datatable_ContactUsCity',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                    $('.hide_show').show()
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

        $('#editButton').click(function ()
        {
            einitMap();
            $('.errors').text('');
            $('#editForm')[0].reset();
            var val = $('.checkbox1:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $("#alertmodel").modal("show");
                $("#alertdata").text("Please select only one payment gateway to edit");
            } else if (val.length > 1)
            {
                $("#alertmodel").modal("show");
                $("#alertdata").text("Please select only one payment gateway to edit");
            } else
            {
                $('#editModal').modal('show');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php?/ContactUsCity/operations/get",
                    data: {id: $('.checkbox1:checked').val()},
                    dataType: "JSON",
                    success: function (response)
                    {
                        $('#editphone').val(response.data.phone);
                        $('#ecityTitle').val(response.data.title);
                        $('#docID').val(response.data._id.$oid);
                        $('#eaddress').val(response.data.address);
                        $('#elocality').val(response.data.city);
                        $('#eadministrative_area_level_1').val(response.data.state);
                        $('#epostal_code').val(response.data.zipCode);



                    }
                });

            }
        });
        $('#Address').focus(function () {

            var input;
            input = document.getElementById('Address');

            var searchBox = new google.maps.places.SearchBox(input);

            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function () {

                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {

                    getCityCountry(place.name);
//                   
                });
            });
        });
        //Add
        $('#addButton').click(function () {
            $('.errors').text('');
            $('#addForm')[0].reset();
            $('#addPopUp').modal('show');
        })

        //delete
        $('#deleteButton').click(function () {
            var val = $('.checkbox1:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $("#alertmodel").modal("show");
                $("#alertdata").text("Please select atleast one payment gateway to delete");
            } else if (val.length > 0)
            {
                $('#deletePopUp').modal('show');
            }
        })
        $(".allownumericwithdecimal").on("keypress keyup blur", function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        //Add-----------------
        $('#insert').click(function () {
//            if ($('#addForm').valid() == true) {

            if ($('#cityTitle').val() == "")
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please enter a Title of office');
                $('#cityTitle').focus();
                return false;
            } else if ($("#phone").val() == "") {
                $("#phoneErr").text('Please enter phone');
                $('#phone').focus();
                return false;
            } else if ($('#address').val() == "")
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please enter an Address');
                $('#address').focus();
                return false;

            }
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php?/ContactUsCity/operations/insert",
                data: $('#addForm').serialize(),
                dataType: "JSON",
                success: function (msg)
                {
                    $('.close').trigger('click');
                    reload();
                }
            });
//            }

        });

        //Delete
        $('#delete').click(function () {
            var ids = $('.checkbox1:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php?/ContactUsCity/operations/delete",
                data: {ids: ids},
                dataType: "JSON",
                success: function (msg)
                {
                    $('.close').trigger('click');
                    reload();
                }
            });

        });

        //Update
        $('#update').click(function () {
//            if ($('#editForm').valid() == true) {

            if ($('#ecityTitle').val() == "")
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please enter a Title of office');
                $('#cityTitle').focus();
                return false;
            } else if ($("#editphone").val() == "") {
                $("#editPhoneErr").text('Please enter phone');
                $('#editphone').focus();
                return false;
            } else if ($('#eaddress').val() == "")
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please enter an Address');
                $('#address').focus();
                return false;

            }
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php?/ContactUsCity/operations/update",
                data: $('#editForm').serialize(),
                dataType: "JSON",
                success: function (msg)
                {
                    $('.close').trigger('click');
                    reload();
                }
            });
//            }

        });

    });
    function reload() {
        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/ContactUsCity/datatable_ContactUsCity',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "fnInitComplete": function () {
                $('#big_table_processing').hide();
                table.show()
                searchInput.show()
                $('.cs-loader').hide();
            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                // csrf protection
                aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                $.ajax
                        ({
                            'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        });
            },
        };
        table.dataTable(settings);
    }
</script>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;

             color: gray;
             margin-left: 30px;padding-top: 20px;">

            <strong style="color:#0090d9;"><?= strtoupper("Contact Us Office "); ?></strong>
        </div>

        <div class="">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent ">
                    <ul class="nav nav-tabs nav-tabs-fillup bg-white" style="padding: 0.5%;">
                        <div class="pull-right m-t-10 cls111" style="margin-right: 1%;"> <button class="btn btn-danger " id="deleteButton"><?= ucwords($this->lang->line('button_delete')); ?></button></a></div>
                        <div class="pull-right m-t-10 cls111"><button class="btn btn-info " id="editButton"><?= ucwords($this->lang->line('button_edit')); ?></button></div>
                        <div  class="pull-right m-t-10 cls110"><button class="btn btn-primary " id="addButton"><?= ucwords($this->lang->line('button_add')); ?></button></div>
                    </ul>

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
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


                                    <div class="row clearfix pull-right" >
                                        <div class="col-sm-12">
                                            <div class="searchbtn" >

                                                <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
                                            </div>

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

</div>

<div class="modal fade stick-up" id="addPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addForm" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <span class="modal-title">ADD</span>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label"><?php echo "Title Of Office"; ?><span style="" class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" style="height: 37px;" name="cityTitle" id="cityTitle" required>
                        </div>
                        <div class="col-sm-2">
                            <img style="width:35px;" id="driver_p" src="" alt="" class="onImageAWS style_prevu_kit">
                        </div>
                        <div class="col-sm-3 error-box" id="file_driver_photo"></div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label"><?php echo "Phone"; ?><span style="" class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" style="height: 37px;" name="phone" id="phone" required>
                        </div>
                        <div class="col-sm-2">
                            <div class="col-sm-3 error-box" id="phoneErr"></div>
                        </div>
                        <div class="col-sm-3 error-box" id="file_driver_photo"></div>
                    </div>
                    <div class="form-group">
                        <label for="fname" class="col-sm-2 control-label">Address<span style="" class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="address" name="address"  class="form-control" placeholder="Address" required>
                        </div>
                        <div class="col-sm-3 error-box" id="addressErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="fname" class="col-sm-2 control-label"></label>
                        <div class="col-sm-2">
                            <input type="text"  id="locality" name="add_city"  class="form-control" placeholder="City" aria-required="true" aria-invalid="true">
                        </div>
                        <div class="col-sm-2">
                            <input type="text"  id="administrative_area_level_1" name="add_state"  class="form-control" placeholder="state" aria-required="true" aria-invalid="true">
                        </div>
                        <div class="col-sm-2">
                            <input type="text"  id="postal_code" name="add_zip"  class="form-control" placeholder="zip" aria-required="true" aria-invalid="true">
                        </div>
                        <input type="hidden" id="lat" name="lat" value="" />
                        <input type="hidden" id="long" name="long" value="" />
                        <div class="col-sm-2">
                            <a href="#modal_default_2" data-toggle="modal" style='color: black;' id="model_2">
                                <span class="icon-plus-sign">                                  
                            </a>
                        </div>
                        <div class="col-sm-3 error-box" id="address_err"></div>
                    </div>
                </div>
                <div class="modal-footer">

                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4 error-box"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="insert" >Add</button>
                    </div>

                </div>
            </form>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>

<div class="modal fade stick-up" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <span class="modal-title">EDIT</span>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label"><?php echo "Title Of Office"; ?><span style="" class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" style="height: 37px;" name="ecityTitle" id="ecityTitle" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label"><?php echo "Phone"; ?><span style="" class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" style="height: 37px;" name="editphone" id="editphone" required>
                        </div>
                        <div class="col-sm-2">
                            <div class="col-sm-3 error-box" id="editPhoneErr"></div>
                        </div>
                        <div class="col-sm-3 error-box" id="file_driver_photo"></div>
                    </div>
                    <div class="form-group">
                        <label for="fname" class="col-sm-2 control-label">Address<span style="" class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="eaddress" name="eaddress"  class="form-control" placeholder="Address" required>
                        </div>
                        <div class="col-sm-3 error-box" id="addressErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="fname" class="col-sm-2 control-label"></label>
                        <div class="col-sm-2">
                            <input type="text"  id="elocality" name="eadd_city"  class="form-control" placeholder="City" aria-required="true" aria-invalid="true">
                        </div>
                        <div class="col-sm-2">
                            <input type="text"  id="eadministrative_area_level_1" name="eadd_state"  class="form-control" placeholder="state" aria-required="true" aria-invalid="true">
                        </div>
                        <div class="col-sm-2">
                            <input type="text"  id="epostal_code" name="eadd_zip"  class="form-control" placeholder="zip" aria-required="true" aria-invalid="true">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="docID" id="docID"/>
                <input type="hidden" id="elat" name="elat" value="" />
                <input type="hidden" id="elong" name="elong" value="" />
                <div class="modal-footer">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4 error-box"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="update" >Update</button>
                    </div>
                </div>
            </form>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
<div class="modal fade stick-up" id="deletePopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <span class="modal-title">DELETE</span>
                </div>

                <div class="modal-body">

                    <div class="col-sm-12" style="text-align: center;font-weight:600"><?php echo "Do you want to delete Contact Us office "; ?></div>

                </div>
                <div class="modal-footer">

                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4 error-box"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="delete" >Delete</button>
                    </div>

                </div>
            </form>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>