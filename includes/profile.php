<?php

include('connection/database.php');
session_start();

$user_id = $_SESSION['user_id'];

$stmt = $database->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Пользователь не найден.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тизана</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/media/logo/favicon.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cuprum:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>

<body>

    <main>

        <!-- profile -->
        <div class="product">
            <div class="product_content container">
                <div class="profile_left">
                    <img src="assets/media/profile/prof_img0mem.jpg" alt="" class="profile-img">

                    <h2 class="title-1 white center"><?= $user['name_surname'] ?></h2>
                    <p class="subtitile_desc white center">Email: <?= $user['email'] ?> <br>
                        Телефон: <?= $user['tel'] ?> <br>
                        Адрес: <?= $user['adress'] ?></p>
                </div>

                <div class="product-text">

                    <h2 class="title-2 left">Заказы</h2>

                    <div class="cart_items">
                        <div class="order">
                            <div class="cart_item-left">
                                <div class="cart_item-img pink_dec">
                                    <img src="assets/media/favorites/1_item.png" alt="">
                                </div>

                                <div class="cart_item-text">
                                    <h2 class="title-3 left">Заказ #12345 от 15.05.2024</h2>
                                    <p class="subtitile_desc" style="padding-top: 15px;">Статус: Доставлен
                                    </p>
                                </div>
                            </div>

                            <div class="profile-btn">
                                <a href="#" class="banner_btn2 btn_mob" style="opacity: 0.7;">Повторить заказ -></a>
                            </div>
                        </div>

                        <div class="order">
                            <div class="cart_item-left">
                                <div class="cart_item-img yell_dec">
                                    <img src="assets/media/favorites/2_item.png" alt="">
                                </div>

                                <div class="cart_item-text">
                                    <h2 class="title-3 left">Заказ #12344 от 10.05.2024</h2>
                                    <p class="subtitile_desc" style="padding-top: 15px;">Статус: В обработке
                                    </p>
                                </div>
                            </div>

                            <div class="profile-btn">
                                <a href="#" class="banner_btn2 btn_mob" style="opacity: 0.7;">Повторить заказ -></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>