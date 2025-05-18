<?php
include('database/connection.php');
$sql = "SELECT * FROM categories";
$products = $database->query($sql)->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];

    if (empty($title)) {
        echo 'Категория не найдена';
    } else {
        $sql = "INSERT INTO categories (title) VALUE (:title)";
        $stmt = $database->prepare($sql);
        $stmt->bindParam(':title', $title);

        if ($stmt->execute()) {
            header("Location: ./?page=all_category");
        } else {
            echo 'Ошибка отправки';
        }
    }
}

?>

<main>
    <div class="out_wrapper">
        <form action="" method="post" class="style-form">
            <h1>Добавить категорию</h1><br><br>
            <input type="text" name="title" placeholder="Название">
            <input class="form_btn" type="submit" name="" value="Добавить">
        </form>
    </div>
</main>