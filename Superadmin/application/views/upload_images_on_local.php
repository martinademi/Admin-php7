<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

$servername = "/var/www/html/Taxi/";
$file_formats = array("jpg", "png", "gif", "jpeg");

$filepath = $servername.'pics/';


$name = $_FILES['myfile']['name']; // filename to get file's extension
$size = $_FILES['myfile']['size'];



if (!strlen($name)) {
    echo "Please select image..!";
    return false;
}

$ext = substr($name, strrpos($name, '.') + 1);
if (!in_array($ext, $file_formats)) {
    echo "Invalid file format.";
    return false;
}// check it if it's a valid format or not
if ($size > (2048 * 1024)) { // check it if it's bigger than 2 mb or no
    echo "Your image size is bigger than 2MB.";
    return FALSE;
}

$imagename = md5(uniqid() . time()) . "." . $ext;
$file_to_open = $filepath . $imagename;
$tmp1 = $_FILES['myfile']['tmp_name'];

try{

    $move = move_uploaded_file($tmp1, $file_to_open);
//    if (!$move) {
//
//        echo "Could not move the file.".$_SERVER['DOCUMENT_ROOT'].'/guyidee/pics';
//        return false;
//    }
}catch (Exception $ex){

    print_r($ex);
    return false;
}


//if ($_REQUEST['image_type'] == 1) {
//
//    $updateDoctorPicQry = "update master set profile_pic = '" . $imagename . "' where mas_id = '" . $_SESSION['admin_id'] . "'";
//    mysql_query($updateDoctorPicQry, $db->conn);
//
//    $location = $db->mongo->selectCollection('location');
//
//    $newdata = array('$set' => array("image" => $imagename));
//    $location->update(array("user" => (int) $_SESSION['admin_id']), $newdata);
//
//    $pic_width = 215;
//    $pic_height = 150;
//    $image_title = "Main profile picture";
//    $disPic = '../pics/xxhdpi/' . $imagename;
//    $echo = "<img id='updatedimagecss'  src=\"" . $disPic . "\" border=\"0\" title=\"$image_title\" width=\"" . $pic_width . "\" height=\"" . $pic_height . "\"/><script>$('.click_to_crop').trigger('click');</script>";
//    ;
//} else {
//
//    $pic_width = 100;
//    $pic_height = 70;
//    $image_title = "Other profile images";
//
//    $insert = "insert into images(doc_id,image)values('" . $_SESSION['admin_id'] . "','" . $imagename . "')";
//    mysql_query($insert, $db->conn);
//    $max_id = mysql_insert_id();
//
//    $id_attr = "p_id='$max_id'";
//    $disPic = '../pics/xxhdpi/' . $imagename;
//
//    $echo = '<div style="position:relative;">
//                                        <img ' . $id_attr . ' src="' . $disPic . '" border="0" width="' . $pic_width . '" height= "' . $pic_height . '"/>
//                                        <div style="position:absolute;top:0;right:0px;">
//                                            <img p_flag="0" p_id="' . $max_id . '" p_th_num="' . $max_id . '" p_src="' . $file_to_open . '" class="thumb_image" src="assets/dialog_close_button.png" height="20px" width="20px" />
//                                        </div>
//                                    </div>';
//}


list($width, $height) = getimagesize($file_to_open);

$ratio = $height / $width;



/* mdpi 36*36 */
$mdpi_nw = 36;
$mdpi_nh = $ratio * 36;

$mtmp = imagecreatetruecolor($mdpi_nw, $mdpi_nh);

if ($ext == "jpg" || $ext == "jpeg") {
    $new_image = imagecreatefromjpeg($file_to_open);
} else if ($ext == "gif") {
    $new_image = imagecreatefromgif($file_to_open);
} else if ($ext == "png") {
    $new_image = imagecreatefrompng($file_to_open);
}
imagecopyresampled($mtmp, $new_image, 0, 0, 0, 0, $mdpi_nw, $mdpi_nh, $width, $height);

$mdpi_file = $servername.'pics/mdpi/' . $imagename;

imagejpeg($mtmp, $mdpi_file, 100);

/* HDPI Image creation 55*55 */
$hdpi_nw = 55;
$hdpi_nh = $ratio * 55;

$tmp = imagecreatetruecolor($hdpi_nw, $hdpi_nh);

if ($ext == "jpg" || $ext == "jpeg") {
    $new_image = imagecreatefromjpeg($file_to_open);
} else if ($ext == "gif") {
    $new_image = imagecreatefromgif($file_to_open);
} else if ($ext == "png") {
    $new_image = imagecreatefrompng($file_to_open);
}
imagecopyresampled($tmp, $new_image, 0, 0, 0, 0, $hdpi_nw, $hdpi_nh, $width, $height);

$hdpi_file = $servername.'pics/hdpi/' . $imagename;

imagejpeg($tmp, $hdpi_file, 100);

/* XHDPI 84*84 */
$xhdpi_nw = 84;
$xhdpi_nh = $ratio * 84;

$xtmp = imagecreatetruecolor($xhdpi_nw, $xhdpi_nh);

if ($ext == "jpg" || $ext == "jpeg") {
    $new_image = imagecreatefromjpeg($file_to_open);
} else if ($ext == "gif") {
    $new_image = imagecreatefromgif($file_to_open);
} else if ($ext == "png") {
    $new_image = imagecreatefrompng($file_to_open);
}
imagecopyresampled($xtmp, $new_image, 0, 0, 0, 0, $xhdpi_nw, $xhdpi_nh, $width, $height);

$xhdpi_file = $servername.'pics/xhdpi/' . $imagename;

imagejpeg($xtmp, $xhdpi_file, 100);

/* xXHDPI 125*125 */
$xxhdpi_nw = 125;
$xxhdpi_nh = $ratio * 125;

$xxtmp = imagecreatetruecolor($xxhdpi_nw, $xxhdpi_nh);

if ($ext == "jpg" || $ext == "jpeg") {
    $new_image = imagecreatefromjpeg($file_to_open);
} else if ($ext == "gif") {
    $new_image = imagecreatefromgif($file_to_open);
} else if ($ext == "png") {
    $new_image = imagecreatefrompng($file_to_open);
}
imagecopyresampled($xxtmp, $new_image, 0, 0, 0, 0, $xxhdpi_nw, $xxhdpi_nh, $width, $height);

$xxhdpi_file = $servername.'pics/xxhdpi/' . $imagename;

imagejpeg($xxtmp, $xxhdpi_file, 100);


echo json_encode(array('msg' => '1', 'fileName' => $imagename));


//echo '<img class="preview" id="' . $max_id . '" style="width:90%" alt="" src="' . $filepath . '/' . $name . '" /><input type="button"   name="delbutton" data-dismiss="modal" aria-hidden="true" class="delbuttonnew" data1="' . $max_id . '"   style="height: 20px;width:30px;background:url(https://instagram-static.s3.amazonaws.com/bluebar/prerelease/images/shared/nav-shadow.png);"><div style="margin-top: -18px;margin-left: 12px;">&times;</div></button>';
?>