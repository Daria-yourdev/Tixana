<?php
include('connection/database.php');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>CRUD</title>
</head>

<body>
    <?php
    include('incl/header.php');
    if (isset($_GET['page'])) {
        $page = $_GET['page'];

        if ($page === 'create-product') {
            include('includes/create-product.php');
        } elseif ($page === 'edit-product' && !empty($_GET['id'])) {
            include('includes/edit-product.php');
        } elseif ($page === 'delete-product' && !empty($_GET['id'])) {
            include('includes/delete-product.php');
        } elseif ($page === 'show-product' && !empty($_GET['id'])) {
            include('includes/show-product.php');
        } else {
            include('includes/404.php');
        }
    } else {
        include('includes/main.php');
    }
    ?>
</body>

</html>