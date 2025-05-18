<h1>Главная</h1>
<br><br>
<h4>Каталог:</h4>

<?php
$products = $database->query("SELECT * FROM products")->fetchAll();
?>

<?php if (!empty($products)): ?>
    <?php foreach ($products as $product):
        ?>
        <img src="./uploads/<?= $product['image'] ?>" alt="" style="height: 100px; width: 100px">
        <p>Название товара: <?= $product['title'] ?></p>
        <br>
        <p>Описание товра: <?= $product['description'] ?></p>
        <br>
        <p>Цена товра: <?= $product['price'] ?></p>
        <br>
        <a href="./?page=show-product&id=<?= $product['id'] ?>">Подробнее</a>
    <?php endforeach; ?>
<?php else: ?>
    <p>Товаров нет</p>
<?php endif; ?>
