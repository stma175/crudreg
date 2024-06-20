<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password === $password_confirm) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login OR email = :email");
        $stmt->execute(['login' => $login, 'email' => $email]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = 'Логин или email занят!!!';
            header('Location: register.php');
            exit();
        }

        $path = '';
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $path = 'uploads/' . time() . $_FILES['avatar']['name'];
            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
                $_SESSION['message'] = 'Ошибка загрузки изображения!!!';
                header('Location: register.php');
                exit();
            }
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (full_name, login, email, password, avatar) VALUES (:full_name, :login, :email, :password, :avatar)");
        $stmt->execute([
            'full_name' => $full_name,
            'login' => $login,
            'email' => $email,
            'password' => $hashed_password,
            'avatar' => $path
        ]);

        $_SESSION['message'] = 'Регистрация прошла успешно!!!';
        header('Location: ../index.php');
    } else {
        $_SESSION['message'] = 'Пароли не совпадают!!!';
        header('Location: register.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="register.css">
    <title>Регистрация</title>
</head>
<body>
<center>
    <center>
    <h2>Регистрация</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>
</center>

    <form action="register.php" method="post" enctype="multipart/form-data">
        <fieldset>
        <input type="text" name="full_name" placeholder="Полное имя" required><br>
        <input type="text" name="login" placeholder="Логин" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <input type="password" name="password_confirm" placeholder="Подтверждение пароля" required><br>
        <input type="file" name="avatar"><br>
        <button type="submit">Зарегистрироваться</button>
        <p>
        У вас уже есть аккаунта? - <a href="login.php">Войти</a>
        </p>
        <p><a href="../index.php">к постам</a></p>
</fieldset>
</form>
</center>
</body>
</html>

