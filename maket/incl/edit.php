<?php

include('database/connection.php');

$sql = "SELECT * FROM products";
$result = $database->query($sql)->fetchAll();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = 'SELECT COUNT(*) FROM products WHERE id=:id';
    $stmt = $database->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->fetchColumn() == 0) {
        header('Location: ./?page=product');
        exit;
    }

    $sql = 'SELECT * FROM products WHERE id=:id';
    $stmt = $database->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $product = $stmt->fetch();

    if (!$product) {
        header('Location: ./?page=catalog');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $title = $_POST['title'];
        $city = $_POST['city'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        if (empty($title) || empty($city) || empty($description) || empty($price)) {
            $message = 'Поля пустые';
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

            $tmpName = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $newName = uniqid() . '.' . $extension;
            $newDirection = 'uploads/' . $newName;

            if (move_uploaded_file($tmpName, $newDirection)) {
                $sql = 'UPDATE products SET
                title=:title,
                city=:city,
                price=:price,
                description=:description,
                image=:image
                WHERE id=:id';
                $stmt = $database->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':image', $newDirection);

                if ($stmt->execute()) {
                    header('Location: ./?page=product&id=' . $_GET['id']);
                    exit();
                } else {
                    $message = 'Ошибка запроса!';
                }
            } else {
                $message = 'Ошибка загрузки изображения!';
            }
        } else {
            $message = 'Загрузите изображене!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Природный Оазис</title>
    <link rel="icon" type="image/svg" href="../images/logo.svg">
</head>

<body>
    <header>
        <div class="header_wrapper">
            <a href="./" class="logo">
                <svg width="113" height="113" viewBox="0 0 113 113" fill="" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M56.6674 0L56.6679 1.48894e-06C56.7583 31.0711 81.9289 56.2418 113 56.3321V56.3325C81.873 56.4231 56.6677 81.6843 56.6677 112.833C56.6677 112.888 56.6678 112.944 56.6679 113C56.6677 113 56.6676 113 56.6674 113L56.6677 112.833C56.6677 81.6553 31.4153 56.376 0.248305 56.3323C31.3594 56.2888 56.577 31.1001 56.6674 0ZM0 56.3325L5.43761e-07 56.3322L0.109126 56.3323L0 56.3325Z"
                        fill="" />
                </svg>
                <p>Природный Оазис</p>
            </a>
            <div class="btns header_btns">
                <a class="btn_auth" href="./?page=authorization">Авторизация</a>
                <a class="btn_reg" href="./?page=registration">Регистрация</a>
            </div>

        </div>
    </header>

    <main>
        <div class="out_wrapper">
            <form action="" method="post" enctype="multipart/form-data">
                <h1>Редактировать товар</h1>
                <input type="text" name="title" value="<?= $product['title'] ?>">
                <select name="city">
                    <?php foreach ($result as $category) : ?>
                        <option value="<?= $category['id'] ?>">
                            <?= $category['city'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="price" value='<?= $product['price'] ?>'>
                <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>
                <input type="file" name="image">
                <img src="<?= $product['image'] ?>" alt="">

                <input class="form_btn" type="submit" name='submit' value="Редактироать">

                <?php if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty($message)) : ?>
                    <p><?= $message ?></p>
                <?php endif; ?>

            </form>
        </div>
    </main>

    <?php include('footer.php'); ?>
</body>

</html>