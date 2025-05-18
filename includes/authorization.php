<?php
include('connection/database.php');
session_start();

$email = $password = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email)) {
        $error = "Введите почту";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Почта не валидна";
    } elseif (empty($password)) {
        $error = "Введите пароль";
    } else {
        $stmt = $database->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ./?page=admin");
            } else {
                header("Location: ./");
            }
            exit;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
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

        .login-container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 70px 20px;
        }

        .login-title {
            font-size: 36px;
            text-align: center;
            margin-bottom: 20px;
            color: #2D431D;
        }

        .login-subtitle {
            font-size: 18px;
            color: #857B3E;
            text-align: center;
            margin-bottom: 40px;
            font-family: 'Inter';
        }

        .login-form {
            display: flex;
            flex-direction: column;
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

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #2D431D;
        }

        .register-link a {
            color: #C7A350;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .auth-error {
            color: #E74C3C;
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Inter';
        }

        @media (max-width: 390px) {
            .login-container {
                padding: 40px 15px;
            }

            .login-form {
                padding: 25px;
            }

            .login-title {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1 class="login-title">Авторизация</h1>
        <p class="login-subtitle">Войдите в свой аккаунт</p>

        <form action="" method="post" class="login-form">
            <?php if (!empty($error)): ?>
                <div class="auth-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="form-group">
                <input type="text" name="email" placeholder="Почта*" value="<?= htmlspecialchars($email) ?>">
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Пароль*">
            </div>

            <button type="submit" class="submit-btn">Войти</button>

            <div class="register-link">
                Нет аккаунта? <a href="?page=registration">Зарегистрируйтесь</a>
            </div>
        </form>
    </div>
</body>

</html>