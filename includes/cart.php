<?php

include('connection/database.php');

$user_id = $USER['user_id'];

$sql = "SELECT c.id AS cart_id, p.id AS product_id, p.title, p.price, p.image, p.article, p.fortress, p.smell, c.count
        FROM carts c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $database->prepare($sql);
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['increment'])) {

    $cart_id = $_POST['cart_id'];
    $sql = "UPDATE carts SET count = count + 1 WHERE id = $cart_id";
    $database->query($sql);
    header('Location: ./?page=cart');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['decrement'])) {
    $count = $_POST['count'];
    $cart_id = $_POST['cart_id'];
    if ($count > 1) {
        $sql = "UPDATE carts SET count = count - 1 WHERE id = $cart_id";
        $database->query($sql);
        header('Location: ./?page=basket');
    } else {
        $sql = "DELETE FROM carts WHERE id = $cart_id";
        $database->query($sql);
        header('Location: ./?page=cart');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
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
                <h2 class="title-2">Корзина</h2>
                <p class="subtitile">Главная / Корзина</p>

                <div class="cart_content title_gap">
                    <div class="cart_items">
                        <?php if (!empty($cartItems)): ?>
                            <?php foreach ($cartItems as $item): ?>
                                <div class="cart_item">
                                    <div class="cart_item-left">
                                        <div class="cart_item-img pink_dec">
                                            <img src="./uploads/<?= htmlspecialchars($item['image']) ?>" alt="">
                                        </div>

                                        <div class="cart_item-text">
                                            <h2 class="title-3 left"><?= htmlspecialchars($item['title']) ?></h2>
                                            <pre><p class="subtitile left" style="opacity: 0.5;">В наличии    Артикул: <?= htmlspecialchars($item['article']) ?></p></pre>
                                            <p class="subtitile_desc" style="padding-top: 25px;">
                                                Крепость: <?= htmlspecialchars($item['fortress']) ?><br>
                                                Аромат: <?= htmlspecialchars($item['smell']) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="title-2" style="padding-top: 17px;"><?= $item['price'] ?> ₽</div>

                                    <div class="quantity-control" style="padding-top: 17px;">
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                            <input type="hidden" name="count" value="<?= $item['count'] ?>">
                                            <button type="submit" name="decrement" class="quantity-btn">−</button>
                                        </form>

                                        <div class="quantity-input"><?= $item['count'] ?></div>

                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                            <button type="submit" name="increment" class="quantity-btn">+</button>
                                        </form>

                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                            <button type="submit" name="remove" style="border: none; background: none;">
                                                <img src="assets/media/cart/cart-delete.png" alt="" class="delete_btn">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <p>Ваша корзина пуста</p>
                        <?php endif; ?>
                    </div>

                    <div class="cart_exe">
                        <img src="assets/media/cart/cart-btn.svg" alt="" class="cart-btn">

                        <div class="cart_exe-text">
                            <div class="cart_exe-item">
                                <h2 class="title-3 left">Ваша корзина</h2>
                                <p class="subtitile left" style="color: #2D431D; opacity: 0.7; padding-bottom: 12px;">1
                                    товар</p>
                            </div>

                            <div class="cart_exe-item">
                                <p class="subtitile left" style="color: #2D431D; opacity: 0.7; padding-bottom: 12px;">
                                    Товары(2)</p>
                                <p class="subtitile left" style="color: #2D431D; opacity: 0.7; padding-bottom: 12px;">
                                    900 ₽</p>
                            </div>

                            <hr class="filter-hr">

                            <div class="cart_exe-item" style="padding-top: 12px;">
                                <h2 class="title-3 left">Общая стоимость</h2>
                                <h2 class="title-3 left">900 ₽</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>