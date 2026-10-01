
<h4>Настройки работы с карточками</h4>
<div class="result"></div>
<form class="default" action="" method="post">
<div class='form-check'>
    <input class='form-check-input' name="showpanel" type='checkbox' value='<?=$settings->showpanel;?>'
           id='show-panel' <? if
    ($settings->showpanel) echo "checked";?>>
    <label class='form-check-label' for='show-panel'>
        Показывать расширенную информацию о карточке
    </label>
    <br>

    <input class='' type="text" name="well" value="<?=$settings->well?>" id="well" size="1">
    <label for="well">коэффициент well</label>
    <br>
    <input class='' type='text' name='well' value="<?= $settings->hard ?>" id='hard' size='1'>
    <label for='hard'>коэффициент hard</label>
    <br>
    <input class='' type='text' name='well' value="<?= $settings->repeat ?>" id='repeat' size='1'>
    <label for='repeat'>коэффициент repeat</label>
    <br>
    <input class='' type='text' name='well' value="..." id='max-repeat' size='1'>
    <label for='max-repeat'>макс. повторений в день</label>



</div>
    <input type="submit" value="Сохранить" class="bnt btn-primary">
</form>

<!--<script src='/public/assets/js/ajax.js'></script>-->