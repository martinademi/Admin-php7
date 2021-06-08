<?PHP error_reporting(false); ?>
<style>
    .form-horizontal .form-group 
    {
        margin-left: 13px;
    }    
</style>




<script>
    $(document).ready(function () {
        $('#callM').click(function () {

            $('#NewCat').modal('show');
        });

        $('#CategoryId').change(function () {

            var catId = $("#CategoryId option:selected").attr('value');
//            alert(catId);
            $('#SubCategory').load('<?PHP echo AjaxUrl; ?>GetSubCatfromCat', {catId: catId});
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
        if ((isBlank($("#entityname").val())))
        {
            pstatus = false;
        }

        if (isBlank($("#entityemail").val()))
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
            $("#tab1icon").removeClass("fs-14 fa fa-check");
            return false;
        }
//        alert();
        $("#tab1icon").addClass("fs-14 fa fa-check");
        $("#prevbutton").removeClass("hidden");
        $("#nextbutton").addClass("hidden");
        $("#finishbutton").removeClass("hidden");
        return true;
    }

    function addresstab(litabtoremove, divtabtoremove)
    {
        var astatus = true;
        //alert(profiletab());
        if (profiletab(litabtoremove, divtabtoremove))
        {
//            if ($("#entitytown").val() === "null")
//            {
//                astatus = false;
//            }
//
//            if (isBlank($("#entitypobox").val()) || isBlank($("#entityzipcode").val()))
//            {
//                astatus = false;
//            }

            if (astatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'secondlitab', 'tab2');

                }, 100);

                alert("complete address tab properly")
                $("#tab2icon").removeClass("fs-14 fa fa-check");
                return false;
            }
            $("#tab2icon").addClass("fs-14 fa fa-check");
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
//            if (isBlank($("#entitydocname").val()) || isBlank($("#entitydocfile").val()) || isBlank($("#entityexpirydate").val()))
//            {
//                bstatus = false;
//            }

            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'thirdlitab', 'tab3');

                }, 100);

                alert("complete bonafide tab properly");
                $("#tab3icon").removeClass("fs-14 fa fa-check");
                return false;
            }

            $("#tab3icon").addClass("fs-14 fa fa-check");
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
//            if (isBlank($("#entitypersonname").val()) || isBlank($("#entitysignatorymobileno").val()) || isBlank($("#entitysignatoryfile").val()) || $("#entitydegination").val() === "null")
//            {
//                bstatus = false;
//            }
//
//            if (validateEmail($("#entitysignatoryemail").val()) !== 2)
//            {
//                bstatus = false;
//            }

            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'fourthlitab', 'tab4');

                }, 100);

                alert("complete signatory tab properly");
                $("#tab4icon").removeClass("fs-14 fa fa-check");
                return false;
            }

            $("#tab4icon").addClass("fs-14 fa fa-check");
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
        }
        else if (currenttabstatus === "secondlitab")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');
        }
        else if (currenttabstatus === "thirdlitab")
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
        }
        else if (currenttabstatus === "thirdlitab")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('thirdlitab', 'tab3', 'secondlitab', 'tab2');
        }
        else if (currenttabstatus === "fourthlitab")
        {
            bonafidetab('fourthlitab', 'tab4');
            proceed('fourthlitab', 'tab4', 'thirdlitab', 'tab3');
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");
        }
    }

</script>




<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="margin-left: 20px;">
                    <li>
                        <a href="<?php echo base_url() ?>index.php/Admin/loadDashbord">Dashboard</a>
                    </li>
                    <li style="width: 100px"><a href="#" class="active">My Profile</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>



            <div class="container-fluid container-fixed-lg bg-white">

                <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php/Admin/AddnewAddOnCategory" method="post" enctype="multipart/form-data">
                    <input type='hidden' name='FData[BusinessId]' value='<?PHP echo $BizId; ?>'> 
                    <div class="tab-content">

                        <div class="row row-same-height">


                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Business Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityname" value='<?PHP echo $ProfileData['ProviderName']; ?>' placeholder="Business Name" name="FData[ProviderName]"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityemail" value='<?PHP echo $ProfileData['Email']; ?>' placeholder="Description" name="FData[Email]"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Owner Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityemail" value='<?PHP echo $ProfileData['OwnerName']; ?>' placeholder="Owner Name" name="FData[OwnerName]"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Web-Site</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityemail" value='<?PHP echo $ProfileData['Website']; ?>' placeholder="Web-Site" name="FData[Website]"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-6">
                                    <!--<input type="text" class="form-control" id="entityemail" placeholder="Description" name="FData[Description]"  aria-required="true">-->
                                    <textarea class="form-control" id="entityemail" placeholder="Description" name="FData[Description]"  aria-required="true"><?PHP echo $ProfileData['Description']; ?></textarea>
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Country</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityemail" placeholder="Description" name="FData[Description]"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">City</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityemail" placeholder="Description" name="FData[Description]"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Postal Code</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityemail" value='<?PHP echo $ProfileData['PostalCode']; ?>' placeholder="Postal Code" name="FData[PostalCode]"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Latitude</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityemail" value='<?PHP echo $ProfileData['Latitude']; ?>' placeholder="Latitude" name="FData[Latitude]"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Longitude</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityemail" value='<?PHP echo $ProfileData['Longitude']; ?>' placeholder="Longitude" name="FData[Longitude]"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>


                        </div>

                        <!--                            <div class="tab-pane slide-left padding-20" id="tab2">
                                                        <div class="row row-same-height">
                                                            <button type="button" class="btn btn-default" id="callM">Add new</button>
                                                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover demo-table-search dataTable no-footer" id="PortionTable" role="grid" aria-describedby="tableWithSearch_info">
                                                                        <thead>
                                                                            <tr role="row">
                                                                            <tr role="row">
                        
                                                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                                    Title</th>
                                                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                                                    Price</th>
                        
                                                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                                                    Option</th>
                                                                            </tr>
                        
                                                                        </thead>
                                                                        <tbody>
                        <?PHP
                        ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>-->



                        <!--                            <div class="padding-20 bg-white">
                                                        <ul class="pager wizard">
                                                            <li class="next" id="nextbutton">
                                                                <button class="btn btn-primary btn-cons btn-animated from-left  pull-right" type="button" onclick="movetonext()">
                                                                    <span>Next</span>
                                                                </button>
                                                            </li>
                                                            <li class="hidden" id="finishbutton">
                                                                <button class="btn btn-primary btn-cons btn-animated from-left fa fa-cog pull-right" type="button" onclick="submitform()">
                                                                    <span>Finish</span>
                                                                </button>
                                                            </li>
                        
                                                            <li class="previous hidden" id="prevbutton">
                                                                <button class="btn btn-default btn-cons pull-right" type="button" onclick="movetoprevious()">
                                                                    <span>Previous</span>
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>-->


                </form>

            </div>


        </div>
        <!-- END PANEL -->
    </div>

</div>
<!-- END JUMBOTRON -->

<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg">
    <!-- BEGIN PlACE PAGE CONTENT HERE -->

    <!-- END PLACE PAGE CONTENT HERE -->
</div>
<!-- END CONTAINER FLUID -->


<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset">
            <span class="hint-text">Copyright © 2014</span>
            <span class="font-montserrat">REVOX</span>.
            <span class="hint-text">All rights reserved.</span>
            <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
            </span>
        </p>
        <p class="small no-margin pull-right sm-pull-reset">
            <a href="#">Hand-crafted</a>
            <span class="hint-text">&amp; Made with Love ®</span>
        </p>
        <div class="clearfix"></div>
    </div>
</div>
<!-- END FOOTER -->
<?PHP
$con = new Mongo();
?>
<script>
    var count = 0;
    function AddPortion()
    {
        var id = '<?PHP
$id = new MongoId();
echo $id;
?>';
        var title = $('#Title').val();
        var price = $('#Price').val();
//        alert(id);
        $('#PortionTable').append('<tr>' +
                '<td> <p>' + title + '</p></td>' +
                '<td> <p>' + price + '</p></td>' +
                '<input type="hidden" name="FData[AddOns][' + count + '][title]" value="' + title + '">' +
                '<input type="hidden" name="FData[AddOns][' + count + '][price]" value="' + price + '">' +
                '<input type="hidden" name="FData[AddOns][' + count + '][id]" value="' + id + '">' +
                ' <td  class="v-align-middle">' +
                ' <div class="btn-group">' +
                '<a href=""><button onclick="edit(this)" id="" type="button" style="color: #ffffff !important;background-color: #10cfbd;" class="btn btn-success"><i class="fa fa-pencil"></i>' +
                '  </button></a>' +
                '  <a><button type="button" onclick="Delservice(this)" id="" class="btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>' +
                '   </button></a>' +
                ' </div>' +
                '</td></tr>');
//        $('#PortionTable').append('<tr>' +
//                '<td> <p>hi</p></td>' +
//                '<td> <p>hello</p></td>' +
//                ' <td  class="v-align-middle">options</td></tr>');
        $('#NewCat').modal('hide');
        count++;
    }
</script>

<div class="modal fade in" id="NewCat" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog">

        <form action = "<?php echo base_url(); ?>index.php/Admin/AddNewSubCategory" method= "post" onsubmit="return validateForm();">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add New AddOn</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group" >
                        <label>Title</label>
                        <input type="text" class="form-control" placeholder="Title" id="Title" name="Title">
                    </div>
                    <div class="form-group" >
                        <label>Price</label>
                        <input type="text" class="form-control" placeholder="Price" id="Price" name="Price">
                    </div>


                    <label id = "errorbox" style="color: red; font-size: 15px;"></label>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="button" class="btn btn-primary" value="Add" onclick="AddPortion();">

                </div>
            </div>
        </form>


    </div>

</div>
