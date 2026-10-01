

<?
\fw\libs\Helper::needAuth();
?>
<div class="result"></div>
<form action="">
    <input class='form-control' type="text" name="name" value="<?=$_SESSION['user']['name']?>">
    <input class='form-control' type="text" name="login" value="<?=$_SESSION['user']['login']?>">
    <input class='form-control' type="text" name="email" disabled="disabled" value="<?=$_SESSION['user']['email']?>">
</form>
<br>
<!--<a href='/user/exit' class='btn btn-primary'>Изменить</a>-->
<a href='/user/exit' class='btn btn-success'>Выйти</a>
<br>
<hr>
<h5>Мои настройки</h5>

<form action="" class="watchingall">
    <div class="row">
        <!--Other users' dictionaries-->
        <? if(\fw\libs\Helper::isAdmin()): ?>
        <div class='col-1'>
            <input style='float: left' class='form-check-input' name='showmydic' type='checkbox'
                   value='<?=$settings["showmydic"]?>';
                   id='showmydic' <?if($settings["showmydic"]):?>checked<?endif;?>>
        </div>
        <div class='col-11'>
            <label class='form-check-label' for='showmydic'>
                Показывать свой словарь другим пользователям и видеть их словари
            </label>
        </div>
<!--        extended card info-->
        <div class='col-1'>
            <input type="checkbox" class="form-check-input" id="showpanel" name="showpanel"
                   value="<?=$settings['showpanel']?>" <?if ($settings['showpanel']):?>checked<?endif;?>>
        </div>
        <div class='col-11'>
            <label class='form-check-label' for='showpanel'>
                Показывать расширенную информацию о карточке (при изучении)
            </label>
        </div>
        <? endif; ?>
        <!--Enable the experimental text-to-speech feature-->
        <div class='col-1'>
            <input type='checkbox' class='form-check-input' id='speaker' name='speaker'
                   value="<?= $settings['speaker'] ?>" <? if ($settings['speaker']): ?>checked<? endif; ?>>
        </div>
        <div class='col-11'>
            <label class='form-check-label' for='speaker'>
                Включить экспериментальную функцию озвучивания
            </label>
        </div>
        <!--Show the search bar in the header-->
        <div class='col-1'>
            <input type='checkbox' class='form-check-input' id='searchline' name='searchline'
                   value="<?= $settings['searchline'] ?>" <? if ($settings['searchline']): ?>checked<? endif; ?>>
        </div>
        <div class='col-11'>
            <label class='form-check-label' for='searchline'>
                Вывести сквозную строку поиска
            </label>
        </div>
        <br>

<!--        hard coefficient-->
        <div class="col-1"></div>
        <div class="col-11"></div>

<!--well coefficient-->
        <div class='col-1'></div>
        <div class='col-11'></div>

<!--repeat coefficient-->
        <div class='col-1'></div>
        <div class='col-11'></div>


        <div class='col-1'></div>
        <div class='col-11'></div>
    </div>


</form>


<script src='/public/assets/js/main.js'></script>
<!--<script src='/public/assets/js/card.js'></script>-->
<script src='/public/assets/js/ajax.js'></script>

<script>
    $(document).ready(function(){
        $('form.watchingall input').on('change', function(event){
            event.preventDefault();

            let param_value = $(this).val();
            let param_name = $(this).attr('name');
            $.ajax({
                url: "/user/settings/", // request target
                type: "post", // HTTP method
                data: {param_name: param_name, param_value: param_value}, // payload
                cache: false, // skip the cache
                success: function (res) { // handle the response
                    $(".result").html('<div class="alert alert-primary">Настройки обновлены</div>');
                    $(".result").show();
                    setTimeout(function(){
                        $('.result').hide(500);
                    },1500);
                },
                error: function () { // handle the error
                    console.log('error');
                }
            });
        })
    });
</script>


