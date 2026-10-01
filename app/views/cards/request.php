
<div style="font-size: 13px; font-weight: 400;">
    <span style="font-size: 14px"><b>"<?=$words['word']?>"</b></span>
    Найдено <span class='badge bg-secondary rounded-pill'>
        <?=(count($dictionary) +count($cards) + count($clouds))?>
            </span> раз
</div> <br>

<? if(!empty($dictionary)) :?>
<div class='w-message dictionary'>
    <div class='w-label'>Найдено в Словаре
        <span class='badge bg-secondary rounded-pill'>
            <?=count($dictionary)?>
        </span>
    </div>
    <div class='wrapper'>
        <? foreach($dictionary as $item): ?>
        <div class='card'>
            <div class='card-body'>
                <span class='word'><b><?=$item["word"]?></b> </span>
                <span class='pronounce'><?=$item["pronounce"]?></span>
                <br>
                <span class='meaning'><?= $item["meaning"]?></span>
            </div>
            <div class='card-actions btn-group-sm'></div>
        </div>
        <? endforeach; ?>
    </div>
</div>
<br>
<? endif; ?>

<? if(!empty($cards)): ?>
<div class='w-message cards'>
    <div class='w-label'>Найдено в Карточках
        <span class='badge bg-secondary rounded-pill'>
            <?=count($cards)?>
        </span>
    </div>
    <div class='wrapper'>
        <? foreach($cards as $item): ?>
        <div class='card' style="margin-bottom: 8px;">
            <div class='card-body' data-id='518'>
                <div class='side top-side'><?=\fw\libs\Helper::NeedleHighlightOne($item['back'], $words["word"])?></div>
                <hr>
                <div class='side bottom-side'><?= $item['front'] ?></div>
                <div class='info'></div>
            </div>
        </div>
        <? endforeach; ?>
    </div>
</div>
<br>
<? endif; ?>

<? if(!empty($clouds)): ?>
<div class='w-message cloud'>
    <div class='w-label'>Найдено в Облаке
        <span class='badge bg-primary rounded-pill'>
            <a href="/cards/cloudList/?word=<?=$words['word']?>"><?=count($clouds)?></a>
        </span>
    </div>
    <div class='wrapper'>
        <? foreach($clouds as $item): ?>
        <div class='card' style='margin-bottom: 8px;'>
            <div class='card-body' data-id='518'>
                <div class='side top-side'><?= \fw\libs\Helper::NeedleHighlightOne($item['text'], $words['word']) ?></div>
            </div>
        </div>
        <? endforeach; ?>
    </div>
</div>
<? endif; ?>
<br><br>

