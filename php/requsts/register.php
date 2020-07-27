<?php 
require '../db/dbUnProtected.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

session_start();
$errors = [];

if(strlen($_POST['password']) < 6){
	$errors[] = 'Password has so short!';
}
if($_POST['password'] !== $_POST['password_second']){
	$errors[] = 'Passwords not same!';
}
if(R::getRow('SELECT COUNT(`id`) FROM `users` WHERE `email` = "'.$_POST['email'].'"')['COUNT(`id`)'] > 0){
	$errors[] = 'User with this email is already exist!';
}
if(R::getRow('SELECT COUNT(`id`) FROM `users` WHERE `login` = "'.$_POST['login'].'"')['COUNT(`id`)'] > 0){
	$errors[] = 'User with this login is already exist!';
}

if(empty($errors)){
	$user = R::dispense('users');
	$user->login = $_POST['login'];
	$user->email = $_POST['email']; 
	$user->password = md5($_POST['password']); 
	$user->activated = 0;
	$user->token = $token = md5(rand(1, 10000));


	try {
		$id = R::store($user);		
		// $_SESSION['user'] = R::getRow('SELECT * FROM `users` WHERE `id` = '.$id);
		$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

$mail->Port = 587;

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

$mail->SMTPAuth = true;

$mail->Username = 'smurffrums18@gmail.com';

//Password to use for SMTP authentication
$mail->Password = '!2qazwsx';

//Set who the message is to be sent from
$mail->setFrom($_SMPT['username'], 'F5 service');

//Set who the message is to be sent to
$mail->addAddress($admin_email, 'Andriy Polishchuk');

//Set the subject line
$mail->Subject = 'User submiting user system access';

$mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'User '.$_POST['login'].' trying get access to database!';
    $mail->Body    = '
    <div class="main" style="
          display: -webkit-flex;
          display: -ms-flex;
          display: flex;
          align-items: center;
          justify-content: space-around;
          flex-direction: column;
          font-family: "Jost", sans-serif;">
      <p>Accept</p>
      <a href="'.$sitelink.'/accept.php?token='.$token.'" style="
          display: block;
          width: 500px;
          padding: 4px;
          background-color: #4CAF50;
          color: #fff;
          text-align: center;
          margin-bottom: 10px;
          font-size: 2em;
          text-decoration: none;
      ">Accept</a>
    </div>
    ';

// //Replace the plain text body with one created manually
// $mail->AltBody = 'This is a plain-text message body';

	} catch (Exception $e) {
		echo json_encode([
			'message' => 'Bad database connection, try again later!',
			'type'	  => 'error'
		]);	
		die;
	}
    //   $mail->send();
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

