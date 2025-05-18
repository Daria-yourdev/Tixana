<?php

try {
    $database = new PDO("mysql:host=localhost;dbname=tea_store;charset=utf8;", "root", "");
} catch (PDOException $error) {
    die('Ошибка подключения к бд: ' . $error->getMessage());
}

?>