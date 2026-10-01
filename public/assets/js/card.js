$('form.card-btn').on('submit', function(event){
    event.preventDefault();
    $('.wrapper').empty();
    let $form = $(this);
    let isError = false; // сохранение ошибок
    // если нет ошибок, передаю данные
    let action = $form.attr('action') + "?nocache="+Math.random();
    if(!isError){
        $.ajax({
            url: action, // куда будет идти запрос
            type: $form.attr('method'), // метод передачи данных
            data: $form.serialize(), // данные которые хотим получить
            cache: false, // не кешировать
            success: function(res){ // что делаем при получении ответа
               $('.wrapper').html(res);
            },
            error: function(){ // если возникла ошибка
               alert('error');
            }
        });
    }

});