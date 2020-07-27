<?php 
require '../db/db.php';
  $res = R::getRow('SELECT `id_publick`,`id` FROM `remonts` ORDER BY `id` DESC  LIMIT 1 ');

  echo json_encode([
    'id_publick' => $res['id_publick'],
    'id'         =>  $res['id']
  ]);
 ?>