<?php 
print_r($_GET);
require 'php/db/db.php';
R::exec('UPDATE `users` SET `activated` = 1  WHERE `token` = "'.$_GET['token'].'"');
 ?>