<br>
<form action="">
    <input type="hidden" class="card-b id" name="id" value="<?=$mistake['id']?>">
   <div class='card'>
      <div class="title">Ситуация</div>
       <div class='card-b description'><?=$mistake['description']?></div>
    </div>

   <div class='card'>
      <div class='title'>Чему я научился</div>
       <div class='card-b lesson'><?=$mistake['lesson']?></div>
   </div>

   <div class='card'>
      <div class='title'>Выводы на будущее</div>
       <div class='card-b conclusion'><?=$mistake['conclusion']?></div>
   </div>

   <div class='card'>
      <div class='title'>Что положительного в этой ситуации</div>
       <div class="card-b helpful"><?=$mistake['helpful']?></div>
   </div>

</form>


<style>
   .card{
      font-size: 0.8em;
      padding: 10px;
      margin-bottom: 20px;
   }
   .title {
      width: fit-content;
      background: #fff;
      padding: 0 10px;
      margin-top: -20px;
      font-style: italic;
      font-weight: bold;
      color: #6c6c6c;
   }
</style>

