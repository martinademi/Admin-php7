<?PHP

?>
<style>
    .form-horizontal .form-group 
    {
        margin-left: 13px;
    } 
    .mandatoryField{
        color:red;
    }
    .btn{
        font-size: 10px !important;
        width: 72px !important;
    }
</style>

<script>
  
    $(document).ready(function () {


              function isNumberKey(evt, obj) {

                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                }

        $('#callM').click(function () {
            $("#add-portion").hide();
            $('#EditporId').val("");
            $('.Title').val("");
            $('#Price').val("");
            $('.modal-header').html('<h4>Add New Addones</h4>');
            
            $('#addOn').val('');
            $('#addOnErr').text('');
            $('#priceErr').text('');
            $('#NewCat').modal('show');
        });

        $('#CategoryId').change(function () {

            var catId = $("#CategoryId option:selected").attr('value');
//            alert(catId);
            $('#SubCategory').load('<?PHP echo AjaxUrl; ?>GetSubCatfromCat', {catId: catId});
        });

        $('.error-box-class').keypress(function () {
            $('.error-box').val('');
        });
//        $('.error-box-class').change(function () {
//             $('.error-box').text('');
//        });

    });

    $(document).ready(function(){
            // cool
        $.ajax({
           
            url:"<?php echo base_url()?>index.php?/AddOns/getAddOnDetail/" + "<?php echo $addOnId ?>",
            type:'POST',
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            data: '',          

        }).done(function(json){
            console.log('details',json)
             // console.log('details********',json);
                $('#entityname_0').val(json.name.en);
                $('#Description_0').val(json.description.en);
               // $('#quantitylimit').val(json.addOnLimit);
                $('#entityname_1').val(json.name.nl);
                $('#Description_1').val(json.description.nl);
                
                
                if(json.mandatory==1){
                    $('#mandatoryid').prop('checked', true);
                }

                if(json.multiple==1){
                    $('#multipleid').prop('checked',true);

                     $('#minL').show();
                     $('#maxL').show();

                    $('#minimumlimit').val(json.minimumLimit);
                    $('#maximumlimit').val(json.maximumLimit);

                    
                }




        $.each(json.addOns,function(index,addOn){
            //console.log('addOn------>',addOn.name);

            var html = '';
            var indVal=0;
        
            var addOnName=new Array();
            $.each(addOn.name, function( key, value ) {
                 addOnName.push(value);
               //  html += '<input id="porTit' + count + '" class="porTit' + count + '"  type="hidden" name="FData[addOns][' + count + '][titleId]" value="' +value+ '">'  
                 html += '<input id="porTit' + indVal + '" class="porTit' + count + '"  type="hidden" name="FData[addOns][' + count + '][name][]" value="' +value+ '">'   
                 indVal++;
            });

           


           
            // $(".Title").each(function () {
            //     var lan_id = $(this).attr('id').split("_");
            //     html += '<input id="porTit' + count + '" class="porTit' + count + '" data-id="' + lan_id + '" type="hidden" name="FData[addOns][' + count + '][titleId]" value="' + $(this).val() + '">'
            // });



            $('#PortionTable').append('<tr id="Row' + count + '">' +
                    '<td> <label id="LabelTit' + count + '">' + addOnName + '</label></td>' +
                    '<td> <label id="LabelPric' + count + '">' + addOn.price + '</label></td>' +
                    html +
                    '<input id="porprice' + count + '" type="hidden" name="FData[addOns][' + count + '][price]" value="' + addOn.price + '">' +
                  //  '<input id="LabelTits' + count + '" type="hidden" name="FData[addOns][' + count + '][name]" value="' + addOn.name.en + '">' +
                    '<input id="porprice' + count + '" type="hidden" name="FData[addOns][' + count + '][id]" value="' + addOn.id + '">' +
                    ' <td  class="v-align-middle">' +
                    ' <div class="btn-group">' +
                    '<a><button onclick="editMe(this);" value="' + count + '" type="button" style="color: #ffffff !important;background-color: #10cfbd;" class="buttonEdit btn btn-success"><i class="fa fa-pencil"></i>' +
                    '  </button></a>' +
                    '  <a><button type="button" onclick="DelRows(this)" id="' + count + '" class="buttonDeletee btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>' +
                    '   </button></a>' +
                    ' </div>' +
                    '</td></tr>');
            count++;
        });
           

// *******************
            


        });

    });

    function editMe(data) {
        

        var id = data.value;
        var porTit = $('#porTit' + id).text();
        var porPric = $('#porprice' + id).val();
        var langData = <?php echo json_encode($language); ?>;
        
        
        $('.porTit' + id).each(function (ind,value) {
          var name=$(this).val();
          $('#addOn_'+ ind).val(value.value);         
        
        });


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
        } else {
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
        $("#nextbutton").removeClass("hidden");
        $("#finishbutton").addClass("hidden");
        $("#tb1").attr('data-toggle', 'tab');
        $("#tb1").attr('href', '#tab1');
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
        var pstatus = true;
//        $(".error-box").hide("");
        var cat = $('#entityname_0').val();
        var cat1 = $('.Category1').val();
        if (cat == '' || cat == null)
        {
            pstatus = false;
            $("#category_err").show();
        }

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
        } else {
            $("#mtab2").attr('data-toggle', 'tab');
            $("#mtab2").attr('href', '#tab2');
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
        if ($("#firstlitab").attr('class') === "active")
        {
            profiletab('secondlitab', 'tab2');
            var cat = $('#entityname_0').val();
            var cat1 = $('.Category1').val();
            if (cat) {
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

        if ($("#secondlitab").attr('class') === "active")
        {
            profiletab('secondlitab', 'tab2');
            proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
            $("#prevbutton").addClass("hidden");
            $("#finishbutton").addClass("hidden");
            $("#nextbutton").removeClass("hidden");
        }

    }
    function DelRows(thisval) {
        $('.modal-header').html('<h5> Are you sure to delete this Add-On ?</h5>');
        $('#deletemodal').modal('show');
        var entityidid = thisval.id;
        $('.deletoption').val(entityidid);
    }

    function Delete() {
        var Delid = $('.deletoption').val();
        $('#Row' + Delid).remove();
        $('#deletemodal').modal('hide');
    }

       $(document).ready(function() {
        $('#multipleid').click(function() {
            
            if ($('#multipleid').is(':checked')) {
                $('#minL').show();
                $('#maxL').show();
			
	     	}else{
                $('#minL').hide();
                $('#maxL').hide();
             }
         });

    });

</script>


<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="">
                    <li><a class="active" href="<?php echo base_url() ?>index.php?/AddOns"><?php echo $this->lang->line('ADD_ONS'); ?></a>
                    </li>
                    <li style=""><a href="#" class="active"><?php echo $this->lang->line('EDIT_ADD_ON'); ?></a>
                        </li>
                    <!-- <?php if ($AddonDetails['_id']) { ?> -->
                        
                    <?php } else { ?>
                        <li style=""><a href="#" class="active"><?php echo $this->lang->line('ADD_ADD_ON'); ?></a>
                        </li>
                    <?php } ?>
                </ul>
                <!-- END BREADCRUMB -->
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                <li class="active" id="firstlitab" onclick="managebuttonstate()">
                    <a id="tb1"><i id="tab1icon" class=""></i> <span><?php echo $this->lang->line('Details'); ?></span></a>
                </li>
                <li class="" id="secondlitab">
                    <a onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span><?php echo $this->lang->line('AddOns'); ?></span></a>
                </li>

            </ul>

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">

                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php?/AddOns/editAddOnData" method="post" enctype="multipart/form-data">
                        <input type='hidden' name='FData[franchiseId]' value='<?PHP echo $BizId; ?>'> 
                        <input type='hidden' id="addonid" name='FData[addOnId]' value='<?PHP echo $addOnId; ?>'> 
                        <div class="tab-content">
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">

                                    <?php // print_r($AddonDetails);  ?>
                                  
                                    <div id="Category_txt">
                                        <div class="form-group ">
                                            <label for="fname" class="col-sm-3  control-label"><?php echo $this->lang->line('AddOn_Group_Name_English'); ?><span style="color:red;font-size: 18px">*</span></label>
                                            <div class="col-sm-6" style="margin-top:10px;">  
                                                <!-- <input type="text"   id="entityname_0" name="FData[category][en]" value="<?PHP echo $AddonDetails['category']['en'] ?>" class=" Category form-control error-box-class" > -->
                                                <input type="text"   id="entityname_0" name="FData[name][en]" value="<?PHP echo $AddonDetails['category']['en'] ?>" class=" Category form-control error-box-class" >
                                            </div>
                                            <div class="col-sm-offset-3 col-sm-6 error-box" id="category_err" style="display:none;"><?php echo $this->lang->line('Enter_the_addOn_name'); ?></div>
                                        </div>

                                        <?php
                                        foreach ($language as $val) {
                                            if ($val['Active'] == 1) {
                                                ?>
                                                <div class="form-group" >
                                                    <label for="fname" class="col-sm-3   control-label"> AddOn Group Name (<?php echo $val['lan_name']; ?>) <span style="color:red;font-size: 18px">*</span></label>
                                                    <div class="col-sm-6">

                                                        <input type="text"  id="entityname_<?= $val['lan_id'] ?>" name="FData[name][<?= $val['langCode'] ?>]" value="<?PHP echo $AddonDetails['category'][$val['langCode']] ?>" class=" Category1 form-control error-box-class" >
                                                    </div>
                                                    <div class="col-sm-offset-3 col-sm-6 error-box" id="category1_err" style="display:none;">Enter the addOn name</div>
                                                </div>

                                            <?php } else { ?>
                                                <div class="form-group" style="display: none;">
                                                    <label for="fname" class="col-sm-3   control-label"> AddOn Group Name (<?php echo $val['lan_name']; ?>) <span style="color:red;font-size: 18px">*</span></label>
                                                    <div class="col-sm-6">

                                                        <input type="text"  id="entityname_<?= $val['lan_id'] ?>" name="FData[name][<?= $val['langCode'] ?>]" value="<?PHP echo $AddonDetails['category'][$val['langCode']] ?>" class=" Category1 form-control error-box-class" >
                                                    </div>
                                                    <div class="col-sm-offset-3 col-sm-6 error-box" id="category1_err" style="display:none;">Enter the addOn name</div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>

                                    <div id="Description_txt">
                                        <div class="form-group ">
                                            <label for="fname" class="col-sm-3 control-label"> <?php echo $this->lang->line(' Description_English'); ?> </label>
                                            <div class="col-sm-6">  
                                                <textarea type="text"   id="Description_0" placeholder="description" name="FData[description][en]"  class=" Description form-control error-box-class" ><?PHP echo $AddonDetails['description']['en'] ?></textarea>
                                            </div>
                                        </div>

                                        <?php
                                        foreach ($language as $val) {
                                            if ($val['Active'] == 1) {
                                                ?>
                                                <div class="form-group" >
                                                    <label for="fname" class="col-sm-3 control-label"> Description (<?php echo $val['lan_name']; ?>) </label>
                                                    <div class="col-sm-6">
                                                        <textarea type="text"  id="Description_<?= $val['lan_id'] ?>" placeholder="Description" name="FData[description][<?= $val['langCode'] ?>]"  class=" Description form-control error-box-class" ><?PHP echo $AddonDetails['description'][$val['langCode']] ?></textarea>

                                                    </div>
                                                </div>

                                            <?php } else { ?>
                                                <div class="form-group" style="display: none;">
                                                    <label for="fname" class="col-sm-3 control-label"> Description (<?php echo $val['lan_name']; ?>) </label>
                                                    <div class="col-sm-6">
                                                        <textarea type="text"  id="Description_<?= $val['lan_id'] ?>" placeholder="description" name="FData[description][<?= $val['langCode'] ?>]"  class=" Description form-control error-box-class" ><?PHP echo $AddonDetails['Description'][$val['langCode']] ?></textarea>

                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>

                                   

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Mandatory'); ?></label>
                                        <div class="col-sm-6">
                                            <?PHP
                                            if ($AddonDetails['mandatory'] == '1') {
                                                echo ' <input type="checkbox" name="FData[mandatory]" id="mandatoryid" value="1" checked>';
                                            } else {
                                                echo ' <input type="checkbox" name="FData[mandatory]" id="mandatoryid" value="1">';
                                            }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Multiple'); ?></label>
                                        <div class="col-sm-6">
                                            <?PHP
                                            if ($AddonDetails['multiple'] == '1') {
                                                echo ' <input type="checkbox" name="FData[multiple]" value="1" id ="multipleid" checked>';
                                            } else {
                                                echo ' <input type="checkbox" name="FData[multiple]" id ="multipleid" value="1">';
                                            }
                                            ?>

                                        </div>

                                    </div>

                                     <div class="form-group " style="display:none" id="minL" >
                                        <label for="fname" class="col-sm-3  control-label"><?php echo $this->lang->line('Minimum_Limits'); ?><span style="color:red;font-size: 18px"></span></label>
                                        <div class="col-sm-6" style="margin-top:10px;">  
                                            <input type="text"   id="minimumlimit" name="FData[minimumLimit]" value="<?PHP echo $AddonDetails['minimumLimit'] ?>" class="form-control error-box-class" onkeypress="return isNumberKey(event,this)" >
                                        </div>
                                    </div>

                                     <div class="form-group " style="display:none" id="maxL">
                                        <label for="fname" class="col-sm-3  control-label"> <?php echo $this->lang->line(' Maximum_Limits'); ?> <span style="color:red;font-size: 18px"></span></label>
                                        <div class="col-sm-6" style="margin-top:10px;">  
                                            <input type="text"   id="maximumlimit" name="FData[maximumLimit]" value="<?PHP echo $AddonDetails['maximumLimit'] ?>" class="form-control error-box-class" onkeypress="return isNumberKey(event,this)">
                                        </div>
                                    </div>


                                     <!-- <div class="form-group ">
                                        <label for="fname" class="col-sm-3  control-label"> Quantity Limits <span style="color:red;font-size: 18px"></span></label>
                                        <div class="col-sm-6" style="margin-top:10px;">  
                                            <input type="text"   id="quantitylimit" name="FData[addOnLimit]" value="<?PHP echo $AddonDetails['addOnLimit'] ?>" class="form-control error-box-class" >
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">
                                    <button type="button" class="buttonAdd btn btn-success pull-right" id="callM" style="margin:1% 0%;"><?php echo $this->lang->line('Add_new'); ?></button>
                                    <h5 class="error-box pull-right" style="display:none;font-size: 18px !important;margin-top: 1.5%;" id="add-portion"><?php echo $this->lang->line('Add_Portion'); ?></h5>
                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="PortionTable" role="grid" aria-describedby="tableWithSearch_info">
                                                <thead>

                                                    <tr role="row">

                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                        <?php echo $this->lang->line('Title'); ?></th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                        <?php echo $this->lang->line('Price'); ?>(<?PHP echo $this->session->userdata('badmin')['Currency']; ?>)</th>

                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                        <?php echo $this->lang->line('Option'); ?></th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <?PHP
                                                    $Poid = 0;
                                                    if (is_array($AddonDetails['addOns'])) {

                                                        foreach ($AddonDetails['addOns'] as $AddOn) {
                                                            ?>
                                                            <tr id='Row<?PHP echo $Poid; ?>'>
                                                                <td> <label id="LabelTit<?PHP echo $Poid; ?>"><?PHP echo implode($AddOn['title'], ','); ?></label></td>
                                                                <td> <label id="LabelPric<?PHP echo $Poid; ?>"><?PHP echo $AddOn['price']; ?></label></td>
                                                                <?php
                                                                foreach ($AddOn['title'] as $key => $value) {
                                                                    ?>
                                                            <input id="porTit<?= $key ?>" class="porTit<?PHP echo $Poid; ?>" data-id="<?= $key ?>" type="hidden" name="FData[addOns][<?PHP echo $Poid; ?>][title][<?= $key ?>]" value="<?PHP echo $value; ?>">
                                                            <!--<input id="porTit<?= $key ?>" class="porTit<?PHP echo $Poid; ?>" data-id="<?= $key ?>" type="hidden" name="FData[AddOns][<?PHP echo $Poid; ?>][title][<?= $key ?>]" value="<?PHP echo $value; ?>">-->
                                                            <?php
                                                        }
                                                        ?>

                                                        <input  id="porprice<?PHP echo $Poid; ?>" type="hidden" name="FData[addOns][<?PHP echo $Poid; ?>][price]" value="<?PHP echo $AddOn['price']; ?>">
                                                        
                                                        <input  id="LabelTit<?PHP echo $Poid; ?>" type="hidden" name="FData[addOns][<?PHP echo $Poid; ?>][name]" value="<?PHP echo $AddOn['name']; ?>">
                                                        <input id="porId<?PHP echo $Poid; ?>" type="hidden" name="FData[addOns][<?PHP echo $Poid; ?>][id]" value="<?PHP echo $AddOn['id']; ?>">
                                                        

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
                                            <span><?php echo $this->lang->line('Next'); ?></span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-primary btn-cons pull-right" type="button" onclick="submitform()">
                                            <span><?php echo $this->lang->line('Finish'); ?></span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-default btn-cons pull-right" type="button" onclick="movetoprevious()">
                                            <span><?php echo $this->lang->line('Previous'); ?></span>
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

<script>
    var count = 0;
    var cn=0;
    function AddPortion()
    {

        console.log('passs1');
        // cool
        
        var taskArray = new Array();
        $('.Title').each(function(){
            taskArray.push($(this).val());
        });

        console.log('----',taskArray);
        

        var titleId = $('#addOn').val();
        var name = $('#addOn').val();

        var price = $('#Price').val();
        
        var num = '<?php echo $val['lan_id'] ?>';
        if (titleId == '') {
            $("#addOnErr").text('Please enter the Add-On');
            return false;
        }
        if (price == '') {
            $("#priceErr").text('Please enter the Price');
            return false;
        }
        if ($('#EditporId').val() != '') {
            console.log('passs2');
            $('.porTit' + $('#EditporId').val()).remove();
            // $(".Title").each(function () {
            //     var lan_id = $(this).attr('id').split("_");
            // });
            var html = '';
            // $(".Title").each(function () {
            //     var lan_id = $(this).attr('id').split("_");
            //    // html += '<input id="porTit' + $('#EditporId').val() + '"  class="porTit' + $('#EditporId').val() + '" data-id="' + lan_id + '" type="hidden" name="FData[addOns][' + $('#EditporId').val() + '][titleId]" value="' + $(this).val() + '">'
            //    html += '<input id="porTit' + count + '" class="porTit' + count + '" data-id="' + lan_id + '" type="hidden" name="FData[addOns][' + count + '][name][]" value="' + $(this).val() + '">'
            // });

            $(".Title").each(function () {
                var lan_id = $(this).attr('id').split("_");
                html += '<input id="porTit' + cn + '" class="porTit' + cn + '" data-id="' + lan_id + '" type="hidden" name="FData[addOns][' + cn + '][name][]" value="' + $(this).val() + '">'
            });

            

            $('#Row' + $('#EditporId').val()).append(html);
            $('#porprice' + $('#EditporId').val()).val(price);
            $('#LabelTit' + $('#EditporId').val()).text(taskArray);
            $('#LabelTits' + $('#EditporId').val()).val(titleId);
            $('#LabelPric' + $('#EditporId').val()).text(price);


        } else {

             console.log('passs3');

            var totl = '<?PHP echo $Poid; ?>';
            if (count > totl) {

            } else {
                count = totl;
            }
            var html = '';
            $(".Title").each(function () {
                var lan_id = $(this).attr('id').split("_");
                //html += '<input id="porTit' + count + '" class="porTit' + count + '" data-id="' + lan_id + '" type="hidden" name="FData[addOns][' + count + '][titleId]" value="' + $(this).val() + '">'
                html += '<input id="porTit' + count + '" class="porTit' + count + '" data-id="' + lan_id + '" type="hidden" name="FData[addOns][' + count + '][name][]" value="' + $(this).val() + '">'
            });
            $('#PortionTable').append('<tr id="Row' + count + '">' +
                    '<td> <label id="LabelTit' + count + '">' + taskArray + '</label></td>' +
                    '<td> <label id="LabelPric' + count + '">' + price + '</label></td>' +
                    html +
                    '<input id="porprice' + count + '" type="hidden" name="FData[addOns][' + count + '][price]" value="' + price + '">' +
//                    '<input id="porId' + count + '" type="hidden" name="FData[AddOns][' + count + '][id]" value="' + id + '">' +
                   // '<input id="LabelTits' + count + '" type="hidden" name="FData[addOns][' + count + '][name]" value="' + name + '">' +
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

        <form action = "<?php echo base_url(); ?>index.php?/superadmin/AddNewSubCategory" method= "post" onsubmit="return validateForm();">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('Add_New_AddOn'); ?></h4>
                </div>

                <div class="modal-body">

                    <!-- <div id="Category_txt">
                        <div class="form-group ">
                            <label> Add-On</label>
                            <input tpe="text" id="addOn" name="Title" class="form-control" style="margin:0px" name="Price">
                                <span id="addOnErr" class="mandatoryField"></span>
                           
                        </div>
                    </div><br> -->
                    <!-- strt -->
                       <div id="Category_txt">
                                        <div class="form-group ">
                                            <label for="fname"> <?php echo $this->lang->line('Add_On_English'); ?> <span style="color:red;font-size: 18px">*</span></label>
                                          
                                                <input type="text"   id="addOn_0" name="Title['en']"  class="Title form-control" >
                                          
                                            
                                        </div>

                                        <?php
                                        foreach ($language as $val) {
                                            if ($val['Active'] == 1) {
                                                ?>
                                                <div class="form-group" >
                                                    <label for="fname" > Add-On   (<?php echo $val['lan_name']; ?>) <span style="color:red;font-size: 18px">*</span></label>
                                                 

                                                        <input type="text"  id="addOn_<?= $val['lan_id'] ?>" name="Title[<?= $val['langCode'] ?>]"  class="Title form-control" >
                                                   
                                                  
                                                </div>

                                            <?php } else { ?>
                                                <div class="form-group" style="display: none;">
                                                    <label for="fname" > Add-On   (<?php echo $val['lan_name']; ?>) <span style="color:red;font-size: 18px">*</span></label>
                                                   

                                                        <input type="text"  id="addOn_<?= $val['lan_id'] ?>" name="Title[<?= $val['langCode'] ?>]"  class="Title form-control" >
                                                  
                                                   
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>
                    <!--  -->

                        <div class="form-group" >
                            <label>Price</label>
                            <div class="input-group transparent">
                                <span class="input-group-addon">
                                    <i><?PHP echo $this->session->userdata('badmin')['Currency']; ?></i>
                                </span>
                                <input type="text" class="form-control" onkeypress="return validate(event)" placeholder="Price" id="Price" name="Price">
                                
                                <span id="priceErr" class="mandatoryField"></span>
                            </div>
                        </div>
                        <input id="EditporId" type="hidden" value="">

                        <label id = "errorbox" style="color: red; font-size: 15px;"></label>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="button" class="btn btn-primary" value="Add" onclick="AddPortion();">

                    </div>
                </div>
        </form>




    </div>

</div>
</div>
<div class="modal fade stick-up in" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5><?php echo $this->lang->line('Delete_Addon'); ?></h5>
                </div>
                <input type='hidden' class='deletoption'>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger no-margin pull-right inline" data-dismiss="modal"><?php echo $this->lang->line('No'); ?></button>
                    <a id="deletelink"><button onclick='Delete(this);' type="button" class="btn btn-primary pull-right inline" style="margin-right:10px;"><?php echo $this->lang->line('Yes'); ?></button></a>

                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
