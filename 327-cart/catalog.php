<?php


$category = $_GET['category_id'] ?? '';
$search = $_GET['search'] ?? '';

$sql = 'SELECT * FROM products WHERE 1=1';



if(!empty($search)){ 
    $sql.=" AND title LIKE '%$search%'";
}

if(!empty($category)){
    $sql .= " AND category_id = $category";
}



$stmt = $database->query($sql);
$products = $stmt->fetchAll();


$sql2 = "SELECT * FROM categories";
$categories = $database->query($sql2)->fetchAll();
/* if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if(empty($title) || empty($description) || empty($price)){
        echo'Товар не найден';
    }
    else{
        $sql = 'INSERT INTO products(title, price) VALUES (:title, :price)';
        $stmt = $database->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':price', $price);

        if($stmt->execute()){
            header('Location: ./');
        }
        else{
            include('404php');
        }
    }
} */
?>


<main>
    <div class="out_wrapper">
        <h1>
            Каталог
        </h1>
        <div class="btns categories">
           <form action="" method="get">

<input type="text" name="search" value="<?= $search ? $search : '' ?>" id="" placeholder="Введите название">

           <select name="category_id" id="">
            <option value="">Все категории</option>
<?php foreach($categories as $cat): ?>
<?= $category ?>
<option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>><?= $cat['title'] ?></option>

    <?php endforeach ?>
    </select>
    <input type="submit" value="Применить">


           </form>
        </div>
        <?php if (isset($USER['role'] ) && $USER['role'] == 'admin'): ?>
        <a class="btn_reg add_basket_btn" href="./?page=add">Добавить дoм</a>
        <?php endif; ?>
        <div class="products_wrapper">

<?php if (!empty($products)): ?>

            <?php foreach ($products as $product): ?>
                <a href="./?page=product&id=<?= $product['id'] ?>" class="product">
                    <img src="<?= $product['image'] ?>" alt="">
                    <div class="price">
                        <p><?= $product['price'] ?></p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="400" height="550" viewBox="0 0 400 550">
                            <path transform="translate(-44,-473)"
                                d="m75.949795,761.44891h49.710085v-249.89624c17.73062-4.20076 36.74661-7.00278 57.04803-8.40606 20.30116-1.4023 40.48496-2.10369 60.55146-2.10419 21.46178,5e-4 42.5784,2.10112 63.34991,6.30188 20.77101,4.20174 39.20666,11.90284 55.30701,23.10333 16.09973,11.20143 29.04883,26.36865 38.84735,45.50171 9.79782,19.13391 14.6969,43.63289 14.69726,73.49701-3.6e-4,29.39485-5.01694,53.89383-15.04974,73.49701-10.0335,19.60373-23.33508,35.47234-39.90479,47.6059-16.57031,12.134-35.47237,20.76792-56.70623,25.90179-21.23436,5.13427-42.81739,7.93629-64.74915,8.40607l-55.28564,0.68359v49.71008h116.18957v43.38684h-116.18957v98.01026h-58.10547v-98.01026h-49.710085v-43.38684h49.710085v-50.39367h-49.710085z
                        M244.64791,550.04755c-12.13396,4.4e-4,-23.68384,0.34936-34.64965,1.04675-10.96613,0.69828-19.71043,1.75215-26.23291,3.16162v202.98462h53.19214c13.99923,2.4e-4 27.99864-1.39899 41.99829-4.19769 13.99919-2.79822 26.59937-8.16371 37.80059-16.0965 11.2007-7.93227 20.30103-18.78075 27.30103-32.54547 6.99942-13.76414 10.26429-31.84731 9.79462-54.24957 0.46967-19.14026-2.2113-35.12637-8.04291-47.95838-5.8322-12.83121-13.76473-23.09579-23.79761-30.79376-10.03342-7.69712-21.70079-13.1801-35.00213-16.44897-13.30182-3.26799-27.42229-4.90221-42.36146-4.90265z" />
                        </svg>
                    </div>
                    <p><?= $product['title'] ?></p>
                </a>
            <?php endforeach; ?>
<?php else: ?>
    <p>Продуктов не обнаружено</p>
<?php  endif; ?>
            

        </div>
    </div>
</main>

