<?php 
// print_r($_POST);
require '../db/dbUnProtected.php';
session_start();

$errors = [];

$user = R::getRow('SELECT * FROM `users` WHERE `login` = "'.$_POST['login'].'" OR `email` = "'.$_POST['login'].'"');

if(empty($user)){
		$errors[] = 'Incorect password or login/email!1';
}else{
	if(md5($_POST['password']) != $user['password']){
		$errors[] = 'Incorect password or login/email!2';
	}
 	if($user['activated'] == '0'){
		$errors[] = 'User has not activated!';
 	}
 }

if(empty($errors)){
	$_SESSION['user'] = $user;
	echo json_encode([
		'message' => $sitelink,
		'type'	  => 'success'
	]);
}else{
	echo json_encode([
		'message' => $errors[0],
		'type'	  => 'error'
	]);
}

 ?>
