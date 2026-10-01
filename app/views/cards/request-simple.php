
<div style='font-size: 13px; font-weight: 400;'>
    <span style='font-size: 14px'><b>"<?= $words['word'] ?>"</b></span>
    Результатов <span class='badge bg-secondary rounded-pill'>
        <?= (count($dictionary) + count($cards) + count($clouds)) ?>
            </span>
</div> <br>


<? if(!empty($dictionary)) :?>
    <div class='w-message dictionary'>
        <div class='w-label' style="font-size: 11px">Найдено в Словаре</div>
        <div class='wrapper-line'>
            <? foreach($dictionary as $item): ?>
                <div class='card'>
                    <div class='card-body'>
                        <span class='word'><b><?=$item["word"]?></b> </span>
                        <span class='pronounce'>[<?= str_replace(['[', ']'], '', $item['pronounce'])?>]</span>
                        <span class='pronounce' style="color:#7b7171"> - <?= $item['meaning'] ?></span>
                    </div>
                    <div class='card-actions btn-group-sm'></div>
                </div>
            <? endforeach; ?>
        </div>
    </div>

<? endif; ?>

<? if(!empty($cards)): ?>
    <div class='w-message cards'>
        <div class='w-label' style='font-size: 11px'>Найдено в Карточках</div>
        <div class='wrapper-line'>
            <? foreach($cards as $item): ?>
                <div class='card' style="margin-bottom: 8px;">
                    <div class='card-body' data-id='518'>
                        <div class='side top-side'><?=\fw\libs\Helper::NeedleHighlightOne($item['back'], $words["word"])?>&nbsp;
                            <span style="color:#7b7171"> - <?=$item['front']?></span>
                        </div>
                        <div class='info'></div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>

<? endif; ?>

<? if(!empty($clouds)): ?>
    <div class='w-message cloud'>
        <div class='w-label' style='font-size: 11px;'>
            <a href="/cards/cloudList/?word=<?=$words['word']?>" style="color:#0b5ed7; text-decoration: underline;
">Найдено в Облаке</a>
        </div>
        <div class='wrapper-line'>
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

<style>
    .search-request{ border: 1px solid #cbcbcb; box-shadow: 2px 2px 2px #cbcbcb;}
</style>


