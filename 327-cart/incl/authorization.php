<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flag = true;

    $email = $_POST['email'];
    $password = $_POST['password'];
}
?>

<body>

    <main>
        <div class="out_wrapper">
            <form action="" method="post" class="form-style">
                <h1>Авторизация</h1>
                <input type="text" name="email" placeholder="Почта">
                <?php
                if (isset($_POST['email'])) {
                    if (empty($email)) {
                        echo 'Введите почту';
                        $flag = false;
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo 'почта не валидна';
                        $flag = false;
                    }
                }
                ?>
                <input type="password" name="password" placeholder="Пароль">
                <?php
                if (isset($_POST['password'])) {
                    if (empty($password)) {
                        echo 'Пароль не введен';
                        $flag = false;
                    }
                }
                ?>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if ($flag) {
                        $sql = "SELECT * FROM users WHERE email = '$email'";
                        $result = $database->query($sql)->fetch();

                        if ($result) {
                            if (password_verify($password, $result['password'])) {
                                $_SESSION['user_id'] = $result['id'];
                                header("Location: ./");
                            }
                            else {
                                echo'Неверный пароль';
                                $flag = false;
                            }
                        }
                        else {
                            echo'Пользователь не найден';
                        }
                    }
                }
                ?>

                <input class="form_btn" type="submit" name="" value="Авторизоваться">
            </form>
        </div>
    </main>

</body>