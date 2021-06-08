var for_what = 'global variable';
var UrlId = 0;
$(function () {

    $('#image').hide();
    $('#FileUpload1').change(function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img').hide();
            $('#image').show();
            $('#FileUpload1').hide();
            for_what = '1';
            $('#ForImageCroping').modal('show');
            $('#image').attr("src", e.target.result);

        }
        reader.readAsDataURL($(this)[0].files[0]);
    });
    $('#FileUpload2').change(function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img').hide();
            $('#image').show();
            $('#FileUpload2').hide();
            for_what = '2';
            $('#ForImageCroping').modal('show');
            $('#image').attr("src", e.target.result);
        }
        reader.readAsDataURL($(this)[0].files[0]);
    });
    $('#FileUpload3').change(function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img').hide();
            $('#image').show();
            $('#FileUpload3').hide();
            for_what = '3';
            $('#ForImageCroping').modal('show');
            $('#image').attr("src", e.target.result);
        }
        reader.readAsDataURL($(this)[0].files[0]);
    });
    $('#FileUpload4').change(function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img').hide();
            $('#image').show();
            $('#FileUpload3').hide();
            for_what = '4';
            $('#ForImageCroping').modal('show');
            $('#image').attr("src", e.target.result);
        }
        reader.readAsDataURL($(this)[0].files[0]);
    });
    $('#FileUpload5').change(function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img').hide();
            $('#image').show();
            $('#FileUpload3').hide();
            for_what = '5';
            $('#ForImageCroping').modal('show');
            $('#image').attr("src", e.target.result);
        }
        reader.readAsDataURL($(this)[0].files[0]);
    });
});

$('#image').on('load', function () {

    'use strict';

    var console = window.console || {log: function () {}};
    var $image = $('#image');
    var $download = $('#download');
    var $dataX = $('#dataX');
    var $dataY = $('#dataY');
    var $dataHeight = $('#dataHeight');
    var $dataWidth = $('#dataWidth');
    var $dataRotate = $('#dataRotate');
    var $dataScaleX = $('#dataScaleX');
    var $dataScaleY = $('#dataScaleY');
    var options = {
        aspectRatio: 1 / 1,
        preview: '.img-preview',
        crop: function (e) {
            $dataX.val(Math.round(e.x));
            $dataY.val(Math.round(e.y));
            $dataHeight.val(Math.round(e.height));
            $dataWidth.val(Math.round(e.width));
            $dataRotate.val(e.rotate);
            $dataScaleX.val(e.scaleX);
            $dataScaleY.val(e.scaleY);
        }
    };
    function saveimg()
    {
        var data1 = $("#imgCropped").val();
        var data2 = $("#imgCropped2").val();
    }
    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();


    // Cropper
    $image.on({
        'build.cropper': function (e) {
            console.log(e.type);
        },
        'built.cropper': function (e) {
            console.log(e.type);
        },
        'cropstart.cropper': function (e) {
            console.log(e.type, e.action);
        },
        'cropmove.cropper': function (e) {
            console.log(e.type, e.action);
        },
        'cropend.cropper': function (e) {
            console.log(e.type, e.action);

        },
        'crop.cropper': function (e) {
            console.log(e.type, e.x, e.y, e.width, e.height, e.rotate, e.scaleX, e.scaleY);
        },
        'zoom.cropper': function (e) {
            console.log(e.type, e.ratio);
        }
    }).cropper(options);


    // Buttons
    if (!$.isFunction(document.createElement('canvas').getContext)) {
        $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
    }

    if (typeof document.createElement('cropper').style.transition === 'undefined') {
        $('button[data-method="rotate"]').prop('disabled', true);
        $('button[data-method="scale"]').prop('disabled', true);
    }


    // Download
    if (typeof $download[0].download === 'undefined') {
        $download.addClass('disabled');
    }


    // Options
    $('.docs-toggles').on('change', 'input', function () {
        var $this = $(this);
        var name = $this.attr('name');
        var type = $this.prop('type');
        var cropBoxData;
        var canvasData;

        if (!$image.data('cropper')) {
            return;
        }

        if (type === 'checkbox') {
            options[name] = $this.prop('checked');
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');

            options.built = function () {
                $image.cropper('setCropBoxData', cropBoxData);
                $image.cropper('setCanvasData', canvasData);
            };
        } else if (type === 'radio') {
            alert(for_what);
            alert($this.val());
            if (for_what === '2') {
                options[name] = '1.7777777777777777';
            } else {
                options[name] = '1';
            }

        }

        $image.cropper('destroy').cropper(options);
    });

    if (for_what === '2') {
        options['aspectRatio'] = '1.7777777777777777';
        $image.cropper('destroy').cropper(options);
    } else {
        options['aspectRatio'] = '1';
        $image.cropper('destroy').cropper(options);
    }

    // Methods
    $('.docs-buttons').on('click', '[data-method]', function () {
//         alert('here');
        var $this = $(this);
        var data = $this.data();
        var $target;
        var result;


        if ($this.prop('disabled') || $this.hasClass('disabled')) {
            return;
        }
//        alert('here');

        if ($image.data('cropper') && data.method) {
            data = $.extend({}, data); // Clone a new one
            if (typeof data.target !== 'undefined') {
                $target = $(data.target);

                if (typeof data.option === 'undefined') {
                    try {
                        data.option = JSON.parse($target.val());
                    } catch (e) {
                        console.log(e.message);
                    }
                }
            }

            result = $image.cropper(data.method, data.option, data.secondOption);

            switch (data.method) {
                case 'scaleX':
                case 'scaleY':
                    $(this).data('option', -data.option);
                    break;

                case 'getCroppedCanvas':
                    if (result) {
                        console.log(result);
                        $('#ForImageCroping').modal('hide');
                        // Bootstrap's Modal
                        $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                        if (!$download.hasClass('disabled')) {
                            // $download.attr('href', result.toDataURL('image/jpeg'));
                            $('#ImageData').val(result.toDataURL('image/jpeg'));
                        }
                    }

                    break;
            }

            if ($.isPlainObject(result) && $target) {
                try {
                    $target.val(JSON.stringify(result));
                } catch (e) {
                    console.log(e.message);
                }
            }

        }
    });


    // Keyboard
    $(document.body).on('keydown', function (e) {

        if (!$image.data('cropper') || this.scrollTop > 300) {
            return;
        }

        switch (e.which) {
            case 37:
                e.preventDefault();
                $image.cropper('move', -1, 0);
                break;

            case 38:
                e.preventDefault();
                $image.cropper('move', 0, -1);
                break;

            case 39:
                e.preventDefault();
                $image.cropper('move', 1, 0);
                break;

            case 40:
                e.preventDefault();
                $image.cropper('move', 0, 1);
                break;
        }

    });


    // Import image
    var $inputImage = $('#inputImage');
    var URL = window.URL || window.webkitURL;
    var blobURL;

    if (URL) {
        $inputImage.change(function () {
            var files = this.files;
            var file;

            if (!$image.data('cropper')) {
                return;
            }

            if (files && files.length) {
                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    blobURL = URL.createObjectURL(file);
                    $image.one('built.cropper', function () {

                        // Revoke when load complete
                        URL.revokeObjectURL(blobURL);
                    }).cropper('reset').cropper('replace', blobURL);
                    $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }

//    myWindow.resizeTo(250, 250);
});
$('#download').click(function () {
    var base64Value = $('#ImageData').val();
    $.ajax({
        ///var/www/html/iDeliver/Business/application/ajaxFile
        url: "http://104.131.66.74/Menuse/Business/application/ajaxFile/Upload_images.php",
        data: {data: base64Value},
        type: 'POST',
        dataType: "JSON",
        success: function (result) {
//            alert(for_what);
//            alert(result.flag);
            if (result.flag === '0') {
                if (for_what === '1') {
                    imgUrl = result.fileName;
                    $('.Masterimageurl').val(imgUrl);
                    $('#MainImageUrl').attr('src', imgUrl);
                    $('#getCroppedCanvasModal').modal('hide');
                } else if (for_what === '2') {
                    imgUrl = result.fileName;
                    $('.Bnnerimageurl').val(imgUrl);
                    $('#BannerImageUrl').attr('src', imgUrl);
                    $('#getCroppedCanvasModal').modal('hide');
                } else if (for_what === '3' || for_what === '5') {
//                    alert('i am here');
                    var imageid = $('#imageId').val();
                    if (imageid === '0') {

                    } else {
                        UrlId = imageid;
                    }
                    imgUrl = result.fileName;
                    $("#MultipleImages").append('<div class="col-md-2" id="Img' + UrlId + '"><input type = "hidden" id = "imagee" name = "FData[Images][' + UrlId + '][Url]" value = "' + imgUrl + '"><img src="' + imgUrl + '" alt="image 1" style="width: 100%;height: 160px;"><div style="position:absolute;top:0;right:-8px; cursor:pointer;"><a onclick="delete1(this)" id="' + UrlId + '"  value="" ><img  class="thumb_image" src="http://54.174.164.30/Tebse/dialog_close_button.png" height="20px" width="20px" /></a></div><div class="col-md-5"></div><div class="col-md-6"><input type="checkbox" name="FData[Images][' + UrlId + '][check]"></div>');
                    UrlId++;
                    $('#imageId').val(UrlId);
                    $('#getCroppedCanvasModal').modal('hide');
                } else if (for_what === '4') {
//                    alert('i am here bro');
                    imgUrl = result.fileName;
                    $('.Masterimageurl').val(imgUrl);
                    $('.masterImageHeight').val(result.Height);
                    $('.masterImageWidth').val(result.Width);
                    $('#MainImageUrl').attr('src', imgUrl);
                    $('#getCroppedCanvasModal').modal('hide');
                }
            } else {
                alert('Oops..! Problem in uploading image, please try again later.');
            }
//            alert(result.flag);
//            alert("Your Image is succesfully saved in : \n\n" + result);
//            $('#dialog').hide();
//            window.location.reload(true);
        },
        failure: function () {
            alert("Create path to save your Images");
        }
    });

});