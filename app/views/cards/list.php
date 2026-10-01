
<!--Check whether there are cards to study today-->
<? if($card !== false): ?>
<!--wrapper the next card gets ajax-loaded into-->
<div class="row">
    <div class='wrapper'>
        <? include __DIR__ . "/get.php";  ?>
    </div>
</div>


<nav class='navbar fixed-bottom navbar-light bg-light'>
        <div class='show  mx-auto'>
            <button type='button' class='btn btn-primary'>Показать ответ</button>
        </div>
    <div style='display: none;' class='btn-group  mx-auto' role='group' aria-label='Basic mixed styles example'>

        <form class='card-btn' action='/cards/get' method='post'>
            <input type='hidden' name='id' value='<?= $card['id'] ?>'>
            <input type='hidden' name='answer' value='easy'>
            <button data-id='2' type='submit' class='btn btn-primary repeat'>
                <?if(isset($_SESSION['repeat'])):?><?=$_SESSION['repeat'];?><?else:?>Легко<?endif;?>
            </button>
        </form>



        <form class='card-btn' action='/cards/get' method='post'>
            <input type='hidden' name='id' value='<?=$card['id']?>'>
            <input type='hidden' name='answer' value='hard'>
            <button data-id='3' type='submit' class='btn btn-warning hard'>
                <?if(isset($_SESSION['hard'])):?><?=$_SESSION['hard'];?><?else:?>Трудно<?endif;?>
            </button>
        </form>

        <form class='card-btn' action='/cards/get' method='post'>
            <input type='hidden' name='id' value='<?=$card['id']?>'>
            <input type='hidden' name='answer' value='well'>
            <button data-id='4' type='submit' class='btn btn-success well'>
                <?if(isset($_SESSION['well'])):?><?=$_SESSION['well'];?><?else:?>Хорошо<?endif;?>
            </button>
        </form>




        </div>
<!--    </div>-->
</nav>

<? else: ?>
    <div class='alert alert-info' role='alert'>
        <span>На сегодня все выучено! <a href="/cards/cloudList">Добавить из облака</a></span>
    </div>
<? endif; ?>


<style>
    .item-dictionary{
        cursor: pointer;
        color:#222;
        font-weight: bold;
        text-decoration: none;
    }

    .card-dictionary >  .row > .col-8{
        padding-left: 0;
        padding-right: 0;
    }
    .card-dictionary >  .row > .col-4{
        padding-right: 0;
    }

    #find_cards .modal-body {
        max-height: 500px;
        overflow: auto;
        font-size: 0.85em;
        background: #eee;
    }

    .badge.bg-secondary.rounded-pill {
        background: #cbcbcb !important;
    }

    #collapseExample {
        position: relative;
        top: -105px;
    }

    .form-control-plaintext{
        border:none;
    }
    textarea{
        resize: none;
        text-align: justify;
        white-space: pre-line;
        -moz-text-align-last: left;
        /*text-align-last: left;*/
        padding: 10px;
        height: 85px;
    }
    textarea:focus-visible{
        border:none;
        outline:none;
    }

    .btn-group form{
        margin: 0 3px;
    }
    .wrapper{
        min-height: calc(100vh - 80px);
    }
    .card-item {
        border: 0;
        min-height: 100%;
        overflow: auto;
    }
    .card-item > div{
        margin:5px;
        padding: 5px;
    }

    #collapseExample > .card-body{
        margin-bottom: 25px;
    }
</style>

<script>
    $(document).ready(function(){
        $('.show').click(function(){
            // hide the "show answer" button, reveal the answer buttons
            $(this).hide().siblings('.btn-group').show(100);
            $('.hide-panel').show(100);
            // sync the card id onto the answer buttons
            let id = $('.card-item').data('id');
            $('.btn-group input[name=id]').val(id);
        });

        $('.btn-group').click(function(){
            setTimeout(function(){
                $('textarea').on('change', function(){
                    $('input.save').show();
                });
            },100);

            $(this).hide().siblings('.show').show(100);

        });

        $('textarea').on('change', function(){
           $('input.save').show();
        });

    });
</script>



<script src='/public/assets/js/card.js'></script>
<script src='/public/assets/js/ajax.js'></script>

<? if($settings['speaker']):?>
<script>
    let script = document.createElement('script');
    script.src = '//code.responsivevoice.org/responsivevoice.js?key=IBfcmUMt';
    document.body.append(script);
</script>
<? endif; ?>
<?/*
    // script.onload = function(){
    //     // only run this once the external script has loaded
    //     $('.speaker').show();
    //     console.log('speaker is ready');
    // };

     либо заменить на такой вызов
<script async src='//code.responsivevoice.org/responsivevoice.js?key=IBfcmUMt'></script>
*/?>