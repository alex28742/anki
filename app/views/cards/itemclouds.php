<?

?>

<? if(!empty($items)): ?>
    <div class="cards-wrapper">
        <? foreach($items as $item): ?>
            <div class='card'>
                <div class='card-body'>
                    <div class='side bottom-side'>
                        <?=\fw\libs\Helper::NeedleHighlight($item['text'], $words)?>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
    </div>
<? else: ?>
    <code>Нет данных для вывода</code>
<? endif; ?>

<style>
    .card{
        margin-bottom: 10px;
    }
</style>
