<?php
    // print_r($_POST);
    $sql = $_POST['sql'];

    require '../db/db.php';
    $res = R::getAll($sql);

    // print_r($res);
    foreach ($res as  $settings) {
        include '../components/reportitem.php';
    }
?>