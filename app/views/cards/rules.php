<br>
<h5>Полезные статьи</h5>

<? if(count($articles)): ?>
<div class="articles-wrapper">
    <? foreach($articles as $article): ?>
        <div class="card">
            <div class="title"><?=$article['title']?></div>
            <div class='text'><?= $article['text'] ?></div>
        </div>
    <? endforeach; ?>
</div>
<? else: ?>
    <div class='alert alert-warning' role='alert'>
        <span>Нет материалов</span>
    </div>
<? endif; ?>

<style>
    .articles-wrapper{
        font-size: 13px;
    }
</style>
