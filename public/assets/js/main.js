// доп проверка при добавлении слова в словарь (на существование слова)
$(document).ready(function(){

    $('#toDictionary input').on('click touchstart', function (){
        $('.result').show();
       // запрос ajax с проверкой наличия слова в словаре
        let word = $('input#word').val();
        let res = $('.result').load('/dictionary/check', {data:word});
        if(res){
            setTimeout(function(){ $('.result').hide(1500).empty(); },1000);
        }
    });

    // очистка полей формы добавления слова в словарь
    $('.dictionary-clear-form').on('click touchstart', function(){
        $(this).closest('form').find('input').val("");
        $(this).closest('form').find('textarea').val("");
    });

    // разделение фразы на две части по пробелу (первое слово и остальная часть строки)
    // при добавлении слова в словарь, разбиваю на слово и произношение
    function division(str){
        let res = [];
        // получаю первое слово в массив с индексом 0
        res.push(str.split(' ', 1));
        // получаю остаток строки в массив с индексом 1
        res.push($.trim(str.replace(res[0], '')));
        return res;
    }

    $('.dictionary-split').on('click touchstart', function(event){
        event.preventDefault();
        let word = $(this).closest('form').find('#word');
        let pronounce = $(this).closest('form').find('#pronounce');
        if(word.val() && pronounce.val() === ""){
            let res = division(word.val());
            word.val(res[0]);
            pronounce.val(res[1]);

        }
        else if(pronounce.val() && word.val() === ""){
            let res = division(pronounce.val());
            word.val(res[0]);
            pronounce.val(res[1]);
        } else return false;

    });

    $('.register_form_show').on('click touchstart', function(event){
        event.preventDefault();
        $(this).closest('.auth_wrap').hide(); // скрываю форму авторизации
        $('.register_wrap').show(); // показываю форму регистрации
    });

});