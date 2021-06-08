<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);

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
    #companyid{
        display: none;
    }
     .pac-container {
    z-index: 1051 !important;
}

</style>

<script type="text/javascript">
        var currentTab = 1;
          var status = '<?php echo $status; ?>';
    $(document).ready(function () {
        

        var table = $('#big_table');

            $('.whenclicked li').click(function (){
            // alert($(this).attr('id'));

            if($(this).attr('id') == 1){
                $('#add').show();
                 $('#activate').show();
                 $('#deactivate').show();
                  $('#suspend').show();
            }
            else if($(this).attr('id') == 3){
                 $('#activate').hide();
                 $('#deactivate').show();
                  $('#suspend').show();
             }
             else if($(this).attr('id') == 5){
                 $('#deactivate').hide();
                  $('#activate').show();
                   $('#suspend').show();

                }else if($(this).attr('id') == 6){
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
        setTimeout(function() {
    
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_companys/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
             "columns": [
      null,
    null,
    { "width": "20%" },
    null,
    null,
    null,
    null,
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
        }, 1000);
        
        

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

    });
</script>

<script>

    $(document).ready(function () {
        $("#define_page").html("Companies");

        $('.company_s').addClass('active');
        $('.company_s').attr('src',"<?php echo base_url();?>/theme/icon/companies_on.png");
//        $('.company_sthumb').addClass("bg-success");


        $("#editcompany").click(function () {
            $('#companyID').val($('.checkbox:checked').val());

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_ANYONE); ?>);
            } else if (val.length > 1) {
                $("#displayData").modal("show");
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_ONLYONE); ?>);
            }
            else {
                
                 $.ajax({
                            type: 'POST',
                            url: "<?php echo base_url('index.php?/superadmin') ?>/getComapnyDetails",
                            data: {companyID: $('.checkbox:checked').val()},
                            dataType: 'JSON',
                            success: function (response)
                            {

                                console.log(response);
                                $.each(response.data,function(i,value)
                                {
                                    
                                      if(value.registered == 1)
                                           $('#unregistered1').prop("checked", true);
                                       else
                                           $('#registered1').prop("checked", true);
                                    $('#cname_S').val(value.companyname);
                                    $('#email_s').val(value.email);
                                    $('#addr_s').val(value.addressline1);
                                    $('#state_s').val(value.state);
                                    $('#city_s').val(value.city);
                                    $('#pcode_s').val(value.postcode);
                                    $('#fname_s').val(value.firstname);
                                    $('#lname_S').val(value.lastname);
                                    $('#mobile_s').val(value.mobile);
                                    
                                    if(value.logo != '')
                                    {
                                        $('.companyLogoLink').attr('href','<?php echo base_url('../../pics')?>/'+value.logo);
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

            var city = $("#city_s").val();
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
               
            }
            else if (!re.test(cname))
            {
                $("#companyname_s").text(<?php echo json_encode(POPUP_COMPANY_NAMEVALID); ?>);
                return false;
              
            }
            else if (uemail == "" || uemail == null)
            {
//              
                $("#email_ss").text(<?php echo json_encode(POPUP_COMPANY_EMAIL); ?>);
                return false;
              
            }
            else if (addr == "" || addr == null)
            {
//           
                $("#address_s").text(<?php echo json_encode(POPUP_COMPANY_ADDRESS); ?>);
                return false;
            }
              if (fname == "" || fname == null)
            {
                $('#fnamefirst').text(<?php echo json_encode(POPUP_COMPANY_SELECT_FIRSTNAME); ?>);
                return false;
                
            }

            else if (mobile == "" || mobile == null)
            {
                $('#mobilefirst').text(<?php echo json_encode(POPUP_COMPANY_SELECT_MOBILE); ?>);
                return false;
               
            }
            else if (!phone.test(mobile))
            {
                $('#mobilefirst').text(<?php echo json_encode(POPUP_MOBILE_VALIDATION_ERROR); ?>);
                return false;
                
            }

            else if (city == "0")
            {
//                alert("select the city");
                $("#cities_s").text(<?php echo json_encode(POPUP_DISPATCHERS_CITY); ?>);
                return false;
                
            }
            else
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_companys/' + currentTab,
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

            if (val.length == 0) {
                $("#displayData").modal("show");
                //        alert("please select atleast one company");
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_ATLEASTONENAME); ?>);
            }
            else if (val.length > 0)
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
                        data: {val: val},
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
                $("#displayData").modal("show");
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_ATLEASTONENAME); ?>);
            }
            else if (val.length > 0) {

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
         alert();
                     var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deactivatecompany",
                        type: 'POST',
                        data: {val: val},
                        dataType: 'JSON',
                        success: function (response)
                        {

                                $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });
                             $(".close").trigger("click");
                        }

                    });


                });


        $("#delete").click(function () {
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $("#displayData").modal("show");
                //         alert("please select atleast one company");
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_ATLEASTONENAME); ?>);
            }
            else if (val.length >= 1)
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
                        data: {val: val},
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

        if(tab_bar != 1)
            $('#add').hide();
       
        if(tab_bar != currentTab)
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

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });
            }

        });
        




    });


    function refreshTableOnActualcitychagne(){

        var table = $('#big_table');

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
                //oTable.fnAdjustColumnSizing();

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

        // search box for table
        $('#search-table').keyup(function () {

            table.fnFilter($(this).val());
        });
    }










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
           <!--                    <img src="--><?php //echo base_url();            ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();            ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();            ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">OPERATORS</strong><!-- id="define_page"-->
        </div>
         <!-- Nav tabs -->

              <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">


                    <li id="1" class="tabs_active  <?php echo ($status == 1 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                        <a class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_companys/1" data-id="1"><span><?php echo LIST_NEW; ?></span></a>
                    </li>
                    <li id="3" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>" style="cursor:pointer;text-transform:uppercase;">
                        <a  class="changeMode"   data="<?php echo base_url(); ?>index.php?/superadmin/datatable_companys/3" data-id="2"><span><?php echo LIST_ACCEPTED; ?> </span></a>
                    </li>
                    <li id="5" class="tabs_active <?php echo ($status == 5 ? "active" : "") ?>" style="cursor:pointer;text-transform:uppercase;">
                        <a  class="changeMode"   data="<?php echo base_url(); ?>index.php?/superadmin/datatable_companys/5" data-id="3"><span><?php echo LIST_REJECTED; ?></span></a>
                    </li>
                   <!-- <li id="6" class="tabs_active <?php echo ($status == 6 ? "active" : "") ?>">
                        <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_companys/6"><span><?php echo LIST_SUSPENDED; ?></span></a>
                    </li> -->


                    <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="delete"><?php echo BUTTON_DELETE; ?></button></div>


                        <!--<div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons action_buttons" id="suspend"><?php echo BUTTON_SUSPEND; ?></button></div>-->

                    <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="editcompany"><?php echo BUTTON_EDIT; ?></button></div>


                        <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons action_buttons" id="deactivate"><?php echo BUTTON_REJECT; ?></button></div>

                        <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons action_buttons" id="activate" ><?php echo BUTTON_ACTIVATE; ?></button></div>


                        <div id="add" class="pull-right m-t-10"><a href="<?php echo base_url() ?>index.php?/superadmin/add_edit/add"> <button class="btn btn-primary btn-cons" ><?php echo BUTTON_ADD; ?></button></a></div>



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
                    <input type="hidden" id="companyID" name="companyID">
                    <div class="tab-pane slide-left padding-20 <?php echo $activetab2 ?>" id="tab3">
                                <div class="row row-same-height">
                                    
                                    <div class="form-group" class="formexx">
                                        <label for="address" class="col-sm-2 control-label">Operator Type<span style="" class="MandatoryMarker"> *</span></label>
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

                                            <label for="address" class="col-sm-2 control-label"><?php echo FIELD_COMPANY_CITY; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <select id="city_s" name="cityname"  class="form-control error-box-class col-sm-6" >
                                                            <option value="0">Select</option>

                                                    <?php
                                                    foreach ($city as $result) {

                                                        $selected = "";
                                                        if ($result->City_Id == $value->city)
                                                            $selected = "selected";

                                                        echo "<option value='" . $result->City_Id . "'" . $selected . ">" . ucfirst(strtolower($result->City_Name)) . "</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-sm-3 error-box" id="cities_s"></div>

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
                                        </div>
                                        
                                        <div class="col-sm-4 error-box" id="logo"></div><br>
                                   
                                        <a style="color:dodgerblue;display:none;" class="companyLogoLink" target="_blank" href="">view</a> 

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


   <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE&sensor=false&libraries=places"></script>
     <script>
                                            var autocomplete = new google.maps.places.Autocomplete($("#addr_s")[0], {});

                                            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                                                var place = autocomplete.getPlace();
                                                
                                                
            $("#city_s").val('');
             $("#state_s").val('');
             $("#pcode_s").val('');
             var address = document.getElementById('addr_s').value;
              console.log(address);
            $.ajax({
              url:"http://maps.googleapis.com/maps/api/geocode/json?address="+address+"&sensor=false",
              type: "POST",
              success:function(res){
                  
                        address = res.results[0].geometry.location.lat+','+res.results[0].geometry.location.lng;
                        geocoder = new google.maps.Geocoder();

                        geocoder.geocode({ 'address': address }, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {                       

                                for (var component in results[0]['address_components']) {
//                                           console.log(results[0]['address_components']);
                                    for (var i in results[0]['address_components'][component]['types']) {
                                            if (results[0]['address_components'][component]['types'][i] == "locality") {
                                                    city = results[0]['address_components'][component]['long_name'];
//                                               
                                                     console.log(city);
                                                     
                                                    $("#city_s").find("option").each(function(){
                                                        if( $(this).text() == city ) {
                                                           $(this).attr("selected","selected");
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



