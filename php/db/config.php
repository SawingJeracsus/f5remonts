<?php
$server_user_name = 'root';
$server_password = '';
$server_db_name = 'f5remonts';
$server_url='localhost';

$sitelink = 'http://f5remonts/';
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link_parrent = "http://$_SERVER[HTTP_HOST]";

$_SMPT = [
    'host' => 'smtp.gmail.com',
    'username' => 'email',
    'password' => 'pass',
    'port' => 587
  ];

$admin_email = 'polisukandrij68@gmail.com';
 ?>
