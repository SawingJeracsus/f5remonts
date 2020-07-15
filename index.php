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
  <title>База ремонтів</title>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
  <link  href="datepicker/dist/datepicker.css" rel="stylesheet">
</head>
<body>
  <header>
    <div class="logo">
      <img src="img/logo.svg" class="logo-img">
      <h1 class="logo-title">F5 Remonts Base</h1>
    </div>
    <div class="searchbar fsb">
      <input data-toggle="datepicker" class="searchbar-input" type="search" placeholder="Введіть пошуковий запит...">
      <button class="btn search_submit">
        <img src="img/search.svg" class="search-icon">
      </button>
      <button class="btn datepick_btn primary fc">
        <img src="img/calendar.svg" class="search-icon">
      </button>
    </div>
  </header>
  <main class="fsb">
    <div class="sidebar fc">
      <form action="#" class="editing-form fsb">
        <div class="form-item">
          <div class="form-title">Прізвище</div>
          <input type="text" name="surname" placeholder="Прізвище...">
        </div>
        <div class="form-item">
          <div class="form-title">Модель</div>
          <input type="text" name="model" placeholder="Модель...">
        </div>
        <div class="btn-group">
           <div class="form-item">
              <div class="form-title">Номер телефону</div>
              <input type="text" name="phone_num" placeholder="Номер телефону...">
            </div>
            <a class="abtn call fc primary" href="#"><img src="img/phone1.svg" alt=""></a>
        </div>
       
        <div class="form-item">
          <div class="form-title">Несправність</div>
          <input type="text" name="broke" placeholder="Несправність...">
        </div>
        <div class="form-item">
          <div class="form-title">Майстер</div>
          <input type="text" name="master" placeholder="Майстер...">
        </div>
        <div class="form-item">
          <div class="form-title">IMEI</div>
          <input type="text" name="imei" placeholder="IMEI...">
        </div>
        <div class="btn-group fsb">
          <div class="form-item">
            <div class="form-title">Дата</div>
            <input type="text" name="date" placeholder="Дата...">
          </div>
          <button type="button" class="btn primary add-story-item">
            +
          </button>
        </div>
        <div class="form-btn-item">
          <button type="button" class="btn primary show-story">
            Продивитися історію
          </button>          
        </div>
        <div class="splited-group fsb">
          <div class="form-item">
            <div class="form-title">Ціна майстра</div>
            <input type="text" name="price_master" placeholder="Ціна майстра...">
          </div>
          <div class="form-item">
            <div class="form-title">Ціна магазину</div>
            <input type="text" name="price_our" placeholder="Ціна магазину...">
          </div>
        </div>
        <div class="form-item">
          <div class="form-title">Примітки</div>
          <input type="text" name="notes" placeholder="Примітки...">
        </div>

        <div class="splited-group fsb bottom">
          <div class="form-item checkbox fsb">
            <div class="form-title">Гарантійний</div>
            <input type="checkbox" name="wariaty">
          </div>
          <div class="form-item id fc">
            <div class="form-title">ID:</div>
            <span class="formid"></span>
            <span class="formsaveby"></span>
          </div>
        </div>
      </form>
    </div>
    <!-- Sidebar End-->
    <div class="main-feed">
      <div class="main-feed-body fsb">
        <div class="history-block hide">
          <h3 class="title">Історія ремонту</h3>
          <div class="history-body">
          </div>
        </div>
        <div class="feed"></div>
      </div>
      <!-- /.main-feed-body -->
      <div class="main-feed-footer primary">
        <button class="btn instrument addnew">Добавити новий</button>
        <button class="btn instrument coppy">Копіювати</button>
        <button class="btn instrument print">Надрукувати</button>
        <button class="btn instrument master_coppy visible">Копіювати для майстра</button>
        <button class="btn instrument last visible">Останній</button>
        <a class="abtn instrument fc viber visible"href="#">Viber</a>
      </div>
      <!-- /.main-feed-footer -->
    </div>
    <!-- /.main-feed -->
  </main>
  <div class="addnew_form_wrapper fc hidden">
    <form class="addnew_form fsb">
      <div class="form-hero fsb">
        <h3 class="title">Новий ремонт</h3>
        <button type="button" class="btn addnewformclose"><img src="img/times.svg" alt=""></button>
      </div>
      <div class="inputs-group fsb">
        <input type="text" name="surname" placeholder="Прізвище...">
        <input type="text" name="model" placeholder="Модель...">
        <input type="text" name="phone_num" placeholder="Номер телефону...">
        <input type="text" name="broke" placeholder="Несправність...">
        <input type="text" name ="master" placeholder="Майcтер...">
      </div>
      <button class="btn primary fc addnewsave">Зберегти</button>
    </form>
  </div>

  <div class="addnewhistory_form_wrapper hidden fc">
    <form class="addnewhistory_form fsb">
      <div class="form-hero fsb">
        <input type="text" name="notes_4" class="new-history-input">
        <!-- <button type="submit" class="btn primary fc save_story">+</button> -->
        <button type="button" class="btn addnewhistoryformclose"><img src="img/times.svg" alt=""></button>
      </div>
    </form>
  </div>

  <div class="history_wrapper hidden fc">
    <form class="history fsb">
      <div class="history-header fsb">
        <h3 class="title">Історія ремонту</h3>
        <button type="button" class="btn close-history"><img src="img/times.svg" alt=""></button>
      </div>
      <div class="history-body main">
      </div>
    </form>
  </div>

  <footer class="primary-dark fc">
    <button class="btn instrument back">Назад</button>
    Designed by <a href="https://www.instagram.com/andriypol68/">Andriy Polishchuck</a>
  </footer>
  <a href="report.php" class="report abtn">Звіт</a>
  <script src = "js/qrcode.min.js"></script>
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="datepicker/dist/datepicker.js"></script>
  <script src="js/app.js"></script>
</body>
</html>
