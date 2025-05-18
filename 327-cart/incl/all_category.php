<?php 

$sql = 'SELECT * FROM categories';
$stmt = $database->query($sql);
$products = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    if (!empty($delete_id)) {
        $sql = "DELETE FROM categories WHERE id =:id";
        $stmt = $database->prepare($sql);
        $stmt->bindParam(':id', $delete_id);

        if ($stmt->execute()) {
            header("Location: ./?page=all_category");
            exit;
        } else {
            echo 'Ошибка удаления';
        }
    }
}
?>



<body>

    <main>
        <div class="out_wrapper">
            <h1>Все категории</h1>

            <div class="categories_block">
                <?php foreach($products as $product): ?>
                <div class="product product_basket">
                    <p> <?= $product['title'] ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="delete_id" value="<?= $product['id'] ?>">
                        <button class="exit_btn minus btn_auth"
                            onclick="return confirm('Вы действительно хотите удалить?')">Удалить</button>
                    </form>

                </div>
                <?php endforeach; ?>
    
            </div>
        </div>
        </div>
        </div>
    </main>