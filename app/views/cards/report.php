<div class="items-wrap">

    <div class='card'>
        <div class='card-body'>
            <span class='date'>28-03-2022</span>
            <span class='text-body'>
                <p> - Открыл возможность авторизации для не админа (убрал проверку на админа)</p>
                <p> - Добавил в контроллер свойство $user</p>
                <p> - Добавил свойство $user в panel свойства</p>
                <p> - Всем карточкам текущим с помощью экшена test проставил id текущего пользователя</p>

                <p> - Дальше надо сделать добавление id при добалвении карточек, слов в словарь и вывод
                    соответственно данных с учетом id пользователя</p>

        </span>
        </div>
    </div>


<div class='card'>
    <div class='card-body'>
        <span class="date">26-03-2022</span>
        <hr>
        <span class="text-body">
            <p> - Убран счетчик слов в карточке при изучении если слово встречается в других карточках только один раз.</p>
            <p> - В методе findCardsByWord() возвращающем количество карточек в которых встречается искомое слово
            добавлены пробелы в выборку ["% $word %"] для избежания выборки карточек в которых есть слова допускающие
                вхождение искомого слова.</p>
            <p> - Во избежание возможной ошибки в методе getDictionaryExt($data) добавлена проверка на строку во
                входящем параметре. if(!is_string($data)) $data = '';</p>
            <p> - Добавлена заготовка для раздела Профиля пользователя /user/profile/ и добавлен метод выхода из
                авторизации /user/exit</p>
            <p>
                 - Сделал аякс регистрацию, но надо доделать авторегистрацию при успешной регистрации. UserController
                стр. 55
            </p>
        </span>
    </div>
</div>
<div class='card'>
    <div class='card-body'>
        <span class='date'></span>
        <span class='text-body'>

        </span>
    </div>
</div>

<div class='card'>
    <div class='card-body'>
       <span class='date'></span>
       <span class='text-body'>

    </span>
    </div>
</div>

</div><!--wrapper-->




<style>
    .items-wrap{
        overflow-y: auto;
        margin-bottom: 50px;
    }
    .card {
        font-size: 13px;
        margin-bottom: 10px;
    }
    .card .date{
        font-weight: bold;
        font-size: 11px;
    }
</style>
