<?php
$sql = "SELECT * FROM categories";
$result = $database->query($sql)->fetchAll();

include('database/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];


    if (empty($title) || empty($description) || empty($price)) {
        echo "ПУстые поля";
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $name = basename($_FILES['image']['name']);
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $newName = uniqid() . '.' . $extension;
        $newDirection = 'upload/' . $newName;


        if (move_uploaded_file($tmpName, $newDirection)) {
            unlink($product['page']);
            $sql = "INSERT INTO products (title, price, description, image, category_id) VALUES ('$title', '$price', '$description', '$newDirection', '$category_id')";
            $stmt = $database->query($sql);
            header('Location: ./');
        } else {
            echo 'Ошибка загрузки';
        }
    } else {
        echo 'Нет изображения';
    }
}
?>


<main>
    <div class="out_wrapper">
        <form action="" method="post" enctype="multipart/form-data" class="form-style">
            <h1>Добавить дом</h1>
            <input type="text" name="title" placeholder="Название">
            <select name="category_id">
                <option value="#">Выберите категорию</option>
                <?php foreach ($result as $category): ?>
                    <option value="<?= $category['id'] ?>">
                        <?= $category['title'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="price" placeholder="Цена">
            <textarea name="description" placeholder="Описание"></textarea>
            <input type="file" name="image">


            <input class="form_btn" type="submit" name="" value="Добавить">
        </form>
    </div>
</main>