<?
if(\fw\libs\Helper::getUserID())
    \fw\libs\Helper::redirect('/cards');
?>

<div style="margin: 50px auto">
    <a href='/' class='btn btn-outline-primary'>На главную</a>
    <button type='button' class='btn btn-outline-success' data-bs-toggle='modal'
            data-bs-target='#auth'>Авторизация</button>
    <br><br>
    <p>Пожалуйста, авторизуйтесь или зарегистрируйтесь</p>

</div>



<script src='/public/assets/js/auth.js'></script>

<script>
   $(document).ready(function(){
       $('form.register').on('submit', function(event){
           event.preventDefault();
           $('.result').empty();
           let form = $(this);
           $.ajax({
               url: form.attr('action'), // request target
               type: form.attr('method'), // HTTP method
               data: form.serialize(), // data to send
               cache: false, // skip the cache
               success: function(res){
                    $('.result').html(res);
                    // check whether it succeeded
                   if(res.indexOf('успешно', res) !== -1){
                       setTimeout(function(){
                           window.location.href = '/';
                       },2000);
                   }
                   setTimeout(function(){
                       $('.result').hide();
                   },2000);
               },
               error: function(){
                   alert('bad request, try again');
               }
           });
       });

       $('form.auth').on('click', function(){
           $('.result').empty();
       })


   });
</script>