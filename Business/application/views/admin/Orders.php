<?PHP error_reporting(false);
?>
<style>
    .form-horizontal .form-group 
    {
        margin-left: 13px;
    }    
</style>

<script>
    $("#HeaderOrders").addClass("active");

    $(document).ready(function () {
        
        $('.Orders').addClass('active');
        
        $('#callM').click(function () {

            $('#NewCat').modal('show');
        });
        $('#CategoryId').val('<?PHP echo $ProductDetails['CategoryId']; ?>');
        var catid = '<?PHP echo $ProductDetails['CategoryId']; ?>';
        var SubCategoryId = '<?PHP echo $ProductDetails['SubCategoryId']; ?>';

        if (SubCategoryId != '') {

            $('#SubCategory').load('<?PHP echo AjaxUrl; ?>GetSubCatfromCat', {catId: catid, SubCat: SubCategoryId});
        }
        $('#CategoryId').change(function () {


            var catId = $("#CategoryId option:selected").attr('value');
//            alert(catId);
            $('#SubCategory').load('<?PHP echo AjaxUrl; ?>GetSubCatfromCat', {catId: catId});
        });


        var table = $('#tableWithSearch2');

        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "sPaginationType": "bootstrap",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 11
        };

        table.dataTable(settings);


        $('#search-table2').keyup(function () {
            table.fnFilter($(this).val());
        });

        var table = $('#tableWithSearch3');

        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "sPaginationType": "bootstrap",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 11
        };

        table.dataTable(settings);
        $('#search-table3').keyup(function () {
            table.fnFilter($(this).val());
        });


    });
    //submit form data from forth tab
    function submitform()
    {
        if (signatorytab('fourthlitab', 'tab4'))
        {
            $("#addentity").submit();
        }
    }

    //load mobile prefix as country code

    function fillcountrycode()
    {
        var country = $("#entitycountry").val();
        if (country !== "null")
        {
            var n = country.indexOf(",");
            $("#mobileprefix").val(country.substring((n + 1), country.length));
            $("#countrycode").val(country.substring((n + 1), country.length));
        }
    }

    //validations for each previous tab before proceeding to the next tab
    function managebuttonstate()
    {
        $("#prevbutton").addClass("hidden");
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
        var pstatus = true;

        if (isBlank($("#CategoryId").val()))
        {
            pstatus = false;
        }


        if (pstatus === false)
        {
            setTimeout(function ()
            {
                proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
            }, 300);
            alert("complete profile tab properly")
//            $("#tab1icon").removeClass("fs-14 fa fa-check");
            return false;
        }
//        alert();
//        $("#tab1icon").addClass("fs-14 fa fa-check");
        $("#prevbutton").removeClass("hidden");
        $("#nextbutton").removeClass("hidden");
        $("#finishbutton").addClass("hidden");
        return true;
    }

    function addresstab(litabtoremove, divtabtoremove)
    {
        var astatus = true;
        //alert(profiletab());
        if (profiletab(litabtoremove, divtabtoremove))
        {
            if (astatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'secondlitab', 'tab2');
                }, 100);
                alert("complete address tab properly")
//                $("#tab2icon").removeClass("fs-14 fa fa-check");
                return false;
            }
//            $("#tab2icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");
            return astatus;
        }
    }

    function bonafidetab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (addresstab(litabtoremove, divtabtoremove))
        {


            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'thirdlitab', 'tab3');
                }, 100);
                alert("complete bonafide tab properly");
//                $("#tab3icon").removeClass("fs-14 fa fa-check");
                return false;
            }

//            $("#tab3icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");
            return bstatus;
        }
    }

    function signatorytab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (bonafidetab(litabtoremove, divtabtoremove))
        {

            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'fourthlitab', 'tab4');
                }, 100);
                alert("complete signatory tab properly");
//                $("#tab4icon").removeClass("fs-14 fa fa-check");
                return false;
            }

//            $("#tab4icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");
            return bstatus;
        }

    }


    function proceed(litabtoremove, divtabtoremove, litabtoadd, divtabtoadd)
    {
        $("#" + litabtoremove).removeClass("active");
        $("#" + divtabtoremove).removeClass("active");
        $("#" + litabtoadd).addClass("active");
        $("#" + divtabtoadd).addClass("active");
    }

    /*-----managing direct click on tab is over -----*/

    //manage next next and finish button
    function movetonext()
    {
        var currenttabstatus = $("li.active").attr('id');
        if (currenttabstatus === "firstlitab")
        {
            profiletab('secondlitab', 'tab2');
            proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
        } else if (currenttabstatus === "secondlitab")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');
        } else if (currenttabstatus === "thirdlitab")
        {
            bonafidetab('fourthlitab', 'tab4');
            proceed('thirdlitab', 'tab3', 'fourthlitab', 'tab4');
            $("#finishbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");
        }
    }

    function movetoprevious()
    {
        var currenttabstatus = $("li.active").attr('id');
        if (currenttabstatus === "secondlitab")
        {
            profiletab('secondlitab', 'tab2');
            proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
            $("#prevbutton").addClass("hidden");
        } else if (currenttabstatus === "thirdlitab")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('thirdlitab', 'tab3', 'secondlitab', 'tab2');
        } else if (currenttabstatus === "fourthlitab")
        {
            bonafidetab('fourthlitab', 'tab4');
            proceed('fourthlitab', 'tab4', 'thirdlitab', 'tab3');
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");
        }
    }
    function DelRows(thisval) {
        $('#deletemodal').modal('show');
        var entityidid = thisval.id;
        $('.deletoption').val(entityidid);
    }

    function Delete() {
        var Delid = $('.deletoption').val();
        $('#Row' + Delid).remove();
        $('#deletemodal').modal('hide');
    }



</script>




<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="">
                   

                    <li>
                       <a href="<?php echo base_url() ?>index.php/Admin/Orders"> <strong style="color:#0090d9;">ORDERS</strong></a>
                    </li>


                </ul>
                <!-- END BREADCRUMB -->
            </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <li class="active" id="firstlitab" onclick="managebuttonstate()">
                            <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span>Processing</span></a>
                        </li>
                        <li class="" id="secondlitab">
                            <a data-toggle="tab" href="#tab2" onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>On the Way</span></a>
                        </li>


                    </ul>

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" >
                    <!-- Nav tabs 
                    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <li class="active" id="firstlitab" onclick="managebuttonstate()">
                            <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span>Processing</span></a>
                        </li>
                        <li class="" id="secondlitab">
                            <a data-toggle="tab" href="#tab2" onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>On the Way</span></a>
                        </li>


                    </ul> -->
                    <!-- Tab panes -->
                    <!--<form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php/Admin/AddnewProduct" method="post" enctype="multipart/form-data">-->
                        <input type='hidden' value='<?PHP echo $ProductId; ?>' name='ProductId'>
                        <input type='hidden' value='<?PHP echo $BizId; ?>' name='FData[BusinessId]'>
                        <div class="tab-content">
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">
                                    <div class="panel panel-transparent">
                                        <div class="panel-heading">
                                            <!--<button type="button" class="btn btn-default" id="callM">Add new</button>-->
                                            <div class="pull-right">
                                                <div class="col-xs-12" style="margin: 10px 0px;padding:0px;">
                                                    <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="panel-body">
                                            <?php 
//                                              foreach ($OrderList as $result) {
//                                                  print_r($result);
//                                              }
                                            ?>
                                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                                        <thead>
                                                            <tr role="row">
                                                            <tr role="row">
                                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Slno</th>
                                                               
                                                                <th  tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Order Id</th>
                                                                <th  tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Customer Name</th>
                                                                <th  tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Driver Name</th>
                                                                <th c tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Order Placed on</th>
                                                                <th  tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                                                    Total (<?PHP echo $this->session->userdata('badmin')['Currency']; ?>)</th>

                                                                <th tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                                    Option</th>
                                                            </tr>

                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $count = 1;

                                                            foreach ($OrderList as $result) {
                                                                if ($result['status'] == '2' || $result['status'] == '13') {
                                                                    ?>
                                                                    <tr role="row" class="odd">
                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <?php echo $count ?></td>
                                                                        <td id = "fname_" class="v-align-middle"> <?php echo $result["orderid"] ?></td>

                                                                        <td id = "fname_" class="v-align-middle"> <?php echo $result["cus_name"] ?></td>
                                                                        <td id = "fname_" class="v-align-middle"> <?php if(!$result["driv_name"])
                                                                                                                            echo 'N/A';
                                                                                                                        else {
                                                                                                                         echo $result["driv_name"];   
                                                                                                                        } ?></td>
                                                                        <td id = "fname_" class="v-align-middle"> <?php echo $result["date"] ?></td>
                                                                        <td id = "lname_" class="v-align-middle"> <?php echo $result["total"]; ?> </td>

                                                                        <td  class="v-align-middle">
                                                                            <div class="btn-group">
                                                                                <a href="<?php echo base_url() . 'index.php/Admin/OrderDetails/' . $result['orderid']; ?>"><button onclick="edit(this)" id="<?php echo $result['appointment_id'] ?>" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;" class="btn btn-success"><i class="fa fa-arrow-right"></i>
                                                                                    </button></a>

                                                                                                                                                                                                                                                    <!--                                                            <a><button type="button" onclick="Delservice(this)" id="<?php echo $result['_id'] ?>" class="btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>
                                                                                                                                                                                                                                                                                                                </button></a>-->

                                                                            </div>
                                                                        </td>

                                                                    </tr>
                                                                    <?php
                                                                    $count++;
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">
                                    <div class="panel panel-transparent">
                                        <div class="panel-heading">
                                            <!--<button type="button" class="btn btn-default" id="callM">Add new</button>-->
                                            <div class="pull-right">
                                                <div class="col-xs-12" style="margin: 10px 0px;padding:0px;">
                                                    <input type="text" id="search-table2" class="form-control pull-right" placeholder="Search">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="panel-body">
                                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="tableWithSearch2" role="grid" aria-describedby="tableWithSearch_info">
                                                        <thead>

                                                            <tr role="row">
                                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Slno</th>
                                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Order Id</th>
                                                                <th  tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Customer Name</th>
                                                                <th  tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Driver Name</th>
                                                                <th c tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                    Order Placed on</th>
                                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                                                    Total (<?PHP echo $this->session->userdata('badmin')['Currency']; ?>)</th>

                                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                                    Option</th>
                                                            </tr>

                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $count = 1;

                                                            foreach ($OrderList as $result) {
                                                                if ($result['status'] == '11') {
                                                                    ?>
                                                                    <tr role="row" class="odd">
                                                                        <td id = "d_no" class="v-align-middle sorting_1"> <?php echo $count ?></td>
                                                                        <td id = "fname_" class="v-align-middle"> <?php echo $result["orderid"] ?></td>

                                                                        <td id = "fname_" class="v-align-middle"> <?php echo $result["cus_name"] ?></td>
                                                                        <td id = "fname_" class="v-align-middle"> <?php echo $result["driv_name"] ?></td>
                                                                        <td id = "fname_" class="v-align-middle"> <?php echo $result["date"] ?></td>
                                                                        <td id = "lname_" class="v-align-middle"> <?php echo $result["total"]; ?> </td>

                                                                        <td  class="v-align-middle">
                                                                            <div class="btn-group">
                                                                                <a href="<?php echo base_url() . 'index.php/Admin/OrderDetails/' . $result['orderid']; ?>"><button onclick="edit(this)" id="<?php echo $result['appointment_id'] ?>" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;" class="btn btn-success"><i class="fa fa-arrow-right"></i>
                                                                                    </button></a>

                                                                                                                                                                                                                                                    <!--                                                            <a><button type="button" onclick="Delservice(this)" id="<?php echo $result['_id'] ?>" class="btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>
                                                                                                                                                                                                                                                                                                                </button></a>-->

                                                                            </div>
                                                                        </td>

                                                                    </tr>
                                                                    <?php
                                                                    $count++;
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <!--</form>-->
                </div>    

            </div>


        </div>
        <!-- END PANEL -->
    </div>

</div>



