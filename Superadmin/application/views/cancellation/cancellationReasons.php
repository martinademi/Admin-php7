<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Cancellation/datatable_canreason/<?= $reason?>/<?= $reasonFor?>',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
//                  $('#big_table_processing').hide();
                $('.cs-loader').hide();
                table.show()
                searchInput.show()
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

        $('#add').click(function () {
            $('#addReasons').val("");
            $('#cancelreason_err').text('');
            $('input:text').val("");
            $('#modalSlideUpSmall').modal('show');

        });

        $('#btnadd').click(function () {
            var reasons = {};
            $('.addReasons').each(function () {
                var key = $(this).attr('lang');
               reasons[key] = ($(this).val());
            });
            if(reasons.en == '')
            {
                $("#cancelreason_err").text("please fill english reasons for cancellation.")
            }
            else
                {
                    $.ajax({
                    url: "<?php echo base_url() ?>index.php?/cancellation/cancell_act",
                    type: "POST",
                    data: {reasons: reasons, res_for: '<?= $reasonFor?>', res: '<?= $reason?>'},
                    dataType: "JSON",
                    success: function (result) {
                        if (result.msg == '1') {
                            $('#search-table').trigger('keyup');
                            $('#modalSlideUpSmall').modal('hide');
                        } else {
                            alert('Problem occurred please try agin.');
                        }
                      }
                    })  
                }
        });
        $('#searchlanguage').change(function () {
            var optionSelected = $(this).val();

            var table = $('#big_table');
            var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": (optionSelected == 'All')?('<?php echo base_url() ?>index.php?/cancellation/datatable_canreason/<?= $reason?>/<?= $reasonFor?>'):('<?php echo base_url() ?>index.php?/Utilities/transection_data_ajax/<?= $reason?>/<?= $reasonFor?>/' + optionSelected),
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
//                  $('#big_table_processing').hide();
                $('.cs-loader').hide();
                table.show()
                searchInput.show()
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


//            $("#callone").trigger("click");
        });

        $('#delete').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $("#generalPopup").modal("show");
            } else if (val.length > 0) {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#modalSlideUpSmallone');
                if (size == "mini") {
                    $('#modalSlideUpSmallone').modal('show')
                } else {
                    $('#modalSlideUpSmallone').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    } else {
                        $('#btndelete').click(function () {
                            $.ajax({
                                url: "<?php echo base_url() ?>index.php?/cancellation/cancell_act/del",
                                type: "POST",
                                data: {id: val, res: '<?= $reason?>'},
                                dataType: "JSON",
                                success: function (result) {
                                    if (result.msg == '1') {
                                        $('#search-table').trigger('keyup');
                                        $('#modalSlideUpSmall').modal('hide');
                                    } else {
                                        alert('Problem occurred please try agin.');
                                    }
                                    $('#modalSlideUpSmallone').modal('hide');
                                }
                            });
                        });
                    }
                }
            }
        });

        $('#edit').click(function () {
            $('#errorboxEdit').val(" ");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                
                $("#generalPopup h4").html("<h4>Please select the checkbox..., to perform the action...!!</h4>")
                $("#generalPopup").modal("show");
            } else if (val.length > 1){
                $("#generalPopup h4").html("<h4>Please Select only one reasons to edit.</h4>")
                $("#generalPopup").modal("show");
            } else if (val.length == 1) {
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/cancellation/getCanData",
                    type: "POST",
                    data: {id: val, res: '<?= $reason?>'},
                    dataType: "JSON",
                    success: function (result) {
                        $('.editReasons').attr('edit_id', result.data.res_id);
                        var language = JSON.parse('<?= json_encode($language);?>')
                        $('#editlanguage').val(result.data.language);
                        $('#addReasons_en').val(result.data.reasonObj['en'])
                        $.each(language, function (index, value) {
                             $('#addReasons_' +value.langCode).val(result.data.reasonObj[value.langCode])

                        })
                    }
                });
                $('#editmodal').modal('show')
            }

        });
        $('#btnedit').click(function () {
            $("#editcancel_err").text("");
            var reasons = {};
            $('.addReasons').each(function () {
                var key = $(this).attr('lang');
                reasons[key] = ($('#addReasons_'+key).val());
            });
            if(reasons.en == '')
            {
                $("#cancelreason_err").text("please fill english reasons for cancellation.")
            }
            else{
                $.ajax({
                            url: "<?php echo base_url() ?>index.php?/cancellation/cancell_act",
                            type: "POST",
                            data: {reasons: reasons, language:$('#editlanguage').val(), res: '<?= $reason?>', edit_id: $('#btnedit').attr('edit_id'), id: $('#btnedit').attr('data-id')},
                            dataType: "JSON",
                            success: function (result) {
                                if (result.msg == '1') {
                                    $('#search-table').trigger('keyup');
                                    $('#editmodal').modal('hide');
                                } else {
                                    alert('Problem occurred please try agin.');
                                }
                            }
                        });
            }
        });
        
        
        
        
        
        $(document).on('click', '.cancelReson', function ()
        {
            var reson='<?= $reason?>';
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php?/cancellation') ?>/getCancelResonsSupportLanguage",
                data: {canId: $(this).data('id'),reson:reson},
                dataType: "JSON",
                success: function (result) {
                   // console.log('langgg',result);
                    $('#supportTableBody').html('');
                   
                    var html = "<tr><td style='text-align: center;'>English</td>";
                    html += "<td style='text-align: center;'>" + result.data.reasonObj.en + "</td></tr>";

                    $.each(result.lang, function (i, res) {
                      
                        if (result.data.reasonObj[res.langCode]) {
                            html += "<tr><td style='text-align: center;text-transform: capitalize;'>"+res.lan_name+"</td>";
                            html += "<td style='text-align: center;'>" + result.data.reasonObj[res.langCode] + "</td></tr>";
                        }
                    })

                     

                    $('#supportTableBody').append(html);
//                          
                    $('#supportModel').modal('show');
                }
            });


        });
    });
 $(document).on('click','.getReasons',function (){ 
    var langCode = $(this).attr('langCode')
    var reasonId   = [$(this).attr('reasonId')] ;
        $.ajax({
                url: "<?php echo base_url() ?>index.php?/cancellation/getCanData",
                type: "POST",
                data: {id: reasonId, res: '<?= $reason?>'},
                dataType: "JSON",
                success: function (result) {
                    $('#cancellationMessage').html("<center><h6>There is no reasons in this language.</h6></center>");
                    $('#modalcancellationMessage').modal('show');
                    $('#cancellationMessage').text(result.data.reasons[langCode]);
                }
        });

});

function buttonDisable(){
    var reasons = {};
            $('.addReasons').each(function () {
                var key = $(this).attr('lang');
               reasons[key] = ($(this).val());
            });
            if(reasons.en == '')
            {
                $('#btnadd').attr('disabled',false);
            }else{

                 $('#btnadd').attr('disabled',true);

            } 

  
}
</script>

<style>
    .exportOptions{
        display: none;
    }
    .btn {
        border-radius: 25px !important;
    }
</style>
<div class="page-content-wrapper">
    <div class="content">
        <div class="container-fluid container-fixed-lg">
            <ul class="breadcrumb">
                <li>
                    <a href="#" class="active">Cancellation Reason</a>
                </li>
                <li>
                    <a href="#" class="active"><?= $reason?></a>
                </li>
                <!-- <li>
                    <a href="#" class="active"><?= $reasonFor?></a>
                </li> -->
            </ul>
            <div class="container-md-height m-b-20">
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs nav-tabs-fillup bg-white">
                            <div class="pull-right m-t-10 cls111"><button  class="btn btn-danger" id="delete"> Delete</button></div>

                            <div class="pull-right m-t-10 cls111"><button data-toggle="modal"  id="edit" class="btn btn-info"> Edit</button></div>

                            <div class="pull-right m-t-10 cls110"><button data-toggle="modal" class="btn btn-primary btn-cons" id="add"> Add</button></div>
                        </ul>
                    </div>
                    <div class="panel-body no-padding">
                        <div class="row" style="margin:10px;">
                            <div class="com-sm-8">
                                <div class="cs-loader">
                                    <div class="cs-loader-inner" >
                                        <label class="loaderPoint" style="color:#10cfbd">●</label>
                                        <label class="loaderPoint" style="color:red">●</label>
                                        <label class="loaderPoint" style="color:#FFD119">●</label>
                                        <label class="loaderPoint" style="color:#4d90fe">●</label>
                                        <label class="loaderPoint" style="color:palevioletred">●</label>
                                    </div>
                                </div>
                            </div>
                            <div class="com-sm-4">
                                    <div class="row clearfix pull-right" >
                                        <div class="col-sm-12">
                                            <div class="searchbtn" >

                                                <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?> "> </div>
                                            </div>

                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="row" style="margin:10px;">
                            <!-- seaarch reasons by language-->
<!--                             <select class="selectpicker" data-live-search="true" id="searchlanguage">
                                <option value='All'>All</option>
                                     <option value="0">English</option>
                                <?php foreach($language as $value):?>
                                    <option value="<?= $value['languageId'];?>"><?= $value['name'];?></option>
                                <?php endforeach ;?>
                            </select> -->
                            <div style="height:10px;clear:both;"></div>
                            <?php echo $this->table->generate(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade slide-up disable-scroll in" id="generalPopup" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"></span>
                </div>
                <div class="modal-body text-center m-t-20">
                    <h4 class="no-margin p-b-10">Please select the checkbok...,  to perform the action...!!</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-cons " data-dismiss="modal">OK</button>
                </div>
            </div>

        </div>
    </div>
    <!-- /.modal-content -->
</div>
</div>
<div class="modal fade slide-up disable-scroll in" id="modalSlideUpSmall" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"> ADD</span>
                </div>
                <div class="modal-body">
                    <label>Reason in Englishs<span style="color:red;font-size: 12px"> *</span></label>
                    <input type="text" id="addReasons" lang = "en" class="form-control addReasons" placeholder="Enter the reason in English for cancellation"/>
                    <span class="show_err" id="cancelreason_err"></span><br>
                    <?php foreach($language as $value){?>
                        <label>Reason in <?php echo ($value['lan_name']);?> </label>
                        <input type="text" lang = "<?= $value['langCode'];?>" id="addReasons" class="form-control addReasons" placeholder="Enter the reason in <?= ucwords($value['lan_name']);?> for cancellation"/>
                        <span class="show_err" id="cancelreason_err"></span>
                    <?php }?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="buttonDisable()" id="btnadd">ADD</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div class="modal fade slide-up disable-scroll in" id="editmodal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"> EDIT</span>
                </div>
                <div class="modal-body">
                    <label>Reason in English<span style="color:red;font-size: 12px"> *</span></label>
                    <input type="text" id="addReasons_en" lang = "en" class="form-control addReasonsForEdit" placeholder="Enter the reason in English for cancellation"/>
                    <span class="show_err" id="cancelreason_err"></span>
                    <?php foreach($language as $value){?>
                        <label>Reason in <?= ucwords($value['lan_name']);?> </label>
                        <input type="text" lang = "<?= ucwords($value['langCode']);?>" id="addReasons_<?= $value['langCode'];?>" class="form-control addReasonsForEdit" placeholder="Enter the reason in <?= ucwords($value['lan_name']);?> for cancellation"/>
                        <span class="show_err" id="cancelreason_err"></span>
                    <?php } ?>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary editReasons"  data-id="" edit_id="" id="btnedit">Edit</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div class="modal fade slide-up disable-scroll in" id="modalSlideUpSmallone" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"></span>
                </div>
                <div class="modal-body">
                    <h4 class="no-margin p-b-10">Are you sure, You want to Delete the reason ?</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btndelete" class="btn btn-primary " data-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- show the popup model for language -->
<div class="modal fade slide-up disable-scroll in" id="modalcancellationMessage" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title">Reasons</span>
                </div>
                <div class="modal-body">
                    <p id="cancellationMessage"></p>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btndelete" class="btn btn-primary " data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
</div>



<div class="modal fade" id="supportModel" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">CANCELLATION REASONS</span> 
            </div>
            <div class="modal-body">
                <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                <table class="table table-bordered">
                    <thead>
                        <tr>

                            <th style="width:10%;text-align: center;">LANGUAGE</th>
                            <th style="width:10%;text-align: center;">CANCELLATION REASONS</th>
                        </tr>
                    </thead>
                    <tbody id="supportTableBody">

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