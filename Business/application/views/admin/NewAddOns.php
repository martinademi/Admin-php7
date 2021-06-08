<?PHP error_reporting(false); ?>
<style>
    .form-horizontal .form-group 
    {
        margin-left: 13px;
    }    
</style>

<script>
    $("#HeaderMenu").addClass("active");
    $("#HeaderMenu3").addClass("active");
    $(document).ready(function () {
        $('#callM').click(function () {
             $("#add-portion").hide();
            $('#EditporId').val("");
            $('.Title').val("");
            $('#Price').val("");
            $('.modal-header').html('<h4>Add New Addones</h4>');
            $('#NewCat').modal('show');
        });

        $('#CategoryId').change(function () {

            var catId = $("#CategoryId option:selected").attr('value');
//            alert(catId);
            $('#SubCategory').load('<?PHP echo AjaxUrl; ?>GetSubCatfromCat', {catId: catId});
        });

    });

    function editMe(data) {

        var id = data.value;

//        var porTit = $('#porTit' + id).val();
        var porPric = $('#porprice' + id).val();

        $('.porTit' + id).each(function () {
            var lan_id = $(this).attr('data-id');
            $('#Title_' + lan_id).val($(this).val());
        });
        console.log(id);
//        console.log(porTit);
//        console.log(porPric);
//        
//        $('.Title').val(porTit);
        $('#Price').val(porPric);
        $('#EditporId').val(id);

        $('.modal-header').html('<h4>Edit New AddOne</h4>');
        $('#NewCat').modal('show');
    }

    //submit form data from forth tab
    function submitform()
    {
        var astatus = true;
        var totl = $('#PortionTable tr').length;
        if (totl == 1) {
             $("#add-portion").show();
            astatus = false;
        }else{                
            $("#add-portion").hide();            
        }
        if (astatus === false)
        {
            setTimeout(function ()
            {
                proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');

            }, 100);

            // alert("Add One Add-on")
            $("#tab2icon").removeClass("fs-14 fa fa-check");
            return false;
        } else {
            if (signatorytab('fourthlitab', 'tab4'))
            {
                $("#addentity").submit();
            }
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
        $("#tb1").attr('data-toggle','tab');
        $("#tb1").attr('href','#tab1');
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
        var pstatus = true;
        $(".error-box").hide("");
        var cat = $('.Category').val();
        var cat1 = $('.Category1').val();
        if (cat == '' || cat == null)
        {
            pstatus = false;
             $("#category_err").show();
        }
//        else if(cat1 == '' || cat1 == null){
//            pstatus = false;
//             $("#category1_err").show();
//        }
//        if (isBlank($("#entityemail").val()))
//        {
//            pstatus = false;
//        }

        if (pstatus === false)
        {
            $("#tb1").removeAttr('data-toggle');
            $("#mtab2").removeAttr('data-toggle');
            $("#tb1").removeAttr('href');
            $("#mtab2").removeAttr('href');
            setTimeout(function ()
            {
                proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
            }, 300);

            // alert("Mandatory Fields Missing")
            $("#tab1icon").removeClass("fs-14 fa fa-check");
            return false;
        }else{
            $("#mtab2").attr('data-toggle','tab');
            $("#mtab2").attr('href','#tab2');
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

            var totl = $('#PortionTable tr').length;

            if (totl == 1) {
                astatus = false;
            }


            if (astatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'secondlitab', 'tab2');

                }, 100);

                alert("Mandatory Fields Missing")
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

                alert("Mandatory Fields Missing");
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

                alert("Mandatory Fields Missing");
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
//        alert();

//        var currenttabstatus = $("#firstlitab").attr('class');
//        alert();
        if ($("#firstlitab").attr('class') === "active")
        {
            profiletab('secondlitab', 'tab2');
           var cat = $('.Category').val();
          var cat1 = $('.Category1').val();
            if(cat || cat1) {
                proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
            } 
        } else if ($("#secondlitab").attr('class') === "active")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');
        }

    }

    function movetoprevious()
    {
//        var currenttabstatus = $("li.active").attr('id');
        if ($("#secondlitab").attr('class') === "active")
        {
//            alert();
            profiletab('secondlitab', 'tab2');
            proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
            $("#prevbutton").addClass("hidden");
            $("#finishbutton").addClass("hidden");
            $("#nextbutton").removeClass("hidden");
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
                        <a class="active" href="#">MENU</a>
                    </li>

                    <li><a class="active" href="<?php echo base_url() ?>index.php/Admin/AddOns">ADD-ONS</a>
                    </li>
                    <?php if ($AddonDetails['_id']) { ?>
                        <li style=""><a href="#" class="active">EDIT ADDON</a>
                        </li>
                    <?php } else { ?>
                        <li style=""><a href="#" class="active">ADD ADDON</a>
                        </li>
                    <?php } ?>
                </ul>
                <!-- END BREADCRUMB -->
            </div>
             <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                    <li class="active" id="firstlitab" onclick="managebuttonstate()">
                        <a id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
                    </li>
                    <li class="" id="secondlitab">
                        <a onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>AddOns</span></a>
                    </li>

                </ul>

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs -->
                    <!--<ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <li class="active" id="firstlitab" onclick="managebuttonstate()">
                            <a id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
                        </li>
                        <li class="" id="secondlitab">
                            <a onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>AddOns</span></a>
                        </li>

                    </ul>-->
                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php/Admin/AddnewAddOnCategory" method="post" enctype="multipart/form-data">
                        <input type='hidden' name='FData[BusinessId]' value='<?PHP echo $BizId; ?>'> 
                        <input type='hidden' id="addonid" name='AddOnId' value='<?PHP echo $AddOnId; ?>'> 
                        <div class="tab-content">
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">

                                    <?php // print_r($AddonDetails); ?>

                                    <div id="Category_txt">
                                        <div class="form-group ">
                                            <label for="fname" class="col-sm-3  control-label"> Category Name (English) <span style="color:red;font-size: 18px">*</span></label>
                                            <div class="col-sm-6" style="margin-top:10px;">  
                                                <input type="text"   id="entityname_0" name="FData[Category][0]" value="<?PHP echo $AddonDetails['Category'][0] ?>" class=" Category form-control error-box-class" >
                                            </div>
                                            <div class="col-sm-offset-3 col-sm-6 error-box" id="category_err" style="display:none;">Enter the category name</div>
                                        </div>

                                        <?php
                                        foreach ($language as $val) {
//                                         print_r($val);
                                            ?>
                                            <div class="form-group" >
                                                <label for="fname" class="col-sm-3   control-label"> Category Name (<?php echo $val['lan_name']; ?>) <span style="color:red;font-size: 18px">*</span></label>
                                                <div class="col-sm-6">

                                                    <input type="text"  id="entityname_<?= $val['lan_id'] ?>" name="FData[Category][<?= $val['lan_id'] ?>]" value="<?PHP echo $AddonDetails['Category'][$val['lan_id']] ?>" class=" Category1 form-control error-box-class" >
                                                </div>
                                                <div class="col-sm-offset-3 col-sm-6 error-box" id="category1_err" style="display:none;">Enter the category name</div>
                                            </div>

                                        <?php } ?>

                                    </div>

                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label">Category Name</label>
                                                                            <div class="col-sm-6">
                                                                                <input type="text" class="form-control" id="entityname" placeholder="Category" name="FData[Category]" value="<?PHP echo $AddonDetails['Category'] ?>"  aria-required="true">
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <span style="color: red; font-size: 20px">*</span>
                                                                            </div>
                                                                        </div>-->

                                    <div id="Description_txt">
                                        <div class="form-group ">
                                            <label for="fname" class="col-sm-3 control-label"> Description (English) </label>
                                            <div class="col-sm-6">  
                                                <textarea type="text"   id="Description_0" placeholder="Description" name="FData[Description][0]"  class=" Description form-control error-box-class" ><?PHP echo $AddonDetails['Description'][0] ?></textarea>
                                            </div>
                                        </div>

                                        <?php
                                        foreach ($language as $val) {
//                                         print_r($val);
                                            ?>
                                            <div class="form-group" >
                                                <label for="fname" class="col-sm-3 control-label"> Description (<?php echo $val['lan_name']; ?>) </label>
                                                <div class="col-sm-6">
                                                    <textarea type="text"  id="Description_<?= $val['lan_id'] ?>" placeholder="Description" name="FData[Description][<?= $val['lan_id'] ?>]"  class=" Description form-control error-box-class" ><?PHP echo $AddonDetails['Description'][$val['lan_id']] ?></textarea>

                                                </div>
                                            </div>

                                        <?php } ?>



                                    </div>

                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label">Description</label>
                                                                            <div class="col-sm-6">
                                                                                <textarea type="text" class="form-control" id="description" placeholder="Description" name="FData[Description]" value="<?PHP echo $AddonDetails['Description'] ?>"  aria-required="true"><?PHP echo $AddonDetails['Description'] ?></textarea>
                                                                            </div>
                                    
                                                                        </div>-->
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Mandatory</label>
                                        <div class="col-sm-6">
                                            <?PHP
                                            if ($AddonDetails['Mandatory'] == '1') {
                                                echo ' <input type="checkbox" name="FData[Mandatory]" value="1" checked>';
                                            } else {
                                                echo ' <input type="checkbox" name="FData[Mandatory]" value="1">';
                                            }
                                            ?>


                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label">Multiple</label>
                                        <div class="col-sm-6">
                                            <?PHP
                                            if ($AddonDetails['Multiple'] == '1') {
                                                echo ' <input type="checkbox" name="FData[Multiple]" value="1" checked>';
                                            } else {
                                                echo ' <input type="checkbox" name="FData[Multiple]" value="1">';
                                            }
                                            ?>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">
                                    <button type="button" class="buttonAdd btn btn-success pull-right" id="callM" style="margin:1% 0%;">Add new</button>
                                    <h5 class="error-box pull-right" style="display:none;font-size: 18px !important;margin-top: 1.5%;" id="add-portion">Add Portion</h5>
                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="PortionTable" role="grid" aria-describedby="tableWithSearch_info">
                                                <thead>

                                                    <tr role="row">

                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                            Title</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                            Price(<?PHP echo $this->session->userdata('badmin')['Currency']; ?>)</th>

                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                            Option</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <?PHP
                                                    $Poid = 0;
                                                    if (is_array($AddonDetails['AddOns'])) {

                                                        foreach ($AddonDetails['AddOns'] as $AddOn) {
                                                            ?>
                                                            <tr id='Row<?PHP echo $Poid; ?>'>
                                                                <td> <label id="LabelTit<?PHP echo $Poid; ?>"><?PHP echo implode($AddOn['title'], ','); ?></label></td>
                                                                <td> <label id="LabelPric<?PHP echo $Poid; ?>"><?PHP echo $AddOn['price']; ?></label></td>
                                                                <?php
                                                                foreach ($AddOn['title'] as $key => $value) {
                                                                    ?>
                                                            <input id="porTit<?= $key ?>" class="porTit<?PHP echo $Poid; ?>" data-id="<?= $key ?>" type="hidden" name="FData[AddOns][<?PHP echo $Poid; ?>][title][<?= $key ?>]" value="<?PHP echo $value; ?>">
                                                            <!--<input id="porTit<?= $key ?>" class="porTit<?PHP echo $Poid; ?>" data-id="<?= $key ?>" type="hidden" name="FData[AddOns][<?PHP echo $Poid; ?>][title][<?= $key ?>]" value="<?PHP echo $value; ?>">-->
                                                            <?php
                                                        }
                                                        ?>

                                                        <input  id="porprice<?PHP echo $Poid; ?>" type="hidden" name="FData[AddOns][<?PHP echo $Poid; ?>][price]" value="<?PHP echo $AddOn['price']; ?>">
                                                        <input id="porId<?PHP echo $Poid; ?>" type="hidden" name="FData[AddOns][<?PHP echo $Poid; ?>][id]" value="<?PHP echo $AddOn['id']; ?>">

                                                        <td  class="v-align-middle">
                                                            <div class="btn-group">
                                                                <a><button onclick="editMe(this)"  value="<?PHP echo $Poid; ?>"  type="button" style="color: #ffffff !important;background-color: #10cfbd;" class="buttonEdit btn btn-success"><i class="fa fa-pencil"></i>
                                                                    </button></a>
                                                                <a><button type="button" onclick="DelRows(this)" id="<?PHP echo $Poid; ?>" class="buttonDeletee btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>
                                                                    </button></a>
                                                            </div>
                                                        </td></tr>
                                                        <?PHP
                                                        $Poid++;
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="padding-20 bg-white">
                                <ul class="pager wizard">
                                    <li class="next" id="nextbutton">
                                        <button class="btn btn-primary btn-cons pull-right" type="button" onclick="movetonext()">
                                            <span>Next</span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-primary btn-cons pull-right" type="button" onclick="submitform()">
                                            <span>Finish</span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-default btn-cons pull-right" type="button" onclick="movetoprevious()">
                                            <span>Previous</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>               
                    </form>

                </div>


            </div>
            <!-- END PANEL -->
        </div>

    </div>
    <!-- END JUMBOTRON -->

</div>
<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
    <?PHP include 'FooterPage.php' ?>
</div>
<!-- END FOOTER -->
<?PHP
$con = new Mongo();
?>
<script>
    var count = 0;
    function AddPortion()
    {
        var title = new Array();
//        if($(".Title").val()!='')
        $(".Title").each(function () {
            if($(this).val())
              title.push($(this).val());
        });

//        var title = $('.Title').val();
        var price = $('#Price').val();
        console.log(title.length);
//        console.log(price);
        <?php foreach ($language as $val){} ?>
            var num = '<?php echo $val['lan_id']?>';
        if (title.length <= num) {
            alert('title Mandatory.');
            return false;
        }
//        else if (price == '') {
//            alert('price Mandatory.');
//            return false;
//        }
        if ($('#EditporId').val() != '') {
            $('.porTit' + $('#EditporId').val()).remove();
            $(".Title").each(function () {
//                console.log($(this).val());
                var lan_id = $(this).attr('id').split("_");
//                $('#Row'+$('#EditporId').val()).find('#porTit' + lan_id).val($(this).val());
            });
            var html = '';
            $(".Title").each(function () {
                var lan_id = $(this).attr('id').split("_");
                html += '<input id="porTit' + $('#EditporId').val() + '"  class="porTit' + $('#EditporId').val() + '" data-id="' + lan_id + '" type="hidden" name="FData[AddOns][' + $('#EditporId').val() + '][title][]" value="' + $(this).val() + '">'
            });
            $('#Row'+$('#EditporId').val()).append(html);
            $('#porprice' + $('#EditporId').val()).val(price);
            $('#LabelTit' + $('#EditporId').val()).text(title);
            $('#LabelPric' + $('#EditporId').val()).text(price);


        } else {
            var id = Math.floor((Math.random() * 10000) + 1);

            var totl = '<?PHP echo $Poid; ?>';
            if (count > totl) {

            } else {
                count = totl;
            }
            var html = '';
            $(".Title").each(function () {
                var lan_id = $(this).attr('id').split("_");
                html += '<input id="porTit' + count + '" class="porTit' + count + '" data-id="' + lan_id + '" type="hidden" name="FData[AddOns][' + count + '][title][]" value="' + $(this).val() + '">'
            });
            $('#PortionTable').append('<tr id="Row' + count + '">' +
                    '<td> <label id="LabelTit' + count + '">' + title + '</label></td>' +
                    '<td> <label id="LabelPric' + count + '">' + price + '</label></td>' +
                    html +
                    '<input id="porprice' + count + '" type="hidden" name="FData[AddOns][' + count + '][price]" value="' + price + '">' +
                    '<input id="porId' + count + '" type="hidden" name="FData[AddOns][' + count + '][id]" value="' + id + '">' +
                    ' <td  class="v-align-middle">' +
                    ' <div class="btn-group">' +
                    '<a><button onclick="editMe(this);" value="' + count + '" type="button" style="color: #ffffff !important;background-color: #10cfbd;" class="buttonEdit btn btn-success"><i class="fa fa-pencil"></i>' +
                    '  </button></a>' +
                    '  <a><button type="button" onclick="DelRows(this)" id="' + count + '" class="buttonDeletee btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>' +
                    '   </button></a>' +
                    ' </div>' +
                    '</td></tr>');
            count++;

        }
        $('#NewCat').modal('hide');

    }

    function validate(key) {
        //getting key code of pressed key
        var keycode = (key.which) ? key.which : key.keyCode;
        // var tex = document.getElementById('TextBox2');
        //comparing pressed keycodes
        if (!(keycode == 8 || keycode == 46) && (keycode < 48 || keycode > 57)) {
            return false;
        } else {

        }
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

                    <div id="Category_txt">
                        <div class="form-group ">
                            <label for="fname" class=" control-label"> Title (English) <span style="color:red;font-size: 18px">*</span></label>
                            <!--<div class="col-sm-6">-->  
                            <input type="text"   id="Title_0" name="Title[0]"  class=" Title form-control error-box-class" >
                            <!--</div>-->
                        </div>

                        <?php
                        foreach ($language as $val) {
//                                         print_r($val);
                            ?>
                            <div class="form-group" >
                                <label for="fname" class="  control-label"> Title (<?php echo $val['lan_name']; ?>) <span style="color:red;font-size: 18px">*</span></label>

                                <input type="text"  id="Title_<?= $val['lan_id'] ?>" name="Title[<?= $val['lan_id'] ?>]"  class=" Title form-control error-box-class" >
                                <!--</div>-->
                            </div>

                        <?php } ?>

                    </div>

                    <!--                    <div class="form-group" >
                                            <label>Title</label>
                                            <input type="text" class="form-control" placeholder="Title" id="Title" name="Title">
                                        </div>-->
                    <div class="form-group" >
                        <label>Price</label>
                        <div class="input-group transparent">
                            <span class="input-group-addon">
                                <i><?PHP echo $this->session->userdata('badmin')['Currency']; ?></i>
                            </span>
                            <input type="text" class="form-control" onkeypress="return validate(event)" placeholder="Price" id="Price" name="Price">
                        </div>
                        <!--<input type="text" class="form-control" placeholder="Price" id="Price" name="Price">-->
                    </div>
                    <input id="EditporId" type="hidden" value="">

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
<div class="modal fade stick-up in" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Are You Sure To Delete This Add-On ? </h5>
                </div>
                <!--<div class="modal-body">

                </div>-->
                <input type='hidden' class='deletoption'>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger no-margin pull-right inline" data-dismiss="modal">No</button>
                    <a id="deletelink"><button onclick='Delete(this);' type="button" class="btn btn-primary pull-right inline" style="margin-right:10px;">Yes</button></a>
                    <!--<a id="deletelink"><button onclick='Delete(this);' type="button" class="btn btn-primary btn-cons  pull-left inline">Continue</button></a>
                    <button type="button" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">Cancel</button>-->

                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
