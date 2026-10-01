<br>
<br>
<div class="container-search">
    <div class='search-wrap fixed-top' style=''>
        <input type='search' class='form-control ds-input' id='search-input' placeholder='найти..'>
    </div>
</div>



<div class="result"></div>
<? foreach($cards as $card): ?>
<div class="card">
    <div class="card-body" data-id="<?=$card['id']?>">

        <div class="side top-side"><?=$card['front']?></div>
        <div class="side bottom-side"><?=$card['back']?></div>
        <div class='info'>
            <span class='actions'>
            <div class='add-info btn btn-outline-primary btn-sm hide-on-small-phone'>
                <span style="display: none"><b>id:</b><?= $card['id'] ?></span>
                <span><?= date('d-m-Y', $card['nextshow']) ?></span>
            </div>

                <div class='add-info btn btn-outline-success btn-sm hide-on-small-phone repeat' data-id="<?=$card['id']?>">
                    <span class="text">Повторить</span>
                </div>

                <form class='default delete' action='/cards/delete' method='post'>
                    <input type='hidden' name='id' value='<?= $card['id'] ?>'>
                    <button type='submit' class='btn btn-outline-danger btn-sm'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-trash'
                             viewBox='0 0 16 16'>
                            <path
                                d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd'
                                  d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                    </button>
                </form>
                <div style='margin: 0 7px;'>
                    <button class='btn btn-outline-primary btn-sm card_edit' data-id='126' data-bs-toggle='modal'
                            data-bs-target='#edit_card'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-pencil'
                             viewBox='0 0 16 16'>
                            <path
                                d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'></path>
                        </svg>
                    </button>
                </div>
            </span>
        </div>
    </div>

</div>


<? endforeach; ?>
<br>
<br>

<style>
    .fixed-top {
        position: relative;
        top: 0px;
        /*max-width: 80%;*/
    }
    .container-search {
        position: fixed;
        top: -15px;
        z-index: 99;
        max-width: 94%;
        min-width: 338px;
    }
    .card{
        margin-bottom: 10px;
        box-shadow: 2px 2px 2px #cbcbcb;
    }
    .info {
        font-size: 0.7em;
        background: #eeebeb;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .side {
        border: 1px solid #f2eeee;
        padding: 5px 10px;
        font-size: 0.8em;
    }
    .actions {
        display: flex;
        justify-content: end;
    }
    .add-info {
    /*    outline: 1px solid #cbcbcb;*/
        margin-right: 10px;
        font-size: 1em;
    /*    padding: 5px 10px;*/
    /*    border-radius: 5px;*/
    }
    .add-info > span{
        line-height: 21px;
        color:#333;
    }
    .add-info.repeat.active .text{
        color:#fff;
        font-weight: bold;
    }
</style>
<script src='/public/assets/js/ajax.js'></script>
<script>

    $(document).ready(function(){
        // swap front/back
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

        // delete a word
        $('form.delete').submit(function (event) {
            event.preventDefault();
            let res = confirm('Удалить?');
            if(!res) return false;
            $(this).closest('.card').hide(500);
        });

        // edit a card
        $('.card_edit').on('click', function(){
            // grab the data
            let id = $(this).closest('.card-body').data('id');
            let top = $(this).closest('.card-body').find('.top-side').text();
            let back = $(this).closest('.card-body').find('.bottom-side').text();
            // fills in the form
            let form = $('form.edit_card');
            form.find('input[name=id]').val(id);
            form.find('textarea[name=top]').val(top);
            form.find('textarea[name=back]').val(back);
        });

        // client-side filter by word
        $('#search-input').on('input', function(){
            let res = $(this).val().toLowerCase(); // current search box value
            $('.card').each(function(){
                // search by word
                let bottom = $(this).find('.bottom-side').text().toLowerCase();
                let top = $(this).find('.top-side').text().toLowerCase();
                let find = bottom.indexOf(res); // indexOf returns -1 when not found
                let find2 = top.indexOf(res); // search in the meaning field
                if(find !== -1 || find2 !== -1) $(this).show();
                else $(this).hide();
            })
        });

        // send the card back into the review queue
        $('.add-info.repeat').on('click', function(){
            let btn = $(this);
            let id = btn.data('id');
            $.ajax({
                url: '/cards/repeat', // request target
                type: 'post', // HTTP method
                data: {id: id}, //
                cache: false, // skip the cache
                success: function (res) { // handle the response
                    if(res){
                        btn.addClass('active');
                        btn.find('.text').text('Отправлено');
                    }
                },
                error: function () { // handle the error
                    btn.find('.text').text('Ошибка');
                }
            });
        });


    });





</script>