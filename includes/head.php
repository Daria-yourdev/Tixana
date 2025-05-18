<?php
session_start();
require_once(__DIR__ . '/../connection/database.php');

$USER = null;

if (isset($_SESSION['user_id'])) {
    $id = (int)$_SESSION['user_id'];
    $stmt = $database->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$id]);
    $USER = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_GET['exit'])) {
    session_destroy();
    header("Location: ./");
    exit;
}
