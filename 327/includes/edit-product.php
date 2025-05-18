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
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = null;

    if (empty($title) || empty($description) || empty($price)) {
        $errors[] = 'Заполните все поля';
    } elseif (strlen($title) < 4 || strlen($description) < 4) {
        $errors[] = 'Заполните не менее 4 символами';
    } elseif (!is_numeric($price)) {
        $errors[] = 'Цена должна быть числом';
    } elseif ($price < 100) {
        $errors[] = 'Цена должна быть не менее 100 рублей';
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
            $uniqueName = uniqid('product_', true) . '.' . $ext; // ''product_',true' - писать не обязательно, добавляет уникальный идентификатор к имени файла
            $dir = $uploadDir . '/' . $uniqueName;
            $image = $uniqueName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
                $errors[] = 'Не удалось загрузить файл';
            } else if (file_exists($uploadDir . '/' . $product['image'])) {
                unlink($uploadDir . '/' . $product['image']);
            }

        }

    }

    if (empty($errors)) {
        $stmt = $database->query("UPDATE products SET
                                        `title` = '$title', 
                                        `description` = '$description', 
                                        `price` = $price,
                                        `image` = '$image'
                                        WHERE id = $id");
        header('Location: ./');
    }

}
?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="название" value="<?= $product['title'] ?>">
    <br>
    <textarea name="description" id="" cols="30" rows="10"
              placeholder="Описание"><?= $product['description'] ?></textarea>
    <br>
    <input type="text" name="price" placeholder="цена" value="<?= $product['price'] ?>">
    <br>
    <input type="file" name="image">
    <br>
    <?php foreach ($errors as $error): ?>
        <div style="color: indianred"><?= $error ?></div>
    <?php endforeach; ?>
    <br>
    <input type="submit" placeholder="создать">

</form>
