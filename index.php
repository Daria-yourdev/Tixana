<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tixana</title>
</head>

<body>
    <?php
    include('includes/head.php');

    $page = $_GET['page'] ?? 'main';

    if ($page !== 'admin' && $page !== 'create-product' && $page !== 'edit-product' && $page !== 'delete-product') {
        include('includes/header.php');
    }

    $requireAuth = ['cart', 'order', 'profile'];
    $requireAdmin = ['edit', 'add', 'add_category', 'admin', 'all_category'];

    if (in_array($page, $requireAuth) && !isset($USER)) {
        include('includes/authorization.php');
        return;
    }

    if (in_array($page, $requireAdmin) && (!isset($USER['role']) || $USER['role'] !== 'admin')) {
        include('includes/404.php');
        return;
    }

    switch ($page) {
        case 'main':
            include('includes/main.php');
            break;

        case 'catalog':
            include('includes/catalog.php');
            break;

        case 'about':
            include('includes/about.php');
            break;

        case 'cart':
            include('includes/cart.php');
            break;

        case 'order':
            include('includes/order.php');
            break;

        case 'profile':
            include('includes/profile.php');
            break;

        case 'about':
            include('includes/about.php');
            break;

        case 'product':
            include('includes/product.php');
            break;

        case 'admin':
            include('includes/admin.php');
            return;

        case 'create-product':
            include('includes/create-product.php');
            return;

        case 'edit-product':
            include('includes/edit-product.php');
            return;

        case 'delete-product':
            include('includes/delete-product.php');
            return;

        case 'registration':
            include('includes/registration.php');
            return;

        case 'authorization':
            include('includes/authorization.php');
            return;

        default:
            include('includes/404.php');
            break;
    }

    include('includes/footer.php');
    ?>
</body>

</html>