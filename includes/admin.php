<?php

include('connection/database.php');

$products = $database->query('SELECT * FROM products')->fetchAll();

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

    <main>

        <!-- admin -->
        <div class="admin">
            <div class="admin-header container">
                <h1 class="title-2">Управление каталогом</h1>
                <div class="admin-actions">
                    <button class="add-btn" onclick="window.location.href='./?page=create-product'">
                        Добавить товар
                    </button>
                </div>
            </div>

            <div class="admin-table-container container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Изображение</th>
                            <th>Название</th>
                            <th>Тип</th>
                            <th>Цена</th>
                            <th>Наличие</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id']) ?></td>
                                <td>
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" class="table-img">
                                    <?php else: ?>
                                        <span>Нет изображения</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product['title']) ?></td>
                                <td><?= htmlspecialchars($product['sort']) ?></td>
                                <td><?= htmlspecialchars($product['price']) ?> ₽</td>
                                <td>
                                    <span class="in-stock">В наличии</span>
                                </td>
                                <td>
                                    <button class="edit-btn" onclick="window.location.href='./?page=edit-product&id=<?= $product['id'] ?>'">
                                        Редактировать
                                    </button>
                                    <button class="delete-btn" onclick="window.location.href='./?page=delete-product&id=<?= $product['id'] ?>'">
                                        Удалить
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>

</html>