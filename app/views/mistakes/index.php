<?php
\fw\libs\Helper::needAuth();
?>
<br>
<h3>Моя копилка ошибок</h3>
<div class="preview-text">
    <h6>Почему совершать ошибки - хорошо.</h6>
    <div class="text-body close">
        <p>Все люди совершают ошибки. Вы согласны? Хорошо, теперь скажите мне: кто вы?
            Человек? Хорошо. Что из этого следует? Конечно, вы <em>будете</em> ошибаться, и вам <em>положено</em> совершать
                                                                                                          ошибки!</p>

        <p>Говорите себе это каждый раз, когда судите себя за то, что совершили ошибку. Просто скажите себе: "Я должен был
        совершить эту ошибку, потому что я человек!" или "Как по-человечески с моей стороны - совершить эту ошибку".</p>

        <p>Кроме того, спросите себя: "Чему я могу научиться благодаря своей ошибке? Есть ли от нее какая-то польза?". Для
        эксперимента подумайте об ошибке, которую вы уже сделали, и запишите все, чему вы научились благодаря ей. Некоторым
        лучшим вещам в жизни можно научиться только благодаря ошибкам. В конце концов, так вы научились говорить, ходить, и
        делать практически все. Смогли бы вы отказаться от такого роста?</p>

        <p>Можно даже сказать что ваши промахи и несовершенства - ваши самые большие сокровища. Берегите их!
        Никогда не отказывайтесь от своей способности ошибаться, ведь тогда вы потеряете способность двигаться вперед.</p>
    </div>
    <div class="to_bottom">Читать все</div>
</div><br>
<div class="items-wrapper">
<?if(isset($mistakes) && !empty($mistakes)):?>
    <?foreach($mistakes as $mistake):?>
        <div class='card'>
            <div class='title'>Ситуация</div>
            <span><?=$mistake['description']?></span>
            <span class='bttn'><a href='/mistakes/detail/?id=<?=$mistake["id"]?>'>Перейти</a></span>
        </div>
    <?endforeach;?>
<?else:?>
Здесь пока нет данных
<?endif;?>
</div>


<style>
    .card{
        font-size: 0.8em;
        padding: 10px;
        margin-bottom: 20px;
    }
    .title {
        width: fit-content;
        background: #fff;
        padding: 0 10px;
        margin-top: -20px;
        font-style: italic;
        font-weight: bold;
        color: #6c6c6c;
    }

    /*.bttn {*/
    /*    display: flex;*/
    /*    justify-content: right;*/
    /*    position: relative;*/
    /*    top: -10px;*/
    /*    right: 20px;*/
    /*    font-size: 0.8em;*/
    /*}*/
    /*.card{*/
    /*    border: 1px solid #c8b0b0;*/
    /*}*/
    /*.item-body{*/
    /*    font-size: 0.8em;*/
    /*    padding:5px;*/
    /*}*/
    /*.item-date {*/
    /*    font-size: 0.7em;*/
    /*    background: #fff;*/
    /*    width: fit-content;*/
    /*    padding: 0 10px;*/
    /*    position: relative;*/
    /*    top: -8px;*/
    /*    left:10px;*/
    /*}*/
    p { margin-bottom: 0.5rem; }
    .to_bottom{
        cursor: pointer;
    }
    .text-body{
        position: relative;
        overflow: hidden;
    }
    .text-body.close{
        height: 80px;
    }

    /*.text-body::after {*/
    /*    content: "";*/
    /*    display: block;*/
    /*    height: 50px;*/
    /*    width: 100%;*/
    /*    background: linear-gradient(0deg, #fff, rgba(255, 255, 255, 0.3));*/
    /*    position: absolute;*/
    /*    top: 25px;*/
    /*    !*opacity: 0.3;*!*/
    /*}*/
    .preview-text{
        font-size: 0.8em;
    }
    em{
        font-weight: bold;
    }
</style>

<script>
    $(document).ready(function(){

        $('.to_bottom').on('click', function(){


            if($(".text-body").hasClass("close")){
                $('.text-body').removeClass("close");
                $(this).text("Свернуть");
            }
            else{
                $('.text-body').addClass("close");
                $(this).text("Читать все");
            }
        })







    });
</script>