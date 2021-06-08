<?php
error_reporting(0);
?>
<link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700" rel="stylesheet">
<html>
<head>
<style>
img {
    /*padding-left: 500px;*/
    opacity: 0.2;
    filter: alpha(opacity=50);  
}

.imgList {
    color: #525252;
    font-family: 'Maven Pro', sans-serif;
    text-align:justify
}

#bdy{
    margin-left: 5%;
    margin-right: 5%;
}
div#header {
    background: #37ff80;
    font-size: 11px;
    padding: 2px;
    text-align: justify;
}
#fixed {
    position: fixed;
    left: calc(50% - 82px);
    top: calc(50% - 87px);
}
</style>
</head>
<body id="bdy" class="imgList">
    <div id='fixed'>
       <img src=" <?php echo base_url('pics/logo71.png') ?>">
    </div>

<?php
echo $desc['en'];
?>
<div>
</div>
</body>
</html>