<?php

$host = 'localhost';
$dbname = 'maket-17';
$name = 'root';
$password = '';

try {
    $database = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;", $name, $password);
} catch (PDOException $error) {
    die('Ошибка подключения к бд: ' . $error->getMessage());
}
?>