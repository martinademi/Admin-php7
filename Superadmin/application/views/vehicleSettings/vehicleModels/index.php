<?php

if ($status == 1) {
    $passenger_status = 'active';
    $active = "active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
} else if ($status == 2) {
    $passenger_status = 'deactive';
    $deactive = "active";
}
?>
<script type="text/javascript">
    var currentTab = '<?php echo $status; ?>';
    function validatebrandname()
    {
        var make = $('#typename_e_en').val();
        var makedef = $('#typename_e_en_def').val();
        var makename = make.toLowerCase();
        var makenamedef = makedef.toLowerCase();

        if (makename != makenamedef)
        {
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/vehicle/validateMake',
                type: "POST",
                data: {makename: makename},
                dataType: "JSON",
                success: function (result) {
                    if (result.flag == 1) {
                        $('#typename_e_en').attr('data-id', '1');
                    } else if (result.flag == 0) {
                        $('#typename_e_en').attr('data-id', '0');
                    }
                }
            });
        } else
        {
            $('#typename_e_en').attr('data-id', '0');
        }
    }
    $(document).ready(function () {
        $(document).ajaxComplete(function () {
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
        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        setTimeout(function () {

            var status = '<?php echo $status; ?>';


            if (status == 1) {
                $('#delete').show();
                $('#btnStickUpSizeToggler').show();
                $('#deletes').hide();

                $('#vehiclemodal_addbutton').hide();


            }
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehiclemodels/' + status,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "drawCallback": function () {
                    $('.cs-loader').hide();
                    /*
                     * .cls100 = view
                     * .cls110 = add
                     * .cls111 = edit and delete
                     */
                    // if (access == "100") {
                    //     $('.cls110').remove();
                    //     $('.cls111').remove();
                    // } else if (access == "110") {
                    //     $('.cls111').remove();

                    // }
                },
                "fnInitComplete": function () {
                    table.show()
                    $('.cs-loader').hide()
                    searchInput.show()
                    /*
                     * .cls100 = view
                     * .cls110 = add
                     * .cls111 = edit and delete
                     */
                    // if (access == "100") {
                    //     $('.cls110').remove();
                    //     $('.cls111').remove();
                    // } else if (access == "110") {
                    //     $('.cls111').remove();

                    // }
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
            
            if (status == 1) {
                $('#big_table').dataTable().fnSetColumnVis([], false);
            } else {
                if (status == 1) {
                    $('#big_table').dataTable().fnSetColumnVis([2, 3], false);
                } else {
                    $('#big_table').dataTable().fnSetColumnVis([4, 5], false);
                }
            }

            // if (access == "111") {
            //     $('#big_table').dataTable().fnSetColumnVis([], false);
            // } else {
            //     if (status == 1) {
            //         $('#big_table').dataTable().fnSetColumnVis([2, 3], false);
            //     } else {
            //         $('#big_table').dataTable().fnSetColumnVis([4, 5], false);
            //     }
            // }
            
        }, 1000);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });



        $('.changeMode').click(function () {

            var table = $('#big_table');
            var tab_id = $(this).attr('data-id');
            if (tab_id != currentTab)
            {
                table.hide();
                currentTab = tab_id;

                if ($(this).attr('id') == 1) {
                    $('#delete').show();
                    $('#btnStickUpSizeToggler').show();
                    $('#deletes').hide();
                    $('#vehiclemodal_addbutton').hide();
                } else if ($(this).attr('id') == 2) {
                    $('#delete').hide();
                    $('#btnStickUpSizeToggler').hide();
                    $('#deletes').show();
                    $('#vehiclemodal_addbutton').show();
                }
                location.href = $(this).attr('data');
            }


        });


    });
    $(document).on('click', '.vehicleMake', function ()
    {

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('index.php?/vehicle') ?>/getVehicleMakeLanguageDate",
            data: {vehicleMakeId: $(this).data('id')},
            dataType: "JSON",
            success: function (result) {

                $('#vehicleTypeNameTableBody').html('');

                var html = "<tr><td style='text-align: center;'>English</td>";
                html += "<td style='text-align: center;'>" + result.data.makeName.en + "</td></tr>";

                $.each(result.lang, function (i, res) {
                    if (result.data.makeName[res.code]) {
                        html += "<tr><td style='text-align: center;text-transform: capitalize;'>" + res.name + "</td>";
                        html += "<td style='text-align: center;'>" + result.data.makeName[res.code] + "</td></tr>";
                    }
                })

                $('#vehicleTypeNameTableBody').append(html);
//                          
                $('#vehicleTypeModel').modal('show');
            }
        });


    });

    $(document).on('click', '.vehicleModel', function ()
    {
        var modelId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('index.php?/vehicle') ?>/getVehicleMakeModelLanguageDate",
            data: {vehicleModelId: modelId},
            dataType: "JSON",
            success: function (result) {

                $('#vehicleTypeModelTableBody').html('');
                var html = '';

                $.each(result.data.models, function (i, res) {
                    if (res._id.$oid == modelId)
                    {
                        html += "<tr><td style='text-align: center;'>English</td>";
                        html += "<td style='text-align: center;'>" + res.name.en + "</td></tr>";
                        $.each(result.lang, function (ilang, reslang) {
                            if (res.name[reslang.code]) {
                                html += "<tr><td style='text-align: center;text-transform: capitalize;'>" + reslang.name + "</td>";
                                html += "<td style='text-align: center;'>" + res.name[reslang.code] + "</td></tr>";
                            }
                        })

                    }
                })



                $('#vehicleTypeModelTableBody').append(html);
//                          
                $('#vehicleTypeMakeModel').modal('show');
            }
        });


    });
</script>


<script>
    $(document).ready(function () {

        $('#typeid').change(function ()
        {
            $('#makeName').val($('#typeid option:selected').attr('make'));
        });
        $('#typeYear').change(function ()
        {
            $('#modelYear').val($('#typeYear option:selected').attr('year'));
        });


        $('#btnStickUpSizeToggler').click(function () {
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModal');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#myModal').modal('show');
                $('.resetData').val('');
                $('.responseErr').html('');
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
        });

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });

        $('#vehiclemodal_addbutton').click(function () {
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModals');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#myModals').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }

            $('#typeid').val('0');
            $('#typeYear').val('0');
            $('#modalname').val('');
            $('.editModelReset').val('');


        });


        $('#searchData').click(function () {
            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

            $('#createcontrollerurl').attr('href', '<?php echo base_url() ?>index.php?/vehicle/Get_dataformdate/' + st + '/' + end);

        });

        $('#search_by_select').change(function () {
            $('#atag').attr('href', '<?php echo base_url() ?>index.php?/vehicle/search_by_select/' + $('#search_by_select').val());

            $("#callone").trigger("click");
        });




        //EDIT MAKE
        $(document).on('click', '#editMakeData', function () {
            var val = $(this).attr('data');
            $("#display-data").text("");
            $.ajax({
                url: "<?php echo base_url('index.php?/vehicle') ?>/getMakeData",
                type: "POST",
                data: {id: val},
                dataType: 'json',
                success: function (result) {
                    $.each(result.makeName, function (index, row)
                    {
                        $('#typename_e_' + index).val(row);

                    });
                    $('#typename_e_en_def').val($('#typename_e_en').val());
                    $('#typename_id_e').val(val);
                    $('#editMakeModal').modal('show');


                }
            });

        });
        $('#editMake').click(function ()
        {
            $(".errors").text("");
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select any one brand name to edit");
            } else if (val.length > 1) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select only one brand name to edit");
            } else {

                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/getMakeData",
                    type: "POST",
                    data: {id: $('.checkbox:checked').val()},
                    dataType: 'json',
                    success: function (result) {
                        $.each(result.makeName, function (index, row)
                        {
                            $('#typename_e_' + index).val(row);

                        });
                        $('#typename_e_en_def').val($('#typename_e_en').val());
                        $('#typename_id_e').val(val);
                        $('#editMakeModal').modal('show');


                    }
                });
                // $('#typename_e').val($('.checkbox:checked').parent().prev().text());
                // $('#typename_id_e').val($('.checkbox:checked').val());
                // $('#editMakeModal').modal('show');

            }
        });
        //EDIT MODEL
        $(document).on('click', '#editModelData', function () {
            var val = $(this).attr('data');
            var data = $(this).attr('data-make');
            $("#display-data").text("");
            $.ajax({
                url: "<?php echo base_url('index.php?/vehicle') ?>/getMakeDetails",
                type: "POST",
                data: {id: data},
                dataType: 'json',
                success: function (result) {
                    $.each(result.data, function (index, row)
                    {
                        $('#select_make_edit').val(row.makeName.en);
                        $('#makeEditId').val(row._id.$oid);
                        $.each(row.models, function (index1, rowData)
                        {
                            if (rowData._id.$oid == val)
                            {
                                $.each(rowData.name, function (index2, row1)
                                {
                                    $('#typename_e_edit_' + index2).val(row1);
                                    $('#typename_e_edit_Def_' + index2).val(row1);
                                });
                                var currentTime = new Date();
                                var year = currentTime.getFullYear();
                                var html;
                                for (var i = year; i >= 1990; i--) {
                                    if (rowData.year == i)
                                    {
                                        html += "<option value='" + i + "' selected>" + i + "</option>";
                                        $('#modelYearEdit').val(i);
                                    } else
                                    {
                                        html += "<option value='" + i + "'>" + i + "</option>";
                                    }
                                }

                                $('#country_select_year_e').html(html);
                                $('#modalname_e').val(rowData.name.en);
                                $('#model_id').val(rowData._id.$oid);
                            }
                        });
                        // $('#model_id').val(row.models._id.$oid);
                    });
                    $('#editModelModal').modal('show');


                }
            });

        });
        $('#editModel').click(function ()
        {

            console.log($('.checkbox:checked').val());
            $("#display-data").text("");
            $(".errors").text("");
            var data;
            var val = $('.checkbox:checked').map(function () {
                data = $('.checkbox:checked').attr('data');
                return this.value;
            }).get();


            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select any one brand name to edit");
            } else if (val.length > 1) {

                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select only one brand name to edit");
            } else {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/getMakeDetails",
                    type: "POST",
                    data: {id: data},
                    dataType: 'json',
                    success: function (result) {
                        $.each(result.data, function (index, row)
                        {
                            $('#select_make_edit').val(row.makeName.en);
                            $('#makeEditId').val(row._id.$oid);
                            $.each(row.models, function (index1, rowData)
                            {
                                if (rowData._id.$oid == val)
                                {
                                    $.each(rowData.name, function (index2, row1)
                                    {
                                        $('#typename_e_edit_' + index2).val(row1);
                                        $('#typename_e_edit_Def_' + index2).val(row1);
                                    });
                                    var currentTime = new Date();
                                    var year = currentTime.getFullYear();
                                    var html;
                                    for (var i = year; i >= 1990; i--) {
                                        if (rowData.year == i)
                                        {
                                            html += "<option value='" + i + "' selected>" + i + "</option>";
                                            $('#modelYearEdit').val(i);
                                        } else
                                        {
                                            html += "<option value='" + i + "'>" + i + "</option>";
                                        }
                                    }

                                    $('#country_select_year_e').html(html);
                                    $('#modalname_e').val(rowData.name.en);
                                    $('#model_id').val(rowData._id.$oid);
                                }
                            });
                            // $('#model_id').val(row.models._id.$oid);
                        });
                        $('#editModelModal').modal('show');


                    }
                });

            }
        });

        $('#select_make_edit').change(function ()
        {
            $('#makeEdit').val($('#select_make_edit option:selected').attr('make'));
        });



        $("#chekdel").click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length > 0) {
                if (confirm("Are you sure to Delete " + val.length + " Vehicle")) {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/vehicle') ?>/deleteVehicles",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result) {
                            alert(result.affectedRows)

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });
                        }
                    });
                }

            } else {
                alert("Please mark any one of options");
            }

        });

        $(document).on('click', '#deleteMakeData', function () {
            var val = $(this).attr('data');
            $("#display-data").text("");
            $('#deleteMakeRecord').modal('show');
            $("#errorboxdata").text(<?php echo json_encode(POPUP_VEHICLE_MAKE); ?>);
            $("#confirmedDel").click(function () {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/addEditVehicleMake/deleteMake",
                    type: "POST",
                    data: {val: val},
                    dataType: 'json',
                    success: function (result)
                    {
                        $(".close").trigger('click');
                        makereload();
                    }
                });
            });

        });

        $("#delete").click(function () {
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 0) {
                $('#deleteMake').modal('show');
                $("#errorboxdata").text(<?php echo json_encode(POPUP_VEHICLE_MAKE); ?>);
                $("#confirmed").click(function () {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/vehicle') ?>/addEditVehicleMake/delete",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {
                            $(".close").trigger('click');
                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });
                        }
                    });
                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select atleast one brand name to delete");
            }

        });
        $(document).on('click', '#deleteModelData', function () {
            var val = $(this).attr('data');
//            $("#display-data").text("");
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#confirmmodelsRecord');
            if (size == "mini")
            {
                $('#modalStickUpSmall').modal('show')
            } else
            {
                $('#confirmmodelsRecord').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
            $("#errorboxdatas").text('are you sure to delete vehicle model');

            $("#confirmedsDel").click(function () {
                {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/vehicle') ?>/addEditVehicleModel/deletemodel",
                        type: "POST",
                        data: {id: val},
                        dataType: 'json',
                        success: function (result)
                        {
                            $(".close").trigger('click');
                            modelreload();

                        }
                    });
                }

            });

        });


        $("#deletes").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 0) {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_VEHICLETYPE); ?>);

                $("#confirmeds").click(function () {
                    {
                        $.ajax({
                            url: "<?php echo base_url('index.php?/vehicle') ?>/addEditVehicleModel/delete",
                            type: "POST",
                            data: {id: val},
                            dataType: 'json',
                            success: function (result)
                            {
                                $(".close").trigger('click');
                                $('.checkbox:checked').each(function (i) {
                                    $(this).closest('tr').remove();
                                });

                            }
                        });
                    }

                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select atleast one brand name to delete");
            }

        });


        $("#insert").click(function () {
            $("#insert_data").text("");
            var text = /^[a-zA-Z ]*$/;
            var typename = $("#typename").val();

            if (typename == "" || typename == null)
            {
                $("#insert_data").text(<?php echo json_encode(VEHICLE_MAKE_ERR); ?>);
            } else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/addEditVehicleMake/add",
                    type: 'POST',
                    data: $('#addFormModal').serialize(),
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.flag == 0)
                        {
                            $("#typename").val('');

                            $(".close").trigger('click');
                            makereload();
                        } else {
                            $('.responseErr').text(response.msg);
                        }
                    }
                });
            }
        });
        $("#updateMake").click(function () {

            var m_name = $("#typename_e_en").val();
            var m_name_def = $("#typename_e_def").val();
            var errstatus = '0';
            if (m_name == "" || m_name == null)
            {
                errstatus = '1';
                $("#errorMakeEdit").text('<?php echo VEHICLE_MAKE_ERR; ?>');
            } else if ($("#typename_e_en").attr('data-id') == '1')
            {
                errstatus = '1';
                $("#errorMakeEdit").text('Entered brand name is already exist, please try again with other brand name');
            }
            if (errstatus == '0')
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/addEditVehicleMake/edit",
                    type: 'POST',
                    data: $('#editFormModal').serialize(),
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.flag == 0)
                        {
                            $("#typename").val('');
                            $(".close").trigger('click');

                            makereload();
                        } else {
                            $('.responseErr').text(response.msg);
                        }


                    }
                });
            }
        });
        $("#updateModel").click(function () {

            $('.errors').text('');
            // var makeID = $("#select_make_edit").val();
            // var model_name = $("#modalname_e").val();
            var model_id = $("#model_id").val();
            var makeEditId = $("#makeEditId").val();
            var modelYearEdit = $("#modelYearEdit").val();
            var country_select_year_e = $("#country_select_year_e").val();
            var typename_e_edit_en = $("#typename_e_edit_en").val();
            var model_id = $("#model_id").val();
            var typename_e_edit_Def_en = $("#typename_e_edit_Def_en").val();


            // if (country_select_year_e == modelYearEdit && typename_e_edit_en == typename_e_edit_Def_en)
            // {
            //     $("#selectMake_e_Error").text('Please select brand name');
            // } else 
            if (typename_e_edit_en == "" || typename_e_edit_en == null)
            {
                $("#model_e_Error").text('Please enter brand name');
            } else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/addEditVehicleModel/edit",
                    type: 'POST',
                    data: $('#EditFormModals').serialize(),
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $("#typename").val('');
                        $(".close").trigger('click');

                        modelreload();
                    }
                });
            }
        });

        $("#inserts").click(function () {
            $(".errors").text("");

            var text = /^[a-zA-Z ]*$/;
            var typeid = $("#typeid").val();
            var modal = $("#modalname").val();
            var typeYear = $("#typeYear").val();

            if (typeid == "0")
            {

                $("#make_name_Error").text(<?php echo json_encode(POPUP_VEHICLEMODEL_TYPENAME); ?>);
            } else if (typeYear == "0")
            {

                $("#model_year_Error").text(<?php echo json_encode(POPUP_VEHICLEMODEL_MODELYEAR); ?>);
            } else if (modal == "" || modal == null)
            {

                $("#model_name_Error").text(<?php echo json_encode(POPUP_VEHICLEMODEL_MODELNAME); ?>);
            } else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/addEditVehicleModel/add",
                    type: 'POST',
                    data: $('#addFormModals').serialize(),
                    dataType: 'JSON',
                    success: function (response)
                    {

                        if (response.flag == 0)
                        {
                            $("#typeid").val('');
                            $("#modalname").val('');

                            $(".close").trigger('click');

                            modelreload();
                        } else {
                            $('.responseErr1').text(response.msg);
                        }
                    }
                });
            }

        });
    });
    function makereload()
    {
        var table = $('#big_table');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehiclemodels/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {

            },
            "drawCallback": function () {
                $('.cs-loader').hide();
                /*
                 * .cls100 = view
                 * .cls110 = add
                 * .cls111 = edit and delete
                 */
                // if (access == "100") {
                //     $('.cls110').remove();
                //     $('.cls111').remove();
                // } else if (access == "110") {
                //     $('.cls111').remove();

                // }
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                $('#big_table_processing').hide();
                /*
                 * .cls100 = view
                 * .cls110 = add
                 * .cls111 = edit and delete
                 */
                // if (access == "100") {
                //     $('.cls110').remove();
                //     $('.cls111').remove();
                // } else if (access == "110") {
                //     $('.cls111').remove();

                // }
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
        if (access == "111") {
            $('#big_table').dataTable().fnSetColumnVis([], false);
        } else {
            $('#big_table').dataTable().fnSetColumnVis([2, 3], false);
        }
    }
    function modelreload()
    {
        var table = $('#big_table');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehiclemodels/2',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {

            },
            "drawCallback": function () {
                $('.cs-loader').hide();
                /*
                 * .cls100 = view
                 * .cls110 = add
                 * .cls111 = edit and delete
                 */
                // if (access == "100") {
                //     $('.cls110').remove();
                //     $('.cls111').remove();
                // } else if (access == "110") {
                //     $('.cls111').remove();

                // }
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                $('#big_table_processing').hide();
                /*
                 * .cls100 = view
                 * .cls110 = add
                 * .cls111 = edit and delete
                 */
                // if (access == "100") {
                //     $('.cls110').remove();
                //     $('.cls111').remove();
                // } else if (access == "110") {
                //     $('.cls111').remove();

                // }
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

        if (access == "111") {
            $('#big_table').dataTable().fnSetColumnVis([], false);
        } else {
            $('#big_table').dataTable().fnSetColumnVis([4, 5], false);
        }
    }

</script>


<div class="page-content-wrapper"style="">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong><?php echo $this->lang->line('vehicle_model_heading'); ?></strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked">
                        <li id="1" class="tabs_active  <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor: pointer;">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/vehicle/vehicle_models/1" data-id="1"><span><?php echo $this->lang->line('tab_brand_name'); ?></span></a>
                        </li>
                        <li id="2" class="tabs_active  <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor: pointer;">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/vehicle/vehicle_models/2" data-id="2"><span><?php echo $this->lang->line('tab_brand_model'); ?></span></a>
                        </li>

                        <?php if ($status == 1) { ?>
                            <div class="pull-right m-t-10 lastButton cls111"><button class="btn btn-danger btn-cons " id="delete"><?php echo $this->lang->line('button_delete'); ?></button></div>
                            <!--<div class="pull-right m-t-10 cls111"><button class="btn btn-info btn-cons " id="editMake"><?php echo $this->lang->line('button_edit'); ?></button></div>-->
                            <div class="pull-right m-t-10 cls110"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler" ><?php echo $this->lang->line('button_add'); ?></button></div>

                        <?php } ?>
                        <?php if ($status == 2) { ?>
                            <div class="pull-right m-t-10 lastButton cls111"><button class="btn btn-danger btn-cons" id="deletes"><?php echo $this->lang->line('button_delete'); ?></button></div>
                            <!--<div class="pull-right m-t-10 cls111"><button class="btn btn-info btn-cons " id="editModel"><?php echo $this->lang->line('button_edit'); ?></button></div>-->
                            <div class="pull-right m-t-10 cls110"> <button class="btn btn-primary btn-cons" id="vehiclemodal_addbutton"><?php echo $this->lang->line('button_add'); ?></button></div>
                        <?php } ?>
                    </ul>
                    <!-- Tab panes -->
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

                                    <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search "> </div>

                                </div>
                                &nbsp;
                                <div class="panel-body">
                                    <?php echo $this->table->generate(); ?>
                                </div>
                            </div>
                            <!--                             END PANEL -->
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>


<div class="modal fade stick-up" id="deleteMakeRecord" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line('pop_up_heading_delete'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>


            <div class="modal-footer">

                <div class="col-sm-4" ></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="confirmedDel" >Delete</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div> 
<div class="modal fade stick-up" id="deleteMake" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line('pop_up_heading_delete'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>


            <div class="modal-footer">

                <div class="col-sm-4" ></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="confirmed" >Delete</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div> 



<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" ><?php echo $this->lang->line('pop_up_heading_add_brand_name'); ?></span>

            </div>

            <div class="modal-body">
                <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left" id="addFormModal">

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_brand_name'); ?> In English<span style="color:red;font-size: 12px"> * </span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text"  id="typename" name="typename[en]"  class="form-control error-box-class resetData" placeholder="Enter Make Name In English">

                        </div>
                        <div class="col-sm-3 error-box errors" id="insert_data">

                        </div>

                    </div>
                    <?php
                    foreach ($languages as $lang) {
                        ?>
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_brand_name'); ?> In <?php echo $lang['name'] ?></label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <input type="text"  id="<?php echo $lang['name'] ?>typename" name="typename[<?php echo $lang['code'] ?>]"  class="form-control error-box-class resetData" placeholder="Enter Make Name In<?php echo $lang['name'] ?>">

                            </div>
                            <div class="col-sm-3" id="">

                            </div>

                        </div>
                        <?php
                    }
                    ?>
                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-8 error-box errors responseErr"></div>
                <div class="col-sm-4" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="insert" ><?php echo $this->lang->line('button_add'); ?></button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_cancel'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="editMakeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" ><?php echo $this->lang->line('pop_up_heading_edit'); ?></span>

            </div>

            <div class="modal-body">
                <form action="" id="editFormModal" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_brand_name'); ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text"  id="typename_e_en" name="typename_e[en]"  class="form-control error-box-class" placeholder="" value="" onblur="validatebrandname();" data-id='0'>
                            <input type="hidden"  id="typename_id_e" name="id">
                            <input type="hidden" id="typename_e_en_def"/>
                        </div>
                        <div class="col-sm-3 error-box errors" id="errorMakeEdit">

                        </div>

                    </div>
                    <?php
                    foreach ($languages as $lang) {
                        ?>
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_brand_name'); ?> In <?php echo $lang['name'] ?></label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <input type="text"  id="typename_e_<?php echo $lang['code'] ?>" name="typename_e[<?php echo $lang['code'] ?>]"  class="form-control error-box-class" placeholder="Enter Make Name In<?php echo $lang['name'] ?>">

                            </div>
                            <div class="col-sm-3" id="">

                            </div>

                        </div>
                        <?php
                    }
                    ?>
                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-8 error-box errors responseErr"></div>
                <div class="col-sm-4" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="updateMake" ><?php echo $this->lang->line('button_update'); ?></button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_cancel'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="vehicleTypeModel" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">BRAND NAME</span> 
            </div>
            <div class="modal-body">
                <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                <table class="table table-bordered">
                    <thead>
                        <tr>

                            <th style="width:10%;text-align: center;">LANGUAGE</th>
                            <th style="width:10%;text-align: center;">VEHICLE MAKE NAME</th>
                        </tr>
                    </thead>
                    <tbody id="vehicleTypeNameTableBody">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--          <button type="button" class="btn btn-success" id="save_image">SAVE</button>-->
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="vehicleTypeMakeModel" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">MODEL NAME</span> 
            </div>
            <div class="modal-body">
                <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                <table class="table table-bordered">
                    <thead>
                        <tr>

                            <th style="width:10%;text-align: center;">LANGUAGE</th>
                            <th style="width:10%;text-align: center;">VEHICLE MODEL NAME</th>
                        </tr>
                    </thead>
                    <tbody id="vehicleTypeModelTableBody">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--          <button type="button" class="btn btn-success" id="save_image">SAVE</button>-->
            </div>
        </div>

    </div>
</div>

<div class="modal fade stick-up" id="myModals" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" ><?php echo $this->lang->line('pop_up_heading_add_model'); ?></span> 
            </div>
            <div class="modal-body">
                <form action="" id="addFormModals" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label" id=""><?php echo $this->lang->line('label_brand_name'); ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select id="typeid" name="country_select"  class="form-control error-box-class" >
                                <option value="0"><?php echo $this->lang->line('select'); ?></option>
                                <?php
                                foreach ($vehiclemake as $each) {

                                    echo "<option value=" . $each['_id']['$oid'] . " make='" . $each['makeName']['en'] . "'>" . $each['makeName']['en'] . "</option>";
                                }
                                ?>

                            </select>
                            <input type="hidden" id="makeName" name="makeName">
                        </div>
                        <div class="col-sm-3 error-box errors" id="make_name_Error" ></div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label" id="">Year<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select id="typeYear" name="country_select_year"  class="form-control error-box-class" >
                                <option value="0"><?php echo $this->lang->line('select'); ?></option>
                                <?php
                                $cYear = date("Y");
                                echo $cYear;
                                for ($i = $cYear; $i >= 1990; $i--) {

                                    echo "<option value=" . $i . ">" . $i . "</option>";
                                }
                                ?>

                            </select>
                            <input type="hidden" id="modelYear" name="modelYear">
                        </div>
                        <div class="col-sm-3 error-box errors" id="model_year_Error" ></div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_brand_model'); ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text"  id="modalname" name="modalname[en]"  class="form-control editModelReset" placeholder="Enter Model Name In English">
                        </div>
                        <div class="col-sm-3 error-box errors" id="model_name_Error" ></div>
                    </div>
                    <?php
                    foreach ($languages as $lang) {
                        ?>
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_brand_name'); ?> In <?php echo $lang['name'] ?></label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <input type="text"  id="<?php echo $lang['code'] ?>_typename" name="modalname[<?php echo $lang['code'] ?>]"  class="form-control error-box-class editModelReset" placeholder="Enter Model Name In<?php echo $lang['name'] ?>">

                            </div>
                            <div class="col-sm-3" id="">

                            </div>

                        </div>
                        <?php
                    }
                    ?>


                </form>
            </div>
            <div class="modal-footer">
                <div class="col-sm-8 errors responseErr1" ></div>

                <div class="col-sm-4">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="inserts" ><?php echo $this->lang->line('button_add'); ?></button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_cancel'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="editModelModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" ><?php echo $this->lang->line('pop_up_heading_edit'); ?></span> 
            </div>
            <div class="modal-body">
                <form action="" id="EditFormModals" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label" id=""><?php echo $this->lang->line('label_brand_name'); ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" name="select_make_edit" id="select_make_edit" readonly="" class="form-control">
                            <input type="hidden" id="makeEditId" name="makeEditId">
                        </div>
                        <div class="col-sm-3 error-box errors" id="selectMake_e_Error"></div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label" id="">Year<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <select id="country_select_year_e" name="country_select_year_e"  class="form-control error-box-class" >

                            </select>
                            <input type="hidden" id="modelYearEdit" name="modelYearEdit">
                        </div>
                        <div class="col-sm-3 error-box errors" id="model_year_Error" ></div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_brand_model'); ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text"  id="typename_e_edit_en" name="brandname_e_edit[en]"  class="form-control" placeholder="">
                            <input type="hidden"  id="model_id" name="model_id">
                            <input type="hidden"  id="typename_e_edit_Def_en" name="typename_e_edit_Def_en">

                        </div>
                        <div class="col-sm-3 error-box errors" id="model_e_Error">
                        </div>
                    </div>
                    <?php
                    foreach ($languages as $lang) {
                        ?>
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_brand_name'); ?> In <?php echo $lang['name'] ?></label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <input type="text"  id="typename_e_edit_<?php echo $lang['code'] ?>" name="brandname_e_edit[<?php echo $lang['code'] ?>]"  class="form-control error-box-class" placeholder="Enter Make Name In<?php echo $lang['name'] ?>">
                                <input type="hidden"  id="typename_e_edit_Def_<?php echo $lang['code'] ?>" name="typename_e_edit_Def_<?php echo $lang['code'] ?>">
                            </div>
                            <div class="col-sm-3" id="">

                            </div>

                        </div>
                        <?php
                    }
                    ?>


                </form>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box errors" id="inserts-data" ></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"><button type="button" class="btn btn-success pull-right" id="updateModel" ><?php echo $this->lang->line('button_update'); ?></button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_cancel'); ?></button></div>
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
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"> <?php echo $this->lang->line('pop_up_heading_delete'); ?></span>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center"> <?php echo $this->lang->line('pop_up_msg_delete'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">

                    <div class="col-sm-4"></div>
                    <div class="col-sm-8" >

                        <div class="pull-right m-t-10"><button type="button" class="btn btn-danger pull-right" id="confirmeds" ><?php echo $this->lang->line('button_delete'); ?></button> <div class="pull-right m-t-10">
                                <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_cancel'); ?></button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>



<div class="modal fade stick-up" id="confirmmodelsRecord" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"> <?php echo $this->lang->line('pop_up_heading_delete'); ?></span>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center">are you sure to delete vehicle model</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">

                    <div class="col-sm-4"></div>
                    <div class="col-sm-8" >

                        <div class="pull-right m-t-10"><button type="button" class="btn btn-danger pull-right" id="confirmedsDel" ><?php echo $this->lang->line('button_delete'); ?></button> <div class="pull-right m-t-10">
                                <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_cancel'); ?></button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>
