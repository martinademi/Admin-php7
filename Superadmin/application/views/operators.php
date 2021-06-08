<?php
if ($status == 5) {
    $vehicle_status = 'New';
    $new = "active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
} else if ($status == 2) {
    $vehicle_status = 'Accepted';
    $accept = "active";
} else if ($status == 4) {
    $vehicle_status = 'Rejected';
    $reject = 'active';
} else if ($status == 2) {
    $vehicle_status = 'Free';
    $free = 'active';
} else if ($status == 1) {
    $active = 'active';
}
?>
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    #companyid{
        display: none;
    }
    .pac-container {
        z-index: 1051 !important;
    }

</style>
<link href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    var currentTab = 1;
    var status = '<?php echo $status; ?>';
    $(document).ready(function () {

        $("#mobile_s").on("countrychange", function (e, countryData) {

            $("#coutry-code").val(countryData.dialCode);
        });

        var table = $('#big_table');

        $('.whenclicked li').click(function () {
            // alert($(this).attr('id'));

            if ($(this).attr('id') == 1) {
                $('#add').show();
                $('#activate').show();
                $('#deactivate').show();
                $('#suspend').show();
            } else if ($(this).attr('id') == 3) {
                $('#activate').hide();
                $('#deactivate').show();
                $('#suspend').show();
            } else if ($(this).attr('id') == 5) {
                $('#deactivate').hide();
                $('#activate').show();
                $('#suspend').show();

            } else if ($(this).attr('id') == 6) {
                $('#suspend').hide();
                $('#deactivate').hide();
                $('#activate').show();
            }

        });

        $('#big_table_processing').show();

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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_operator/' + status,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "columns": [
                    {"width": "5%"},
                    null,
                    {"width": "20%"},
                    null,
                    null,
                    null,
                    {"width": "20%"},
                    null,
                    null,
                    null,
                    null

                ],
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
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
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
//                           var data = JSON.stringify(aData.bid);
                    console.log('aData:' + JSON.stringify(aData));
                }
            };

            table.dataTable(settings);
        }, 1000);



        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });


        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];

            if (status == 1 || status == 4)
                $('#big_table').dataTable().fnSetColumnVis([4, 5], false);

        });

    });
</script>

<script>

    $(document).ready(function () {

        $(":file").on("change", function (e) {
            var fieldID = $(this).attr('id');
            var ext = $(this).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $(this).val('');
                alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
            } else
            {

                var formElement = $(this).prop('files')[0];
                var form_data = new FormData();
                form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
                form_data.append('OtherPhoto', formElement);
                form_data.append('type', 'Operator');
                form_data.append('folder', 'Logo');


//                form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/superadmin/upload_images_on_amazon",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",
                    async: false,
                    beforeSend: function () {
                        //                    $("#ImageLoading").show();
                    },
                    success: function (result) {

                        $('#operatorImage').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                        $('.companyLogoLink').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                    },
                    error: function () {

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

        $("#define_page").html("Companies");

        $('.company_s').addClass('active');
        $('.company_s').attr('src', "<?php echo base_url(); ?>/theme/icon/companies_on.png");
//        $('.company_sthumb').addClass("bg-success");


        $("#editcompany").click(function () {
            $('#companyID').val($('.checkbox:checked').val());

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $('#alertmodel').modal('show');
                $("#alertdata").text("Please select atleast one operator");
            } else if (val.length > 1) {
                $("#displayData").modal("show");
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_ONLYONE); ?>);
            } else {

                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getComapnyDetails",
                    data: {companyID: $('.checkbox:checked').val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $.each(response.data, function (i, value)
                        {

                            if (value.registered == 1)
                                $('#unregistered1').prop("checked", true);
                            else
                                $('#registered1').prop("checked", true);
                            $('#cname_S').val(value.operatorName);
                            $('#email_s').val(value.email);
                            $('#addr_s').val(value.address);
                            $('#state_s').val(value.state);
                            $('#city_s').val(value.cityID);
                            $('#pcode_s').val(value.postcode);
                            $('#fname_s').val(value.fname);
                            $('#lname_S').val(value.lname);
                            var arr = value.mobile.split('-');

                            $("#mobile_s").intlTelInput("setNumber", arr[0] + ' ' + arr[1]);


                            if (value.operatorLogo != '')
                            {
                                $('.companyLogoLink').attr('href', value.operatorLogo);
                                $('.companyLogoLink').attr('src', value.operatorLogo);
                                $('.companyLogoLink').show();
                            }
                        });
                    }, error: function (e) {
                        alert('error' + e.message);
                    }
                });


                $('#EditCompanyPopUp').modal('show');
//                window.location = "<?php echo base_url() ?>index.php?/superadmin/add_edit/edit/" + val;

            }


        });

        $('#updateCompnayDetials').click(function ()
        {

            $('.error-box').text('');
            var cname = $("#cname_S").val();

            var pass = $("#pass_s").val();
            var uemail = $("#email_s").val();
            var addr = $("#addr_s").val();

            
            var state = $("#state_s").val();
            var pcode = $("#pcode_s").val();
            var vnumber = $("#vnumber_s").val();

            var fname = $("#fname_s").val();
            var lname = $("#lname_S").val();
            var uname = $("#uname_s").val();
            var mobile = $("#mobile_s").val();


            var password = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{6,}$/g;

            var number = /^[0-9-+]+$/;
            var post_code = /^[0-9]+$/;

            var phone = /^[0-9]{10,14}$/;
            var company = /^[-\w\s]+$/;
            var re = /[a-zA-Z0-9\-\_]$/;

            var email = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            var text = /^[a-zA-Z ]*$/;
            var alphabit = /^[a-zA-Z]+$/;


            if (cname == "" || cname == null)
            {
                $("#companyname_s").text(<?php echo json_encode(POPUP_COMPANY_NAME); ?>);
                return false;

            } else if (!re.test(cname))
            {
                $("#companyname_s").text(<?php echo json_encode(POPUP_COMPANY_NAMEVALID); ?>);
                return false;

            } else if (uemail == "" || uemail == null)
            {
//              
                $("#email_ss").text(<?php echo json_encode(POPUP_COMPANY_EMAIL); ?>);
                return false;

            } else if (addr == "" || addr == null)
            {
//           
                $("#address_s").text(<?php echo json_encode(POPUP_COMPANY_ADDRESS); ?>);
                return false;
            }
            if (fname == "" || fname == null)
            {
                $('#fnamefirst').text(<?php echo json_encode(POPUP_COMPANY_SELECT_FIRSTNAME); ?>);
                return false;

            } else if (mobile == "" || mobile == null)
            {
                $('#mobilefirst').text(<?php echo json_encode(POPUP_COMPANY_SELECT_MOBILE); ?>);
                return false;

            }else
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>index.php?/superadmin/updatecompany",
                    data: new FormData($('#editCompanyForm')[0]),
                    processData: false,
                    contentType: false,
                    success: function (data) {

                        $('.close').trigger('click');
                        var table = $('#big_table');
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_operator/' + currentTab,
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                            },
                            "fnInitComplete": function () {
                                //oTable.fnAdjustColumnSizing();
                                $('#big_table_processing').hide();
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
                            }
                        };

                        table.dataTable(settings);


                    }
                });
            }
        });

        $("#activate").click(function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0 || val.length == null) {
                $('#alertmodel').modal('show');
                //        alert("please select atleast one company");
                $('#alertdata').text("Please select atleast one operator");
            } else if (val.length > 0)
            {
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
                $("#errorboxdata").text(<?php echo json_encode(POPUP_ACCEPTED); ?>);

            }

        });

        $("#confirmed").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('index.php?/superadmin') ?>/activatecompany",
                data: {val: val,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>', },
                dataType: 'JSON',
                success: function (response)
                {

                    $('.checkbox:checked').each(function (i) {
                        $(this).closest('tr').remove();


                    });
                    $(".close").trigger("click");
                }, error: function (e) {

                    alert('error' + e.message);
                }
            });
        });



        $("#deactivate").click(function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                //  alert("please select atleast one company");
                $("#alertmodel").modal("show");
                $("#alertdata").text("Please select atleast one operator");
            } else if (val.length > 0) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_REJECTED); ?>);


            }

        });

        $("#confirmeds").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/deactivatecompany",
                type: 'POST',
                data: {val: val,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>', },
                dataType: 'JSON',
                success: function (response)
                {

                    $('.checkbox:checked').each(function (i) {
                        $(this).closest('tr').remove();


                    });
                    $(".close").trigger("click");
//                             alert(response.msg);
//                            window.location = "<?php echo base_url(); ?>index.php?/superadmin/company_s/5";
                }
            });
        });


        $("#delete").click(function () {
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $("#alertmodel").modal("show");
                //         alert("please select atleast one company");
                $("#alertdata").text("Please select atleast one operator");
            } else if (val.length >= 1)
            {
//                 if(confirm("Are you sure to Delete " +val.length + " companys")){
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmode');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmode').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdat").text(<?php echo json_encode(POPUP_DELETE); ?>);


            }

        });

        $("#confirme").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('index.php?/superadmin') ?>/delete_company",
                data: {val: val,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
                dataType: 'JSON',
                success: function (response)
                {
                    //      alert(response.msg);

                    $('.checkbox:checked').each(function (i) {
                        $(this).closest('tr').remove();
                    });
                    $(".close").trigger("click");
                }


            });


        });


        $('.changeMode').click(function () {


            var tab_bar = $(this).attr('data-id');

            if (tab_bar != 1)
                $('#add').hide();

            if (tab_bar != currentTab)
            {
                currentTab = tab_bar;

                var table = $('#big_table');
                table.hide();

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
                        //oTable.fnAdjustColumnSizing();
                        table.show()
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
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();                ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();                ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();                ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">OPERATORS</strong><!-- id="define_page"-->
        </div>
        <!-- Nav tabs -->

        <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">


            <li id="1" class="tabs_active  <?php echo ($status == 1 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_operator/1" data-id="1"><span><?php echo LIST_NEW; ?></span></a>
            </li>
            <li id="3" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>" style="cursor:pointer;text-transform:uppercase;">
                <a  class="changeMode"   data="<?php echo base_url(); ?>index.php?/superadmin/datatable_operator/3" data-id="3"><span><?php echo LIST_ACCEPTED; ?> </span></a>
            </li>
            <li id="5" class="tabs_active <?php echo ($status == 5 ? "active" : "") ?>" style="cursor:pointer;text-transform:uppercase;">
                <a  class="changeMode"   data="<?php echo base_url(); ?>index.php?/superadmin/datatable_operator/4" data-id="4"><span>DEACTIVATED</span></a>
            </li>
           <!-- <li id="6" class="tabs_active <?php echo ($status == 6 ? "active" : "") ?>">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_operator/6"><span><?php echo LIST_SUSPENDED; ?></span></a>
            </li> -->


            <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons" id="delete"><?php echo BUTTON_DELETE; ?></button></div>


                        <!--<div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons action_buttons" id="suspend"><?php echo BUTTON_SUSPEND; ?></button></div>-->




            <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons action_buttons" id="deactivate"><?php echo BUTTON_REJECT; ?></button></div>

            <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons action_buttons" id="activate" ><?php echo BUTTON_ACTIVATE; ?></button></div>

            <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons" id="editcompany"><?php echo BUTTON_EDIT; ?></button></div>
            <div id="add" class="pull-right m-t-10 cls110"><a href="<?php echo base_url() ?>index.php?/superadmin/add_operator"> <button class="btn btn-primary btn-cons" ><?php echo BUTTON_ADD; ?></button></a></div>



        </ul>
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

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="alertmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="alertdata" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >

                        <button type="button" class="btn btn-primary pull-right" data-dismiss="modal" aria-hidden="true">OK</button>
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
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="confirmmodelss" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatass" style="text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmedss" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="confirmmode" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DELETE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>


            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdat" style="text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-danger pull-right" id="confirme" >Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="EditCompanyPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">EDIT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>


            </div>
            <div class="modal-body">
                <form id="editCompanyForm" class="form-horizontal" role="form" action=""  method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" id="coutry-code" name="coutry-code" value="">
                    <input type="hidden" id="companyID" name="companyID">
                    <div class="tab-pane slide-left padding-20 <?php echo $activetab2 ?>" id="tab3">
                        <div class="row row-same-height">

                            <div class="form-group" class="formexx">
                                <label for="address" class="col-sm-2 control-label">Operator  Type<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                    <div class="col-sm-5">
                                        <input type="radio" class="radio-success" name="registered" id="Registered1" value="0" checked>
                                        <label>Registered</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="radio" class="radio-success" name="registered" id="Unregistered1" value="1">
                                        <label>Unregistered</label>
                                    </div>
                                </div>

                                <div class="col-sm-3 error-box" id="companyname"></div>
                            </div>

                            <div class="form-group" class="formexx">
                                <label for="address" class="col-sm-2 control-label">Operator Name<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text" id="cname_S" name="companyname" class="form-control error-box-class" value="<?php echo $value->companyname; ?>">

                                </div>
                                <div class="col-sm-3 error-box" id="companyname_s"></div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_EMAIL; ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text" id="email_s" name="email" class="form-control error-box-class" onblur="ValidateFromDb()" value="<?php echo $value->email; ?>">

                                </div>
                                <div class="col-sm-3 error-box" id="email_ss"></div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_ADDRESS; ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text" id="addr_s" name="address" class="form-control error-box-class" value="<?php echo $value->addressline1; ?>" autocomplete="on">

                                </div>
                                <div class="col-sm-3 error-box" id="address_s"></div>

                            </div>


                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_STATE; ?></label>
                                <div class="col-sm-6">
                                    <input type="text" id="state_s" name="state" class="form-control error-box-class" value="<?php echo $value->state; ?>">

                                </div>

                            </div>

                           

                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_POSTCODE; ?></label>
                                <div class="col-sm-6">
                                    <input type="text" id="pcode_s" name="pincode" class="form-control error-box-class" onkeypress="return isNumberKey(event)" value="<?php echo $value->postcode; ?>">

                                </div>
                                <div class="col-sm-3 error-box" id="pcode_sErr"></div>
                            </div>


                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_FIRSTNAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text" id="fname_s" name="firstname" class="form-control error-box-class" value="<?php echo $value->firstname; ?>">

                                </div>
                                <div class="col-sm-3 error-box" id="fnamefirst"></div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_LASTNAME; ?></label>
                                <div class="col-sm-6">
                                    <input type="text" id="lname_S" name="lastname" class="form-control error-box-class" value="<?php echo $value->lastname; ?>">

                                </div>
                                <div class="col-sm-3 error-box" id="lnamefirst"></div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_MOBILE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text" id="mobile_s" name="mobilenumber" class="form-control error-box-class" onkeypress="return isNumberKeyedit(event)" value="<?php echo $value->mobile; ?>">

                                </div>
                                <div class="col-sm-3 error-box" id="mobilefirst"></div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_COMPANYLOGO; ?></label>
                                <div class="col-sm-6">

                                    <input type="file" class="form-control" style="height: 37px;" name="e_companylog" id="e_companylogo">
                                    <input type="hidden" class="form-control" style="height: 37px;" name="operatorImage" id="operatorImage">
                                </div>
                                <div class="col-sm-1"><img src="" style="width: 35px;height:35px;display:none;" class="companyLogoLink style_prevu_kit"></div>
                                <div class="col-sm-3 error-box" id="logo"></div><br>

                            </div>



                            <div class="pull-right m-t-10" style="margin-right:18.5%;"> <button class="btn btn-success btn-cons" id="updateCompnayDetials" type="button"><?php echo BUTTON_CHANGES_COMPANY; ?></button></div>
                            <div class="pull-right m-t-10"> <button button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo BUTTON_CANCEL; ?></button></div>

                        </div>
                    </div>
                </form>
            </div>


            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>


<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE&sensor=false&libraries=places"></script>
<script>
                                        var autocomplete = new google.maps.places.Autocomplete($("#addr_s")[0], {});

                                        google.maps.event.addListener(autocomplete, 'place_changed', function () {
                                            var place = autocomplete.getPlace();


                                            $("#city_s").val('');
                                            $("#state_s").val('');
                                            $("#pcode_s").val('');
                                            var address = document.getElementById('addr_s').value;
                                            console.log(address);
                                            $.ajax({
                                                url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + address + "&sensor=false",
                                                type: "POST",
                                                success: function (res) {

                                                    address = res.results[0].geometry.location.lat + ',' + res.results[0].geometry.location.lng;
                                                    geocoder = new google.maps.Geocoder();

                                                    geocoder.geocode({'address': address}, function (results, status) {
                                                        if (status == google.maps.GeocoderStatus.OK) {

                                                            for (var component in results[0]['address_components']) {
//                                           console.log(results[0]['address_components']);
                                                                for (var i in results[0]['address_components'][component]['types']) {
                                                                    if (results[0]['address_components'][component]['types'][i] == "locality") {
                                                                        city = results[0]['address_components'][component]['long_name'];
//                                               
                                                                        console.log(city);

                                                                        $("#city_s").find("option").each(function () {
                                                                            if ($(this).text() == city) {
                                                                                $(this).attr("selected", "selected");
                                                                            }
                                                                        });

                                                                    }


                                                                    if (results[0]['address_components'][component]['types'][i] == "administrative_area_level_1") {
                                                                        state = results[0]['address_components'][component]['long_name'];

                                                                        $('#state_s').val(state);

                                                                    }

                                                                    if (results[0]['address_components'][component]['types'][i] == "postal_code") {
                                                                        pcode = results[0]['address_components'][component]['long_name'];

                                                                        $('#pcode_s').val(pcode);

                                                                    }

                                                                }
                                                            }
                                                        } else {
                                                            alert('Invalid Zipcode');
                                                        }
                                                    });

                                                }

                                            });

                                        });
</script>

<script src="<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>                               
<script>
                                        var countryData = $.fn.intlTelInput.getCountryData();
                                        $.each(countryData, function (i, country) {

                                            country.name = country.name.replace(/.+\((.+)\)/, "$1");
                                        });
                                        $("#mobile_s").intlTelInput({
//       allowDropdown: false,
                                            autoHideDialCode: false,
                                            autoPlaceholder: "off",
                                            dropdownContainer: "body",
//       excludeCountries: ["us"],
                                            formatOnDisplay: false,
                                            geoIpLookup: function (callback) {
                                                $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                                                    var countryCode = (resp && resp.country) ? resp.country : "";
                                                    callback(countryCode);
                                                });
                                            },
                                            initialCountry: "auto",
                                            nationalMode: false,
//       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                                            placeholderNumberType: "MOBILE",
//       preferredCountries: ['srilanka'],
                                            separateDialCode: true,
                                            utilsScript: "<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/utils.js",
                                        });

</script>



