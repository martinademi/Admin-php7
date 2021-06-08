<style>
    .overlay{
        display: none !important; 
    }
</style>
<?php
define('AjaxUrl', 'https://104.131.66.74/Grocer/Business/index.php/superadmin/');
define('ImageAjaxUrl', 'https://104.131.66.74/Grocer/Business/application/ajaxFile/');

include_once 'superadmin/header.php';
include_once 'superadmin/navigation.php';
include_once $pagename . '.php';
include_once 'superadmin/footer.php';
?>
<!--
<script>
    sessionStorage.setItem("name", "GeekChamp");
</script>
<aside class="right-side">
                 Content Header (Page header) 
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                
                <section class="content"><div class="col-xs-12">
                           
                        <h1> Here is your dashboard</h1>
                </section>
 </aside>-->




