<?php 
require 'php/db/db.php';
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['activated'] == '0'){
   header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Звіти</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link  href="datepicker/dist/datepicker.css" rel="stylesheet">
	<link rel="stylesheet" href="css/report.css">
</head>
<body>
	<div class="content-wrapper">
		<header>
		<div class="container">
			<div class="header-content-wrapper">
				<div class="header-filters-pannel">

			</div>
			<div class="header-btn-group">
				<label class="allarm_of_search_type">
					Жорсткий пошук?
					<input type="checkbox" class="allarm_of_search_type_submit">
				</label>	
				
				<button class="btn light addfilter">
					Додати фільтр
				</button>
			</div>
			</div>
		</div>
	</header>
	<section class="filter-section light">
		<div class="filter-container container">
		</div>
	</section>

	<section class="tags-section">
		<div class="tag-container container">
			<div class="col"><button class="btn tag">ID</button></div>
			<div class="col"><button class="btn tag">Прізвище</button></div>
			<div class="col"><button class="btn tag">Модель</button></div>
			<div class="col"><button class="btn tag">Номер Телефону</button></div>
			<div class="col"><button class="btn tag">Несправність</button></div>
			<div class="col"><button class="btn tag">Майстер</button></div>
			<div class="col"><button class="btn tag">Дата</button></div>
			<div class="col"><button class="btn tag">Ціна</button></div>
		</div>
	</section>
	<main class="main-feed">
		<div class="main-container container">
			
		</div>
	</main>
	<footer>
		<div class="footer-container container">
			<div class="col footer-title">
				Загальна статистика:
			</div>
			<div class="col"></div>
			<button class="btn col stats-block">
				Cтатистика Моделі
			</button>
			<div class="col"></div>
			<button class="btn col stats-block">
				Cтатистика Поломок
			</button>
			<button class="btn col stats-block">
				Cтатистика Майcтрів
			</button>
			<button class="btn col stats-block">
				Cтатистика Дат
			</button>
			<div class="col"></div>
		</div> 
	</footer>
								
	<div class="modal fc hidden">
		<div class="modal_container">
			<div class="modal-header">
				<h1 class="modal-title">Статистика Чогось там</h1>							
				<button class="btn modal-close-btn"><img src="img/times.svg" alt="close"></button>
			</div>
			<div class="modal-body">
				<div class="modal-col">
					<div class="stats">
						Найчастіше значення: фів <br>
						Найчастіше значення: фів <br>
						Найчастіше значення: фів
					</div>
					<div class="modal-input-wrapper">
						<h3 class="modal-input-title">Отримати статистику за:</h3>
						<input type="text" placeholder = "Введыть значення...">	
						<button class="btn priamary">
							Вперед
						</button>	
					</div>
				</div>
				<div class="modal-col">
					
				</div>
			</div>
		</div>
		<div class="dark_filter"></div>
	</div>

	</div>
	<script src="js/jquery-3.5.1.min.js"></script>
  	<script src="datepicker/dist/datepicker.js"></script>
	<script src="js/report.js"></script>
</body>
</html>