<?php

$sql = "SELECT * FROM categories";
$result = $database->query($sql)->fetchAll();

if (isset($_GET) && !empty($_GET)) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $database->prepare($sql);
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch();

    if (!$product) {
        echo 'Товара не найден';
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];

        if (empty($title) || empty($price) || empty($description)) {
            echo 'Поля пусты';
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['image']['tmp_name'];
            $name = basename($_FILES['image']['name']);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $newName = uniqid() . '.' . $extension;
            $newDirection = 'upload/' . $newName;

            if (move_uploaded_file($tmpName, $newDirection)) {
                unlink($product['image']);
                $sql = "UPDATE products SET
                `title`=:title,
                `description`=:description,
                `price`=:price,
                `image`=:image,
                `category_id`=:category_id
                WHERE id=:id";

                $stmt = $database->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':image', $newDirection);
                $stmt->bindParam(':category_id', $category_id);
                $stmt->bindParam(':id', $_GET['id']);

                if ($stmt->execute()) {
                    header("Location: ./?page=product&id=" . $_GET['id']);
                    exit();
                } else {
                    include('404.php');
                }
            }

        } else {
            echo"Ошибка загрузки изображения";
        }
    }

}
?>


<main>
    <div class="out_wrapper">
        <form action="" method="post" enctype="multipart/form-data" class="form-style">
            <h1>Редактировать товар</h1>
            <input type="text" name="title" placeholder="Название" value="<?= $product['title'] ?>">
            <select name="category_id">
                <?php foreach ($result as $category): ?>
                    <option value="<?= $category['id'] ?>">
                        <?= $category['title'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="price" placeholder="Цена" value="<?= $product['price'] ?>">
            <textarea name="description" placeholder="Описание"><?= $product['description'] ?></textarea>
            <input type="file" name="image" value="<?= $product['image'] ?>">


            <input class="form_btn" type="submit" name="" value="Редактировать">
        </form>
    </div>
</main>
<footer>
    <div class="header_wrapper footer_wrapper">
        <a href="" class="logo footer_logo">
            <svg width="113" height="113" viewBox="0 0 113 113" fill="" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M56.6674 0L56.6679 1.48894e-06C56.7583 31.0711 81.9289 56.2418 113 56.3321V56.3325C81.873 56.4231 56.6677 81.6843 56.6677 112.833C56.6677 112.888 56.6678 112.944 56.6679 113C56.6677 113 56.6676 113 56.6674 113L56.6677 112.833C56.6677 81.6553 31.4153 56.376 0.248305 56.3323C31.3594 56.2888 56.577 31.1001 56.6674 0ZM0 56.3325L5.43761e-07 56.3322L0.109126 56.3323L0 56.3325Z"
                    fill="" />
            </svg>
            <p>Природный Оазис</p>
        </a>
        <div class="footer_text_wrapper_out">
            <div class="footer_text_wrapper">
                <p class="footer_title">КОНТАКТЫ</p>
                <a href="">+7 (999) 999-99-99</a>
                <a href="">Vk: Природный Оазис</a>
                <a href="">Tg: Природный Оазис</a>
            </div>

        </div>
    </div>
</footer>
</body>

</html>