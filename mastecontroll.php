<?php
require 'php/db/db.php';

$masters = R::getAll('SELECT * FROM `masters`');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація нового майстра</title>
    <link rel="stylesheet" href="css/mastercontroll.css">
</head>
<body>
    <main>
        <div class="container">
            <div class="title">
                Реєстрація нового майстра
            </div>
            <ul class = "master-list">
            <div class="items">
            <?php foreach($masters as $master):?>
            <li class="master">
                    <div class="name">
                        <?= $master['name']?>
                    </div>
                    <button class="btn danger remove" data-id="<?= $master['id']?>">-</button>
                </li>
            <?php endforeach;?>    
            </div>
               
            <button class="btn primary add">
                +
                <input type="text" id="newmaster" placeholder=" Введіть ім'я нового майстра">
            </button>  
            </ul>
        </div>
    </main>
  <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/mastercontroll.js"></script>
</body>
</html>