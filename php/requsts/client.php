<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title></title>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="style_c.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap&subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
<style>
    .warning{
        color: yellow;
    }
</style>
</head>
<body>
     <?php 
require 'db.php';
$id = $_GET['id'];
$res = R::getRow("SELECT * FROM `remont` WHERE `id_publick` = ".$id);


  ?>
 <div class="container">
     <div class="row">
         <div class="col lg6 sm3 active_punct" >Назва</div>
         <div class="col lg6 sm9 active_punct2" >Значення</div>
     </div>
     <div class="row">
         <div class="col lg6 sm3 sample1" >Прізвище</div>
         <div class="col lg6 sm9 sample2" ><?php echo $res['surname']?></div>
     </div>
    <div class="row">
         <div class="col lg6 sm3 sample2" >Модель</div>
         <div class="col lg6 sm9 sample1" ><?php echo $res['model']?></div>
     </div> 
     <div class="row">
         <div class="col lg6 sm3 sample1" >Телефон</div>
         <div class="col lg6 sm9 sample2" ><?php echo $res['phone_num']?></div>
     </div>
     <div class="row">
         <div class="col lg6 sm3 sample2" >Пломка</div>
         <div class="col lg6 sm9 sample1" ><?php echo $res['broke'] ?></div>
     </div>
     <div class="row">
         <div class="col lg6 sm3 sample1" >Дата</div>
         <div class="col lg6 sm9 sample2" ><?php echo $res['date']?></div>
     </div>
     <div class="row">
         <div class="col lg6 sm3 sample2" >Ціна</div>
         <div class="col lg6 sm9 sample1" ><?php echo $res['price_our']?></div>
     </div>
     <div class="row">
         <div class="col lg6 sm3 sample1" >Унікальний код</div>
         <div class="col lg6 sm9 sample2" ><?php echo $res['id_publick'] ?></div>
     </div>
     <div class="row">
         <div class="col lg6 sm3 sample2" >Примітки</div>
         <div class="col lg6 sm9 sample1" ><?php echo $res['notes']?></div>
     </div>
     <div class="row important">
         <div class="col lg12"><?php 
If($res['price_our'] == '' or $res['price_our'] == 'Null'  or $res['price_our'] == ' '){
    echo "<span class='warning'>В ремонті...</span>";
}else{
    if($res['price_our'] != "не зроб" || $res['price_our'] != "не зроблено" || $res['price_our'] != "не зроб."|| $res['price_our'] != "не зроб"|| $res['price_our'] != "X"|| $res['price_our'] != "x"|| $res['price_our'] != "х"|| $res['price_our'] != "Х"){
    echo "<span class='success'>Зроблено</span>";
}else{
    echo "<span class='erorr'>Не зроблено</span>";
}    
}

         ?></div>
     </div>
     <div class="row footer">
     	<div class="col lg6 sm6 ">
     		F5 servise <a href="https://t.me/F5Remontsbot">@F5Remontsbot - наш телеграм бот!</a>
     	</div>
     	<div class="col lg6 sm6 right">
     		<span>Designed by </span><a href="https://www.instagram.com/andriypol68/">@andrijpol68</a>
     	</div>
     </div>
 </div>

</body>
</html>