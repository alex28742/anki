<?php
\fw\libs\Helper::needAuth();
if(isset($card) && (!isset($card['front']) || !isset($card['back']))){
    $card['front'] = "";
    $card['back'] = "";
    \fw\libs\Helper::redirect('/cards/');
}else{
    $back_text = $card['back'] ?: "";
}
?>
<!--data for the answer buttons (how long each defers the card)-->
<span style="display:none;" class="btn-time well" data-time="<?if(isset($_SESSION['well'])) echo $_SESSION['well']?>"></span>
<span style="display:none;" class="btn-time hard" data-time="<?if(isset($_SESSION['hard'])) echo $_SESSION['hard']?>"></span>
<span style="display:none;" class="btn-time repeat" data-time="<?if(isset($_SESSION['repeat'])) echo $_SESSION['repeat']?>"></span>


<div class='card-item' data-id = "<?=$card['id']?>">
    <? if(isset($settings->showpanel) && $settings->showpanel == 1):?>
    <div class="params-panel">
        <span>id: <?=$card['id']?></span>
        <span>Всего повторений: <?=$card['totalrepeat']?></span>
        <span>Рейтинг: <?=$card['queue']?></span>
        <span>Сегодня повторений: <?=$card['countdayrepeat']?></span>
        <span>Создана: <?=$card['datecreate']?></span>
        <span>Была на изучении: <?=$card['lastdayrepeat']?></span>
        <span>Плановый повтор: <?=date('d-m-Y', $card['nextshow'])?></span>
    </div>
    <? endif; ?>

    <form>
        <div class="card-top">
            <?= trim($card['front']); ?>
        </div>

        <hr>
        <div class="hide-panel" style="display: none">
            <div class="card-back">
                <?= trim($card['back']); ?>
            </div>
            <input type='hidden' name='id' value="<?= $card['id'] ?>">
            <button type="submit" class="btn-edit" style="display: none"></button>
        </div>
    </form>

    <!-- Button trigger modal -->
    <div class="additional-wrapper">
        <div class="additional-buttons">

            <form class="delete" action="/cards/del" method="post">
                <input type="hidden" name="del" value="<?=$card->id?>">
                <a type='submit' class='btn btn-outline-danger'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                         class='bi bi-trash'
                         viewBox='0 0 16 16'>
                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                        <path fill-rule='evenodd'
                              d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                    </svg>
                </a>
            </form>


            <a type="button" class="btn btn-outline-dark btn-edit-trigger" data-bs-toggle='modal' data-bs-target='#edit_card'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil'
                     viewBox='0 0 16 16'>
                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                </svg>
            </a>
            <? if($settings['speaker']):?>
            <a type='button'
               class='btn btn-outline-primary speaker' onclick="responsiveVoice.speak('<?=addslashes($back_text)?>');"
               value="Play">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-volume-up-fill" viewBox="0 0 16 16">
                    <path d="M11.536 14.01A8.473 8.473 0 0 0 14.026 8a8.473 8.473 0 0 0-2.49-6.01l-.708.707A7.476 7.476 0 0 1 13.025 8c0 2.071-.84 3.946-2.197 5.303l.708.707z"/>
                    <path d="M10.121 12.596A6.48 6.48 0 0 0 12.025 8a6.48 6.48 0 0 0-1.904-4.596l-.707.707A5.483 5.483 0 0 1 11.025 8a5.483 5.483 0 0 1-1.61 3.89l.706.706z"/>
                    <path d="M8.707 11.182A4.486 4.486 0 0 0 10.025 8a4.486 4.486 0 0 0-1.318-3.182L8 5.525A3.489 3.489 0 0 1 9.025 8 3.49 3.49 0 0 1 8 10.475l.707.707zM6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06z"/>
                </svg>
            </a>
            <?endif;?>

                <a type='button' class='btn btn-outline-primary' data-bs-toggle='modal' data-bs-target='#toCloud'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                         class='bi bi-cloud-arrow-down' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd'
                              d='M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z'></path>
                        <path d='M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z'></path>
                    </svg>
                </a>


            <a type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#toDictionary'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus'
                     viewBox='0 0 16 16'>
                    <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/>
                </svg>
            </a>

            <!--only if dictionary words were found-->
            <? if(!empty($own_dictionary) || !empty($dictionary)): ?>
            <a type="button" href='#' class='btn btn-outline-primary' data-bs-toggle='collapse' data-bs-target='#collapseExample'
               aria-expanded='false' aria-controls='collapseExample'>
                <? if(false):?>
                    <span class='badge bg-primary rounded-pill'><?=count($own_dictionary);?></span>

                    <span class='badge bg-success rounded-pill'><?=count($dictionary);?></span>
                <? endif; ?>
               <?/* <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye'
                     viewBox='0 0 16 16'>
                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                </svg>*/?>
                <span class='badge bg-primary rounded-pill'><?=count($own_dictionary);?></span>
            </a>
            <? endif; ?>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>

        <!--if the card's dictionary words were found-->
        <? if(!empty($dictionary) || !empty($own_dictionary)): ?>

        <div class='collapse' id='collapseExample'>
            <div class='card card-body'>
                <? if(!empty($own_dictionary)):?>

                <div class='card-dictionary'>
                    <? foreach($own_dictionary as $item): ?>
                        <div class='row parent'>
                            <div class='col-6' style="font-size: 0.85em">

                                <b><a class="item-dictionary" data-id="<?=$item['id']?>"
                                      data-tough="<?=$item['tough_selection']?>"
                                      data-bs-toggle='modal'
                                      data-bs-target='#edit_word'>
                                        <?=$item['word']?>
                                    </a>
                                </b>
                                <? if($item['count'] > 1): ?>
                                <span class="counter" data-find="<?=$item['word']?>" data-bs-toggle='modal'
                                   data-bs-target='#find_cards' style="cursor: pointer">
                                    <span class='badge bg-success rounded-pill' style="background-color:#66ac8c !important;"><?=$item['count']?></span>
                                </span>
                                <? endif; ?>

                                <!--whether the word appears in cloud phrases-->
                                <? if($item['cloud'] > 0):?>
                                    <a class='counter-cards' data-find="<?=$item['word']?>"
                                       data-bs-toggle='modal'
                                       data-bs-target='#find_cloud' style='cursor: pointer'
                                    <?/*href="/cards/cloudList/?word=<?=$item['word']?>"*/?>>
                                        <span class='badge  bg-secondary rounded-pill'><?=$item['cloud']?></span>
                                    </a>
                                <? endif; ?>



                            </div>
                            <div class='col-6 item-pronounce' style='font-size: 0.85em'><?=$item['pronounce']?></div>
                            <div class='col-12 item-meaning' style='font-size: 0.85em'><?=$item['meaning']?></div>
                            <? if($item['definition']):?>
                                <div class='col-12 item-definition'
                                     style='font-size: 0.85em;
                                      max-width:95%;
                                      margin:5px 10px;
                                      border: 1px dashed;
                                      border-radius: 2px;
                                '><?=$item['definition']?></div>
                            <? endif; ?>
                            <br>
                        </div>
                    <? endforeach; ?>

                </div>
                <? endif; ?>
                <!--another word list-->
                <? if(!empty($dictionary) && $settings['showmydic']):?>
                <hr>
                <div class='card-dictionary'>
                    <div style="font-size: 0.85em; text-decoration: underline;"><em>Чужие словари</em></div>
                    <? foreach($dictionary as $item):?>
                        <div class='row parent'>
                            <div class='col-4 item-pronounce' style='font-size: 0.85em'><b><?=$item['word']?></b></div>
                            <div class='col-8 item-pronounce' style='font-size: 0.85em'><?=$item['pronounce']?></div>
                            <div class='col-12 item-meaning' style='font-size: 0.85em'><?=$item['meaning']?></div>
                            <div class='col-12 item-definition' style='font-size: 0.85em'><?=$item['definition']?></div>
                        </div>
                    <? endforeach; ?>
                </div>
                <? endif; ?>
            </div>
        </div>
        <? endif; ?>
    </div>
</div>

<script>

    $(document).ready(function(){
        // swap front/back while editing a card
        $('.reverse').on('click', function(event){
            event.preventDefault();
            let form = $(this).closest('form.edit_card');
            // grab the data
            let top = form.find('textarea[name=top]').val();
            let back = form.find('textarea[name=back]').val();
            // insert the data
            form.find('textarea[name=top]').val(back);
            form.find('textarea[name=back]').val(top);

        });

        // edit a card
        $('.btn-edit-trigger').on('click', function(){
            // grab the data
            let id = $('.card-item').data('id');
            let top = $('.card-item').find('.card-top').text();
            let back = $('.card-item').find('.card-back').text();
            // fills in the form
            let form = $('form.edit_card');
            form.find('input[name=id]').val(id);
            form.find('textarea[name=top]').val(top);
            form.find('textarea[name=back]').val(back);

            setTimeout(function(){ areas_clear(); },200);
        });

        // delete a card
        $('form.delete').on('click', function (event) {
            event.preventDefault();
            const result = confirm('Удалить карточку?');
            if (result === false) return false;
            let form = $(this);
            let id = form.find('input').val();
            $.ajax({
                url: form.attr('action'), // request target
                type: form.attr('method'), // HTTP method
                data: {del: id}, // data to send
                cache: false, // skip the cache
                success: function (res) { // handle the response
                    window.location.href = '/cards/list';
                },
                error: function () { // handle the error
                    alert('error');
                }
            });
        });

    });

    // layout tweak for the card-edit popup
    function areas_clear(){
        let form = $('form.edit_card');
        let top = form.find('textarea[name=top]').val();
        let back = form.find('textarea[name=back]').val();
        form.find('textarea[name=top]').val($.trim(top));
        form.find('textarea[name=back]').val($.trim(back));
    }


    // click on a dictionary word's counter (opens a popup listing the cards where it appears
    $('.counter').on('click', function () {
        let fined = $(this).data('find');
        $.ajax({
            url: '/cards/byword/', // request target
            type: 'post', // HTTP method
            data: {word: fined},
            cache: false, // skip the cache
            success: function (res) {
                $('#find_cards').find('.modal-body').html(res);
            },
            error: function () {
                alert('error');
            }
        });
    });

    // click on a cloud-phrase word counter
    $('.counter-cards').on('click', function(){
        let fined = $(this).data('find');
        $.ajax({
            url: '/cards/bywordincloud/', // request target
            type: 'post', // HTTP method
            data: {word: fined},
            cache: false, // skip the cache
            success: function (res) {
                $('#find_cloud').find('.modal-body').html(res);
                $('#find_cloud').find('.modal-open-cloud').attr('href', '/cards/cloudList/?word='+fined);
            },
            error: function () {
                alert('error');
            }
        });
    });


    $('#find_cards').find('.btn-close').on('click', function () {
        $('#find_cards').get(0);//.reset();
    });

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




