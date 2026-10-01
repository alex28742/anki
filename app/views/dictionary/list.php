<div class="search-wrap fixed-top" style="">
    <input type='search' class='form-control ds-input' id='search-input' placeholder='найти..'>
</div>

<div class='result'></div>
<? if (count($list)): ?>
    <?php foreach ($list as $val): ?>
        <div class='card'>
            <div class='card-body'>
                <span class="word"><b><?= $val['word']; ?></b> </span>
                <!--counter-->
                <? if($val['count'] > 0): ?>
                <span class="counter" data-find="<?=$val['word']?>" data-bs-toggle='modal' data-bs-target='#find_cards'>
                    <span class='badge bg-secondary rounded-pill'><?=$val['count']?></span>
                </span>&nbsp;
                <? endif; ?>
                <!--cчетчик-->
                <span class="pronounce"><?= $val['pronounce']; ?></span>
                <br>
                <span class="meaning"><?= $val['meaning']; ?></span>
                <? if($val['definition']): ?>
                    <br><span class='definition'><?= $val['definition']; ?></span>
                <? endif; ?>
            </div>
            <div class="card-actions btn-group-sm">
                <form class="default delete" action="/dictionary/delete" method="post">
                    <input type="hidden" name="id" value="<?= $val['id'] ?>">
                    <button type="submit" class='btn btn-outline-danger btn-sm'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd'
                                  d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                    </button>
                </form>
                <div style="position: relative; top:2px; margin: 0 7px;">
                    <button class='btn btn-outline-primary btn-sm word_edit' data-id="<?= $val['id'] ?>"
                    data-tough="<?= $val['tough_selection']?>"
                            data-bs-toggle='modal' data-bs-target='#edit_word'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-pencil' viewBox='0 0 16 16'>
                            <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'></path>
                        </svg>
                    </button>
                </div>


            </div>
        </div>
    <?php endforeach; ?>
<? else: ?>

    <div class='alert alert-warning' role='alert'>
        Нет слов в словаре
    </div>
<? endif; ?>
<div style='margin-bottom: 15px; height:50px;'></div>

<style>
    .content{
        position: relative;
        top:50px;
    }
    input#search-input{
        margin-top: 6px;
    }
    .search-wrap {
        background: #fff;
        margin: 0 12px 10px;
    }
    .card{
        margin-bottom: 7px;
    }
   .card-body .definition {
        background: #eae4e4;
        display: block;
        padding: 5px 10px;
        font-size: 0.8em;
        margin-top: 5px;
    }

    .content {
        overflow: auto;
    }

    .card-actions {
        display: flex;
        justify-content: end;
        margin-bottom: 5px;
        background: #f7f1f1;
    }

    .card-actions form {
        margin: 2px 5px;
    }

    .card-actions form input.btn {
        margin-top: 2px;
        margin-bottom: 2px;

    }
    .badge.bg-secondary.rounded-pill {
        font-size: 0.7em;
        background-color: #d7aeae !important;
        cursor:pointer;
    }
</style>

<script src='/public/assets/js/ajax.js'></script>

<script>
    // delete a word
    $('form.delete').submit(function (event) {
        let res = confirm('Удалить?');
        if(!res) return false;
        event.preventDefault();
        $(this).closest('.card').hide(500);
    });

    // edit a word
    $('.word_edit').on('click', function(){
        let id = $(this).data('id');
        let tough = $(this).data('tough');
        let word = $(this).closest('.card').find('.word').text();
        let pronounce = $(this).closest('.card').find('.pronounce').text();
        let meaning = $(this).closest('.card').find('.meaning').text();
        let definition = $(this).closest('.card').find('.definition').text();

        let form = $('form.word-edit');
        form.find('input[name=id]').val(id);
        form.find('input[name=word]').val(word);
        form.find('input[name=pronounce]').val(pronounce);
        form.find('input[name=meaning]').val(meaning);
        let trigger = form.find('.trigger-tough');
        if(tough == 1) trigger.removeClass('btn-outline-secondary').addClass('btn-primary');
            else trigger.removeClass('btn-primary').addClass('btn-outline-secondary');
        if(definition) form.find('textarea[name=definition]').val(definition);
    });

    // client-side filter by word
    $('#search-input').on('input', function(){
        let res = $(this).val().toLowerCase(); // current search box value
        $('.card').each(function(){
            // search by word
            let word = $(this).find('.word').text().toLowerCase();
            let meaning = $(this).find('.meaning').text().toLowerCase();
            let find = word.indexOf(res); // indexOf returns -1 when not found
            let find2 = meaning.indexOf(res); // search in the meaning field
            if(find !== -1 || find2 !== -1) $(this).show();
            else $(this).hide();
        })
    });

    // click on a dictionary word's counter (opens a popup listing the cards where it appears
    $('.counter').on('click', function () {
        let fined = $(this).data('find');
        $.ajax({
            url: '/dictionary/byword/', // request target
            type: 'post', // HTTP method
            data: {word: fined}, // word to filter cards by
            cache: false, // skip the cache
            success: function (res) {
                $('#find_cards').find('.modal-body').html(res);
            },
            error: function () {
                alert('error');
            }
        });
    });


</script>