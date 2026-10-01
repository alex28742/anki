<br>
<br>
<div class='container-search'>
    <div class='search-wrap fixed-top' style='' data-word='<?=$word?>'>
        <input type='search' class='form-control ds-input' id='search-input' placeholder='найти..'>
    </div>
</div>

<div class="result"></div>
<? if(count($clouds)): ?>
<?php foreach($clouds as $val): ?>
    <div class='card'>
        <div class='card-body'>
            <?=$val['text'];?>
        </div>
        <div class="card-actions">
            <form class="default delete" action="/cards/cloudList" method="post">
                <input type="hidden" name="delete" value="<?=$val['id']?>">
                <input class="btn btn-outline-danger btn-sm" type="submit" value="удалить">
            </form>
            <form class='default add' action="/cards/cloudList" method="post">
                <input type='hidden' name='add' value="<?= $val['id'] ?>">
                <input class='btn btn-outline-primary btn-sm' type='submit' value='в колоду'>
            </form>
        </div>
    </div>
<?php endforeach; ?>
<? else: ?>

    <div class='alert alert-warning' role='alert'>
        Нет записей в облаке
    </div>
<? endif; ?>
<div style='margin-bottom: 15px; height:50px;'></div>

<style>
    .fixed-top {
        position: relative;
        top: 0px;
    }
    .container-search {
        position: fixed;
        top: -14px;
        z-index: 99;
    }
    .content {overflow: auto;}
    .card-actions {
        display: flex;
        justify-content: end;
        margin-bottom: 5px;
        background: #f7f1f1;
    }
    .card-actions form {margin: 2px 5px;}
    .card-actions form input.btn {margin-top:2px; margin-bottom: 2px;}
</style>

<!--<script src='/public/assets/js/ajax.js'></script>-->

<script>

    $(document).ready(function(){




        // client-side filter by word
        let searchInput = $('#search-input');
        searchInput.on('input', function(){
            let res = $(this).val().toLowerCase(); // current search box value
            $('.card').each(function(){
                // search by word
                let text = $(this).find('.card-body').text().toLowerCase();
                let find = text.indexOf(res); // indexOf returns -1 when not found
                if(find !== -1) $(this).show();
                else $(this).hide();
            })
        });

        let search = $('.search-wrap').data('word');
        if(search !== ""){
            searchInput.val(search);
            searchInput.trigger('input');

        }

    });






    // hide the row being deleted
    $('form.delete').submit(function(event){
        event.preventDefault();
        $(this).closest('.card').hide(500);
    });
    // redirect to the add-card screen
    $('form.add').submit(function (event){
       event.preventDefault();
       setTimeout(function(){
           window.location.href = '/cards/add';
       },1000);

    });


</script>