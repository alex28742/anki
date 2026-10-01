<div class='container-search' style="height: 50px;">
    <div class='search-wrap' style='' data-word=''>
        <input type='search' class='form-control ds-input ' style='width:100%;' id='search-input' placeholder='найти..'>
    </div>
</div>

<div class="setting">
    <form id="setting" action="">
        <div class="searching-in" style="display: flex; justify-content: space-around;">
            <div class="wr">
                <label for='fdic'>Словарь</label>
                <input id='fdic' name="fdic" type='checkbox' value='<?=$settings["fdic"]?>'
                       <?if($settings['fdic']):?>checked<?endif;?>>
            </div>

            <div class="wr">
                <label for='fcards'>Карточки</label>
                <input id='fcards' name='fcards' type='checkbox' value='<?= $settings['fcards'] ?>'
                       <?if($settings['fcards']):?>checked<?endif;?>>
            </div>

            <div class="wr">
                <label for='fcloud'>Облако</label>
                <input id='fcloud' name='fcloud' type='checkbox' value='<?= $settings['fcloud'] ?>'
                       <?if($settings['fcloud']):?>checked<?endif;?>>
            </div>

        </div>

    </form>

</div>

<div class='dictionary-wrap'></div>


<style>
    .card{
        font-size: 13px;
        font-weight: 400;
    }
    .wrapper {
        max-height: 250px;
        overflow: auto;
    }
    .w-message {
        /*background: #ece1e1;*/
    }
    .w-label {
        /*border: 1px solid #cbcbcb;*/
    }
    .card-body{
        background: #f2ede4;
    }
    .badge.rounded-pill > a{
        color: #fff !important;
        text-decoration: none;
    }
</style>

<script>

    // settings
    $('form#setting input').on('change', function (e){
        e.preventDefault();
        let param_value = $(this).val();
        let param_name = $(this).attr('name');
        $.ajax({
            url: '/user/settings/',
            type: 'post', // HTTP method
            data: {param_name: param_name, param_value: param_value}, //
            cache: false, // skip the cache
            success: function (res) { // handle the response
                $('#search-input').trigger('input');
            },
            error: function () { // handle the error
                alert("Не удалось");
            }
        });
    });

    function queryToBase(word){
        $.ajax({
            url: '/cards/request/',
            type: 'post', // HTTP method
            data: {word: word}, //
            cache: false, // skip the cache
            success: function (res) { // handle the response
                $('.dictionary-wrap').html(res);
            },
            error: function () { // handle the error
                $('.dictionary-wrap').empty();
            }
        });
    }

    // client-side filter by word
    $('#search-input').on('input touchstart', function(){
        let word = $(this).val().toLowerCase(); // current search box value
        setTimeout(function(){
            queryToBase(word);
        },1000);
    });
</script>

<script src='/public/assets/js/card.js'></script>
<script src='/public/assets/js/ajax.js'></script>
