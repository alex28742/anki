<?php
if($panel['total_cards'] > 0)
    $cards = $panel['total_cards'];
else $cards = 0;
if($panel['dictionary_items'])
    $dic = $panel['dictionary_items'];
else $dic = 0;

if(isset($panel['statistics'][0]))
    $statistics = $panel['statistics'][0];
else
    $statistics = 0;
if(isset($statistics['lastactivedate']))
    $lastactive = $statistics['lastactivedate'];
else
    $lastactive = "Нет данных";

$totalRepeated = $statistics['cardshard'] + $statistics['cardswell'];

/** Получить оценку по текущему дню
 * @param $well
 * @param $hard
 * @param $maxwell
 * @param $maxhard
 * @return void
 */
function getEstimate($well = 0, $hard = 0, $maxwell = 0, $maxhard = 0):string{
    $maxTotalAmount = $maxwell + $maxhard;
    $curTotalAmount = $well + $hard;
    if($curTotalAmount < 5) return '&#129396';
    $best = round($maxTotalAmount * 0.9);
    $norm = round($maxTotalAmount * 0.5);
    $weak = round($maxTotalAmount * 0.3);
    if($curTotalAmount >= $best) return '&#128512';
    if($curTotalAmount >= $norm) return '&#128526';
    if($curTotalAmount >= $weak) return '&#129402';
    return '&#129396';
}

?>

<div class="main">
    <div class="container">

      <?/*  <div class="buttons-wrapper">
            <!--Dictionary-->
            <div class='row simple-btn'>
                <a <?if($dic):?>href='/dictionary/list/'<?endif;?> class='btn btn-outline-<?if($dic)
                    :?>primary<?else:?>secondary<?endif;?>'>
                <span class='badge bg-<?if($dic):?>primary<?else:?>secondary<?endif;?> rounded-pill'>
                    <?= $dic; ?>
                </span>
                    Словарь
                </a>
            </div>
            <!--Cards-->
            <div class='row simple-btn'>
                <a <?if($cards):?>href='/cards/view/'<?endif;?> class='btn btn-outline-<?if($cards)
                    :?>primary<?else:?>secondary<?endif;?>'>
                <span class='badge bg-<?if($cards):?>primary<?else:?>secondary<?endif;?> rounded-pill'>
                    <?= $cards; ?>
                </span>
                    Карточки
                </a>
            </div>
            </div>*/?>

        </div>
    <br>
        <div class="row2">
            <?if(\fw\libs\Helper::isAdmin() && false):?>
            <div class='alert alert-success' role='alert'>
                <span><a href="/cards/report" class='alert-link'>Что сделано</a></span>
            </div>
            <?endif;?>

            <div class='w-message cards'>
                <div class='w-label'>Статистика</div>
                <div class='wrapper'>
                    <div class='card' style='margin-bottom: 8px;'>
                        <div class='card-body'>
                            <div class='info'>
                                <? if($statistics['lastactivedate'] == date('d-m-Y')):?>
                                <div>Всего попыток сегодня:&nbsp;<b><?=$totalRepeated; ?></b></div>
                                <div>Закреплено:&nbsp;<b><?= \fw\libs\Helper::getPercent($totalRepeated, $statistics['cardswell']) ?>%</b></div>
                                <div>Отправлено на повтор:&nbsp;<b><?= \fw\libs\Helper::getPercent($totalRepeated, $statistics['cardshard']) ?>%</b></div>
                                    <? if($statistics['addednewcard'] || $statistics['addedcloud'] || $statistics['addedwords']) :?>
                                        <hr>
                                        <? if($statistics['addednewcard']): ?>
                                            <div>Добавлено новых карточек:&nbsp; <b><?=$statistics['addednewcard']?></b></div>
                                        <? endif; ?>
                                        <? if($statistics['addedcloud']): ?>
                                            <div>Добавлено новых фраз в облако:&nbsp;
                                                <b><?=$statistics['addedcloud']?></b></div>
                                        <? endif; ?>
                                        <? if($statistics['addedwords']): ?>
                                            <div>Добавлено слов в словарь:&nbsp; <b><?=$statistics['addedwords']?></b></div>
                                        <? endif; ?>
                                    <? endif;?>
                                <? else: ?>
                                <div>Последняя активность: <?=$lastactive?></div>
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrapper-estimate">
                <?if(!empty($progress)):?>
                    <table class='table'>
                        <thead>
                        <tr>
                            <th scope='col'>Дата занятия</th>
                            <th scope='col'>Легко</th>
                            <th scope='col'>Тяжело</th>
                            <th scope='col'>Оценка</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?foreach($progress['history'] as $item):?>
                            <tr>
                                <th scope='row'><?=$item['lastactivedate']?></th>
                                <td><?=$item['cardswell']?></td>
                                <td><?=$item['cardshard']?></td>
                                <td class="smile">
                                    <?= getEstimate($item['cardswell'], $item['cardshard'], $progress['cardswell'],
                                        $progress['cardshard']); ?>
                                </td>
                            </tr>
                        <?endforeach;?>
                        </tbody>
                    </table>
                <?endif;?>
            </div>


            <? if(isset($panel['doubles_cards']) && is_array($panel['doubles_cards'])): ?>
            <div class='alert alert-danger' role='alert'>
                <span>Найдены дубли карточек! <a href="/cards/doubles"><?=count($panel['doubles_cards']);?></a></span>
            </div>
            <? endif; ?>

            <div class='alert alert-success' role='alert'>
                <span>Всего карточек: <?=$panel['total_cards']?></span>
            </div>

            <div class='alert alert-warning' role='alert'>
                <span>Слов в словаре: <?=$dic?></span>
            </div>

            <div class='alert alert-dark' role='alert'>
                <span>Фраз в облаке: <?=$panel['cloud_items']?></span>
            </div>

            <?  if(\fw\libs\Helper::isAdmin()): ?>
                <div class='alert alert-success' role='alert'>
                    <span>Полезные статьи <a href="/cards/rules">Читать</a></span>
                </div>
            <? endif; ?>
            <br><br>

        </div>
    </div>
</div>

<style>
    .buttons-wrapper {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }
    .w-message .w-label{
        position: relative;
        top: -15px;
        left: 9px;
        background: #fff;
        width: fit-content;
        padding: 0 10px;
        font-size: 12px;
        font-weight: bold;
        color: #333;
    }
    .w-message {
        border: 1px solid #cbcbcb;
        padding: 5px;
        font-size: 13px;
        margin-bottom: 15px;
    }
    .wrapper {
        max-height: 250px;
        overflow: auto;
    }
    .card-body {
        background: #f2ede4;
    }
</style>

<script src='/public/assets/js/ajax.js'></script>



