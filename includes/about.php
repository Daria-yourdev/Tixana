<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/media/logo/favicon.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cuprum:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>

<body>

<<<<<<< HEAD:includes/about.php
=======
    <!-- header -->
    <header class="header">
        <div class="header-content container_wide">
            <img src="assets/media/logo/logo.svg" alt="" onclick="window.location.href='index.html'" class="logo">

            <input type="checkbox" id="burger-toggle" class="burger-toggle">
            <label for="burger-toggle" class="burger-menu">
                <span></span>
                <span></span>
                <span></span>
            </label>

            <nav class="main-nav">

                <div class="h-nav">
                    <a href="index.html" class="h-nav_item">Главная</a>
                    <a href="catalog.html" class="h-nav_item">Каталог</a>
                    <a href="#receps" class="h-nav_item">Советы</a>
                    <a href="#questions" class="h-nav_item">FAQ</a>
                    <a href="about.html" class="h-nav_item">О нас</a>
                </div>

                <a href="tel: 79650842929" class="h-tel"><img src="assets/media/icons/tel.svg" alt="">+7 (965)
                    084-29-29</a>

                <img src="assets/media/icons/button_cart.svg" alt="" class="header-btn"
                    onclick="window.location.href='cart.html'">

                <a href="profile.html" class="h-nav_item">Профиль</a>
                <label for="auth-toggle" class="h-nav_item">Войти</label>
                <a href="admin.html" class="h-nav_item btn_mob">Я админ</a>
            </nav>
        </div>
    </header>

>>>>>>> 41af80474d942d21fc5da17f74398ca8d070d058:about.html
    <main>
        <!-- about -->
        <div class="banner">
            <div class="about_content container">

                <div class="b_left-top about_right">
                    <h1 class="title-1 white">ДОБРО ПОЖАЛОВАТЬ В ТИЗАНУ!</h1>
                    <p class="subtitile left white"><br> Мы — команда энтузиастов, влюбленных в чай и его многовековую
                        культуру. Наша миссия — делиться с вами лучшими сортами чая со всего мира, сохраняя традиции и
                        предлагая только натуральные, качественные продукты. <br><br><br>
                        <b>Наша философия</b><br><br>
                        Чай — это не просто напиток, а целый ритуал, способ замедлиться, насладиться моментом и
                        почувствовать гармонию. Мы верим, что хороший чай должен быть доступен каждому, и стремимся
                        сделать ваш выбор простым и приятным.
                    </p>

                    <img src="assets/media/banner/banner_btn1.svg" alt="" class="banner-btn">
                </div>


                <img src="assets/media/about/img.jpg" alt="" class="about-img">
            </div>
        </div>

        <!-- advantages -->
        <div class="adv_content about">
            <div class="adv container display">
                <img src="assets/media/about/about-docimg.png" alt="" class="adv_img">

                <div class="adv_items">
                    <p class="desc"><img src="assets/media/about/dload-icon.svg" alt="">Сертификаты качества <br>
                        (Скачать, PDF, 2.4 МБ)</p>
                    <p class="desc"><img src="assets/media/about/dload-icon.svg" alt="">Политика конфиденциальности
                        <br>(Скачать, PDF, 1.1 МБ)
                    </p>
                </div>

                <div class="adv_items">
                    <p class="desc"><img src="assets/media/about/dload-icon.svg" alt="">Условия доставки и оплаты <br>
                        (Скачать, PDF, 0.8 МБ)</p>
                    <p class="desc"><img src="assets/media/about/dload-icon.svg" alt="">Каталог чаев 2025 <br>(Скачать,
                        PDF, 3.5 МБ)</p>
                </div>
            </div>
        </div>
    </main>
<<<<<<< HEAD:includes/about.php
=======

    <!-- footer -->
    <footer class="footer container">
        <div class="footer_left">
            <img src="assets/media/logo/logo.svg" alt="" class="logo">

            <div class="footer_contacts">
                <div class="footer-tel">
                    <img src="assets/media/footer/call-calling.svg" alt="">

                    <div class="text_info">
                        <p>Контактный телефон</p>
                        <a href="tel: 78123090934" class="desc">+ 7 (812) 309-09-34</a>
                        <a href="tel: 78123090934" class="desc">+ 7 (965) 084-029-09</a>
                    </div>
                </div>

                <div class="footer-tel">
                    <img src="assets/media/footer/Icon.png" alt="">
                    <div class="text_info">
                        <p>Электронная почта</p>
                        <a href="mailto: tustin78@mail.ru" class="desc">tustin78@mail.ru</a>
                        <a href="mailto: info@tustin.ru" class="desc">info@tustin.ru</a>
                    </div>
                </div>
            </div>
            <p class="h-nav_item">© 2025, Пирогова Дарья Денисовна</p>
        </div>

        <div class="footer_right">
            <h2 class="title-2 left">Первый заказ?</h2>
            <input type="text" placeholder="Введите email">
            <img src="assets/media/icons/button_footer.svg" alt="" class="footer-btn">

            <nav class="h-nav">
                <a href="" class="h-nav_item">Главная</a>
                <a href="" class="h-nav_item">Каталог</a>
                <a href="" class="h-nav_item">Советы</a>
                <a href="" class="h-nav_item">FAQ</a>
                <a href="" class="h-nav_item">О нас</a>
            </nav>
        </div>
    </footer>

    <!-- авторизация -->
    <input type="checkbox" id="auth-toggle" class="modal-toggle">

    <div class="modal-overlay">
        <div class="modal-window">

            <label for="auth-toggle" class="close-btn">×</label>

            <div class="form-switcher">
                <input type="radio" id="show-login" name="form-type" checked>
                <label for="show-login">Вход</label>

                <input type="radio" id="show-register" name="form-type">
                <label for="show-register">Регистрация</label>
            </div>

            <div class="auth-form login-form">
                <input type="email" placeholder="Ваш email">
                <input type="password" placeholder="Пароль">
                <img src="assets/media/icons/login-btn.svg" alt="" class="auth-btn">
            </div>

            <div class="auth-form register-form">
                <input type="text" placeholder="Ваше имя">
                <input type="email" placeholder="Ваш email">
                <input type="password" placeholder="Пароль">
                <img src="assets/media/icons/login-btn.svg" alt="" class="auth-btn">
            </div>
        </div>
    </div>
>>>>>>> 41af80474d942d21fc5da17f74398ca8d070d058:about.html
</body>

</html>