<?php
$id = $_GET['id'];
$product = $database->query("SELECT * FROM products WHERE id = $id")->fetch();

if (!$product) {
    include('404.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $uploadDir = __DIR__ . '/../uploads';

    if (file_exists($uploadDir . '/' . $product['image'])) {
        unlink($uploadDir . '/' . $product['image']);
    }

    if (file_exists($uploadDir . '/' . $product['image_hover'])) {
        unlink($uploadDir . '/' . $product['image_hover']);
    }

    $delete = $database->query("DELETE FROM products WHERE id = $id");
    header('Location: ./?page=admin');

}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удалить товар</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/media/logo/favicon.png" type="image/x-icon">
    <style>
        .delete-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .delete-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #2D431D;
        }

        .product-info {
            margin-bottom: 30px;
        }

        .product-image {
            max-width: 200px;
            max-height: 200px;
            margin-bottom: 15px;
        }

        .product-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .delete-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
            border: none;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <!-- header -->
    <header class="header">
        <div class="header_content container_wide" style="display: flex; justify-content: space-between;">
            <div class="header-left">
                <nav class="h-nav">
                    <a href="./" class="h-nav_item">Главная</a>
                    <a href="./?page=catalog" class="h-nav_item">Каталог</a>
                    <a href="./?page=about" class="h-nav_item">О нас</a>
                </nav>
            </div>

            <div class="header-right">
                <a class="h-nav_item" href="?exit">Выйти</a>
            </div>
        </div>
    </header>

    <div class="admin">
        <div class="admin-header container">
            <h1 class="title-2">Удаление товара</h1>
            <div class="admin-actions">
                <button class="btn btn-secondary" onclick="window.location.href='./?page=admin'">
                    Назад
                </button>
            </div>
        </div>

        <div class="container">
            <div class="delete-container">
                <h2 class="delete-title">Вы уверены, что хотите удалить этот товар?</h2>

                <div class="product-info">
                    <?php if (!empty($product['image'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" class="product-image">
                    <?php endif; ?>
                    <div class="product-name"><?= htmlspecialchars($product['title']) ?></div>
                    <div>Артикул: <?= htmlspecialchars($product['article']) ?></div>
                    <div>Цена: <?= htmlspecialchars($product['price']) ?> ₽</div>
                </div>

                <form method="post" class="delete-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='./?page=admin'">
                        Отмена
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Удалить
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>