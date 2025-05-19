<?php

include('connection/database.php');

$products = $database->query('SELECT * FROM products')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $user_id = $USER['user_id'] ?? null;

    if ($user_id && $product_id) {
        $stmt = $database->prepare("SELECT id FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $cartItem = $stmt->fetch();

        if ($cartItem) {
            $stmt = $database->prepare("UPDATE carts SET count = count + 1 WHERE id = ?");
            $stmt->execute([$cartItem['id']]);
        } else {
            $stmt = $database->prepare("INSERT INTO carts (user_id, product_id, count) VALUES (?, ?, 1)");
            $stmt->execute([$user_id, $product_id]);
        }

        header('Location: ./?page=cart');
        exit;
    }
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
        <div class="catalog">
            <div class="container">
                <h2 class="title-2">Каталог</h2>
                <p class="subtitile">Главная / Каталог</p>

                <div class="filter_mob title-3"><img src="assets/media/icons/filter-icon.png" alt="">Открыть фильтры
                </div>

                <div class="catalog_content title_gap">
                    <div class="filter">
                        <h2 class="title-3 left">Фильтры</h2>
                        <p class="subtitile left" style="color: #2D431D; opacity: 0.7; padding-bottom: 12px;">По типу
                            чая</p>

                        <div class="filter-group">
                            <input type="checkbox" id="black-tea" class="filter-checkbox">
                            <label for="black-tea" class="filter-label">
                                <span class="custom-checkbox"></span>
                                <span class="tea-type-name">Чёрный</span>
                            </label>
                        </div>

                        <div class="filter-group">
                            <input type="checkbox" id="green-tea" class="filter-checkbox">
                            <label for="green-tea" class="filter-label">
                                <span class="custom-checkbox"></span>
                                <span class="tea-type-name">Зелёный</span>
                            </label>
                        </div>

                        <div class="filter-group">
                            <input type="checkbox" id="herbal-tea" class="filter-checkbox">
                            <label for="herbal-tea" class="filter-label">
                                <span class="custom-checkbox"></span>
                                <span class="tea-type-name">Травяной</span>
                            </label>
                        </div>

                        <div class="filter-group">
                            <input type="checkbox" id="fruit-tea" class="filter-checkbox">
                            <label for="fruit-tea" class="filter-label">
                                <span class="custom-checkbox"></span>
                                <span class="tea-type-name">Фруктовый</span>
                            </label>
                        </div>

                        <hr class="filter-hr">

                        <p class="subtitile left" style="color: #2D431D; opacity: 0.7; padding-bottom: 12px;">По
                            крепкости</p>

                        <div class="filter-group">
                            <input type="checkbox" id="light-tea" class="filter-checkbox">
                            <label for="light-tea" class="filter-label">
                                <span class="custom-checkbox"></span>
                                <span class="tea-type-name">Легкий</span>
                            </label>
                        </div>

                        <div class="filter-group">
                            <input type="checkbox" id="hard-tea" class="filter-checkbox">
                            <label for="hard-tea" class="filter-label">
                                <span class="custom-checkbox"></span>
                                <span class="tea-type-name">Крепкий</span>
                            </label>
                        </div>

                        <div class="filter-group">
                            <input type="checkbox" id="norm-tea" class="filter-checkbox">
                            <label for="norm-tea" class="filter-label">
                                <span class="custom-checkbox"></span>
                                <span class="tea-type-name">Средний</span>
                            </label>
                        </div>

                        <hr class="filter-hr">

                        <img src="assets/media/catalog/catalog_fil-btn.svg" alt="" class="filter-btn">
                        <p class="subtitile left" style="color: #2D431D; opacity: 0.7; padding-bottom: 12px;">Сбросить
                            фильтры</p>
                    </div>

                    <div class="catalog_cards">
                        <?php if (!empty($products)) : ?>
                            <?php foreach ($products as $product) : ?>
                                <? if ($product['sort'] === 'черный') : ?>
                                    <div class="fav-card pink_dec catalog_card" onclick="window.location.href='./?page=product&id=<?= $product['id'] ?>'">
                                        <div class="fav-img_container">
                                            <img src="./uploads/<?= $product['image'] ?>" alt="" class="fav-img">
                                            <img src="./uploads/<?= $product['image_hover'] ?>" alt="" class="fav-img img_hover">
                                            <img class="icon-heart" width="35" height="35"
                                                src="https://img.icons8.com/fluency-systems-regular/48/FFFFFF/like--v1.png"
                                                alt="like--v1" />
                                            <img class="icon-cart" width="30" height="30"
                                                src="https://img.icons8.com/pastel-glyph/100/FFFFFF/shopping-basket-2--v2.png"
                                                alt="shopping-basket-2--v2" />
                                        </div>

                                        <div class="fav_text_container">
                                            <h2 class="title-3"><?= $product['title'] ?></h2>
                                            <pre><p class="subtitile" style="opacity: 0.7;">В наличии    Артикул: <?= $product['article'] ?></p></pre>

                                            <?php if (isset($USER['role'])): ?>

                                                <form action="?page=catalog" method="post">
                                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                    <button type="submit" name="add_to_cart" style='border: none;'><img src="assets/media/icons/button_tocart.svg" alt="" class="fav-btn"></button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if (isset($USER['role']) && $USER['role'] == 'admin'): ?>
                                                <a class="border_bottom edit_btn" href="./?page=edit-product&id=<?= $product['id'] ?>">Редактировать</a>
                                                <form action="" method="post">
                                                    <input type="hidden" name="delete_id" value="<?= $product['id'] ?>">
                                                    <button class="exit_btn"
                                                        onclick="return confirm('Вы действительно хотите удалить?')">Удалить
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                <?php elseif ($product['sort'] === 'зеленый') : ?>

                                    <div class="fav-card yell_dec catalog_card" onclick="window.location.href='./?page=product&id=<?= $product['id'] ?>'">
                                        <div class="fav-img_container">
                                            <img src="./uploads/<?= $product['image'] ?>" alt="" class="fav-img">
                                            <img src="./uploads/<?= $product['image_hover'] ?>" alt="" class="fav-img img_hover">
                                            <img class="icon-heart" width="35" height="35"
                                                src="https://img.icons8.com/fluency-systems-regular/48/FFFFFF/like--v1.png"
                                                alt="like--v1" />
                                            <img class="icon-cart" width="30" height="30"
                                                src="https://img.icons8.com/pastel-glyph/100/FFFFFF/shopping-basket-2--v2.png"
                                                alt="shopping-basket-2--v2" />
                                        </div>

                                        <div class="fav_text_container">
                                            <h2 class="title-3 white"><?= $product['title'] ?></h2>
                                            <pre><p class="subtitile white" style="opacity: 0.7;">В наличии    Артикул: <?= $product['article'] ?></span></p></pre>

                                            <?php if (isset($USER['role'])): ?>

                                                <form action="?page=catalog" method="post">
                                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                    <button type="submit" name="add_to_cart" style='border: none;'><img src="assets/media/icons/button_tocart2.svg" alt="" class="fav-btn"></button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if (isset($USER['role']) && $USER['role'] == 'admin'): ?>
                                                <a class="border_bottom edit_btn" href="./?page=edit-product&id=<?= $product['id'] ?>">Редактировать</a>
                                                <form action="" method="post">
                                                    <input type="hidden" name="delete_id" value="<?= $product['id'] ?>">
                                                    <button class="exit_btn"
                                                        onclick="return confirm('Вы действительно хотите удалить?')">Удалить
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                <?php elseif ($product['sort'] === 'травяной') : ?>

                                    <div class="fav-card green_dec catalog_card" onclick="window.location.href='./?page=product&id=<?= $product['id'] ?>'">
                                        <div class="fav-img_container">
                                            <img src="./uploads/<?= $product['image'] ?>" alt="" class="fav-img">
                                            <img src="./uploads/<?= $product['image_hover'] ?>" alt="" class="fav-img img_hover">
                                            <img class="icon-heart" width="35" height="35"
                                                src="https://img.icons8.com/fluency-systems-regular/48/FFFFFF/like--v1.png"
                                                alt="like--v1" />
                                            <img class="icon-cart" width="30" height="30"
                                                src="https://img.icons8.com/pastel-glyph/100/FFFFFF/shopping-basket-2--v2.png"
                                                alt="shopping-basket-2--v2" />
                                        </div>

                                        <div class="fav_text_container">
                                            <h2 class="title-3 white"><?= $product['title'] ?></h2>
                                            <pre><p class="subtitile white" style="opacity: 0.7;">Нет на складе    Артикул: <?= $product['article'] ?></p></pre>

                                            <?php if (isset($USER['role'])): ?>

                                                <form action="?page=catalog" method="post">
                                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                    <button type="submit" name="add_to_cart" style='border: none;'><img src="assets/media/icons/button_tocart3.svg" alt="" class="fav-btn"></button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if (isset($USER['role']) && $USER['role'] == 'admin'): ?>
                                                <a class="border_bottom edit_btn" href="./?page=edit-product&id=<?= $product['id'] ?>">Редактировать</a>
                                                <form action="" method="post">
                                                    <input type="hidden" name="delete_id" value="<?= $product['id'] ?>">
                                                    <button class="exit_btn"
                                                        onclick="return confirm('Вы действительно хотите удалить?')">Удалить
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                <?php else : ?>

                                    <div class="fav-card white_dec catalog_card" onclick="window.location.href='./?page=product&id=<?= $product['id'] ?>'">
                                        <div class="fav-img_container">
                                            <img src="./uploads/<?= $product['image'] ?>" alt="" class="fav-img">
                                            <img src="./uploads/<?= $product['image_hover'] ?>" alt="" class="fav-img img_hover">
                                            <img class="icon-heart" width="35" height="35"
                                                src="https://img.icons8.com/fluency-systems-regular/48/FFFFFF/like--v1.png"
                                                alt="like--v1" />
                                            <img class="icon-cart" width="30" height="30"
                                                src="https://img.icons8.com/pastel-glyph/100/FFFFFF/shopping-basket-2--v2.png"
                                                alt="shopping-basket-2--v2" />
                                        </div>

                                        <div class="fav_text_container">
                                            <h2 class="title-3"><?= $product['title'] ?></h2>
                                            <pre><p class="subtitile" style="opacity: 0.7;">В наличии    Артикул: <?= $product['article'] ?></p></pre>

                                            <?php if (isset($USER['role'])): ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                    <button type="submit" name="add_to_cart" style='border: none;'><img src="assets/media/icons/button_tocart4.svg" alt="" class="fav-btn"></button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if (isset($USER['role']) && $USER['role'] == 'admin'): ?>
                                                <a class="border_bottom edit_btn" href="./?page=edit-product&id=<?= $product['id'] ?>">Редактировать</a>
                                                <form action="?page=catalog" method="post">
                                                    <input type="hidden" name="delete_id" value="<?= $product['id'] ?>">
                                                    <button class="exit_btn"
                                                        onclick="return confirm('Вы действительно хотите удалить?')">Удалить
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Товаров нет</p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

    </main>
</body>

</html>