<!doctype html>
<html lang='ru'>
<head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <!-- CSS -->
    <link rel='stylesheet' href="<?=ASSETS?>/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>/css/main.css">
    <link rel="stylesheet" href="<?=ASSETS?>/css/mistake.css">
    <!-- JS -->
    <script src="<?=ASSETS?>/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=ASSETS?>/libs/jquery.js"></script>
    <script src="<?=ASSETS?>/js/main.js"></script>

    <? \fw\core\View::getMeta(); ?>
</head>
<body>
<!--<code>mistakes layout</code>-->

<div class="container">

<!--    the view's content goes here-->
    <?=$content?>
    <div class="bottom_menu">
        <? include(__DIR__ .'/include/mistakes/bottom-menu.php');?>
    </div>
</div>

<? // re-insert scripts stripped out of the view
foreach($scripts as $script){
    echo $script;
}
?>
<!--layout footer-->


<div>
    <a type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#add-mistake'>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus'
             viewBox='0 0 16 16'>
            <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'></path>
        </svg>
    </a>
</div>


<div class='modal fade' id='add-mistake' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'
     aria-labelledby='add-mistakeLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='result'></div>
            hello world
        </div>
    </div>
</div>

</body>
</html>
