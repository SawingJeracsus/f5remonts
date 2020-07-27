<?php

// print_r($_POST);
require '../db/db.php';
try {
    R::exec('UPDATE `users` SET `activated` = '.$_POST['status'].' WHERE `id` = '.$_POST['id']);
} catch (\Throwable $th) {
    print_r(json_encode([
        'message' => 'Bad DataBase connection',
        'type'    => 'error',
    ], JSON_UNESCAPED_UNICODE));
    die;
}
print_r(json_encode([
    'message' => 'User updated successfull!',
    'type'    => 'success',
], JSON_UNESCAPED_UNICODE));
?>