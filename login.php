<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Уввійдіть на сайт!</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<main>
		<form class = "main-form" >
			<div class="logo">
				<img src="img/logo.svg" alt="" class="logo-img">
				<div class="logo-title">F5 Remonts Base</div>
			</div>
			<p class="error"></p>
			<input class= "form-item" type="text" name="login" placeholder="Логін чи e-mail...">
			<input class= "form-item" type="password" name="password" placeholder="Пароль...">
			<button type="submit">Уввіти</button>
		</form>
		<a href="register.php">Зареєструватися в системі</a>
		
	</main>
    <script src="js/jquery-3.5.1.min.js"></script>	
	<script src="js/login.js"></script>
</body>
</html>