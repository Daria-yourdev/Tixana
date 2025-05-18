<?php 
    if(isset($_SESSION['user_id'])){
        header('Location: ./');
    }

    $flag = true;
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
    }
?>

<body>
    <main>
        <div class="out_wrapper">
            <form action="" method="post" class="form-style">
                <h1>Регистрация</h1>
                <p class="error">Заполните все поля</p>
                <input type="text" name="username" placeholder="Имя*">
                <?php 
                if(isset($_POST['username'])) {
                    if(empty($username)) {
                        echo'Имя не введено';
                        $flag = false;
                    }
                }
                ?>
                <input type="text" name="surname" placeholder="Фамилия*">
                <?php 
                if(isset($_POST['surname'])) {
                    if(empty($surname)) {
                        echo'Введите фамилию';
                        $flag =false;
                    }
                }

                ?>
                <input type="text" name="email" placeholder="Почта*">
                <?php 
                if(isset($_POST['email'])) {
                    if(empty($email)){
                        echo'введите почту';
                        $flag = false;
                    }
                    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo'почта не валидна';
                        $flag =false;
                    }
                    else {
                        $issetEmail = $database->query("SELECT * FROM users WHERE email = '$email' ")->fetch();
                        if(!empty($issetEmail)) {
                            $flag =false;
                            echo'Пользователь с этой почтой уже существует';
                        }
                    }

                }
                ?>
                <input type="password" name="password" placeholder="Пароль*">
                <?php 
                if(isset($_POST['password'])) {
                    if(empty($password)) {
                        echo'введите пароль';
                        $flag= false;
                    }elseif (strlen($password)<6) {
                        $flag = false;
                        echo 'Введите более 6 символов';
                    }
                }
                ?>
                <input type="password" name="repassword" placeholder="Повторите пароль*">
                <?php 
                    if(isset($_POST['repassword'])) {
                        if(empty($repassword)) {
                            echo'повторите пароль';
                            $flag = false;
                        }
                        elseif ($password != $repassword) {
                            echo'пароли не совпадают';
                            $flag = false;
                        }
                    }
                ?>
             
                <input class="form_btn" type="submit" name="" value="Зарегистрироваться">
                <?php 
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if($flag) {
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO users (username, surname, email, password) VALUES ('$username', '$surname', '$email', '$password')";
                        $database->query($sql);
                        header("Location: ./");
                    }
                }
                ?>
            </form>
        </div>
    </main>
</body>
