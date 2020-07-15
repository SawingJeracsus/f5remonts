<?php
require '../db/db.php';

$res = R::getRow('SELECT * FROM `remonts` WHERE `id` = '.$_GET['id']);
print_r(json_encode($res));
 ?>
