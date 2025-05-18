<?php
$id = $_GET['id'];
$product = $database->query("SELECT * FROM products WHERE id = $id")->fetch();

if (!$product) {
    include('404.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $sort = $_POST['sort'];
    $article = $_POST['article'];
    $fortress = $_POST['fortress'];
    $smell = $_POST['smell'];
    $aftertaste = $_POST['aftertaste'];
    $price = $_POST['price'];
    $image = null;
    $image_hover = null;

    if (empty($title) || empty($sort) || empty($article) || empty($price)) {
        $errors[] = 'Заполните обязательные поля';
    } elseif (!is_numeric($price)) {
        $errors[] = 'Цена должна быть числом';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = __DIR__ . '/../uploads';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        $maxSize = 1024 * 1024 * 2;

        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $errors[] = 'Не удалось создать папку';
            }
        } elseif (!in_array($_FILES['image']['type'], $allowedTypes)) {
            $errors[] = 'Не верное расширение изображения';
        } elseif ($_FILES['image']['size'] > $maxSize) {
            $errors[] = 'Размер файла не должен превышать 2 мегабайта';
        } else {
            $ext = pathinfo($_FILES['image']['name'], 4);
            $uniqueName = uniqid('product_', true) . '.' . $ext;
            $dir = $uploadDir . '/' . $uniqueName;
            $image = $uniqueName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
                $errors[] = 'Не удалось загрузить файл';
            } else if (file_exists($uploadDir . '/' . $product['image'])) {
                unlink($uploadDir . '/' . $product['image']);
            }
        }
    }

    if (isset($_FILES['image_hover']) && $_FILES['image_hover']['error'] === 0) {
        $uploadDir = __DIR__ . '/../uploads';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        $maxSize = 1024 * 1024 * 2;

        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $errors[] = 'Не удалось создать папку';
            }
        } elseif (!in_array($_FILES['image_hover']['type'], $allowedTypes)) {
            $errors[] = 'Неверное расширение изображения при наведении';
        } elseif ($_FILES['image_hover']['size'] > $maxSize) {
            $errors[] = 'Размер файла (hover) не должен превышать 2 мегабайта';
        } else {
            $ext = pathinfo($_FILES['image_hover']['name'], PATHINFO_EXTENSION);
            $uniqueName = uniqid('hover_', true) . '.' . $ext;
            $dir = $uploadDir . '/' . $uniqueName;
            $image_hover = $uniqueName;
            if (!move_uploaded_file($_FILES['image_hover']['tmp_name'], $dir)) {
                $errors[] = 'Не удалось загрузить файл image_hover';
            } else if (file_exists($uploadDir . '/' . $product['image-hover'])) {
                unlink($uploadDir . '/' . $product['image-hover']);
            }
        }
    }

    if (empty($image)) {
        $image = $product['image'];
    }

    if (empty($image_hover)) {
        $image_hover = $product['image-hover'];
    }

    if (empty($errors)) {
        $stmt = $database->prepare("UPDATE products SET 
            title = ?, sort = ?, article = ?, fortress = ?, smell = ?, aftertaste = ?, price = ?, 
            image = ?, `image-hover` = ? WHERE id = ?");
        $stmt->execute([$title, $sort, $article, $fortress, $smell, $aftertaste, $price, $image, $image_hover, $id]);

        header('Location: ./?page=admin');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать товар</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/media/logo/favicon.png" type="image/x-icon">
    <style>
        .admin-form {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-actions {
            margin-top: 30px;
            text-align: right;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary {
            background: #2c5e1a;
            color: white;
            border: none;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .error-message {
            color: #e74c3c;
            margin-top: 5px;
            font-size: 14px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-col {
            flex: 1;
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
            <h1 class="title-2">Редактировать товар</h1>
            <div class="admin-actions">
                <button class="btn btn-secondary" onclick="window.location.href='./?page=admin'">
                    Назад
                </button>
            </div>
        </div>

        <div class="container">
            <form class="admin-form" method="post" enctype="multipart/form-data">
                <?php if (!empty($errors)): ?>
                    <div class="error-message" style="margin-bottom: 20px;">
                        <?php foreach ($errors as $error): ?>
                            <p><?= htmlspecialchars($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="title">Название*</label>
                            <input type="text" id="title" name="title" class="form-control" value="<?= $product['title'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="sort">Тип чая*</label>
                            <select id="sort" name="sort" class="form-control" required>
                                <option value="черный" <?= $product['sort'] === 'черный' ? 'selected' : '' ?>>Чёрный</option>
                                <option value="зеленый" <?= $product['sort'] === 'зеленый' ? 'selected' : '' ?>>Зелёный</option>
                                <option value="травяной" <?= $product['sort'] === 'травяной' ? 'selected' : '' ?>>Травяной</option>
                                <option value="фруктовый" <?= $product['sort'] === 'фруктовый' ? 'selected' : '' ?>>Фруктовый</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="article">Артикул*</label>
                            <input type="text" id="article" name="article" class="form-control" value="<?= $product['article'] ?>" required>
                        </div>
                    </div>

                    <div class="form-col">
                        <div class="form-group">
                            <label for="fortress">Крепкость</label>
                            <input type="text" id="fortress" name="fortress" class="form-control" value="<?= $product['fortress'] ?>">
                        </div>

                        <div class="form-group">
                            <label for="smell">Аромат</label>
                            <input type="text" id="smell" name="smell" class="form-control" value="<?= $product['smell'] ?>">
                        </div>

                        <div class="form-group">
                            <label for="aftertaste">Послевкусие</label>
                            <input type="text" id="aftertaste" name="aftertaste" class="form-control" value="<?= $product['aftertaste'] ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="price">Цена* (руб)</label>
                    <input type="number" id="price" name="price" class="form-control" value="<?= $product['price'] ?>" min="100" step="0.01" required>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="image">Основное изображение</label>
                            <input type="file" id="image" name="image" class="form-control">
                            <?php if (!empty($product['image'])): ?>
                                <div style="margin-top: 10px;">
                                    <small>Текущее изображение:</small><br>
                                    <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" width="100" style="margin-top: 5px;">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="image_hover">Изображение при наведении</label>
                            <input type="file" id="image_hover" name="image_hover" class="form-control">
                            <?php if (!empty($product['image-hover'])): ?>
                                <div style="margin-top: 10px;">
                                    <small>Текущее изображение:</small><br>
                                    <img src="../uploads/<?= htmlspecialchars($product['image-hover']) ?>" width="100" style="margin-top: 5px;">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='./?page=admin'">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>