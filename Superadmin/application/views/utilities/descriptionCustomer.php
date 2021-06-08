<script>
    
    
    
    </script>
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
    left: calc(50% - 150px);
    top: calc(50% - 150px);
}
</style>
</head>
<body id="bdy" class="imgList">
    <div id='fixed'>
        <img src="<?php echo base_url()?>pics/spinner.gif">
    </div>
<!--    <div id="header">
        <h1>HELP & SUPPORT</h1>
    </div>-->
<?php

foreach($desc['desc'] as $data){
    echo $data;
    
}


?>
<div>
<!--    <img src="https://neu1-api.asm.skype.com/v1/objects/0-neu-d3-1f27e4a0d2823f227f1658ecba3be084/views/imgpsh_fullsize" style="width:300px;opacity:0.5;" id="image">   -->
</div>
</body>
</html>