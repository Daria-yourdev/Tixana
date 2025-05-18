<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
</head>

<body>
    <!-- header -->
    <header class="header">
        <div class="header-content container_wide">
            <img src="assets/media/logo/logo.svg" alt="" onclick="window.location.href='./'" class="logo">

            <input type="checkbox" id="burger-toggle" class="burger-toggle">
            <label for="burger-toggle" class="burger-menu">
                <span></span>
                <span></span>
                <span></span>
            </label>

            <nav class="main-nav">

                <div class="h-nav">
                    <a href="./" class="h-nav_item">Главная</a>
                    <a href="./?page=catalog" class="h-nav_item">Каталог</a>
                    <a href="./#receps" class="h-nav_item">Советы</a>
                    <a href="./#questions" class="h-nav_item">FAQ</a>
                    <a href="./?page=about" class="h-nav_item">О нас</a>
                </div>

                <a href="tel: 79650842929" class="h-tel"><img src="assets/media/icons/tel.svg" alt="">+7 (965)
                    084-29-29</a>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a class="h-nav_item" href="./?page=authorization">Авторизация</a>
                    <a class="h-nav_item" href="./?page=registration">Регистрация</a>
                <?php else: ?>

                    <?php if (isset($USER['role']) && $USER['role'] === 'admin'): ?>
                        <a class="h-nav_item btn_mob" href="./?page=admin">Админ панель</a>
                    <?php else: ?>
                        <img src="assets/media/icons/button_cart.svg" alt="" class="header-btn"
                            onclick="window.location.href='./?page=cart'">

                        <a href="./?page=profile" class="h-nav_item">Профиль</a>
                        
                    <?php endif; ?>

                    <a class="h-nav_item" href="?exit">Выйти</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
</body>

</html>