<!doctype html>
<html lang='ru'>
<head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <!-- CSS -->
    <link rel='stylesheet' href="<?=ASSETS?>/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>/css/main.css">
    <!-- JS -->
    <script src="<?=ASSETS?>/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=ASSETS?>/libs/jquery.js"></script>
    <script src="<?=ASSETS?>/js/main.js"></script>

    <? \fw\core\View::getMeta(); ?>
</head>
<body>
<!--<code>default layout</code>-->

<div class="container">
<!--    the view's content goes here-->
    <?=$content?>
</div>

<? // re-insert scripts stripped out of the view
foreach($scripts as $script){
    echo $script;
}
?>
<!-- Modals -->
<? include(__DIR__ .'/include/modals.php');?>
<!--layout footer-->
</body>
</html>
