<?php
// pages that get a preloader
$url = rtrim($_SERVER['REQUEST_URI'], '/');
$preloader = false;
if($url == "/dictionary/list" || $url == "/cards/view" || stripos($url, 'cards/cloudList') !== false)
    $preloader = true;

// pages that show the global search bar
$searchline_on = [
    "/cards",
    "/cards/list",
];

$searchline_flag = false;
if(isset($settings->searchline) && $settings->searchline)
    $searchline_flag = true;

use fw\libs\Helper;
// requires the user to be logged in
Helper::needAuth();
?>
<!doctype html>
<html lang='ru'>
<head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <!-- CSS -->
    <link rel='stylesheet' href="<?=ASSETS?>/libs/bootstrap/css/bootstrap.min.css">
    <link rel='stylesheet' href='<?=ASSETS?>/css/right-nav-style.css'>
    <link rel="stylesheet" href="<?=ASSETS?>/css/main.css">
    <link rel="stylesheet" href="<?=ASSETS?>/css/anki.css">
    <!-- JS -->
    <script src="<?=ASSETS?>/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=ASSETS?>/libs/jquery.js"></script>
    <script src="<?=ASSETS?>/js/main.js"></script>

    <? \fw\core\View::getMeta(); ?>
    <?if($preloader):?>
    <style>
        /*Прелоадер*/
        .preloader{
            position: fixed;
            background-color: #fefefe;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
        }
        .preloader > div{
            position: relative;
            left: 50%;
            top: 50vh;
            margin: -100px 0 0 -100px;
        }
        .preloader i{
            font-size: 200px;
            color: #ccc;
        }
        /*Прелоадер*/
    </style>
    <?endif;?>
</head>
<!--anki.php-->
<body>
<!--Hidden checkbox that toggles the side panel-->
<input type='checkbox' id='nav-toggle' hidden>
<!--The slide-out panel-->
<? include(__DIR__ .'/include/anki/nav.php');?>
<?if($preloader):?>
<!--preloader-->
<div class='preloader'>
    <div>
        <img src='<?=ASSETS?>/img/clock.svg' alt=''>
    </div>
</div>
<?endif;?>

<div class="container">
    <div class='main-wrapp'>
    <div class="row">
        <div class="content" style="overflow-y: auto">

            <? if($searchline_flag && in_array(rtrim($url, "/"), $searchline_on)): ?>
                <!--Global search input-->
            <div class='container-search line' style=''>
                <div class='search-wrap' style='' data-word=''>
                    <input type='search' class='form-control ds-input ' style='width:100%;' id='search-input'
                           placeholder='найти..'>
                </div>
                <div class='search-request' style=""></div>

            </div>

            <? endif; ?>

                <!--    the view's content goes here-->
                <?=$content?>


        </div>
    </div>


    <!--gorizontal menu-->
    <?if($url !== "/cards/cloud" && $url !== '/cards/add' && $url !== '/cards/list'):?>
        <? include(APP.'/views/cards/include/bottom_menu.php');?>
    <? endif; ?>

    </div>
</div> <!--container-->

<? // re-insert scripts stripped out of the view
foreach($scripts as $script){
    echo $script;
}
?>

<!-- Modals -->
<? include(__DIR__ .'/include/anki/modals.php');?>
<!--layout footer-->
<?if($preloader):?>
<script>
    $(window).on('load', function(){
        $('.preloader').delay(1000).fadeOut('slow');
    });
</script>
<?endif;?>

<script>
    // opens a dictionary word for editing while studying
    $('.item-dictionary').on('click', function (){
        // grab the data
        let id =$(this).data('id');
        let tough = $(this).data('tough');
        let word = $(this).text();
        let pronounce = $(this).closest('.parent').find('.item-pronounce').text();
        let meaning = $(this).closest('.parent').find('.item-meaning').text();
        let definition = $(this).closest('.parent').find('.item-definition').text();
        // fills in the popup form
        let form = $('form.word-edit');
        // first clear the checkbox state
        //form.find('input[name=tough_selection]').prop('checked', false);

        form.find('input[name=id]').val(id);
        form.find('input[name=word]').val($.trim(word));
        form.find('input[name=pronounce]').val($.trim(pronounce));
        form.find('input[name=meaning]').val($.trim(meaning));
        form.find('input[name=tough_selection]').val($.trim(tough));
        let trigger = form.closest('form').find('.trigger-tough');
        if(tough == 1) trigger.removeClass('btn-outline-secondary').addClass('btn-primary');
        else trigger.removeClass('btn-primary').addClass('btn-outline-secondary');
        if(definition) form.find('textarea[name=definition]').val($.trim(definition));
    });

    $('.trigger-tough').on('click', function(e){
        e.stopPropagation();
        let item = $(this);
        let input = item.closest('form').find('input[name=tough_selection]');
        if(item.hasClass('btn-primary')){
            item.removeClass('btn-primary').addClass('btn-outline-secondary');
            input.val(0);

        } else{
            item.removeClass('btn-outline-secondary').addClass('btn-primary');
            input.val(1);
        }
    });
</script>


<? if ($searchline_flag && in_array(rtrim($url, '/'), $searchline_on)): ?>
    <!--global search script-->
    <script>

        $(document).ready(function(){

            function queryToBase(word){
                $.ajax({
                    url: '/cards/request/',
                    type: 'post', // HTTP method
                    data: {word: word, template: 'simple'}, //
                    cache: false, // skip the cache
                    success: function (res) { // handle the response
                        $('.search-request').html(res);
                    },
                    error: function () { // handle the error
                        $('.search-request').empty();
                    }
                });
            }

            // client-side filter by word
            $('#search-input').on('input touchstart', function () {
                let word = $(this).val().toLowerCase(); // current search box value
                //queryToBase(word);
                if(word === undefined) return false;
                setTimeout(function(){
                    queryToBase(word);
                }, 1000);

            });

            $('#search-input').on('click', function(e){
                e.stopPropagation();
            });

            $('.search-request').on('click', function(e){
                e.stopPropagation();
            });

            <? if($url == "/cards"): ?>
            $('body').on('click', function(e){
                //e.preventDefault();
                queryToBase("");
                $('#search-input').val('');
            });
            <? endif; ?>
        });

    </script>
<? endif; ?>

</body>
</html>


