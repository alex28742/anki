$(document).on('submit','form.auth', function(event){
    event.preventDefault();
    let $form = $(this);

    //
        $.ajax({
            url: $form.attr('action'), // куда будет идти запрос
            type: $form.attr('method'), // метод передачи данных
            data: $form.serialize(), // данные которые хотим получить
            success: function(res){ // что делаем при получении ответа
                $('.result').empty();
                if(res) {
                    if (res == "Y") {
                        $('.result').html("<div class='alert alert-success'>Добро пожаловать!</div>");
                        setTimeout(function () {
                            window.location.href = document.referrer;
                        }, 1000);
                    } else if (res == "N") {
                        $('.result').html("<div class='alert alert-danger'>Неправильный логин / пароль</div>");
                    } else if(res){
                        $('.result').html("<div class='alert alert-danger'>"+res+"</div>");
                    } else {
                        $('.result').html("<div class='alert alert-danger'>Произошла ошибка((</div>");
                    }
                }
            },
            error: function(){ // если возникла ошибка
                $('.result').html("<div class='alert alert-danger'>Произошла ошибка((</div>");
            }
        });
    return false;
});