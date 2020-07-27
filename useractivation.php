<?php
    require 'php/db/db.php';
    $users = R::getAll('SELECT * FROM `users`');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Activation</title>
    <link rel="stylesheet" href="css/useractivation.css">
</head>
<body>
    <main>
        <div class="container">
            <h1 class="title">Активаіця Користувачів</h1> <a href="<?= $actual_link_parrent?>">Назад</a>
            <ul class="users_list">
                
                <?php foreach ($users as $key => $user) :?>
                    <li class="user">
                    <div class="left">
                        <span class="name"><?=$user['login'];?></span>
                        <span class="email"><?=$user['email'];?></span>
                    </div>
                    <label class="activated">
                        <input type="checkbox" data-id = "<?=$user['id'];?>" name="activated" <?= $user['activated'] ? 'checked' : ''; ?>>
                        <div class="checkbox-div"></div>    
                    </label>
                </li>  
                <?php endforeach; ?>
            </ul>    
        </div>
    </main>
	<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/useractivation.js"></script>
</body>
</html>