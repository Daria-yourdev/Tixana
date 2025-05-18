<?php

$id = $_GET['id'];
$product = $database->query("SELECT * FROM products WHERE id = $id")->fetch();

if (!$product) {
    include('404.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/media/logo/favicon.png" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cuprum:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>

<body>

    <main>

        <!-- product -->
        <div class="product">
            <div class="product_content container">
                <?php if ($product['sort'] == 'черный') : ?>
                    <div class="product-img_container" style='background-color: #E7AF91;'>
                        <img src="./uploads/<?= $product['image'] ?>" alt="" class="fav-img">
                        <img src="./uploads/<?= $product['image_hover'] ?>" alt="" class="fav-img img_hover">
                    </div>
                <?php elseif ($product['sort'] == 'зеленый') : ?>
                    <div class="product-img_container" style='background-color: #857B3E;'>
                        <img src="./uploads/<?= $product['image'] ?>" alt="" class="fav-img">
                        <img src="./uploads/<?= $product['image_hover'] ?>" alt="" class="fav-img img_hover">
                    </div>
                <?php elseif ($product['sort'] == 'травяной') : ?>
                    <div class="product-img_container" style='background-color: #857B3E;'>
                        <img src="./uploads/<?= $product['image'] ?>" alt="" class="fav-img">
                        <img src="./uploads/<?= $product['image_hover'] ?>" alt="" class="fav-img img_hover">
                    </div>
                <?php elseif ($product['sort'] == 'фруктовый') : ?>
                    <div class="product-img_container" style='background-color: #F6ECEB;'>
                        <img src="./uploads/<?= $product['image'] ?>" alt="" class="fav-img">
                        <img src="./uploads/<?= $product['image_hover'] ?>" alt="" class="fav-img img_hover">
                    </div>
                <?php else : ?>
                    <div class="product-img_container" style='background-color: #fff;'>
                        <img src="./uploads/<?= $product['image'] ?>" alt="" class="fav-img">
                        <img src="./uploads/<?= $product['image_hover'] ?>" alt="" class="fav-img img_hover">
                    </div>
                <?php endif; ?>

                <div class="product-text">
                    <p class="subtitile_desc">крепкий • согревающий</p>
                    <h2 class="title-2 left"><?= $product['sort'] ?> чай <?= $product['title'] ?></h2>
                    <p class="subtitile_desc">Крепость: <?= $product['fortress'] ?> <br>
                        Аромат: <?= $product['smell'] ?><br>
                        Послевкусие: <?= $product['aftertaste'] ?></p>
                    <p class="subtitile_desc" style="padding-top: 52px;">Состав:</p>

                    <div class="tea_content">
                        <div class="tea_card">
                            <img src="assets/media/product/1_img.png" alt="" class="tea-img">
                            <p class="h-nav_item center">Отборные листья
                                ассамского чая</p>
                        </div>

                        <div class="tea_card">
                            <img src="assets/media/product/2_img.png" alt="" class="tea-img">
                            <p class="h-nav_item center">Лепестки
                                календулы</p>
                        </div>

                        <div class="tea_card">
                            <img src="assets/media/product/3_img.png" alt="" class="tea-img">
                            <p class="h-nav_item center">Натуральные
                                медовые кусочки</p>
                        </div>
                    </div>

                    <div class="product_price title-2 left"><?= $product['price'] ?> ₽
                        <span class="subtitile_desc">/ 100 г</span>
                    </div>

                    <img src="assets/media/product/product-btn.svg" alt="" class="product-btn">
                </div>
            </div>

        </div>
    </main>
</body>

</html>