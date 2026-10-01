<?

?>

<? if(!empty($cards)): ?>
    <div class="cards-wrapper">
        <? foreach($cards as $card): ?>
            <div class='card'>
                <div class='card-body'>
                    <div class='side bottom-side'>
                        <?=\fw\libs\Helper::NeedleHighlight($card['back'], $words)?>
                    </div>
                    <hr>
                    <div class='side top-side'><?=$card['front']?></div>
                    <div class='info'>
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


