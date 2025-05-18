<?php
$id = $_GET['id'];
$product = $database->query("SELECT * FROM products WHERE id = $id")->fetch();
if(!$product){
    include('404.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $uploadDir = __DIR__ . '/../uploads';

    if (file_exists($uploadDir . '/' . $product['image'])) {
        unlink($uploadDir . '/' . $product['image']);
    }

    $delete = $database->query("DELETE FROM products WHERE id = $id");
    header('Location: ./');

}

?>


<h1>Вы уверены, что хотите удалить <?= $product['title'] ?>?</h1>

<form action="" method="post">

    <a href="./?page=show-product&id=<?= $id ?>">Вернуться назад</a>

    <input type="submit" value="Удалить">

</form>
