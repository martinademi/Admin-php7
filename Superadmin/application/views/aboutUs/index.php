<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>
<style>
    .btn {
        font-size: 11px;
        width: 113px;
    }
</style>

<script>
    function uploadImage(formElement, id, imageId, hiddenId,folderName) {
        console.log("id===",id,"imageId==",imageId);
        var form_data = new FormData();
        form_data.append("OtherPhoto", formElement)
        form_data.append('type', 'uploadImage');
        form_data.append('Image', 'Image');
        form_data.append('folder', folderName);
        $.ajax({
            url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
            type: "POST",
            data: form_data,
            dataType: "JSON",
            beforeSend: function () {

            },
            success: function (response) {
                if (response.msg == '1') {
                    console.log(response.fileName);
                    $(imageId + id).attr('src', response.fileName);
                    $(hiddenId + id).val(response.fileName);
                }
            },
            error: function () {

            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
</script>
<script>
    var ques = 0;
    var visi = 0;
    var inv = 0;
    function getData() {
       console.log(visi);
        $.ajax({
            url: "<?php echo base_url(); ?>index.php?/websitePages/getAboutUsData",
            type: "POST",
            dataType: 'json',
            success: function (result) {
                console.log("==========")
                console.log(result);
                for (var i = 0; i < result.question.length; i++) {
                    var divquestion = '<div class="form-group">' +
                            '<label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo "Title"; ?></label>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="col-sm-12">' +
                            '<input type="text" name="title' + ques + '" id="title' + ques + '" values="' + result.question[0]['title'] + '" class="form-control error-box-class" placeholder="">' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                            ' <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo "Question "; ?></label>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<div class="col-sm-12">' +
                            '<textarea value="' + result.question[0]['description'] + '" name="description' + ques + '" id="description' + ques + '"></textarea>'
                            + '</div>' +
                            '</div>' +
                            '</div>';
//                    console.log(result.question[0]['title']);
                    $('.questionsAdd').append(divquestion);
                    $("#description" + ques).val(result.question[i]['description']);
                    $("#title" + ques).val(result.question[i]['title']);
                    CKEDITOR.replace("description" + ques);
                    ques++;
                }
                for (var i = 0; i < result.visinor.length; i++) {
                    var divVisinor = '<br><br>' +
                            '<div class="form-group">' +
                            '<div class="imagesField row">' +
                            '   <div class="form-group pos_relative2">' +
                            '      <label id="td1" for="fname" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Member Image" ?>  <span style="" class="MandatoryMarker">   </span></label>' +
                            '     <div class="col-sm-6">' +
//                    '        <input type="file" attribut="' + visi + '" attribute_id="' + visi + '" name="imageupload"' + visi + '" id="imageupload" class="error - box - class form - control imagesProduct"  data-attribute="job0" id="jobImages" attrId="0" value="Text Element 1">' +
                            '<input type="file" attribute_id="' + inv + '" name="imageupload"  id="imageupload" class="error-box-class form-control imageuploadclass"  data-attribute="job0" id="jobImages" attrId="0" value="Text Element 1">' +
                            '   </div>' +
                            '  <div class="col-sm-2">' +
                            '     <img style="width:35px;" id="showjob' + visi + '" name="showjob' + visi + '" src="<?= defaultImage ?>" class="onImageAWS style_prevu_kit">' +
                            '</div>' +
                            '<div class="col-sm-3 error-box" id="text_images1"></div>    ' +
                            '   <input type="hidden" id="jobimages' + visi + '" attribut="' + visi + '" name="jobimages' + visi + '"/>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group pos_relative2">' +
                            '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Member name"; ?></label>' +
                            '  <div class="col-sm-6">' +
                            '     <input type="text" name="visinorText' + visi + '"  id="visinorText' + visi + '" class="form-control error-box-class" placeholder="">' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group pos_relative2">' +
                            '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "facebook link"; ?></label>' +
                            '  <div class="col-sm-6">' +
                            '     <input type="text" name="visinorFacebook' + visi + '"  id="visinorFacebook' + visi + '" class="form-control error-box-class" placeholder="">' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group pos_relative2">' +
                            '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "linkedin link"; ?></label>' +
                            '  <div class="col-sm-6">' +
                            '     <input type="text" name="visinorLinkedin' + visi + '"  id="visinorLinkedin' + visi + '" class="form-control error-box-class" placeholder="">' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group pos_relative2">' +
                            '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "twitter link"; ?></label>' +
                            '  <div class="col-sm-6">' +
                            '     <input type="text" name="visinorTwitter' + visi + '"  id="visinorTwitter' + visi + '" class="form-control error-box-class" placeholder="">' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group pos_relative2">' +
                            '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Designation"; ?></label>' +
                            '  <div class="col-sm-6">' +
                            '     <input type="text" name="visinorDesig' + visi + '" id="visinorDesig' + visi + '"  class="form-control error-box-class" placeholder="">' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group pos_relative2">' +
                            '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "About"; ?></label>' +
                            '  <div class="col-sm-6">' +
                            ' <textarea name="visinorDescr' + visi + '" id="visinorDescr' + visi + '" style="width: 100%;max-width:100%;height: 37%;"></textarea>' +
                            '</div>' +
                            '</div>';
                    $('.visionor').append(divVisinor);
                    $("#visinorText" + visi).val(result.visinor[i]['visinorName']);
                    $("#visinorDesig" + visi).val(result.visinor[i]['visinorDesignation']);
                    $("#visinorFacebook" + visi).val(result.visinor[i]['visinorFacebook']);
                    $("#visinorLinkedin" + visi).val(result.visinor[i]['visinorLinkedin']);
                    $("#visinorTwitter" + visi).val(result.visinor[i]['visinorTwitter']);
                    $("#visinorDescr" + visi).val(result.visinor[i]['visinorDescription']);
                    $("#showjob" + visi).attr("src", result.visinor[i]['visinorImages']? result.visinor[i]['visinorImages'] : "<?= defaultImage ?>");
                    visi++;
                    inv++;

                    console.log(visi);
                }
                for (var i = 0; i < result.investor.length; i++) {
                    var divInvestor = '<br><br>' +
                            '<div class="form-group">' +
                            '<div class="imagesField row">' +
                            '   <div class="form-group pos_relative2">' +//admin.instacart-clone.com/pics/user.jpg
                            '      <label id="td1" for="fname" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Investor Image" ?>  <span style="" class="MandatoryMarker">   </span></label>' +
                            '     <div class="col-sm-6">' +
                            '        <input type="file" attribute_id="' + inv + '" name="imageuploadInv" id="imageuploadInv" class="error-box-class form-control imageuploadInvClass1"  data-attribute="job0" id="jobImages" attrId="0" value="Text Element 1">' +
                            '   </div>' +
                            '  <div class="col-sm-2">' +
                            '     <img style="width:35px;" id="showjobInv' + inv + '" src="<?= defaultImage ?>" alt="" class="onImageAWS style_prevu_kit">' +
                            '</div>' +
                            '<div class="col-sm-3 error-box" id="text_images1"></div>    ' +
                            '   <input type="hidden" attribut="' + inv + '" id="jobimagesInv' + inv + '"  name="jobimagesInv' + inv + '"/>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group pos_relative2">' +
                            '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Name of investor"; ?></label>' +
                            '  <div class="col-sm-6">' +
                            '     <input type="text" name="investorText' + inv + '" id="investorText' + inv + '" class="form-control error-box-class" placeholder="">' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group pos_relative2">' +
                            '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Designation"; ?></label>' +
                            '  <div class="col-sm-6">' +
                            '     <input type="text" name="investorDesig' + inv + '" id="investorDesig' + inv + '"  class="form-control error-box-class" placeholder="">' +
                            '</div>' +
                            '</div>' +
                            '<div class="form-group pos_relative2">' +
                            '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Description"; ?></label>' +
                            '  <div class="col-sm-6">' +
                            ' <textarea name="investorDescr' + inv + '" id="investorDescr' + inv + '" style="width: 100%;max-width:100%;height: 37%;"></textarea>' +
                            '</div>' +
                            '</div>';
                    $('.investor').append(divInvestor);
                    $("#investorText" + inv).val(result.investor[i]['investorName']);
                    $("#investorDesig" + inv).val(result.investor[i]['investorDesignation']);
                    $("#investorDescr" + inv).val(result.investor[i]['investorDescription']);
                    $("#showjobInv" + inv).attr("src", result.investor[i]['investorImages'] ? result.investor[i]['investorImages'] : "<?= defaultImage ?>");
                    inv++;
                }

            }
        });
    }
    $(document).ready(function () {
        getData();
        $(document).on('change', '.imageuploadclass', function () {
            // console.log("attId", this);
            var id = $(this).attr('attribute_id');
            // var files = $('.imageuploadclass')[0].files[0];
            // console.log("attId", files);
            // var formElement = $(".imageuploadclass").prop("files")[0];
            var formElement = $(this).prop("files")[0];
            // console.log("attId", formElement);
            uploadImage(formElement, id, "#showjob", "#jobimages",'teamMember');
        });
        $(document).on('change', '.imageuploadInvClass1', function () {
            // console.log("attId", this);
            var id = $(this).attr('attribute_id');
            var formElement = $(".imageuploadInvClass1").prop("files")[0];
            // console.log("attId111", formElement);
            uploadImage(formElement, id, "#showjobInv", "#jobimagesInv",'investor');
//            console.log("attId", this);
//            var id = $(this).attr('attribute_id');
//            console.log('id',id);
//            var formElementData = $(".imageuploadInvClass").prop("files")[0];
//            console.log("attId", formElementData);
//            uploadImage(formElementData, id, "#showjobInv", "#jobimagesInv");
////            $("#imageuploadInv").val(null);

        });
        $('#update').click(function () {
            var questionArray = [];
            var visinorArray = [];
            var investorArray = [];
            for (var i = 0; i < ques; i++)
            {
                item = {};
                item ["title"] = $('#title' + i).val();
                item ["description"] = CKEDITOR.instances['description' + i].getData();
                if (item['title'] != "" && item['description'] != "") {
                    questionArray.push(item);
                }
            }
            for (var i = 0; i < visi; i++)
            {
                item = {};
                item ["visinorImages"] = $('#showjob' + i).attr("src");
                item ["visinorName"] = $('#visinorText' + i).val();
                item ["visinorDesignation"] = $('#visinorDesig' + i).val();
                item ["visinorFacebook"] = $('#visinorFacebook' + i).val();
                item ["visinorLinkedin"] = $('#visinorLinkedin' + i).val();
                item ["visinorTwitter"] = $('#visinorTwitter' + i).val();
                item ["visinorDescription"] = $('#visinorDescr' + i).val();
                if (item['visinorName'] && item['visinorDesignation'] && item['visinorDescription']) {
                    visinorArray.push(item);
                }
            }
            for (var i = 0; i < inv; i++)
            {
                item = {};
                item ["investorImages"] = $('#showjobInv' + i).attr("src");
                item ["investorName"] = $('#investorText' + i).val();
                item ["investorDesignation"] = $('#investorDesig' + i).val();
                item ["investorDescription"] = $('#investorDescr' + i).val();
                if (item['investorName'] && item['investorDesignation'] && item['investorDescription']) {
                    investorArray.push(item);
                }
            }
            console.log("question array", questionArray);
            console.log("visinor array", visinorArray);
            console.log("Investor array", investorArray);
//             action="<?php echo base_url(); ?>index.php?/websitePages/updateAboutUs
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/websitePages/updateAboutUs",
                type: "POST",
                data: {question: questionArray, visinor: visinorArray, investor: investorArray},
                dataType: 'json',
                success: function (result) {
//                    console.log(result);
                    alert("Updated successfully");
                }
            });
        });
        $('#btAddques').click(function () {
            var divquestion = '<div class="form-group">' +
                    '<label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo "Title"; ?></label>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<div class="col-sm-12">' +
                    '<input type="text" name="title' + ques + '" id="title' + ques + '" class="form-control error-box-class" placeholder="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                    ' <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo "Question "; ?></label>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<div class="col-sm-12">' +
                    '<textarea name="description' + ques + '" id="description' + ques + '"></textarea>'
                    + '</div>' +
                    '</div>' +
                    '</div>';
            console.log("qes", ques);
            console.log(divquestion);
            $('.questionsAdd').append(divquestion);
            CKEDITOR.replace("description" + ques);
            ques++;
        });
        $('#btAddVisionor').click(function () {
            console.log(visi);
            var divVisinor = '<br><br>' +
                    '<div class="form-group">' +
                    '<div class="imagesField row">' +
                    '   <div class="form-group pos_relative2">' +
                    '      <label id="td1" for="fname" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Member Image" ?>  <span style="" class="MandatoryMarker">   </span></label>' +
                    '     <div class="col-sm-6">' +
//                    '        <input type="file" attribut="' + visi + '" attribute_id="' + visi + '" name="imageupload"' + visi + '" id="imageupload" class="error - box - class form - control imagesProduct"  data-attribute="job0" id="jobImages" attrId="0" value="Text Element 1">' +
                    '<input type="file" attribute_id="' + inv + '" name="imageupload"  id="imageupload" class="error-box-class form-control imageuploadclass"  data-attribute="job0" id="jobImages" attrId="0" value="Text Element 1">' +
                    '   </div>' +
                    '  <div class="col-sm-2">' +
                    '     <img style="width:35px;" id="showjob' + visi + '" name="showjob' + visi + '" src="<?= defaultImage ?>" onerror="src=<?= defaultImage ?>"  class="onImageAWS style_prevu_kit">' +
                    '</div>' +
                    '<div class="col-sm-3 error-box" id="text_images1"></div>    ' +
                    '   <input type="hidden" id="jobimages' + visi + '" attribut="' + visi + '" name="jobimages' + visi + '"/>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group pos_relative2">' +
                    '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Member name"; ?></label>' +
                    '  <div class="col-sm-6">' +
                    '     <input type="text" name="visinorText' + visi + '"  id="visinorText' + visi + '" class="form-control error-box-class" placeholder="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group pos_relative2">' +
                    '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "facebook link"; ?></label>' +
                    '  <div class="col-sm-6">' +
                    '     <input type="text" name="visinorFacebook' + visi + '"  id="visinorFacebook' + visi + '" class="form-control error-box-class" placeholder="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group pos_relative2">' +
                    '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "linkedin link"; ?></label>' +
                    '  <div class="col-sm-6">' +
                    '     <input type="text" name="visinorLinkedin' + visi + '"  id="visinorLinkedin' + visi + '" class="form-control error-box-class" placeholder="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group pos_relative2">' +
                    '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "twitter link"; ?></label>' +
                    '  <div class="col-sm-6">' +
                    '     <input type="text" name="visinorTwitter' + visi + '"  id="visinorTwitter' + visi + '" class="form-control error-box-class" placeholder="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group pos_relative2">' +
                    '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Designation"; ?></label>' +
                    '  <div class="col-sm-6">' +
                    '     <input type="text" name="visinorDesig' + visi + '" id="visinorDesig' + visi + '"  class="form-control error-box-class" placeholder="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group pos_relative2">' +
                    '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "About"; ?></label>' +
                    '  <div class="col-sm-6">' +
                    ' <textarea name="visinorDescr' + visi + '" id="visinorDescr' + visi + '" style="width: 100%;max-width:100%;height: 37%;"></textarea>' +
                    '</div>' +
                    '</div>';
            $('.visionor').append(divVisinor);
            visi++;
        });
        $('#btAddInvestor').click(function () {
            var divInvestor = '<br><br>' +
                    '<div class="form-group">' +
                    '<div class="imagesField row">' +
                    '   <div class="form-group pos_relative2">' +
                    '      <label id="td1" for="fname" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Investor Image" ?>  <span style="" class="MandatoryMarker">   </span></label>' +
                    '     <div class="col-sm-6">' +
                    '        <input type="file" attribute_id="' + inv + '" name="imageuploadInv" id="imageuploadInv" class="error-box-class form-control imageuploadInvClass1"  data-attribute="job0" id="jobImages" attrId="0" value="Text Element 1">' +
                    '   </div>' +
                    '  <div class="col-sm-2">' +
                    '     <img style="width:35px;" id="showjobInv' + inv + '" src="<?= defaultImage ?>" alt="" class="onImageAWS style_prevu_kit">' +
                    '</div>' +
                    '<div class="col-sm-3 error-box" id="text_images1"></div>    ' +
                    '   <input type="hidden" attribut="' + inv + '" id="jobimagesInv' + inv + '"  name="jobimagesInv' + inv + '"/>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group pos_relative2">' +
                    '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Name of investor"; ?></label>' +
                    '  <div class="col-sm-6">' +
                    '     <input type="text" name="investorText' + inv + '" id="investorText' + inv + '" class="form-control error-box-class" placeholder="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group pos_relative2">' +
                    '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Designation"; ?></label>' +
                    '  <div class="col-sm-6">' +
                    '     <input type="text" name="investorDesig' + inv + '" id="investorDesig' + inv + '"  class="form-control error-box-class" placeholder="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group pos_relative2">' +
                    '   <label for="" class="col-sm-2 control-label" style="color: #0090d9;"><?php echo "Description"; ?></label>' +
                    '  <div class="col-sm-6">' +
                    ' <textarea name="investorDescr' + inv + '" id="investorDescr' + inv + '" style="width: 100%;max-width:100%;height: 37%;"></textarea>' +
                    '</div>' +
                    '</div>';
            $('.investor').append(divInvestor);
            inv++;
        });
    }
    );</script>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;

             color: gray;
             margin-left: 30px;padding-top: 20px;">

            <strong style="color:#0090d9;"><?php echo "About us"; ?></strong>
        </div>
        <div class="">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                </div>
                                &nbsp;
                                <div class="panel-body">
                                    <div class="form-group col-md-1"></div>

                                    <div class="col-md-9" style="border-style:solid;padding:20px;">
                                        <form id="updateForm" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/websitePages/updateAboutUs"  enctype="multipart/form-data"> 

                                            <div class="brand inline" style="  width: auto;color: gray;margin-left: 30px;padding-top: 20px;">
                                                <strong style="color:#0090d9;"><?php echo "Add question"; ?></strong>
                                            </div>
                                            <div style="border-style:solid;padding:10px;">
                                                <div class="form-group">
                                                    <label for="fname" class="col-sm-2 control-label"> <button type="button" id="btAddques" class="btn btn-default marginSet btn-primary">
                                                            <span class="">+ Add Content</span>
                                                        </button><span style="" class="MandatoryMarker"> </span></label>
                                                    <div class="col-sm-6">
                                                    </div>
                                                    <div class="col-sm-3 error-box" id=""></div>
                                                </div>
                                                <div class="questionsAdd">
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="brand inline" style="  width: auto;color: gray;margin-left: 30px;padding-top: 20px;">
                                                <strong style="color:#0090d9;"><?php echo "Add team Members"; ?></strong>
                                            </div>
                                            <div style="border-style:solid;padding:10px;">

                                                <div class="form-group">
                                                    <label for="fname" class="col-sm-2 control-label"> <button type="button" id="btAddVisionor" class="btn btn-default marginSet btn-primary">
                                                            <span class="">+ Add Members</span>
                                                        </button><span style="" class="MandatoryMarker"> </span></label>
                                                    <div class="col-sm-6">
                                                    </div>
                                                    <div class="col-sm-3 error-box" id=""></div>
                                                </div>
                                                <div class="visionor" >

                                                </div>
                                            </div>

                                            <hr>
                                            <div class="brand inline" style="  width: auto;color: gray;margin-left: 30px;padding-top: 20px;">
                                                <strong style="color:#0090d9;"><?php echo "Add Investor"; ?></strong>
                                            </div>
                                            <div style="border-style:solid;padding:10px;">

                                                <div class="form-group">
                                                    <label for="fname" class="col-sm-2 control-label"> <button type="button" id="btAddInvestor" class="btn btn-default marginSet btn-primary">
                                                            <span class="">+ Add investor</span>
                                                        </button><span style="" class="MandatoryMarker"> </span></label>
                                                    <div class="col-sm-6">
                                                    </div>
                                                    <div class="col-sm-3 error-box" id=""></div>
                                                </div>
                                                <div class="investor" >                                                   
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-4 cls111">
                                                <button type="button" class="btn btn-success" id="update" style="position:fixed;"><?php echo "Update"; ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
