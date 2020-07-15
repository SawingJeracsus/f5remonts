<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Реєстрація в сиситемі!</title>
	<link rel="stylesheet" href="css/register.css">
</head>
<body>
	<main>
		<form class = "main-form" >
			<div class="logo">
				<img src="img/logo.svg" alt="" class="logo-img">
				<div class="logo-title">F5 Remonts Base</div>
			</div>
			<p class="error"></p>
			<input class= "form-item" type="text" name="login" placeholder="Логін...">
			<input class= "form-item" type="text" name="email" placeholder="Email...">
			<input class= "form-item" type="password" name="password" placeholder="Пароль...">
			<input class= "form-item" type="password" name="password_second" placeholder="Пароль ще раз...">
			<button type="submit">Зареєструватися</button>
		</form>
		<a href="login.php">Уввійти в систему</a>

	</main>
	<script src="js/jquery-3.5.1.min.js"></script>	
	<script src="js/register.js"></script>
</body>
</html>