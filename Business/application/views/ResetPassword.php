<style>
    .overlay{
        display: none !important; 
    }
</style>
<?php
define('AjaxUrl', 'http://54.174.164.30/Tebse/Business/index.php/Admin/');
define('ImageAjaxUrl', 'http://54.174.164.30/Tebse/Business/application/ajaxFile/');

include_once 'admin/header1.php';
//include_once 'admin/navigation.php';
include_once $pagename . '.php';
include_once 'admin/footer.php';
?>



