<?php
//\fw\libs\Helper::needAuth();
\fw\libs\Helper::redirect('/cards');
?>

<br>
<h1>Главная</h1>

<a href="/cards/" class="btn btn btn-primary">Анки</a>
<? if(\fw\libs\Helper::isAdmin()):?>
<a href='/diary/' class='btn btn btn-success'>Дневник</a>
<a href='/mistakes/' class='btn btn btn-success'>Мои ошибки</a>
<? endif; ?>