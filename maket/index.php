<?php

include('database/connection.php');

if (isset($_GET['page'])) {

    $page = $_GET['page'];

    switch ($page) {
        case 'registration':
            include('incl/registration.php');
            exit;

        case 'registration':
            include('incl/registration.php');
            exit;

        case 'authorization':
            include('incl/authorization.php');
            exit;

        case 'admin':
            include('incl/admin.php');
            exit;

        case 'product':
            include('incl/product.php');
            exit;

        case 'add':
            include('incl/add.php');
            exit;

        case 'edit':
            include('incl/edit.php');
            exit;

        default:
            include('404.php');
            exit;
    }
} else {
    include('catalog.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Природный Оазис</title>
    <link rel="icon" type="image/svg" href="images/logo.svg">
</head>

<body>
    <?php include('header.php'); ?>

    <?php include('footer.php'); ?>
</body>

</html>