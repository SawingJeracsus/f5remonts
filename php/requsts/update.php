<?php
require '../db/db.php';
$sql = 'UPDATE `remonts` SET '.$_POST['table'].' = "'.$_POST['val'].'" WHERE `id` = '.$_POST['id'];
R::exec($sql);
// echo $sql;
// echo json_encode()
 ?>
