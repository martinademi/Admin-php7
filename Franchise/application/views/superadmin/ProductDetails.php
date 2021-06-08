<?PHP error_reporting(false);
?>
<style>
    .form-horizontal .form-group 
    {
        margin-left: 13px;
    } 
    #ForImageCroping .cropper-container.cropper-bg {
        width: auto !important;
        height: 100% !important;
    }
     #ForImageCroping .img-container {
        min-height: 435px !important;
    }   
</style>

<script>
    
    function selectall(){
         var checked = $("#selectbids:checked").length;
//            alert(checked);
            
             if (checked == 0){
                  $(".selectbids").attr('checked',false);
             }else{
                  $(".selectbids").attr('checked',true);
      //        alert();
             }
    }
    
    $("#HeaderMenu").addClass("active");
    $("#HeaderMenu4").addClass("active");
    $(document).ready(function () {
        
        $('.close').click(function(){
          $("#Title-Error").hide();
            $("#Price-Error").hide();
              
        });
        
//        alert('Loading');
        $('#callM').click(function () {
            $("#Title-Error").hide();
            $("#Price-Error").hide();
            $("#editPortionTitle").hide();
            $("#newPortionTitle").show();
            $("#add-portion").hide();
            $('#EditporId').val("");
            $('.Title').val("");
            $('#Price').val("");
            $('#Default').prop('checked', false);
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

        $(".errEmpty").on('keyup change', function (){
            var err = $("#entityname").val();
            console.log(err.length);
            if(err.length == 0){
                $("#tb1").removeAttr('data-toggle');
                $("#mtab2").removeAttr('data-toggle');
                $("#mtab3").removeAttr('data-toggle');
                $("#mtab4").removeAttr('data-toggle');
                $("#tb1").removeAttr('href');
                $("#mtab2").removeAttr('href');
                $("#mtab3").removeAttr('href');
                $("#mtab4").removeAttr('href');
            }
        });

    });
    function editMe(data) {
    
        $("#newPortionTitle").hide();
        $("#editPortionTitle").show();
        var id = data.value;
//        var fkid = data.value;
         $('.porTit' + id).each(function(){
            var lan_id = $(this).attr('data-id');
            $('#Title_'+lan_id).val($(this).val());
           
        });
//        var porTit = $('#porTit' + id).val();
        var porPric = $('#porPric' + id).val();
        var Def = $('#Def' + id).val();

        if (Def == 'true') {
            $('#Default').prop('checked', true);
        } else {
            $('#Default').prop('checked', false);
        }
//        $('#Title').val(porTit);
        $('#Price').val(porPric);
        $('#EditporId').val(id);


        $('#NewCat').modal('show');
    }

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
        $("#tb1").attr('data-toggle','tab');
        $("#tb1").attr('href','#tab1');
    }

     function businestab(litabtoremove, divtabtoremove) {

        var bstatus = true;
        if (bonafidetab(litabtoremove, divtabtoremove))
        {
            $("#tab4icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");
            return bstatus;
        }
    }
    
    function profiletab(litabtoremove, divtabtoremove)
    {
        var pstatus = true;
        var reason = '';
        var entityname = new Array();
        $(".entityname").each(function (){
            entityname.push($(this).val());
        });
         $(".error-box").hide();
         var err1 = $(".entityname").val();
         var err2 = $(".entityname1").val();
         var err3 = $(".Description").val();
         var err4 = $(".Description1").val();
         var err5 = $("#CategoryId").val();
        if (err1 == '' || err1 == null)
        {
            pstatus = false;            
            $("#Name1").show();
        } else if(err2 == '' || err2 == null) {
             pstatus = false;            
            $("#Name2").show();        
        }
//        else if(err3 == '' || err3 == null) {
//             pstatus = false;            
//            $("#Name3").show();          
//        }else if(err4 == '' || err4 == null) {
//             pstatus = false;            
//            $("#Name4").show();          
//        }
        else if(err5 == '0' || err5 == null) {
             pstatus = false;            
            $("#Name5").show();           
        }else {
            $("#mtab2").attr('data-toggle', 'tab');
            $("#mtab2").attr('href', '#tab2');
        }


<?PHP
//if ($ProfileData['ImageFlag'] == '1') {
//    
?>
//            if ((isBlank($(".Masterimageurl").val())))
//            {
//                reason = 'Upload Image';
//                pstatus = false;
//            }
        //<?PHP
//}
?>


        //        if (isBlank($("#entityemail").val()))
        //        {
        //            pstatus = false;
        //        }
        // if ($("#CategoryId").val() == '0')
        // {
        //     pstatus = false;
        //     // alert("Category is Missing");
        //     $("#category").show();
        //     $(".error-border1").addClass("active");
        // }else{
        //      $("#category").hide();
        //      $(".error-border1").removeClass("active");
        // }

        //        if (isBlank($("#SubCategoryId").val()))
        //        {
        //            pstatus = false;
        //        }


        if (pstatus === false)
        {
                $("#tb1").removeAttr('data-toggle');
                $("#mtab2").removeAttr('data-toggle');
                $("#mtab3").removeAttr('data-toggle');
                $("#mtab4").removeAttr('data-toggle');
                $("#mtab5").removeAttr('data-toggle');
                $("#tb1").removeAttr('href');
                $("#mtab2").removeAttr('href');
                $("#mtab3").removeAttr('href');
                $("#mtab4").removeAttr('href');
                $("#mtab5").removeAttr('href');
            // $("#nextbutton").attr(disabled);
            setTimeout(function ()
            {                
                proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
            }, 1);
            if (reason != '') {
                alert(reason);
            } else {

//                alert("Mandatory Fields Missing")
            }
            $("#tab1icon").removeClass("fs-14 fa fa-check");
            return false;
        }
        //        alert();
        $("#tab1icon").addClass("fs-14 fa fa-check");
        $("#prevbutton").removeClass("hidden");
        $("#nextbutton").removeClass("hidden");
        $("#finishbutton").addClass("hidden");
        return true;
    }

    function addresstab(litabtoremove, divtabtoremove)
    {

        var astatus = true;
        var totl1 = $('#PortionTable111 tr').length;
        //        alert(totl1);
        if (totl1 == 1) {
             $("#add-portion").show();            
            astatus = false;
        }else{
             $("#add-portion").hide();            
        }

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
                // alert("Add Portion.");
                $("#tab2icon").removeClass("fs-14 fa fa-check");
                return false;
            }else{
                $("#mtab3").attr('data-toggle','tab');
                $("#mtab3").attr('href','#tab3');
            }
            $("#tab2icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");
            return astatus;
        }
    }

    function bonafidetab(litabtoremove, divtabtoremove)
    {
//        console.log(litabtoremove);
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
            else{
                $("#mtab4").attr('data-toggle','tab');
                $("#mtab4").attr('href','#tab4');
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
        //        var currenttabstatus = $("li.active").attr('id');
        if ($("#firstlitab").attr('class') === "active")
        {
               var entityname = new Array();
                    $(".entityname").each(function (){
                        entityname.push($(this).val());
                    });
//            var entityname = $("#entityname").val();
         profiletab('secondlitab', 'tab2');
         var err1 = $(".entityname").val();
         var err2 = $(".entityname1").val();
         var err3 = $(".Description").val();
         var err4 = $(".Description1").val();
         var err5 = $("#CategoryId").val();
         if(err1 && err2 &&  err5 != '0'){
            proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
         }
        } else if ($("#secondlitab").attr('class') === "active")
        {
            addresstab('thirdlitab', 'tab3');
            var totl1 = $('#PortionTable111 tr').length;
            // alert(totl1);
            if(totl1 > 1){
                proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');
            }                   
        }else if ($("#thirdlitab").attr('class') === "active")
        {
//            bonafidetab('fourthlitab', 'tab4');
            proceed('thirdlitab', 'tab3', 'fourthlitab', 'tab4');

        } else if ($("#fourthlitab").attr('class') === "active")
        {
            
            bonafidetab('fourthlitab', 'tab4');
            proceed('fourthlitab', 'tab4', 'fifthlitab', 'tab5');
            $("#finishbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");
        }
    }

    function movetoprevious()
    {
        var currenttabstatus = $("li.active").attr('id');
        if ($("#secondlitab").attr('class') === "active")
        {
            profiletab('secondlitab', 'tab2');
            proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
            $("#prevbutton").addClass("hidden");
        } else if ($("#thirdlitab").attr('class') === "active")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('thirdlitab', 'tab3', 'secondlitab', 'tab2');
        } else if ($("#fourthlitab").attr('class') === "active")
        {
//            bonafidetab('fourthlitab', 'tab4');
            proceed('fourthlitab', 'tab4', 'thirdlitab', 'tab3');

        } else if ($("#fifthlitab").attr('class') === "active")
        {
            bonafidetab('fifthlitab', 'tab5');
            proceed('fifthlitab', 'tab5', 'fourthlitab', 'tab4');
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
                        <a class="active" href="#">MENU</a>
                    </li>


                    <li><a class="active" href="<?php echo base_url() ?>index.php/superadmin/Products">PRODUCTS</a>
                    </li>

                    <li style="width: 100px"><a href="#" class="active" style="font-size: 12px;">ADD</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                <li class="active" id="firstlitab" onclick="managebuttonstate()">
                    <a id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
                </li>
                <li class="" id="secondlitab">
                    <a onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>Portions</span></a>
                </li>
                <li class="" id="thirdlitab">
                    <a onclick="addresstab('thirdlitab', 'tab3')" id="mtab3"><i id="tab3icon" class=""></i> <span>Add Ons</span></a>
                </li>
                <li class="" id="fourthlitab">
                    <a onclick="bonafidetab('fourthlitab', 'tab4')" id="mtab4"><i id="tab4icon" class=""></i> <span>Images</span></a>
                </li>
                <li class="" id="fifthlitab">
                    <a data-toggle="tab" href="#tab5" onclick="businestab('fifthlitab', 'tab5')"><i id="tab4icon" class=""></i> <span>Product available in</span></a>
                </li>
            </ul>

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs 
                    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <li class="active" id="firstlitab" onclick="managebuttonstate()">
                            <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
                        </li>
                        <li class="" id="secondlitab">
                            <a data-toggle="tab" href="#tab2" onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>Portions</span></a>
                        </li>
                        <li class="" id="thirdlitab">
                            <a data-toggle="tab" href="#tab3" onclick="addresstab('thirdlitab', 'tab3')"><i id="tab3icon" class=""></i> <span>Add Ons</span></a>
                        </li>
                        <li class="" id="fourthlitab">
                            <a data-toggle="tab" href="#tab4" onclick="bonafidetab('fourthlitab', 'tab4')"><i id="tab4icon" class=""></i> <span>Images</span></a>
                        </li>
                    </ul> -->
                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php/superadmin/AddnewProduct" method="post" enctype="multipart/form-data">
                        <input type='hidden' value='<?PHP echo $ProductId; ?>' name='ProductId'>
                        <input type='hidden' value='<?PHP echo $BizId; ?>' name='FData[BusinessId]'>
                        <?PHP
                        if ((string) $ProductDetails['_id'] == '') {
                            echo " <input type='hidden' value='" . $count . "' name='count'>";
                        }
                        ?>

                        <div class="tab-content">
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">
                                    <?PHP
                                    if ($ProfileData['ImageFlag'] == '1') {
                                        ?>
                                        <div class="form-group">
                                            <label for="fname" class="control-label">Product Image</label>

                                            <div class="" >
                                               
                                                    <div class="portfolio-group">
                                                     <a onclick="openFileUpload(this)" id='1' style="cursor: pointer;">
                                                        <?PHP
                                                        if ($ProductDetails['Masterimageurl']['Url'] == '') {
                                                            echo '  <img src="http://54.174.164.30/Tebse/Business/addnew.png" onerror="if (this.src != \'error.jpg\') this.src = \'http://54.174.164.30/Tebse/Business/addnew.png\';" id="MainImageUrl" style="width:14% ;height: 24%;">';
                                                        } else {
                                                            echo '  <img src="' . $ProductDetails['Masterimageurl']['Url'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'http://54.174.164.30/Tebse/Business/addnew.png\';" id="MainImageUrl" style="width:12% ;height: 12%;">';
                                                        }
                                                        ?>
                                                        </a> 
                                                    </div>
                                                                                                                   
                                            </div>
                                        </div>
                                        <?PHP
                                    }
                                    ?>
                                    
                                    <div id="Category_txt" >
                                        <div class="form-group " style="margin-bottom:0px;">
                                            <label for="fname" class="col-sm-2 control-label"> Name (English) <span style="color:red;font-size: 18px">*</span></label>
                                           <div class="col-sm-4">    <!--<div class="col-sm-6">-->  
                                            <input type="text"   id="entityname_0" name="FData[ProductName][0]" value="<?PHP echo $ProductDetails['ProductName'][0]; ?>"  class=" entityname form-control error-box-class" >
                                           </div>
                                           <div class="col-sm-offset-2 col-sm-6 error-box" id="Name1" style="display:none;">Select name</div>
                                         </div>
                                        <br>
                                                <?php
                                                 foreach ($language as $val) {
            //                                         print_r($val);
                                                ?>
                                        <div class="form-group" style="margin-bottom:0px;">
                                               <label for="fname" class="col-sm-2 control-label"> Name (<?php echo $val['lan_name'];?>) <span style="color:red;font-size: 18px">*</span></label>
                                            <div class="col-sm-4">
                                                 <input type="text"  id="entityname_<?= $val['lan_id'] ?>" name="FData[ProductName][<?= $val['lan_id'] ?>]"  value="<?PHP echo $ProductDetails['ProductName'][$val['lan_id']]; ?>"  class=" entityname1 form-control error-box-class" >
                                            </div>
                                            <div class="col-sm-offset-2 col-sm-6 error-box" id="Name2" style="display:none;">Select name</div>
                                        </div>

                                       <?php } ?>

                                    </div>
                                    
<!--                                    <div class="form-group" style="margin-bottom:0px;">
                                        <label for="fname" class="col-sm-2 control-label">Name<em>*</em></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="errEmpty error-border form-control" id="entityname" placeholder="Product Name" name="FData[ProductName]"  aria-required="true" value="<?PHP echo $ProductDetails['ProductName']; ?>">
                                        </div>                                                                             
                                    </div>-->
                                     <div class="form-group">
                                        <span class="col-sm-2"></span>
                                        <span class="col-sm-4" style="font-size:11px;color: tomato;margin-top: 0px;margin-bottom: 10px;display:none;" id="product">Please enter the product name</span>
                                    </div>
                                    <!-- <h5 class="col-xs-offset-3" style="margin-left: 18.2%;font-size: 11px;color: tomato;margin-top: 0px;margin-bottom: 10px;display:none;" id="product">Please enter the product name</h5>  

                                                                        <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label">Description</label>
                                                                            <div class="col-sm-6">
                                                                                <input type="text" class="form-control" id="entityemail" placeholder="Product Description" name="FData[ProductDescription]"  aria-required="true" value='<?PHP echo $ProductDetails['ProductDescription']; ?>'>
                                                                            </div>
                                    
                                                                        </div>-->

                                    
                                    <div id="Description_txt">
                                            <div class="form-group ">
                                                <label for="fname" class="col-sm-2 control-label"> Description (English)</label>
                                                  <div class="col-sm-4"><!--<div class="col-sm-6">-->  
                                                  <textarea type="text"   id="Description_0" placeholder="Description" name="FData[ProductDescription][0]"  class=" Description form-control error-box-class" ><?PHP echo $ProductDetails['ProductDescription'][0]; ?></textarea>
                                                  </div>
                                                  <div class="col-sm-offset-2 col-sm-6 error-box" id="Name3" style="display:none;"> Enter description</div>
                                             </div>
                                        <br>
                                                    <?php
                                                     foreach ($language as $val) {
                //                                         print_r($val);
                                                    ?>
                                            <div class="form-group" >
                                                   <label for="fname" class="col-sm-2 control-label"> Description (<?php echo $val['lan_name'];?>)</label>
                                                   <div class="col-sm-4">
                                                   <textarea type="text"  id="Description_<?= $val['lan_id'] ?>" placeholder="Description" name="FData[ProductDescription][<?= $val['lan_id'] ?>]"  style="margin-bottom:10px;"  class=" Description1 form-control error-box-class" ><?PHP echo $ProductDetails['ProductDescription'][$val['lan_id']]; ?></textarea>

                                                    </div>
                                                    <div class="col-sm-offset-2 col-sm-6 error-box" id="Name4" style="display:none;"> Enter description</div>
                                            </div>

                                           <?php } ?>



                                    </div>
                                    
<!--                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Description</label>
                                        <div class="col-sm-4" style="margin-bottom: 10px;">
                                            <input type="text" class="form-control" id="entityemail" placeholder="Description" name="FData[Description]"  aria-required="true">
                                            <textarea rows="4" cols="50" class="form-control" id="entitydesc" placeholder="Description" name="FData[ProductDescription]"  aria-required="true" style="margin-bottom:10px;" ><?PHP echo $ProductDetails['ProductDescription']; ?></textarea>
                                        </div>

                                    </div>-->
                                    
                                    

                                    <div class="form-group" style="margin-bottom:0px;">
                                        <label for="fname" class="col-sm-2 control-label">Category<em>*</em></label>
                                        <div class="col-sm-4">
                                            <select class="error-border1 form-control" id="CategoryId" name="FData[CategoryId]" required>
                                                <option value="0">Select Category</option>
                                                <?PHP
                                                foreach ($AllCats as $Cats) {
                                                    echo '<option value = "' . (string) $Cats['_id'] . '">' . implode($Cats['Category'],',') . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-offset-2 col-sm-6 error-box" id="Name5" style="display:none;"> Please select category</div>                                                                               
                                    </div>
                                    <div class="form-group">
                                        <span class="col-sm-2"></span>
                                        <span class="col-sm-4" style="font-size:11px;color: tomato;margin-top: 0px;margin-bottom: 10px;display:none;" id="category">Please select the category</span>
                                    </div>
                                   <!-- <h5 class="col-xs-offset-3" style="margin-left: 18.2%;font-size: 11px;color: tomato;margin-top: 0px;margin-bottom: 10px;display:none;" id="category">Please select the category</h5> --> 

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Sub-Category</label>
                                        <div class="col-sm-4" id="SubCategory">
                                            <select class="form-control" id="SubCategoryId" name="FData[SubCategoryId]" required>
                                                <option value="">Select Sub-Category</option>

                                            </select>
                                        </div>

                                    </div>



                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">
                                    <button type="button" class="btn btn-primary" id="callM" style="float:right;margin-right: 0.8%;margin-top: 5px;">Add</button>
                                    <h5 style="color: tomato;float: right;margin-right: 1%;margin-top: 15px;display:none;" id="add-portion">Add Portion</h5>
                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                        <div class="table-responsive col-xs-12">
                                            <table class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="PortionTable111" role="grid" aria-describedby="tableWithSearch_info">
                                                <thead>

                                                    <tr role="row">

                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                            Title</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                            Price(<?PHP echo $this->session->userdata('fadmin')['Currency']; ?>)</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                            Default</th>
                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                            Option</th>
                                                    </tr>

                                                </thead>
                                                <tbody>

                                                    <?PHP
                                                    $Poid = 0;
                                                    if (is_array($ProductDetails['Portion'])) {

                                                        foreach ($ProductDetails['Portion'] as $portion) {
                                                           
//                                                            print_r($portion);
                                                            ?>
                                                            <tr id='Row<?PHP echo $Poid; ?>'>
                                                                <td> <label id="LabelTit<?PHP echo $Poid; ?>"><?PHP echo implode($portion['title'],','); ?></label></td>
                                                                <td> <label id="LabelPric<?PHP echo $Poid; ?>"><?PHP echo $portion['price']; ?></label></td>
                                                                <?php                                                           
                                                                foreach ($portion['title'] as $key => $value) {
//                                                                    print_r($value);
                                                                ?>
                                                                  <input id="porTit<?= $key ?>" class="porTit<?PHP echo $Poid; ?>" data-id="<?= $key ?>" type="hidden" name="FData[Portion][<?PHP echo $Poid; ?>][title][<?= $key ?>]" value="<?PHP echo $value; ?>">

                                                                    <!--<input id="porTit<?= $key?>" class="porTit<?PHP echo $Poid; ?>" data-id="<?= $key?>" type="hidden" name="FData[Portion][<?PHP echo $Poid; ?>][title][<?= $key?>]" value="<?PHP echo $value; ?>">-->
                                                                <?php
                                                                }
                                                                ?>       
                                                <!--<input id="porTit<?PHP // echo $Poid; ?>" type="hidden" name="FData[Portion][<?PHP // echo $Poid; ?>][title]" value="<?PHP // echo $portion['title']; ?>">-->
                                                        <input id="porPric<?PHP echo $Poid; ?>" type="hidden" name="FData[Portion][<?PHP echo $Poid; ?>][price]" value="<?PHP echo $portion['price']; ?>">
                                                        <input id="porId<?PHP echo $Poid; ?>" type="hidden" name="FData[Portion][<?PHP echo $Poid; ?>][id]" value="<?PHP echo $portion['id']; ?>">
                                                        <input id="Def<?PHP echo $Poid; ?>" type="hidden" name="FData[Portion][<?PHP echo $Poid; ?>][Default]" value="<?PHP echo $portion['Default']; ?>" >

                                                        <td> <label id="LabelDef<?PHP echo $Poid; ?>"><?PHP echo $portion['Default']; ?></label></td>

                                                        <td  class="v-align-middle">
                                                            <div class="btn-group">
                                                                <a><button type="button" onclick="editMe(this);"   value="<?PHP echo $Poid; ?>" type="button" style="color: #ffffff !important;background-color: #5bc0de;border: 1px solid #5bc0de;" class="btn btn-success"><i class="fa fa-pencil"></i>
                                                                    </button></a>
                                                                <a><button type="button" onclick="DelRows(this)" id="<?PHP echo $Poid; ?>" class="btn btn-success" style="color: #ffffff !important;background-color: #d9534f;border: 1px solid #d9534f;"><i class="fa fa-trash-o"></i>
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

                            <div class="tab-pane slide-left padding-20" id="tab3">
                                <div class="row row-same-height">

                                    <label for="fname" class="control-label">Add-Ons</label>
                                    <br><br>

                                    <?PHP
                                    $i = 0;
                                    $array = array();
                                    foreach ($ProductDetails['AddOns'] as $adon) {
                                        $array[] = $adon['AddOn'];
                                    }
                                    foreach ($AllAddonCats as $Cats) {
                                        if (in_array((string) $Cats['_id'], $array)) {
                                            echo '   <div class="col-md-2" style="font-size: 12px;"><input type="checkbox" class="checkbox-inline" name="FData[AddOns][][AddOn]" value="' . (string) $Cats['_id'] . '" checked> ' . implode($Cats['Category'],',') . ' </div>';
                                        } else {
                                            echo '   <div class="col-md-2" style="font-size: 12px;"><input type="checkbox" class="checkbox-inline" name="FData[AddOns][][AddOn]" value="' . (string) $Cats['_id'] . '"> ' . implode($Cats['Category'],',') . ' </div>';
                                        }
                                        $i++;
                                    }
                                    ?>
                                </div>
                            </div>
                            <script>
                                var imgCout = 0;
//                                alert(imgCout);
                                imgCout = '<?PHP echo count($ProductDetails['Images']); ?>';
//                                alert(imgCout);
                                var imgAllowed = '<?PHP echo $ProfileData['MaxImageForProducts']; ?>';
                               
//                                alert(imgAllowed);
//                                return false;
                                if (imgAllowed === '' || imgAllowed === null) {
                                    imgAllowed = 10;
                                }
//alert(imgAllowed);
                                function openFileUpload(check)
                                {

//                                      alert('<?PHP echo ImageAjaxUrl; ?>');
                                    if (check.id == '1') {
//                                        $('#uploadMain').trigger('click');
                                        $('#FileUpload4').trigger('click');
                                    } else {


                                        if (imgCout < imgAllowed) {
                                            $('#FileUpload5').trigger('click');
                                            imgCout++;
                                        } else {
                                            alert('Oops! you can not upload more then ' + imgAllowed + ' images.');
                                        }
//                                        $('#uploadFile').trigger('click');

                                    }
                                    //                                    $('#iimg').show();

                                    //                                    $('#iimg').hide();


                                }

                                function delete1(val) {
                                    var ii = val.id;
                                    $('#Img' + ii).remove();
                                    //                                    $('#SaveImages').load('<?PHP echo AjaxUrl; ?>DeleteImage.php', {ImageId: ii});
                                }

                            </script>
                            <input type='hidden' class='Masterimageurl' name='FData[Masterimageurl][Url]' value="<?PHP echo $ProductDetails['Masterimageurl']['Url']; ?>">
                            <input type='hidden' class='masterImageHeight' name='FData[Masterimageurl][Height]' value="<?PHP echo $ProductDetails['Masterimageurl']['Height']; ?>">
                            <input type='hidden' class='masterImageWidth' name='FData[Masterimageurl][Width]' value="<?PHP echo $ProductDetails['Masterimageurl']['Width']; ?>">

                            <input id="FileUpload4" type="file" name="myMainfile"  style="visibility: hidden;"/>
                            <input id="FileUpload5" type="file" name="myMainfile"  style="visibility: hidden;"/>

                            <div class="tab-pane slide-left padding-20" id="tab4">

                                <div class="row row-same-height">
                                    <div id='MultipleImages'>
                                        <?PHP
                                        $ImgId = 0;
                                        foreach ($ProductDetails['Images'] as $Imgs) {
                                            echo '<div class="col-md-2" id="Img' . $ImgId . '">
                                            <input type = "hidden" id = "image1" name = "FData[Images][' . $ImgId . '][Url]" value = "' . $Imgs['Url'] . '"><img src="' . $Imgs['Url'] . '" alt="image 1" style="width: 100%;height: 160px;">
                                            <div style="position:absolute;top:0;right:0px;">
                                                <a onclick="delete1(this)" id="' . $ImgId . '"  value="" ><img  class="thumb_image" src="http://54.174.164.30/Tebse/dialog_close_button.png" height="20px" width="20px" /></a>
                                            </div>
                                            
                                             <div class="col-md-5">
                                             </div>
                                             <div class="col-md-6">';
                                            if ($Imgs['check'] == 'on') {
                                                echo '<input class="checkbox-inline" type="checkbox" name="FData[Images][' . $ImgId . '][check]" checked>';
                                            } else {
                                                echo '<input class="checkbox-inline" type="checkbox" name="FData[Images][' . $ImgId . '][check]">';
                                            }
                                            echo ' </div>
                                          
                                            
                                        </div>';
                                            $ImgId++;
                                        }
                                        ?>

                                        <input type = "hidden" id = "imageId" value = "<?PHP echo $ImgId; ?>">
                                    </div>
                                    <div class="col-md-2" >
                                        <a onclick="openFileUpload(this)" id='2' onmouseover="" style="cursor: pointer;">
                                            <div class="portfolio-group">
                                                <img src="http://54.174.164.30/Tebse/Business/addnew.png" onerror="if (this.src != \'error.jpg\') this.src = \'http://54.174.164.30/Tebse/Business/addnew.png\';" style="">
                                            </div>
                                        </a>                                                                    
                                    </div>
                                </div>

                            </div>
                            
                            <div class="tab-pane slide-left padding-20" id="tab5">
                                <div class="row row-same-height">

                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                        <div class="table-responsive">
                                            <table class="table table-hover demo-table-search dataTable no-footer" id="businesstable" role="grid" aria-describedby="tableWithSearch_info">
                                                <thead>

                                                    <tr role="row">

<!--                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                            Id</th>-->
                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                            Business Name</th>

                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                          <?php if (is_array($AllBusinesses)) {
                                                                    foreach ($AllBusinesses as $bizs) {
                                                                      if ($bizs['added'] == '1') {
                                                                            $sid = '1';
                                                                        }else{
                                                                            $sid = '0';
                                                                        }
                                                                  }
                                                          }
                                                          if($sid != '1'){
                                                                echo ' <input type="checkbox"  id="selectbids"  onclick="selectall();">';


                                                          }
                                                          else{
                                                               echo ' <input type="checkbox"  id="selectbids"  onclick="selectall();" checked disabled  >';

                                                          }
                                                          ?>
                                                          </th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <?PHP
                                                    $bid = 0;

                                                    if (is_array($AllBusinesses)) {

                                                        foreach ($AllBusinesses as $bizs) {
//                                                            print_r($bizs);
                                                            ?>
                                                            <tr id='Row<?PHP echo $bid; ?>'>
                                                                <!--<td> <label id=""><?PHP // echo $bizs['id'];                                         ?></label></td>-->
                                                                <td> <label id=""><?PHP echo $bizs['ProviderName'][0]; ?></label></td>

                                                                <td  class="v-align-middle">
                                                                    <div class="btn-group">
                                                                        <?PHP
                                                                        if ($bizs['added'] == '1') {
                                                                            echo '<input type="checkbox"  value="' . (string) $bizs['_id'] . '" checked disabled>';
                                                                            echo '<input type="hidden" class="selectbids" name="businesses[]" value="' . (string) $bizs['_id'] . '">';
                                                                        } else {
                                                                            echo '<input type="checkbox"  class="selectbids" name="businesses[]" value="' . (string) $bizs['_id'] . '" >';
                                                                        }
                                                                        ?>       


                                                                    </div>
                                                                </td></tr>
                                                            <?PHP
                                                            $bid++;
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
                        <div class="padding-20 bg-white">
                            <ul class="pager wizard">
                                <li class="next" id="nextbutton">
                                    <button class="btn btn-primary btn-cons pull-right" type="button" id="next-Button" onclick="movetonext()" >
                                        <span>Next</span>
                                    </button>
                                </li>
                                <li class="hidden" id="finishbutton">
                                    <button class="btn btn-primary btn-cons pull-right" type="button" onclick="submitform()" >
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


                    </form>
                </div>    

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

</div>
<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
    <?PHP include 'FooterPage.php' ?>
</div>
<!-- END FOOTER -->

<script>
    var count = 0;
    function AddPortion()
    {

        var totl = '<?PHP echo $Poid; ?>';
       
        if (count > totl) {

        } else {
            count = totl;
        }

//        var title = $('#Title').val();
         var title = new Array();
                    $(".Title").each(function (){
                        if($(this).val())
                            title.push($(this).val());
                    });
        var price = $('#Price').val();
        var checked = '';
        if ($('#Default').is(":checked")) {
            checked = 'true';

        }
         <?php foreach ($language as $val){} ?>
            var num = '<?php echo $val['lan_id']?>';

        if (title.length <= num) {
                // alert('Please Enter Title.');
               $("#Title-Error").show();
            }
           else if (price == '') {
                // alert('Please Enter Price.');
                 $("#Title-Error").hide();
                 $("#Price-Error").show();
            } else{
                 $("#Price-Error").hide();
            }
        if(title && price){
        if ($('#EditporId').val() != '') {
//            alert($('#EditporId').val());
            if (checked === 'true') {
                for (ii = 0; ii < count; ii++) {
                    if (ii !== $('#EditporId').val()) {
                        $('#LabelDef' + ii).text('');
                        $('#Def' + ii).val('');
                    }
                }
//                $('.defaulttext').html('');
//                $('.defaulthidden').val('');
            }
//            console.log(title);
//            var i = 0;
//        
//            $('.porTit' + $('#EditporId').val()).val('');
//             $('.porTit' + $('#EditporId').val()).each(function(){
//                          console.log(title[i]);
//                          var lan_id = $(this).attr('data-id');
//                        $('#porTit'+lan_id).val(title[i]);
////                        var lan_id = $(this).attr('data-id');
////                        $('.porTit' + $('#EditporId').val()).val(title[i]);
//                        i++;
//                    });
//                    
                     $('.porTit' + $('#EditporId').val()).remove();
//            $(".Title").each(function () {
////                console.log($(this).val());
//                var lan_id = $(this).attr('id').split("_");
////                $('#Row'+$('#EditporId').val()).find('#porTit' + lan_id).val($(this).val());
//            });
            var html = '';
            $(".Title").each(function () {
                var lan_id = $(this).attr('id').split("_");
                html += '<input id="porTit' + $('#EditporId').val() + '"  class="porTit' + $('#EditporId').val() + '" data-id="' + lan_id + '" type="hidden" name="FData[Portion][' + $('#EditporId').val() + '][title][]" value="' + $(this).val() + '">'
            });
            $('#Row'+$('#EditporId').val()).append(html);
//            $('#porTit' + $('#EditporId').val()).val(title);
            $('#porPric' + $('#EditporId').val()).val(price);
            $('#LabelTit' + $('#EditporId').val()).text(title);
            $('#LabelPric' + $('#EditporId').val()).text(price);
            $('#LabelDef' + $('#EditporId').val()).text(checked);
            $('#Def' + $('#EditporId').val()).val(checked);



        } else {
            //            alert();
            var id = Math.floor((Math.random() * 10000) + 1);


            var totl = '<?PHP echo $Poid; ?>';
//             alert(totl);
//        alert(count);
//            if (count > totl) {
//
//            } else {
//                count = totl;
//            }
//            if (count === '0') {
////                alert();
//                checked = 'true';
//            } else {
//                alert(checked);
//                if (checked == 'true') {
//                    alert(checked);
//                    for (ii = 0; ii < count; ii++) {
//                        $('#LabelDef' + ii).text('');
//                        $('#Def' + ii).val('');
//                    }
//                }
//
//            }
            if(checked == 'true'){
                $('.defaulttext').html('');
                $('.defaulthidden').val('');
                 for (ii = 0; ii < count; ii++) {
                        $('#LabelDef' + ii).text('');
                        $('#Def' + ii).val('');
                    }
            }
//             if (checked === 'true') {
//                for (ii = 0; ii < count; ii++) {
//                    {
//                        $('#LabelDef' + ii).text('');
//                        $('#Def' + ii).val('');
//                    }
//                }
//            }
            var html = '';
            $(".Title").each(function (){
                   var lan_id = $(this).attr('id').split("_");
                html += '<input id="porTit' + count + '" class="porTit' + count + '" data-id="' + lan_id + '" type="hidden" name="FData[Portion][' + count + '][title][]" value="' + $(this).val() + '">'
            });

            $('#PortionTable111').append('<tr id="Row' + count + '">' +
                    '<td> <label id="LabelTit' + count + '">' + title + '</label></td>' +
                    '<td> <label id="LabelPric' + count + '">' + price + '</label></td>' +
                     html +
                    '<input id="porPric' + count + '" type="hidden" name="FData[Portion][' + count + '][price]" value="' + price + '">' +
                    '<input id="porId' + count + '" type="hidden" name="FData[Portion][' + count + '][id]" value="' + id + '">' +
                    '<input id="Def' + count + '" class="defaulthidden" type="hidden" name="FData[Portion][' + count + '][Default]" value="'+ checked +'" >' +
                    '<td> <label id="LabelDef' + count + '" class="defaulttext">' + checked + '</label></td>' +
                    ' <td  class="v-align-middle">' +
                    ' <div class="btn-group">' +
                    '<a><button onclick="editMe(this);" value="' + count + '" type="button" style="color: #ffffff !important;background-color: #5bc0de;border: 1px solid #5bc0de;" class="btn btn-success"><i class="fa fa-pencil"></i>' +
                    '  </button></a>' +
                    '  <a><button type="button" onclick="DelRows(this)" id="' + count + '" class="btn btn-success" style="color: #ffffff !important;background-color: #d9534f;border: 1px solid #d9534f;"><i class="fa fa-trash-o"></i>' +
                    '   </button></a>' +
                    ' </div>' +
                    '</td></tr>');
            count++;
        }
        $('#NewCat').modal('hide');
         }

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
    function Cancel1() {
        $('#getCroppedCanvasModal').modal('hide');
        $('#ForImageCroping').modal('show');
    }

</script>

<div class="modal fade in" id="NewCat" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog modal-md" style="padding: 0% 5%;">

        <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewSubCategory" method= "post" onsubmit="return validateForm();">
            <div class="modal-content" style="padding: 0% 4%;">
                <div class="modal-header" style="padding-top: 18px;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity: initial;">&times;</button>
                    <h4 class="modal-title" id="newPortionTitle" style="display:none;">Add New Portion</h4>
                    <h4 class="modal-title" id="editPortionTitle" style="display:none;">Edit Portion</h4>
                </div>

                <div class="modal-body">
                    
                     <div id="Category_txt">
                            <div class="form-group ">
                                <label > Title (English) </label>
                                  <!--<div class="col-sm-6">-->  
                                <input type="text"  id="Title_0" name="Title[0]"  class=" Title form-control error-box-class" >
                                <h5 class="" style="margin-top:5px;font-size: 11px;color: tomato;display:none;" id="Title-Error">Please enter the title</h5>
 
                                <!--</div>-->
                             </div>
                            
                                    <?php
                                     foreach ($language as $val) {
//                                         print_r($val);
                                    ?>
                            <div class="form-group" >
                                   <label > Title (<?php echo $val['lan_name'];?>) </label>
                                   
                                 <input type="text"   id="Title_<?= $val['lan_id'] ?>" name="Title<?= $val['lan_id'] ?>"  class=" Title form-control error-box-class" >
                                 <h5 class="" style="margin-top:5px;font-size: 11px;color: tomato;display:none;" id="Title-Error">Please enter the title</h5>

                                 <!--</div>-->
                            </div>
                                  
                           <?php } ?>
                            
                               
                            
                        </div>    
                    
<!--                    <div class="form-group" >
                        <label>Title</label>
                        <input type="text" class="form-control" placeholder="Title" id="Title" name="Title">
                        <h5 class="" style="margin-top:5px;font-size: 11px;color: tomato;display:none;" id="Title-Error">Please enter the title</h5>
                    </div>-->
                    <div class="form-group" >
                        <label>Price</label>
                        <div class="input-group transparent" style="margin-bottom: 5px;">
                            <span class="input-group-addon">
                                <i><?PHP echo $this->session->userdata('fadmin')['Currency']; ?></i>
                            </span>
                            <input type="text" class="form-control" onkeypress="return validate(event)" placeholder="Price" id="Price" name="Price">
                        </div>
                        <h5 class="" style="margin-top:5px;font-size: 11px;color: tomato;display:none;" id="Price-Error">Please enter the price</h5>

<!--<input type="text" class="form-control" placeholder="Price" id="Price" name="Price">-->
                    </div>
                    <div class="form-group" >                        
                        <input type="checkbox" class="checkbox-inline"  id="Default" name="Title" style="margin:0px;"> Make this as default
                    </div>
<!--                    <input id="EditporTit" type="hidden"  value="">
                    <input id="EditporPric" type="hidden"  value="">-->
                    <input id="EditporId" type="hidden" value="">


                    <label id = "errorbox" style="color: red; font-size: 15px;"></label>

                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-danger close" data-dismiss="modal">Close</button>
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
                    <h5 style="text-align: center;color: #0090d9;font-weight: bold;">Delete </h5>
                </div>
                <div class="modal-body">
                    <h5 style="text-align: center;line-height:22px;">Are You Sure To Delete This Portion? </h5>
                </div>
                <input type='hidden' class='deletoption'>
                <div class="modal-footer">
                    <a id="deletelink"><button onclick='Delete(this);' type="button" class="btn btn-primary btn-cons inline">Continue</button></a>
                    <button type="button" class="btn btn-danger btn-cons no-margin inline" data-dismiss="modal">Cancel</button>

                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade in" id="ForImageCroping" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog" style="
         width: 750px;
         ">


        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Crop Image</h4>
            </div>

            <div class="modal-body">
                <div class="form-group" >
                    <!--<div class="container">-->
                    <div class="row"  style="height:423px;">
                        <div class="col-md-12" style="
                             height: 106%;
                             ">
                            <!-- <h3 class="page-header">Demo:</h3> -->
                            <div class="img-container" style="
                                 margin-top: 29px;
                                 ">
                                <div id="toUpload1" style="display: block; width: 825px; margin-top:-30px; overflow: hidden;">
                                    <label class="btn-upload" for="FileUpload1" title="Upload image file">
                                        <!--<input type="file"  id="FileUpload1" name="file" accept="image/*">-->
                                        <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                                            <span><a><img id="img" src="img/images (6).jpg" style= margin-top:150px; ></a></span>
                                        </span>
                                    </label>
                                </div>
                                <img id="image" src=" ">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="
                         margin-top: -114px;
                         ">
                        <div class="col-md-12 docs-buttons" style="margin-top:-2px;margin-left: 3px; ">
                            <div class="btn-group btn-group-crop">
                                <button type="button" class="btn btn-primary btn block" data-method="getCroppedCanvas">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Custom Crop Image" style="width:158px">
                                        Crop Image
                                    </span>
                                </button>
                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 60, &quot;height&quot;: 60 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 60x60">
                                        60&times;60
                                    </span>
                                </button>
                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 120, &quot;height&quot;: 120 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 120x120">
                                        120&times;120
                                    </span>
                                </button>

                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 150, &quot;height&quot;: 150 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 150x150">
                                        150&times;150
                                    </span>
                                </button>
                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 500, &quot;height&quot;: 500 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 500x500">
                                        500&times;500
                                    </span>
                                </button>
                                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" style="width:90px" data-option="{ &quot;width&quot;: 400, &quot;height&quot;: 300 }">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="save this as 400X300">
                                        400&times;300
                                    </span>
                                </button>

                            </div>

                            <!-- Show the cropped image in modal -->

                        </div>
                    </div>
                    <!--</div>-->
                </div>
            </div>

        </div>


    </div>

</div>
<div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
    <div id="dialog" class="modal-dialog">
        <div class="modal-content">
            <div id="header" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
            </div>
            <div id="prop1" class="modal-body"></div>
            <div id="prop" class="modal-footer">
                <button type="button" class="btn btn-default"  onclick='Cancel1();'>Close</button>
                <input type='hidden' id='ImageData' name='ImageData'>
                <a class="btn btn-primary" id="download" href="javascript:void(0);">Save</a>
            </div>
        </div>
    </div>
</div>

<?php $customjs = ''; ?>
