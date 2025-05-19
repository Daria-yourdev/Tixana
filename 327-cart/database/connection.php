<?php
$host = 'localhost';
$dbanme = 'php17';
$name = 'root';
$password = 'root';
try {
    $database = new PDO("mysql:host=$host;dbname=$dbanme;charset=utf8;", $name, $password);
} catch (PDOException $err) {
    die('Error connection' . $err->getMessage());
}
?>