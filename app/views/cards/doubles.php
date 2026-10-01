<?php
if(!count($doubles))
    \fw\libs\Helper::redirect("/cards/");
?>
<div class="result"></div>
<? foreach($doubles as $arr): ?>
    <div class="row couple">
        <? foreach ($arr as $card): ?>
            <div class="card col-6">
                <div class="info">
                    <div style="font-size: 12px">id: <?=$card->id?></div>
                    <div>
                        <span class='trash' data-id="<?=$card->id?>">
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16'
                                                         fill='currentColor'
                             class='bi bi-trash' viewBox='0 0 16 16'>
                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'></path>
                            <path fill-rule='evenodd'
                                  d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'></path>
                        </svg>
                        </span>
                    </div>
                </div>
                <div class="front"><?=$card->front?></div>
                <hr>
                <div class="back"><?=$card->back?></div>
            </div>
        <? endforeach; ?>
    </div>
<? endforeach; ?>

<style>
    .trash{
        cursor:pointer;
    }

    .card.col-6 {
        max-width: 47%;
        margin: 5px;
        outline: 1px solid #333;
    }
    .info {
        display: flex;
        justify-content: space-between;
    }
</style>

<script>

    $(document).ready(function(){
        $('.trash').on('click touchstart', function(event){
            event.preventDefault();
            let _this = $(this);
            $('.result').empty();
            let res = confirm('Удалить?');
            if(res === false) return false;

           let itemid = $(this).data('id');
           _this.parent('.couple').hide(500);

           $.ajax({
               url: "/cards/del",
               type: "post",
               data:{del:itemid},
               success: function(res){

                   $(".result").text(res);
                   setTimeout(function(){
                        window.location.href = "/cards/doubles";
                   },1000);
               },
               error: function(){
                   $('.result').text(res);
               }

           });
        });
    });
</script>

