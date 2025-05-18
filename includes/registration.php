<?php

include('connection/database.php');
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ./');
    exit;
}

$errors = [];
$name_surname = $email = $tel = $adress = $password = $repassword = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_surname = trim($_POST['name_surname']);
    $email = trim($_POST['email']);
    $tel = trim($_POST['tel']);
    $adress = trim($_POST['adress']);
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    if (empty($name_surname)) $errors['name_surname'] = "Имя не введено";
    if (empty($email)) {
        $errors['email'] = "Введите почту";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Почта не валидна";
    } else {
        $stmt = $database->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = "Пользователь с этой почтой уже существует";
        }
    }

    if (empty($tel)) $errors['tel'] = "Телефон не введен";
    if (empty($adress)) $errors['adress'] = "Адрес не введен";
    if (empty($password)) {
        $errors['password'] = "Введите пароль";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Введите более 6 символов";
    }

    if (empty($repassword)) {
        $errors['repassword'] = "Повторите пароль";
    } elseif ($password !== $repassword) {
        $errors['repassword'] = "Пароли не совпадают";
    }

    if (empty($errors)) {
        $stmt = $database->prepare("INSERT INTO users (name_surname, tel, email, adress, password, role)
                            VALUES (?, ?, ?, ?, ?, 'user')");
        $stmt->execute([$name_surname, $tel, $email, $adress, $passwordHash]);
        header("Location: ./");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="shortcut icon" href="assets/media/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cuprum:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Cuprum', 'Inter', sans-serif;
        }

        body {
            background-color: #F6ECEB;
            color: #2D431D;
            line-height: 1.6;
            padding-top: 88px;
        }

        .registration-container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 70px 20px;
        }

        .registration-title {
            font-size: 36px;
            text-align: center;
            margin-bottom: 20px;
            color: #2D431D;
        }

        .registration-subtitle {
            font-size: 18px;
            color: #857B3E;
            text-align: center;
            margin-bottom: 40px;
            font-family: 'Inter';
        }

        .registration-form {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 5px 30px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #2D431D;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-group input:focus {
            border-color: #C7A350;
            outline: none;
            box-shadow: 0 0 5px rgba(199, 163, 80, 0.5);
        }

        .error-message {
            color: #E74C3C;
            font-size: 14px;
            margin-top: 5px;
            font-family: 'Inter';
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: #857B3E;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background-color: #6B6232;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #2D431D;
        }

        .login-link a {
            color: #C7A350;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 390px) {
            .registration-container {
                padding: 40px 15px;
            }

            .registration-form {
                padding: 25px;
            }

            .registration-title {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="registration-container">
        <h1 class="registration-title">Регистрация</h1>
        <p class="registration-subtitle">Создайте аккаунт для совершения покупок</p>

        <form action="" method="post" class="registration-form">
            <div class="form-group">
                <input type="text" name="name_surname" placeholder="Имя и фамилия*" value="<?= htmlspecialchars($name_surname) ?>">
                <?php if (!empty($errors['name_surname'])): ?>
                    <p class="error-message"><?= $errors['name_surname'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="text" name="email" placeholder="Почта*" value="<?= htmlspecialchars($email) ?>">
                <?php if (!empty($errors['email'])): ?>
                    <p class="error-message"><?= $errors['email'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="text" name="tel" placeholder="Телефон*" value="<?= htmlspecialchars($tel) ?>">
                <?php if (!empty($errors['tel'])): ?>
                    <p class="error-message"><?= $errors['tel'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="text" name="adress" placeholder="Адрес*" value="<?= htmlspecialchars($adress) ?>">
                <?php if (!empty($errors['adress'])): ?>
                    <p class="error-message"><?= $errors['adress'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Пароль*">
                <?php if (!empty($errors['password'])): ?>
                    <p class="error-message"><?= $errors['password'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="password" name="repassword" placeholder="Повторите пароль*">
                <?php if (!empty($errors['repassword'])): ?>
                    <p class="error-message"><?= $errors['repassword'] ?></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="submit-btn">Зарегистрироваться</button>

            <div class="login-link">
                Уже есть аккаунт? <a href="?page=authorization">Войдите</a>
            </div>
        </form>
    </div>

</body>

</html>