<?php
require '../db/db.php';
$lastDATA = R::getRow('SELECT `history` FROM `remonts` WHERE `id` = '.$_POST['id'])['history'];
$date = json_decode($lastDATA !== ''? $lastDATA: '[]');
$date[] = [
  'date' => date('d:m:Y'),
  'note' => $_POST['notes_4']
];
$date = json_encode($date, JSON_UNESCAPED_UNICODE);

$sql = 'UPDATE `remonts` SET `history` = \''.$date.'\' WHERE `id` = '.$_POST['id'];
try {
  R::exec($sql);
} catch (\Exception $e) {
  echo $sql;
  echo json_encode([
    'type' => 'error',
    'message' => 'saving_error'
  ]);
  die;
}
$lastDATA = R::getRow('SELECT `history` FROM `remonts` WHERE `id` = '.$_POST['id'])['history'];
echo $lastDATA;

 ?>
