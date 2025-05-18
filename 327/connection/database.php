<?php 
    $host = 'localhost';
    $dbname = 'prmm';
    $name = 'root';
    $password = 'root';

    try {
        $database = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;", $name, $password);
    }
    catch(PDOException $err) {
        die('ОШибка подключения' . $err->getMessage());
    }
?>