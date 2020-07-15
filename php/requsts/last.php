<?php 
require '../db/db.php';
  $res = R::getRow('SELECT `id_publick` FROM `remonts` ORDER BY `id` DESC  LIMIT 1 ');

  echo $res['id_publick'];
 ?>