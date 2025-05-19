<?php
include('database/connection.php');
include('head.php');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Природный Оазис</title>
    <link rel="icon" type="image/svg" href="images/logo.svg">
</head>

<body>
    <?php
    include('header.php');

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        
        $requireAuth = in_array($page, ['basket', 'order', 'profile']);
        $requireAdmin = in_array($page, ['edit', 'add', 'add_category', 'admin', 'all_category']);
        
        if ($requireAuth && !isset($USER['role'])) {
            include('incl/authorization.php');
            exit;
        }
        
        if ($requireAdmin && (!isset($USER['role']) || $USER['role'] !== 'admin')) {
            include('404.php');
            exit;
        }
        
        switch ($page) {
            case 'edit':
                include('incl/edit.php');
                break;
                
            case 'add':
                include('incl/add.php');
                break;
                
            case 'add_category':
                include('incl/add_сategory.php');
                break;
                
            case 'admin':
                include('incl/admin.php');
                break;
                
            case 'basket':
                include('incl/basket.php');
                break;
                
            case 'all_category':
                include('incl/all_category.php');
                break;
                
            case 'product':
                include('incl/product.php');
                break;
                
            case 'order':
                include('incl/order.php');
                break;
                
            case 'registration':
                include('incl/registration.php');
                break;
                
            case 'authorization':
                include('incl/authorization.php');
                break;
                
            case 'profile':
                include('incl/profile.php');
                break;
                
            default:
                include('404.php');
                break;
        }
    } else {
        include('catalog.php');
    }
    ?>

    <footer>
        <div class="header_wrapper footer_wrapper">
            <a href="" class="logo footer_logo">
                <svg width="113" height="113" viewBox="0 0 113 113" fill="" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M56.6674 0L56.6679 1.48894e-06C56.7583 31.0711 81.9289 56.2418 113 56.3321V56.3325C81.873 56.4231 56.6677 81.6843 56.6677 112.833C56.6677 112.888 56.6678 112.944 56.6679 113C56.6677 113 56.6676 113 56.6674 113L56.6677 112.833C56.6677 81.6553 31.4153 56.376 0.248305 56.3323C31.3594 56.2888 56.577 31.1001 56.6674 0ZM0 56.3325L5.43761e-07 56.3322L0.109126 56.3323L0 56.3325Z"
                        fill="" />
                </svg>
                <p>Природный Оазис</p>
            </a>
            <div class="footer_text_wrapper_out">
                <div class="footer_text_wrapper">
                    <p class="footer_title">КОНТАКТЫ</p>
                    <a href="">+7 (999) 999-99-99</a>
                    <a href="">Vk: Природный Оазис</a>
                    <a href="">Tg: Природный Оазис</a>
                </div>

            </div>
        </div>
    </footer>
</body>

</html>