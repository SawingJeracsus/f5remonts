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
	<link rel="stylesheet" href="css/report.css">
</head>
<body>
	<div class="content-wrapper">
		<header>
		<div class="container">
			<div class="header-content-wrapper">
				<div class="header-filters-pannel">

				<!-- <div class="filter_block">
					<h1 class="filter-block-title">
						Сортувати за:
					</h1>
					<div class="filter-block-input-wrapper">
						<select name="sort_type" class="filter-block-input">
							<option value="id">ID</option>
							<option value="surname">Прізвище</option>
						 	<option value="surname">Модель</option>	
							<option value="surname">Номер телефону</option>	
							<option value="surname">Несправність</option>	
							<option value="surname">Майстер</option>	
							<option value="surname">Дата</option>	
							<option value="surname">Ціна</option>	 
						</select>
					</div>
				</div> -->
				<!-- <div class="filter_block">
					<h1 class="filter-block-title">
						З:
					</h1>
					<div class="filter-block-input-wrapper">
						<input type="text" placeholder="З..." class="filter-block-input">
						<button class="btn priamary filter-block-input-button">
							<img src="img/calendar.svg" alt="calendar">
						</button>
					</div>
				</div>
				<div class="filter_block">
					<h1 class="filter-block-title">
						По:
					</h1>
					<div class="filter-block-input-wrapper">
						<input type="text" placeholder="По..." class="filter-block-input">
						<button class="btn priamary filter-block-input-button">
							<img src="img/calendar.svg" alt="calendar">
						</button>
					</div>
				</div> -->
				

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
			<!-- <div class="filter">
				<h4 class="filter-title">Фільтр по даті №1</h4>
				<button class="btn filter-close">
					<img src="img/times.svg" alt="close">
				</button>
			</div>
			<div class="filter">
				<h4 class="filter-title">Фільтр по даті №2</h4>
				<button class="btn filter-close">
					<img src="img/times.svg" alt="close">
				</button>
			</div> -->
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
			<!-- <div class="main-feed-item">
					<div class="id col">102221</div>		
					<div class="col item-info-block">Прізвище</div>
					<div class="col item-info-block">Модель</div>
					<div class="col item-info-block">Номер</div>
					<div class="col item-info-block">Несправність</div>
					<div class="col item-info-block">Майстер</div>
					<div class="col item-info-block">Дата</div>
					<div class="col item-info-block">Ціна</div>
			</div> -->
			
		</div>
	</main>
	<footer>
		<div class="footer-container container">
			<div class="col footer-title">
				Загальна статистика:
			</div>
			<div class="col"></div>
			<div class="col stats-block">
				Cтатистика Моделі
			</div>
			<div class="col"></div>
			<div class="col stats-block">
				Cтатистика Поломок
			</div>
			<div class="col stats-block">
				Cтатистика Майтрів
			</div>
			<div class="col stats-block">
				Cтатистика Дат
			</div>
			<div class="col"></div>
		</div>
	</footer>
	</div>
	<script src="js/jquery-3.5.1.min.js"></script>
  	<script src="datepicker/dist/datepicker.js"></script>
	<script src="js/report.js"></script>
</body>
</html>